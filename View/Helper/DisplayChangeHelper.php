<?php
/**
 * DisplayChangeHelper
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');

/**
 * DisplayChangeHelper
 *
 * @author Mitsuru Mutaguchi <mutaguchi@opensource-workshop.jp>
 * @package NetCommons\NetCommons\View\Helper
 */
class DisplayChangeHelper extends AppHelper {

/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.NetCommonsHtml',
	);

/**
 * 表示切替element
 * displayTypeによってcss, js, elementを切り替えます。
 * ### 以下必要
 * * DisplayChangeHelperの読み込み. 表示切替が必要なコントローラ、ヘルパー等
 * * DisplayChangeHelper::element()実行
 * * 対応するプラグインのframe_settings系テーブルに displayType 追加  ex) menu_frame_settings.display_type
 * * 表示設定画面。基本はブロック設定画面にタブで「表示設定」を作る。メニュープラグインは例外。
 * * frame_settings系テーブルのモデル
 * * コントローラでframe_settings系のデータをviewにセット
 *
 * @param string $displayType 表示タイプ
 * @return string HTMLタグ
 * @see https://github.com/NetCommons3/Menus/blob/master/View/Helper/MenuHelper.php#L35 参考：$helpers、DisplayChangeHelperの読み込み。ヘルパー
 * @see https://github.com/NetCommons3/Menus/blob/master/View/Helper/MenuHelper.php#L60 参考：renderMain()、DisplayChangeHelper::element()実行
 * @see https://github.com/NetCommons3/Menus/blob/master/View/Menus/index.ctp 参考：renderMain()呼び出し
 * @see https://github.com/NetCommons3/Menus/blob/master/Config/Schema/schema.php#L56 参考：対応するプラグインのframe_settings系テーブルに displayType 追加
 * @see https://github.com/NetCommons3/Menus/blob/master/View/MenuFrameSettings/edit.ctp 参考：表示設定画面
 * @see https://github.com/NetCommons3/Menus/blob/master/Model/MenuFrameSetting.php 参考：frame_settings系テーブルのモデル
 * @see https://github.com/NetCommons3/Menus/blob/master/Model/MenuFrameSetting.php 参考：コントローラでframe_settings系のデータをセット
 * @see https://github.com/NetCommons3/Menus/blob/master/Controller/MenusController.php#L56 参考：コントローラでframe_settings系のデータをviewにセット
 * @see https://github.com/NetCommons3/Menus/tree/master/View/Elements/Menus 参考：Elements/Menusのディレクトリ構成
 */
	public function element($displayType) {
		$html = '';
		$pluginUnderscore = $this->_View->params['plugin'];
		$pluginCamel = Inflector::camelize($pluginUnderscore);

		// スタイルシートの読み込み
		// ex）$displayType=header でcssあれば /menus/css/header/style.css 読み込み
		//                            なければ /menus/css/style.css 読み込み
		//                            上記（/menus/css/style.css）もなければ読み込まない
		$cssPath = CakePlugin::path($pluginCamel) .
			WEBROOT_DIR . DS . 'css' . DS . $displayType . DS . 'style.css';
		$cssPathDefault = CakePlugin::path($pluginCamel) . WEBROOT_DIR . DS . 'css' . DS . 'style.css';
		if (file_exists($cssPath)) {
			$html .= $this->NetCommonsHtml->css('/' . $pluginUnderscore .
				'/css/' . $displayType . '/style.css');
		} elseif (file_exists($cssPathDefault)) {
			$html .= $this->NetCommonsHtml->css('/' . $pluginUnderscore . '/css/style.css');
		}

		// JSの読み込み
		// ex）$displayType=header でjsあれば  /menus/js/header/menus.js 読み込み
		//                            なければ /menus/js/menus.js 読み込み
		//                            上記（/menus/js/menus.js）もなければ読み込まない
		$jsPath = CakePlugin::path($pluginCamel) .
					WEBROOT_DIR . DS . 'js' . DS . $displayType . DS . $pluginUnderscore . '.js';
		$jsPathDefault = CakePlugin::path($pluginCamel) .
					WEBROOT_DIR . DS . 'js' . DS . $pluginUnderscore . '.js';
		if (file_exists($jsPath)) {
			$html .= $this->NetCommonsHtml->script('/' . $pluginUnderscore .
				'/js/' . $displayType . '/' . $pluginUnderscore . '.js');
		} elseif (file_exists($jsPathDefault)) {
			$html .= $this->NetCommonsHtml->script('/' . $pluginUnderscore .
				'/js/' . $pluginUnderscore . '.js');
		}

		$controllerCamel = Inflector::camelize($this->_View->params['controller']);

		// HTML表示
		// ex）$displayType=header でelementあれば Menus.Menus/header/index 読み込み
		//                                なければ Menus.Menus/index 読み込み
		// elementはどちらかが必ずある想定
		$elementPath = $pluginCamel . '.' . $controllerCamel . '/' . $displayType . '/' .
			$this->_View->params['action'];
		if ($this->_View->elementExists($elementPath)) {
			$html .= $this->_View->element($elementPath);
		} else {
			$html .= $this->_View->element($pluginCamel . '.' . $controllerCamel . '/' .
				$this->_View->params['action']);
		}

		return $html;
	}
}
