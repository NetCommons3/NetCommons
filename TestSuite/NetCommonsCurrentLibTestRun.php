<?php
/**
 * Currentライブラリテスト群
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

/**
 * Currentライブラリテスト群
 *
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
class NetCommonsCurrentLibTestRun {

/**
 * 期待値テストクラス
 *
 * @var CurrentLibControllerTestExpectedData
 */
	public $__ExpectedData;

/**
 * POSTデータクラス
 *
 * @var array
 */
	private $__PostData;

/**
 * Constructor.
 *
 * @param CakeRequest $request Request object for this controller. Can be null for testing,
 *  but expect that features that use the request parameters will not work.
 * @param CakeResponse $response Response object for this controller.
 */
	public function __construct() {
		$this->__ExpectedData = new CurrentLibControllerTestExpectedData();
		$this->__PostData = new CurrentLibControllerTestPostData();
	}

/**
 * GETテスト
 *
 * @param ControllerTestCase &$test コントローラテストクラス
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @return void
 */
	public function testGetRequest(
			ControllerTestCase &$test, $controller, $url, $expects, $exception) {
		$test->generate($controller);

		NetCommonsCurrentLibTestUtility::testControllerGetRequest(
			$test, $url, $expects, $exception
		);
	}

/**
 * パブリックのお知らせページのセッティングモード表示のテスト
 *
 * @param ControllerTestCase $test コントローラテストクラス
  * @return void
 */
	public function testGetRequestAnnouncementPageWithSettingMode(
			ControllerTestCase &$test) {
		$controller = 'Pages.Pages';
		$url = '/setting/announcements_page';
		$expects = [
			'assertContains' => array_merge(
				$this->__ExpectedData->getExpectedAnnouncement(['public_1', 'public_2', 'public_3']),
				$this->__ExpectedData->getExpectedFrame(['menu']),
				$this->__ExpectedData->getExpectedMenuList([
					'public', 'private', 'community_1', 'community_2'
				]),
				$this->__ExpectedData->getExpectedSettingMode('off')
			),
			'assertNotContains' => [],
			'assertRegExp' => array_merge([],
				$this->__ExpectedData->getExpectedActiveMenu('public_announcement_page')
			),
		];
		$exception = false;

		//セッティングモードON
		NetCommonsCurrentLibTestUtility::settingMode(true);

		$test->generate($controller);

		NetCommonsCurrentLibTestUtility::testControllerGetRequest(
			$test, $url, $expects, $exception
		);

		//セッティングモードのクリア
		NetCommonsCurrentLibTestUtility::settingMode(null);
	}

/**
 * パブリックのお知らせページのセッティングモード表示のテスト
 *
 * @param ControllerTestCase &$test コントローラテストクラス
  * @return void
 */
	public function testGetRequestAnnouncementPageWithSettingModeAsRedirectOff(
			ControllerTestCase &$test) {
		$controller = 'Pages.Pages';
		$url = '/setting/announcements_page';
		$expects = [
			'headers.Location' =>
				$this->__ExpectedData->getExpectedRedirectAfterPost('public_announcement_page')
		];
		$exception = false;

		//セッティングモードON
		NetCommonsCurrentLibTestUtility::settingMode(true);

		$test->generate($controller);

		NetCommonsCurrentLibTestUtility::testControllerGetRequest(
			$test, $url, $expects, $exception
		);

		//セッティングモードのクリア
		NetCommonsCurrentLibTestUtility::settingMode(null);
	}

/**
 * ファイルダウンロードテスト
 *
 * @param ControllerTestCase &$test コントローラテストクラス
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @return void
 */
	public function testGetRequestDownload(
			ControllerTestCase &$test, $controller, $url, $expects, $exception) {
		if (! NetCommonsCurrentLibTestUtility::prepareUploadDir()) {
			$test->markTestSkipped();
			return;
		}

		$test->generate($controller);

		NetCommonsCurrentLibTestUtility::testControllerGetRequest(
			$test, $url, $expects, $exception, true
		);

		NetCommonsCurrentLibTestUtility::clearUploadDir();
	}

/**
 * POSTテスト
 *
 * @param ControllerTestCase &$test コントローラテストクラス
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array $post POSTの内容
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @return void
 */
	public function testPostRequest(
			ControllerTestCase &$test, $controller, $url, $post, $expects, $exception) {
		$test->generate($controller, [
			'components' => ['Security'],
		]);

		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$test, $url, $post, $expects, $exception
		);
	}

/**
 * Frame追加テスト
 *
 * @param ControllerTestCase &$test コントローラテストクラス
 * @param array $post POSTの内容
 * @param array|false $expects 期待値
 * @param string|false $exception Exception文字列
 * @return void
 */
	public function testPostRequestFrameAdd(
			ControllerTestCase &$test, $post, $expects, $exception) {
		$controller = 'Frames.Frames';
		$url = '/frames/frames/add';

		$test->generate($controller, [
			'components' => ['Security'],
		]);

		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$test, $url, $post, $expects, $exception
		);
	}

/**
 * Frame編集テスト
 *
 * @param ControllerTestCase &$test コントローラテストクラス
 * @param array|false $expects 期待値
 * @param string|false $exception Exception文字列
 * @return void
 */
	public function testPostRequestFrameEdit(ControllerTestCase &$test, $expects, $exception) {
		$controller = 'Frames.Frames';
		$url = '/frames/frames/edit';
		$post = $this->__PostData->getPostDataByFrameEdit();

		$test->generate($controller, [
			'components' => ['Security'],
		]);

		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$test, $url, $post, $expects, $exception
		);
	}

/**
 * Frame削除テスト
 *
 * @param ControllerTestCase &$test コントローラテストクラス
 * @param array|false $expects 期待値
 * @param string|false $exception Exception文字列
 * @return void
 */
	public function testPostRequestFrameDelete(
			ControllerTestCase &$test, $expects, $exception) {
		$controller = 'Frames.Frames';
		$url = '/frames/frames/delete';
		$post = $this->__PostData->getPostDataByFrameDelete();

		$_SERVER['HTTP_REFERER'] = '/setting/announcements_page';

		$test->generate($controller, [
			'components' => ['Security'],
		]);

		NetCommonsCurrentLibTestUtility::testControllerPostRequest(
			$test, $url, $post, $expects, $exception
		);

		unset($_SERVER['HTTP_REFERER']);
	}

/**
 * Wysiwygのアップロードテスト
 *
 * @param ControllerTestCase $test コントローラテストクラス
 * @param string $controller generateするコントローラ
 * @param string $url テストするURL
 * @param array $post POSTの内容
 * @param array|false $expects 期待値リスト
 * @param string|false $exception Exception文字列
 *
 * @return void
 */
	public function testPostRequestWysiwygUploads(
			ControllerTestCase &$test, $controller, $url, $post, $expects, $exception) {
		if (! NetCommonsCurrentLibTestUtility::prepareUploadDir()) {
			$test->markTestSkipped();
			return;
		}

		$_FILES = $post['_FILES'];

		$test->generate($controller, [
			'components' => [
				'Security',
				'Wysiwyg.Wysiwyg' => ['isUploadedFile'],
				'Files.FileUpload' => ['getTemporaryUploadFile']
			],
		]);

		$test->controller->Wysiwyg->expects($test->once())
			->method('isUploadedFile')
			->will($test->returnValue(true));

		$TmpUploadFile = NetCommonsCurrentLibTestUtility::getTemporaryFileMock($post['_fileInfo']);
		$test->controller->FileUpload
			->expects($test->once())->method('getTemporaryUploadFile')
			->with('Wysiwyg.file')
			->will($test->returnValue($TmpUploadFile));

		unset($post['_FILES'], $post['_fileInfo']);
		NetCommonsCurrentLibTestUtility::testJsonControllerPostRequest(
			$test, $url, $post, $expects, $exception
		);

		unset($_FILES);

		NetCommonsCurrentLibTestUtility::clearUploadDir();
	}

}
