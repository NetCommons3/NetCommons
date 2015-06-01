<?php
/**
 * NetCommonsBlock Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

use visualCaptcha\Captcha;
use visualCaptcha\Session;

App::uses('Component', 'Controller');

App::import('Vendor', 'Captcha', array(
	'file' => 'visualcaptcha' . DS . 'src' . DS . 'visualCaptcha' . DS . 'Captcha.php'
));
App::import('Vendor', 'Session', array(
	'file' => 'visualcaptcha' . DS . 'src' . DS . 'visualCaptcha' . DS . 'Session.php'
));

/**
 * NetCommonsVisualCaptcha Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller\Component
 */
class NetCommonsVisualCaptchaComponent extends Component {

/**
 * call controller w/ associations
 *
 * @var object
 */
	public $controller = null;

/**
 * imageField Answer /r associations
 *
 * @var string
 */
	public $imageField = null;

/**
 * audioField Answer /r associations
 *
 * @var string
 */
	public $audioField = null;

/**
 * Called before the Controller::beforeFilter().
 *
 * @param Controller $controller Instantiating controller
 * @return void
 */
	public function initialize(Controller $controller) {
		$this->controller = $controller;
		// if Security component is used
		if (array_key_exists('Security', $this->controller->components)) {
			$this->imageField = $this->controller->Session->read('visualcaptcha.frontendData.imageFieldName');
			$this->audioField = $this->controller->Session->read('visualcaptcha.frontendData.audioFieldName');

			if ($this->imageField && $this->audioField) {
				$this->controller->Security->unlockedFields = array(
					$this->imageField,
					$this->audioField
				);
			}
		}
	}

/**
 * Called after the Controller::beforeFilter() and before the controller action
 *
 * @param Controller $controller Controller with components to startup
 * @return void
 * @throws ForbiddenException
 */
	public function startup(Controller $controller) {
	}

/**
 * generate visual captcha data and return it
 *
 * @param int $count display image count
 * @return string
 */
	public function generate($count = 5) {
		$session = new Session();
		//$assetsPath = VENDORS . 'emotionloop' . DS . 'visualcaptcha' . DS . 'src' . DS . 'visualCaptcha' . DS . 'assets';
		$lang = Configure::read('Config.language');
		$assetsPath = App::pluginPath('NetCommons') . 'Vendor' . DS . 'visual_captcha';
		$imageJsonPath =$assetsPath . DS . $lang . DS . 'images.json';
		$audioJsonPath = $assetsPath . DS . $lang . DS . 'audios.json';
		$captcha = new Captcha($session, $assetsPath, $this->__utilReadJSON($imageJsonPath), $this->__utilReadJSON($audioJsonPath));
		$captcha->generate($count);
		return json_encode($captcha->getFrontEndData());
	}

/**
 * generate visual captcha image data and return it
 *
 * @param int $index display image index
 * @return string
 */
	public function image($index) {
		$session = new Session();
		$captcha = new Captcha($session);
		return $captcha->streamImage(array(), $index, 0);
	}

/**
 * generate audio captcha data and return it
 *
 * @return streaming data
 */
	public function audio() {
		$session = new Session();
		$captcha = new Captcha($session);
		return $captcha->streamAudio(array(), 'mp3');
	}

/**
 * check input response
 *
 * @return bool
 */
	public function check() {
		$reqData = $this->controller->request->data;
		$session = new Session();
		$captcha = new Captcha($session);

		if (isset($reqData[$this->imageField])) {
			return $captcha->validateImage($reqData[$this->imageField]);
		} elseif (isset($reqData[$this->audioField])) {
			return $captcha->validateAudio($reqData[$this->audioField]);
		}

		return false;
	}

	// Read input file as JSON
	private function __utilReadJSON( $filePath ) {
		if ( !file_exists( $filePath ) ) {
			return null;
		}
		return json_decode( file_get_contents( $filePath ), true );
	}
}
