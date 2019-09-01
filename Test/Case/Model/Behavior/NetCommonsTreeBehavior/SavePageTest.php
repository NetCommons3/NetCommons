<?php
/**
 * Page::savePage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('Page4pagesFixture', 'Pages.Test/Fixture');

/**
 * Page::savePage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Page
 */
class PageSavePageTest extends NetCommonsSaveTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.box4pages',
		//'plugin.pages.boxes_page4pages',
		//'plugin.pages.container4pages',
		//'plugin.pages.containers_page4pages',
		'plugin.pages.frame4pages',
		'plugin.pages.frame_public_language4pages',
		'plugin.pages.pages_language4pages',
		'plugin.pages.page4pages',
		'plugin.pages.plugin4pages',
		'plugin.pages.plugins_room4pages',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'pages';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'Page';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'savePage';

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$data['Page'] = Hash::extract((new Page4pagesFixture())->records, '{n}[id=7]')[0];
		$data['Room']['id'] = '2';
		$data['Room']['space_id'] = '2';

		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1][0]['Page']['id'] = null;
		$results[1][0]['Page']['permalink'] = 'home/insert_key';
		$results[1][0]['Page']['slug'] = 'insert_key';
		unset($results[1][0]['Page']['created_user']);

		return $results;
	}

/**
 * Saveのテスト
 *
 * @param array $data 登録データ
 * @dataProvider dataProviderSave
 * @return void
 */
	public function testSave($data) {
		$model = $this->_modelName;
		$method = $this->_methodName;

		if (isset($data['Page']['id'])) {
			parent::testSave($data);
			return;
		}

		//テスト実行
		$result = $this->$model->$method($data);
		$this->assertNotEmpty($result);

		$id = $this->$model->getLastInsertID();

		//登録データ取得
		$actual = $this->$model->find('first', array(
			'recursive' => -1,
			'conditions' => array('id' => $id),
		));
		$this->assertDatetime($actual[$this->$model->alias]['created']);
		$this->assertDatetime($actual[$this->$model->alias]['modified']);

		unset($actual[$this->$model->alias]['created']);
		unset($actual[$this->$model->alias]['created_user']);
		unset($actual[$this->$model->alias]['modified']);
		unset($actual[$this->$model->alias]['modified_user']);

		$expected[$this->$model->alias] = Hash::merge(
			$data[$this->$model->alias],
			array(
				'id' => $id,
				//'lft' => '5', 'rght' => '6',
				'lft' => null, 'rght' => null,
				'weight' => '2',
				'sort_key' => '~00000001-00000001-00000002',
				'child_count' => '0',
				'is_container_fluid' => false,
				'theme' => null
			)
		);
		$this->assertEquals($expected, $actual);
	}

/**
 * Saveのテスト(atomic=falseの場合)
 *
 * @return void
 */
	public function testSaveeOptionAtomic() {
		$model = $this->_modelName;
		$method = $this->_methodName;
		$data = $this->dataProviderSave()[0][0];

		$this->$model = $this->getMockForModel('Pages.Page', array('begin', 'commit', 'save'));
		$this->_mockForReturnTrue($model, 'Pages.Page', 'save');
		$this->_mockForReturnTrue($model, 'Pages.Page', array('begin', 'commit'), 0);

		//テスト実行
		$result = $this->$model->$method($data, array('atomic' => false));
		$this->assertNotEmpty($result);
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Pages.Page', 'save'),
		);
	}

/**
 * SaveのExceptionErrorテスト(atomic=falseの場合)
 *
 * @return void
 */
	public function testSaveeOptionAtomicOnExceptionError() {
		$model = $this->_modelName;
		$method = $this->_methodName;
		$data = $this->dataProviderSave()[0][0];

		$this->$model = $this->getMockForModel('Pages.Page', array('begin', 'rollback', 'save'));
		$this->_mockForReturnFalse($model, 'Pages.Page', 'save');
		$this->_mockForReturnTrue($model, 'Pages.Page', array('begin', 'rollback'), 0);

		//テスト実行
		$this->setExpectedException('InternalErrorException');
		$this->$model->$method($data, array('atomic' => false));
	}

/**
 * SaveのValidationError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnValidationError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Pages.Page'),
		);
	}

}
