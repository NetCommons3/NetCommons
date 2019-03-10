<?php
/**
 * NetCommonsの機能に必要な情報を取得する内容をまとめたUtility
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('LibAppObject', 'NetCommons.Lib');

/**
 * NetCommonsの機能に必要な情報(言語)を取得する内容をまとめたUtility
 *
 * @property Controller $_controller コントローラ
 * @property Language $Language Languageモデル
 * @property PluginsRole $PluginsRole PluginsRoleモデル
 * @property Plugin $Plugin Pluginモデル
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentLibLanguage extends LibAppObject {

/**
 * 使用するモデル
 *
 * @var array
 */
	public $uses = [
		'Language' => 'M17n.Language',
	];

/**
 * 言語ID
 *
 * @var string|null 数値型の文字列
 */
	private $__langId = null;

/**
 * インスタンスの取得
 *
 * @return CurrentLibLanguage
 */
	public static function getInstance() {
		return parent::_getInstance(__CLASS__);
	}

/**
 * インスタンスのクリア
 *
 * @return void
 */
	public static function resetInstance() {
		parent::_resetInstance(__CLASS__);
	}

/**
 * コントローラのセット
 *
 * @param Controller $controller コントローラ
 * @return void
 */
	public function initialize($controller = null) {
		parent::initialize($controller);

		if (empty($this->_controller->request->params['requested'])) {
			if (isset($this->_controller->request->query['lang']) &&
					! array_key_exists('search', $this->_controller->request->query)) {
				$langCode = $this->_controller->request->query['lang'];
				Configure::write('Config.language', $langCode);
				$this->_controller->Session->write('Config.language', $langCode);
			} elseif ($this->_controller->Session->check('Config.language')) {
				Configure::write('Config.language', $this->_controller->Session->read('Config.language'));
			}
		}
	}

/**
 * Configureにlanguageをセットする
 *
 * @param string $langCode コントローラ
 * @return void
 */
	public function setConfigure($langCode) {
		if ($this->Language->useDbConfig !== 'test' &&
				$langCode !== Configure::write('Config.language')) {
			Configure::write('Config.language', $langCode);
			$this->_controller->Session->write('Config.language', $langCode);
		}
	}

/**
 * 言語データを取得
 *
 * @return array
 */
	public function findLanguage() {
		$langCode = Configure::read('Config.language');

		$rseult = $this->Language->cacheRead('current', $langCode);
		if ($rseult) {
			return $rseult;
		}

		$language = $this->Language->getLanguage('first', array(
			'fields' => [
				'id', 'code', 'weight', 'is_active'
			],
			'conditions' => array(
				'code' => $langCode,
			)
		));
		if (! isset($language['Language'])) {
			$language = $this->Language->getLanguage('first', array(
				'fields' => [
					'id', 'code', 'weight', 'is_active'
				],
				'order' => 'weight'
			));
		}

		$this->Language->cacheWrite($language, 'current', $langCode);
		return $language;
	}

/**
 * 言語IDの取得
 *
 * @return string|null 数値型の文字列
 */
	public function getLangId() {
		if (! $this->__langId) {
			$language = $this->findLanguage();
			$this->__langId = $language['Language']['id'];
		}
		return $this->__langId;
	}

}
