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

App::uses('CurrentGetAppObject', 'NetCommons.Lib');

/**
 * NetCommonsの機能に必要な情報(システム系)を取得する内容をまとめたUtility
 *
 * @property Plugin $Plugin Pluginモデル
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Utility
 */
class CurrentGetFrame extends CurrentGetAppObject {

/**
 * 使用するモデル
 *
 * @var array
 */
	protected $_uses = [
		'Frame' => 'Frames.Frame',
		'Plugin' => 'PluginManager.Plugin',
	];

/**
 * インスタンスの取得
 *
 * @param Controller $controller コントローラ
 * @return CurrentGetSystem
 */
	public static function getInstance(Controller $controller) {
		return parent::_getInstance($controller, __CLASS__);
	}

/**
 * BoxIdからフレームデータを取得
 *
 * @return array
 */
	private function __makeFields() {
		return $language;
	}

/**
 * 多言語のフレーム取得のためのjoinsを生成する
 *
 * @return array
 */
	private function __makeJoinsByMultipleLang() {
		return $language;
	}

/**
 * 単一言語のフレーム取得のためのjoinsを生成する
 *
 * @return array
 */
	private function __makeJoinsBySingleLang() {
		return $language;
	}

/**
 * フレームデータを取得
 *
 * @param array $boxIds ボックスIDリスト
 * @return array
 */
	public function findFramesByBoxIds($boxIds) {
		$fields = $this->__makeFields();


		$query = array(
			'recursive' => -1,
			'conditions' => array(
				'Frame.is_deleted' => false,
				'Frame.box_id' => $boxIds,
			),
			'order' => array(
				'Frame.weight'
			),
		);



		return $language;
	}

}
