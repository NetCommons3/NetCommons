<?php
/**
 * Page::saveMove()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesModelTestCase', 'Pages.TestSuite');

/**
 * Page::saveMove()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Page
 */
class PageSaveMoveTest extends PagesModelTestCase {

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
	protected $_methodName = 'saveMove';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストクエリ
		$this->___query = array(
			'recursive' => -1,
			'fields' => array('id', 'parent_id', 'weight', 'sort_key', 'child_count'),
			'conditions' => array('id' => array('4', '7', '8')),
			'order' => array('sort_key' => 'asc'),
		);
		//事前チェック
		$model = $this->_modelName;
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '4',
				'parent_id' => '1',
				//'lft' => '2', 'rght' => '5',
				'weight' => '1',
				'sort_key' => '~00000001-00000001',
				'child_count' => '1',
			)),
			1 => array('Page' => array(
				'id' => '7',
				'parent_id' => '4',
				//'lft' => '3', 'rght' => '4',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001',
				'child_count' => '0',
			)),
			2 => array('Page' => array(
				'id' => '8',
				'parent_id' => '1',
				//'lft' => '6', 'rght' => '7',
				'weight' => '2',
				'sort_key' => '~00000001-00000002',
				'child_count' => '0',
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()のUpテスト
 *
 * @return void
 */
	public function testSaveMoveUp() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '8';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'up'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '8',
				'parent_id' => '1',
				//'lft' => '2', 'rght' => '3',
				'weight' => '1',
				'sort_key' => '~00000001-00000001',
				'child_count' => '0',
			)),
			1 => array('Page' => array(
				'id' => '4',
				'parent_id' => '1',
				//'lft' => '4', 'rght' => '7',
				'weight' => '2',
				'sort_key' => '~00000001-00000002',
				'child_count' => '1',
			)),
			2 => array('Page' => array(
				'id' => '7',
				'parent_id' => '4',
				//'lft' => '5', 'rght' => '6',
				'weight' => '1',
				'sort_key' => '~00000001-00000002-00000001',
				'child_count' => '0',
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()のExceptionErrorテスト
 *
 * @return void
 */
	public function testSaveMoveUpOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '8';
		$roomId = '2';
		$this->_mockForReturnFalse($model, 'Rooms.Room', 'saveField');

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'up'),
			'Room' => array('id' => $roomId)
		);
		$this->setExpectedException('InternalErrorException');
		$this->$model->$methodName($data);
	}

/**
 * saveMove()の最上部のUpテスト
 *
 * CakeTreeでは、Exceptionになっていたが、NetCommonsTreeでは、エラーとしない
 *
 * @return void
 */
	public function testSaveMoveUpOnTop() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		//$this->setExpectedException('InternalErrorException');
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'up'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '4',
				'parent_id' => '1',
				//'lft' => '2', 'rght' => '5',
				'weight' => '1',
				'sort_key' => '~00000001-00000001',
				'child_count' => '1',
			)),
			1 => array('Page' => array(
				'id' => '7',
				'parent_id' => '4',
				//'lft' => '3', 'rght' => '4',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001',
				'child_count' => '0',
			)),
			2 => array('Page' => array(
				'id' => '8',
				'parent_id' => '1',
				//'lft' => '6', 'rght' => '7',
				'weight' => '2',
				'sort_key' => '~00000001-00000002',
				'child_count' => '0',
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()のDownテスト
 *
 * @return void
 */
	public function testSaveMoveDown() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'down'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '8',
				'parent_id' => '1',
				//'lft' => '2', 'rght' => '3',
				'weight' => '1',
				'sort_key' => '~00000001-00000001',
				'child_count' => '0',
			)),
			1 => array('Page' => array(
				'id' => '4',
				'parent_id' => '1',
				//'lft' => '4', 'rght' => '7',
				'weight' => '2',
				'sort_key' => '~00000001-00000002',
				'child_count' => '1',
			)),
			2 => array('Page' => array(
				'id' => '7',
				'parent_id' => '4',
				//'lft' => '5', 'rght' => '6',
				'weight' => '1',
				'sort_key' => '~00000001-00000002-00000001',
				'child_count' => '0',
			)),
		);

		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()の最下部のDownテスト
 *
 * CakeTreeでは、Exceptionになっていたが、NetCommonsTreeでは、エラーとしない
 *
 * @return void
 */
	public function testSaveMoveDownOnLast() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '8';
		$roomId = '2';

		//テスト実施
		//$this->setExpectedException('InternalErrorException');
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'down'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '4',
				'parent_id' => '1',
				//'lft' => '2', 'rght' => '5',
				'weight' => '1',
				'sort_key' => '~00000001-00000001',
				'child_count' => '1',
			)),
			1 => array('Page' => array(
				'id' => '7',
				'parent_id' => '4',
				//'lft' => '3', 'rght' => '4',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001',
				'child_count' => '0',
			)),
			2 => array('Page' => array(
				'id' => '8',
				'parent_id' => '1',
				//'lft' => '6', 'rght' => '7',
				'weight' => '2',
				'sort_key' => '~00000001-00000002',
				'child_count' => '0',
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()の移動(Move)テスト(ケース1)
 *
 * @return void
 */
	public function testSaveMoveParentMove1() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '8';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'move', 'parent_id' => '4'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '4',
				'parent_id' => '1',
				//'lft' => '2', 'rght' => '7',
				'weight' => '1',
				'sort_key' => '~00000001-00000001',
				'child_count' => '2',
			)),
			1 => array('Page' => array(
				'id' => '7',
				'parent_id' => '4',
				//'lft' => '3', 'rght' => '4',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001',
				'child_count' => '0',
			)),
			2 => array('Page' => array(
				'id' => '8',
				'parent_id' => '4',
				//'lft' => '5', 'rght' => '6',
				'weight' => '2',
				'sort_key' => '~00000001-00000001-00000002',
				'child_count' => '0',
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()の移動(Move)テスト(ケース2)
 *
 * @return void
 */
	public function testSaveMoveParentMove2() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'move', 'parent_id' => '8'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '8',
				'parent_id' => '1',
				//'lft' => '2', 'rght' => '7',
				'weight' => '1',
				'sort_key' => '~00000001-00000001',
				'child_count' => '2',
			)),
			1 => array('Page' => array(
				'id' => '4',
				'parent_id' => '8',
				//'lft' => '3', 'rght' => '6',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001',
				'child_count' => '1',
			)),
			2 => array('Page' => array(
				'id' => '7',
				'parent_id' => '4',
				//'lft' => '4', 'rght' => '5',
				'weight' => '1',
				'sort_key' => '~00000001-00000001-00000001-00000001',
				'child_count' => '0',
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()の移動(Move)のExceptionErrorテスト(入れ子)
 *
 * @return void
 */
	public function testSaveMoveParentMoveOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'move', 'parent_id' => '7'),
			'Room' => array('id' => $roomId)
		);
		$this->$model->$methodName($data);
	}

/**
 * saveMove()ののExceptionErrorテスト(不正パラメータ)
 *
 * @return void
 */
	public function testSaveMoveOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'error'),
			'Room' => array('id' => $roomId)
		);
		$this->$model->$methodName($data);
	}

/**
 * saveMove()ののExistsErrorテスト(ページID不正)
 *
 * @return void
 */
	public function testSaveMoveExistsError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '999';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'error'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertFalse($result);
	}

}
