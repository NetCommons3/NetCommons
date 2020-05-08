<?php
/**
 * NetCommons Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('Component', 'Controller');

/**
 * NetCommons Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller\Component
 */
class NetCommonsComponent extends Component {

/**
 * alert
 *
 * @var string
 */
	const ALERT_SUCCESS_INTERVAL = 2000,
		ALERT_VALIDATE_ERROR_INTERVAL = 6000;

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
	}

/**
 * render json
 *
 * @param array $results results data
 * @param string $name message
 * @param int $status status code
 * @return void
 */
	public function renderJson($results = [], $name = 'OK', $status = 200) {
		$this->controller->viewClass = 'Json';
		$this->controller->layout = false;
		$this->controller->response->statusCode($status);
		$results = array_merge([
			'name' => $name,
			'message' => $name,
			'code' => $status,
		], $results);
		$results = NetCommonsAppController::camelizeKeyRecursive($results);
		$this->controller->set(compact('results'));
		$this->controller->set('_serialize', 'results');
		$this->controller->set(
			'_jsonOptions',
			JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
		);
	}

/**
 * Handle validation error
 *
 * @param array $errors validation errors
 * @param string $message エラーメッセージ
 * @return bool true on success, false on error
 * @SuppressWarnings(PHPMD.DevelopmentCodeFragment)
 */
	public function handleValidationError($errors, $message = null) {
		if (! $errors) {
			return true;
		}

		$this->controller->validationErrors = $errors;

		if (! $message) {
			$message = __d('net_commons', 'Failed on validation errors. Please check the input data.');
		}
		if (Configure::read('debug')) {
			CakeLog::info('[ValidationErrors] ' . $this->controller->request->here());
			CakeLog::info(print_r($errors, true));
			//CakeLog::info(print_r($this->request->data, true));
		}

		$this->setFlashNotification($message, array(
			'class' => 'danger',
			'name' => 'Bad Request',
			'message' => $message,
			'interval' => self::ALERT_VALIDATE_ERROR_INTERVAL,
			'error' => ['validationErrors' => $errors]
		), 400);
		return false;
	}

/**
 * Used to set a session variable that can be used to output messages in the view.
 *
 * @param string $message message
 * @param array $params Parameters to be sent to layout as view variables
 * @param int $status status code
 * @return void
 */
	public function setFlashNotification($message, $params = array(), $status = 200) {
		if (is_string($params)) {
			$params = array('class' => $params);
		}

		if (isset($params['element'])) {
			$element = $params['element'];
			unset($params['element']);
		} else {
			$element = 'common_alert';
		}

		$params = Hash::merge(array(
			'class' => 'danger',
			'interval' => null,
			'ajax' => $this->controller->request->is('ajax'),
		), $params);

		if ($params['interval'] === null && $params['class'] !== 'danger') {
			$params['interval'] = self::ALERT_SUCCESS_INTERVAL;
		}

		if ($params['ajax']) {
			$this->renderJson($params, $message, $status);
		} else {
			$this->controller->Flash->set($message, [
				'element' => 'NetCommons.' . $element, 'params' => $params
			]);
		}
	}

/**
 * bodyタグの直下に強制的に埋め込むHTMLタグ。特にリダイレクト時に使用する
 *
 * @param string $html HTML
 * @return void
 */
	public function setAppendHtml($html) {
		$this->controller->Session->write('appendHtml', $html);
	}
}
