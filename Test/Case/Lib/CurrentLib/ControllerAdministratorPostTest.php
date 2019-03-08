<?php
/**
 * Current::initialize()のControllerテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCurrentLibTestUtility', 'NetCommons.TestSuite');
App::uses('CurrentLibControllerTestExpectedData', 'NetCommons.Test/Fixture/CurrentLib');
App::uses('CurrentLibControllerTestPostData', 'NetCommons.Test/Fixture/CurrentLib');
App::uses('CurrentLib', 'NetCommons.Lib');
App::uses('Current', 'NetCommons.Utility');

/**
 * Current::initialize()のControllerテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\Case\Lib\CurrentLib
 */
class NetCommonsLibCurrentLibControllerAdministratorPostTest extends ControllerTestCase {

/**
 * By default, all fixtures attached to this class will be truncated and reloaded after each test.
 * Set this to false to handle manually
 *
 * @var array
 */
	public $autoFixtures = false;

/**
 * Called when a test case method is about to start (to be overridden when needed.)
 *
 * @param string $method Test method about to get executed.
 * @return void
 */
	public function startTest($method) {
		if (! NetCommonsCurrentLibTestUtility::canLoadTables()) {
			$this->markTestSkipped('開発環境でのみテストができます。');
			return;
		}
		NetCommonsCurrentLibTestUtility::loadTables();

		//ログ出力
		NetCommonsCurrentLibTestUtility::debugLogTestName('管理者でログイン', $method);
	}

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		NetCommonsCurrentLibTestUtility::login('1');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		NetCommonsCurrentLibTestUtility::logout();
		NetCommonsCurrentLibTestUtility::resetCurrentLib();
		parent::tearDown();
	}

/**
 * 管理者でのPOSTテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array $post POSTの内容
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @dataProvider dataPostRequestAnnouncementOfToppage
 * @dataProvider dataPostRequestAnnouncementOfPublicPage
 * @dataProvider dataPostRequestAddCalendarPlan
 * @dataProvider dataPostRequestEditCalendarPlan
 * @dataProvider dataPostRequestDeleteCalendarPlan
 *
 * @return void
 */
	public function testPostRequest($controller, $url, $post, $expects, $exception) {
		$this->generate($controller, [
			'components' => ['Security'],
		]);
		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$this, $url, $post, $expects, $exception
		);
	}

/**
 * Frame追加テスト
 *
 * @param array $post POSTの内容
 * @dataProvider dataPostRequestFrameAdd
 * @return void
 */
	public function testPostRequestFrameAdd($post, $expects) {
		$controller = 'Frames.Frames';
		$url = '/frames/frames/add';
		$exception = false;

		$this->generate($controller, [
			'components' => ['Security'],
		]);
		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$this, $url, $post, $expects, $exception
		);
	}

/**
 * Frame編集テスト
 *
 * @return void
 */
	public function testPostRequestFrameEdit() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$controller = 'Frames.Frames';
		$url = '/frames/frames/edit';
		$post = $PostData->getPostDataByFrameEdit();
		$expects = [
			'Location' =>
				$ExpectedData->getExpectedRedirectAfterPost('public_announcement_page')
		];
		$exception = false;

		$this->generate($controller, [
			'components' => ['Security'],
		]);
		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$this, $url, $post, $expects, $exception
		);
	}

/**
 * Frame削除テスト
 *
 * @return void
 */
	public function testPostRequestFrameDelete() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$controller = 'Frames.Frames';
		$url = '/frames/frames/delete';
		$post = $PostData->getPostDataByFrameDelete();
		$expects = [
			'Location' =>
				$ExpectedData->getExpectedRedirectAfterPost('public_announcement_page_setting_mode')
		];
		$exception = false;

		$_SERVER['HTTP_REFERER'] = '/setting/announcements_page';
		$this->generate($controller, [
			'components' => ['Security'],
		]);
		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$this, $url, $post, $expects, $exception
		);
		unset($_SERVER['HTTP_REFERER']);
	}

/**
 * Wysiwygのアップロードテスト
 *
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array $post POSTの内容
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @dataProvider dataPostRequestWysiwygUploads
 *
 * @return void
 */
	public function testPostRequestWysiwygUploads($controller, $url, $post, $expects, $exception) {
		if (! NetCommonsCurrentLibTestUtility::prepareUploadDir()) {
			$this->markTestSkipped();
			return;
		}

		$_FILES = $post['_FILES'];

		$this->generate($controller, [
			'components' => [
				'Security',
				'Wysiwyg.Wysiwyg' => ['isUploadedFile'],
				'Files.FileUpload' => ['getTemporaryUploadFile']
			],
		]);

		$this->controller->Wysiwyg->expects($this->once())
			->method('isUploadedFile')
			->will($this->returnValue(true));

		$TmpUploadFile = NetCommonsCurrentLibTestUtility::getTemporaryFileMock($post['_fileInfo']);
		$this->controller->FileUpload
			->expects($this->once())->method('getTemporaryUploadFile')
			->with('Wysiwyg.file')
			->will($this->returnValue($TmpUploadFile));

		unset($post['_FILES'], $post['_fileInfo']);
		NetCommonsCurrentLibTestUtility::testJsonControllerPostRequest(
			$this, $url, $post, $expects, $exception
		);

		unset($_FILES);

		NetCommonsCurrentLibTestUtility::clearUploadDir();
	}

/**
 * トップページのお知らせ登録のテストデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestAnnouncementOfToppage() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$results = [
			'トップページのお知らせ' => [
				'controller' => 'Announcements.Announcements',
				'url' => '/announcements/announcements/edit/12',
				'post' => $PostData->getPostDataAnnouncement('toppage_announcement'),
				'expects' => [
					'Location' => $ExpectedData->getExpectedRedirectAfterPost('toppage'),
				],
				'exception' => false,
			],
		];

		return $results;
	}

/**
 * パブリックスペースのお知らせ1(Announcements Page)登録のテストデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestAnnouncementOfPublicPage() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$results = [
			'パブリックスペースのお知らせ1(Announcements Page)' => [
				'controller' => 'Announcements.Announcements',
				'url' => '/announcements/announcements/edit/8?frame_id=12',
				'post' => $PostData->getPostDataAnnouncement('public_announcement_2'),
				'expects' => [
					'Location' => $ExpectedData->getExpectedRedirectAfterPost('public_announcement_page'),
				],
				'exception' => false,
			],
		];

		return $results;
	}

/**
 * フレーム追加のテストデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestFrameAdd() {
		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();
		$results = $PostData->getDataProviderByFrameAdd();
		return $results;
	}

/**
 * カレンダーの予定追加のテストデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestAddCalendarPlan() {
		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$frameTests = [
			'11' => 'フレームあり',
			null => 'フレームなし',
		];

		$results = [];
		foreach ($frameTests as $frameId => $testFrameTitle) {
			$commonSuccessResults = $PostData->getSuccessCommonDataByEditCalendarPlan($frameId);
			$commonFailureResults = $PostData->getFailureCommonDataByEditCalendarPlan($frameId);

			$frameResults = [
				'カレンダーの予定追加(' . $testFrameTitle . '、パブリック)' => array_merge(
					$commonSuccessResults,
					[
						'url' => $PostData->getPostUrlAddCalendarPlan($frameId),
						'post' => $PostData->getPostDataAddCalendarPlan('1', $frameId),
					]
				),
				'カレンダーの予定追加(' . $testFrameTitle . '、管理者のプライベート)' => array_merge(
					$commonSuccessResults,
					[
						'url' => $PostData->getPostUrlAddCalendarPlan($frameId),
						'post' => $PostData->getPostDataAddCalendarPlan('5', $frameId),
					]
				),
				'カレンダーの予定追加(' . $testFrameTitle . '、一般ユーザ1のプライベート)' => array_merge(
					$commonFailureResults,
					[
						'url' => $PostData->getPostUrlAddCalendarPlan($frameId),
						'post' => $PostData->getPostDataAddCalendarPlan('6', $frameId),
					]
				),
				'カレンダーの予定追加(' . $testFrameTitle . '、コミュニティ1)' => array_merge(
					$commonSuccessResults,
					[
						'url' => $PostData->getPostUrlAddCalendarPlan($frameId),
						'post' => $PostData->getPostDataAddCalendarPlan('8', $frameId),
					]
				),
				'カレンダーの予定追加(' . $testFrameTitle . '、コミュニティ2(準備中))' => array_merge(
					$commonSuccessResults,
					[
						'url' => $PostData->getPostUrlAddCalendarPlan($frameId),
						'post' => $PostData->getPostDataAddCalendarPlan('11', $frameId),
					]
				),
				'カレンダーの予定追加(' . $testFrameTitle . '、会員全員)' => array_merge(
					$commonSuccessResults,
					[
						'url' => $PostData->getPostUrlAddCalendarPlan($frameId),
						'post' => $PostData->getPostDataAddCalendarPlan('3', $frameId),
					]
				),
			];

			$results = array_merge($results, $frameResults);
		}

		return $results;
	}

/**
 * カレンダーの予定編集のテストデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestEditCalendarPlan() {
		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$frameTests = [
			'11' => 'フレームあり',
			null => 'フレームなし',
		];
		//$editRrules = [
		//	'0' => 'この予定のみ',
		//	'1' => 'これ以降に指定した全ての予定',
		//	'2' => '設定した全ての予定',
		//];

		$results = [];
		foreach ($frameTests as $frameId => $testFrameTitle) {
			$commonSuccessResults = $PostData->getSuccessCommonDataByEditCalendarPlan($frameId);
			//$commonFailureResults = $PostData->getFailureCommonDataByEditCalendarPlan($frameId);

			$frameResults = [
				'カレンダーの予定編集(' . $testFrameTitle . '、繰り返しなし、パブリック)' =>
					array_merge(
						$commonSuccessResults,
						[
							'url' => $PostData->getPostUrlEditCalendarPlan('1100', $frameId),
							'post' => $PostData->getPostDataEditCalendarPlan('1100', '0', $frameId),
						]
					),
				'カレンダーの予定編集(' . $testFrameTitle . '、繰り返しなし、管理者のプライベート)' =>
					array_merge(
						$commonSuccessResults,
						[
							'url' => $PostData->getPostUrlEditCalendarPlan('1101', $frameId),
							'post' => $PostData->getPostDataEditCalendarPlan('1101', '0', $frameId),
						]
					),
				'カレンダーの予定編集(' . $testFrameTitle . '、繰り返しなし、コミュニティ1)' =>
					array_merge(
						$commonSuccessResults,
						[
							'url' => $PostData->getPostUrlEditCalendarPlan('1101', $frameId),
							'post' => $PostData->getPostDataEditCalendarPlan('1101', '0', $frameId),
						]
					),
			];
			$results = array_merge($results, $frameResults);

			//foreach ($editRrules as $editRrule => $editRruleTile) {
			//	$frameResults = [
			//		'カレンダーの予定編集(' . $testFrameTitle . '、繰り返しあり(' . $editRruleTile . ')、パブリック)' =>
			//			array_merge(
			//				$commonSuccessResults,
			//				[
			//					'url' => $PostData->getPostUrlEditCalendarPlan('2', $frameId),
			//					'post' => $PostData->getPostDataEditCalendarPlan('2', $editRrule, $frameId),
			//				]
			//			),
			//		'カレンダーの予定編集(' . $testFrameTitle . '、繰り返しあり(' . $editRruleTile . ')、管理者のプライベート)' =>
			//			array_merge(
			//				$commonSuccessResults,
			//				[
			//					'url' => $PostData->getPostUrlEditCalendarPlan('472', $frameId),
			//					'post' => $PostData->getPostDataEditCalendarPlan('472', $editRrule, $frameId),
			//				]
			//			),
			//	];
			//	$results = array_merge($results, $frameResults);
			//}
		}

		return $results;
	}

/**
 * カレンダーの予定削除のテストデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestDeleteCalendarPlan() {
		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$frameTests = [
			'11' => 'フレームあり',
			null => 'フレームなし',
		];
		//$editRrules = [
		//	'0' => 'この予定のみ',
		//	'1' => 'これ以降に指定した全ての予定',
		//	'2' => '設定した全ての予定',
		//];

		$results = [];
		foreach ($frameTests as $frameId => $testFrameTitle) {
			$commonSuccessResults = $PostData->getSuccessCommonDataByDeleteCalendarPlan($frameId);
			//$commonFailureResults = $PostData->getFailureCommonDataByEditCalendarPlan($frameId);

			$frameResults = [
				'カレンダーの予定削除(' . $testFrameTitle . '、繰り返しなし、パブリック)' =>
					array_merge(
						$commonSuccessResults,
						[
							'url' => $PostData->getPostUrlDeleteCalendarPlan('1100', $frameId),
							'post' => $PostData->getPostDataDeleteCalendarPlan('1100', '0', $frameId),
						]
					),
				'カレンダーの予定削除(' . $testFrameTitle . '、繰り返しなし、管理者のプライベート)' =>
					array_merge(
						$commonSuccessResults,
						[
							'url' => $PostData->getPostUrlDeleteCalendarPlan('1101', $frameId),
							'post' => $PostData->getPostDataDeleteCalendarPlan('1101', '0', $frameId),
						]
					),
				'カレンダーの予定削除(' . $testFrameTitle . '、繰り返しなし、コミュニティ1)' =>
					array_merge(
						$commonSuccessResults,
						[
							'url' => $PostData->getPostUrlDeleteCalendarPlan('1101', $frameId),
							'post' => $PostData->getPostDataDeleteCalendarPlan('1101', '0', $frameId),
						]
					),
			];
			$results = array_merge($results, $frameResults);

			//foreach ($editRrules as $editRrule => $editRruleTile) {
			//	$frameResults = [
			//		'カレンダーの予定削除(' . $testFrameTitle . '、繰り返しあり(' . $editRruleTile . ')、パブリック)' =>
			//			array_merge(
			//				$commonSuccessResults,
			//				[
			//					'url' => $PostData->getPostUrlDeleteCalendarPlan('2', $frameId),
			//					'post' => $PostData->getPostDataDeleteCalendarPlan('2', $editRrule, $frameId),
			//				]
			//			),
			//		'カレンダーの予定削除(' . $testFrameTitle . '、繰り返しあり(' . $editRruleTile . ')、管理者のプライベート)' =>
			//			array_merge(
			//				$commonSuccessResults,
			//				[
			//					'url' => $PostData->getPostUrlDeleteCalendarPlan('472', $frameId),
			//					'post' => $PostData->getPostDataDeleteCalendarPlan('472', $editRrule, $frameId),
			//				]
			//			),
			//	];
			//	$results = array_merge($results, $frameResults);
			//}
		}

		return $results;
	}

/**
 * アップロードテストデータ
 *
 * @return array テストデータ
 */
	public function dataPostRequestWysiwygUploads() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		//@var CurrentLibControllerTestPostData
		$PostData = new CurrentLibControllerTestPostData();

		$results = [
			'Wysiwygの画像アップロード' => [
				'controller' => 'Wysiwyg.WysiwygImage',
				'url' => '/wysiwyg/image/upload',
				'post' => $PostData->getPostDataUploads('wysiwyg_image'),
				'expects' => [
					'statusCode' => 200,
					'file.id' => '3',
					'file.original_name' => 'Test.png'
				],
				'exception' => false,
			],
			'Wysiwygのファイルアップロード' => [
				'controller' => 'Wysiwyg.WysiwygFile',
				'url' => '/wysiwyg/file/upload',
				'post' => $PostData->getPostDataUploads('wysiwyg_file'),
				'expects' => [
					'statusCode' => 200,
					'file.id' => '3',
					'file.original_name' => 'Test.png'
				],
				'exception' => false,
			],
		];

		return $results;
	}

}
