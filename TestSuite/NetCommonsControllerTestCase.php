<?php
/**
 * NetCommonsControllerTestCase
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerBaseTestCase', 'NetCommons.TestSuite');
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

/**
 * NetCommonsControllerTestCase
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\TestSuite
 * @codeCoverageIgnore
 */
abstract class NetCommonsControllerTestCase extends NetCommonsControllerBaseTestCase {

/**
 * Load TestPlugin
 *
 * @param CakeTestCase $test CakeTestCase
 * @param string $plugin Plugin name
 * @param string $testPlugin Test plugin name
 * @return void
 */
	public static function loadTestPlugin(CakeTestCase $test, $plugin, $testPlugin) {
		NetCommonsCakeTestCase::loadTestPlugin($test, $plugin, $testPlugin);
	}

/**
 * Lets you do functional tests of a controller action.
 *
 * ### Options:
 *
 * - `data` Will be used as the request data. If the `method` is GET,
 *   data will be used a GET params. If the `method` is POST, it will be used
 *   as POST data. By setting `$options['data']` to a string, you can simulate XML or JSON
 *   payloads to your controllers allowing you to test REST webservices.
 * - `method` POST or GET. Defaults to POST.
 * - `return` Specify the return type you want. Choose from:
 *     - `vars` Get the set view variables.
 *     - `view` Get the rendered view, without a layout.
 *     - `contents` Get the rendered view including the layout.
 *     - `result` Get the return value of the controller action. Useful
 *       for testing requestAction methods.
 * - `type` json or html, Defaults to html.
 *
 * @param string $url The url to test
 * @param array $options See options
 * @return mixed
 */
	protected function _testAction($url = '', $options = []) {
		$options = array_merge(['type' => 'html'], $options);
		if ($options['type'] === 'json') {
			$_SERVER['HTTP_X_REQUESTED_WITH'] = 'XMLHttpRequest';
			$_SERVER['HTTP_ACCEPT'] = 'application/json';
		}
		$ret = parent::_testAction($url, $options);
		return $ret;
	}

/**
 * Assert input tag
 *
 * ### $returnについて
 *  - viewFile: viewファイル名を戻す
 *  - json: JSONをでコードした配列を戻す
 *  - 上記以外: $this->testActionのreturnで指定した内容を戻す
 *
 * @param array $url URL配列
 * @param array $paramsOptions リクエストパラメータオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @return void
 */
	protected function _testNcAction($url = [], $paramsOptions = [],
										$exception = null, $return = 'view') {
		if ($exception && $return !== 'json') {
			$this->setExpectedException($exception);
		}

		//URL設定
		$params = array();
		if ($return === 'viewFile') {
			$params['return'] = 'view';
		} elseif ($return === 'json') {
			$params['return'] = 'view';
			$params['type'] = 'json';
			if ($exception === 'BadRequestException') {
				$status = 400;
			} elseif ($exception === 'ForbiddenException') {
				$status = 403;
			} else {
				$status = 200;
			}
		} else {
			$params['return'] = $return;
		}
		$params = Hash::merge($params, $paramsOptions);

		//テスト実施
		$view = $this->testAction(NetCommonsUrl::actionUrl($url), $params);
		if ($return === 'viewFile') {
			$result = $this->controller->view;
		} elseif ($return === 'json') {
			$result = json_decode($this->contents, true);
			$this->assertArrayHasKey('code', $result);
			$this->assertEquals($status, $result['code']);
		} else {
			$result = $view;
		}

		return $result;
	}

/**
 * viewアクションのテスト
 *
 * @param array $urlOptions URLオプション
 * @param array $assert テストの期待値
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @return mixed テスト結果
 */
	protected function _testGetAction($urlOptions, $assert, $exception = null, $return = 'view') {
		//テスト実施
		if (is_array($urlOptions)) {
			$url = Hash::merge(array(
				'plugin' => $this->plugin,
				'controller' => $this->_controller,
			), $urlOptions);
		} else {
			$url = $urlOptions;
		}
		$result = $this->_testNcAction($url, array('method' => 'get'), $exception, $return);

		if (! $exception && $assert) {
			if ($assert['method'] === 'assertActionLink') {
				$assert['url'] = Hash::merge($url, $assert['url']);
			}

			$this->asserts(array($assert), $result);
		}

		return $result;
	}

/**
 * addアクションのPOSTテスト
 *
 * @param array $method リクエストのmethod(post put delete)
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $exception Exception
 * @param string $return testActionの実行後の結果
 * @return mixed テスト結果
 */
	protected function _testPostAction($method, $data, $urlOptions,
											$exception = null, $return = 'view') {
		//テスト実施
		if (is_array($urlOptions)) {
			$url = Hash::merge(array(
				'plugin' => $this->plugin,
				'controller' => $this->_controller,
			), $urlOptions);
		} else {
			$url = $urlOptions;
		}
		$result = $this->_testNcAction($url, ['method' => $method, 'data' => $data], $exception, $return);

		return $result;
	}

/**
 * addアクションのValidateionErrorテスト
 *
 * @param array $method リクエストのmethod(post put delete)
 * @param array $data POSTデータ
 * @param array $urlOptions URLオプション
 * @param string|null $validError ValidationError
 * @return mixed テスト結果
 */
	protected function _testActionOnValidationError($method, $data, $urlOptions, $validError = null) {
		$data = Hash::remove($data, $validError['field']);
		$data = Hash::insert($data, $validError['field'], $validError['value']);

		//テスト実施
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
		), $urlOptions);
		$result = $this->_testNcAction($url, array('method' => $method, 'data' => $data));

		//バリデーションエラー
		$asserts = array(
			array('method' => 'assertNotEmpty', 'value' => $this->controller->validationErrors),
			array('method' => 'assertTextContains', 'expected' => $validError['message']),
		);

		//チェック
		$this->asserts($asserts, $result);

		return $result;
	}

/**
 * 戻り値FalseのMockセット
 *
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param int|string $count Mockの呼び出し回数
 * @return void
 */
	protected function _mockForReturnFalse($mockModel, $mockMethod, $count = 1) {
		$this->_mockForReturn($mockModel, $mockMethod, false, $count);
	}

/**
 * 戻り値TrueのMockセット
 *
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param int|string $count Mockの呼び出し回数
 * @return void
 */
	protected function _mockForReturnTrue($mockModel, $mockMethod, $count = 1) {
		$this->_mockForReturn($mockModel, $mockMethod, true, $count);
	}

/**
 * 戻り値指定のMockセット
 *
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param bool $return 戻り値
 * @param int|string $count Mockの呼び出し回数
 * @return void
 */
	protected function _mockForReturn($mockModel, $mockMethod, $return, $count = 1) {
		list($mockPlugin, $mockModel) = pluginSplit($mockModel);

		if (substr(get_class($this->controller->$mockModel), 0, strlen('Mock_')) !== 'Mock_') {
			$this->controller->$mockModel = $this->getMockForModel(
				$mockPlugin . '.' . $mockModel,
				array($mockMethod),
				array('plugin' => Inflector::underscore($mockPlugin))
			);
		}
		if ($count === 'any') {
			$funcCount = $this->any();
		} elseif ($count === 1) {
			$funcCount = $this->once();
		} else {
			$funcCount = $this->exactly($count);
		}
		$this->controller->$mockModel->expects($funcCount)
			->method($mockMethod)
			->will($this->returnValue($return));
	}

/**
 * CallbackのMockセット
 *
 * @param string $mockModel Mockのモデル
 * @param string $mockMethod Mockのメソッド
 * @param mixed $callback コールバック関数
 * @return void
 */
	protected function _mockForReturnCallback($mockModel, $mockMethod, $callback) {
		list($mockPlugin, $mockModel) = pluginSplit($mockModel);

		if (substr(get_class($this->controller->$mockModel), 0, strlen('Mock_')) !== 'Mock_') {
			$this->controller->$mockModel = $this->getMockForModel(
				$mockPlugin . '.' . $mockModel, array($mockMethod)
			);
		}
		$funcCount = $this->once();
		$this->controller->$mockModel->expects($funcCount)
			->method($mockMethod)
			->will($this->returnCallback($callback));
	}

/**
 * Asserts
 *
 * @param array $asserts テストAssert
 * @param string $result Result data
 * @return void
 */
	public function asserts($asserts, $result) {
		//チェック
		if (isset($asserts)) {
			foreach ($asserts as $assert) {
				$assertMethod = $assert['method'];

				if ($assertMethod === 'assertInput') {
					$this->$assertMethod($assert['type'], $assert['name'], $assert['value'], $result);
					continue;
				}

				if ($assertMethod === 'assertActionLink') {
					$this->$assertMethod($assert['action'], $assert['url'], $assert['linkExist'], $result);
					continue;
				}

				if (! isset($assert['value'])) {
					$assert['value'] = $result;
				}
				if (isset($assert['expected'])) {
					$this->$assertMethod($assert['expected'], $assert['value']);
				} else {
					$this->$assertMethod($assert['value']);
				}
			}
		}
	}

/**
 * Assert input tag
 *
 * @param string $tagType タグタイプ(input or textearea or button)
 * @param string $name inputタグのname属性
 * @param string $value inputタグのvalue値
 * @param string $result Result data
 * @param string $message メッセージ
 * @return void
 */
	public function assertInput($tagType, $name, $value, $result, $message = null) {
		$result = str_replace("\n", '', $result);

		if ($name) {
			$patternName = '.*?name="' . preg_quote($name, '/') . '"';
		} else {
			$patternName = '';
		}

		if (! $value) {
			$patternValue = '';
		} elseif (in_array($value, ['checked', 'selected'], true)) {
			$patternValue = '.*?' . preg_quote($value, '/') . '="' . preg_quote($value, '/') . '"';
		} else {
			$patternValue = '.*?value="' . preg_quote($value, '/') . '"';
		}

		if ($tagType === 'textarea') {
			$this->assertRegExp(
				'/<textarea' . $patternName . '.*?>.*?' . preg_quote($value, '/') . '<\/textarea>/',
				$result, $message
			);
		} elseif ($tagType === 'option') {
			$this->assertRegExp(
				'/<option.*?value="' . preg_quote($name, '/') . '"' . $patternValue . '.*?>/',
				$result, $message
			);
		} elseif ($tagType === 'form') {
			$this->assertRegExp(
				'/<form.*?action=".*?' . preg_quote($value, '/') . '.*"' . $patternName . '.*?>/',
				$result, $message
			);
		} elseif (in_array($tagType, ['input', 'select', 'button'], true)) {
			$this->assertRegExp(
				'/<' . $tagType . $patternName . $patternValue . '.*?>/', $result, $message
			);
		}
	}

/**
 * Assert アクションリンク
 *
 * @param string $action アクション
 * @param array $urlOptions URLオプション
 * @param bool $linkExist リンクの有無
 * @param string $result Result data
 * @param string $message メッセージ
 * @return void
 */
	public function assertActionLink($action, $urlOptions, $linkExist, $result, $message = null) {
		$url = Hash::merge(array(
			'plugin' => $this->plugin,
			'controller' => $this->_controller,
		), $urlOptions);

		$url['action'] = $action;

		if (isset($url['frame_id']) && ! Current::read('Frame.id')) {
			unset($url['frame_id']);
		}
		if (isset($url['block_id']) && ! Current::read('Block.id')) {
			unset($url['block_id']);
		}

		if ($linkExist) {
			$method = 'assertRegExp';
		} else {
			$method = 'assertNotRegExp';
		}
		$expected = '/' . preg_quote(NetCommonsUrl::actionUrl($url), '/') . '/';

		//チェック
		$this->$method($expected, $result, $message);
	}

}
