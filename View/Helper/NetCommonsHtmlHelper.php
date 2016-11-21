<?php
/**
 * NetCommonsHtml Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');
App::uses('NetCommonsUrl', 'NetCommons.Utility');

/**
 * NetCommonsでHtmlHelperをOverrideしたHelper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class NetCommonsHtmlHelper extends AppHelper {

/**
 * 使用するHelpers
 *
 * - [HtmlHelper](http://book.cakephp.org/2.0/ja/core-libraries/helpers/html.html)
 *
 * @var array
 */
	public $helpers = array(
		'Html',
		'NetCommons.Date'
	);

/**
 * HtmlHelperラップ用マジックメソッド。
 *
 * 指定されたメソッドにより、各プラグインのHelperメソッドを呼び出します。
 *
 * #### $method の内容による出力
 * - <a id="method___call_mailHelp" name="method___call_mailHelp" class="anchor"></a>
 * NetCommonsHtml::mailHelp()<br>
 * [Mails.MailsHtml::help()](../../Mails/classes/MailsHtmlHelper.html#method_help)
 * の結果を出力する。
 *
 * - <a id="method___call_others" name="method___call_others" class="anchor"></a>
 * それ以外<br>
 * [HtmlHelper](http://book.cakephp.org/2.0/ja/core-libraries/helpers/html.html)
 * の各メソッドの結果を出力する。
 *
 * @param string $method メソッド
 * @param array $params パラメータ
 * @return string
 */
	public function __call($method, $params) {
		if ($method === 'mailHelp') {
			$this->MailsHtml = $this->_View->loadHelper('Mails.MailsHtml');
			$helper = $this->MailsHtml;
			$method = 'help';
		} elseif ($method === 'titleIcon') {
			$this->script('/net_commons/js/title_icon_picker.js');
			$helper = $this->_View->loadHelper('NetCommons.TitleIcon');
		} elseif ($method === 'dateFormat') {
			$helper = $this->Date;
		} elseif (in_array($method, ['handleLink', 'avatarLink'], true)) {
			$helper = $this->_View->loadHelper('Users.DisplayUser');
		} elseif (in_array($method, ['blockTitle', 'getBlockStatus'], true)) {
			$this->css('/blocks/css/style.css');
			$helper = $this->_View->loadHelper('Blocks.Blocks');
		} else {
			$helper = $this->Html;
		}
		return call_user_func_array(array($helper, $method), $params);
	}

/**
 * NetCommonsによるHtmlHelper::script()を共通化
 *
 * @param string|array $url javascriptファイルのURL
 * @param array|bool $options HTML属性のオプション
 * @return mixed `<script>`タグの出力
 * @link http://book.cakephp.org/2.0/ja/core-libraries/helpers/html.html#HtmlHelper::script HtmlHelper::script
 */
	public function script($url, $options = array()) {
		$defaultOptions = array(
			'plugin' => false,
			'once' => true,
			'inline' => false
		);

		return $this->Html->script($url, Hash::merge($defaultOptions, $options));
	}

/**
 * NetCommonsによるHtmlHelper::css()を共通化
 *
 * @param string|array $path CSS style sheetのパス
 * @param array $options HTML属性のオプション
 * @return string CSS `<link>` or `<style>`タグの出力
 * @link http://book.cakephp.org/2.0/ja/core-libraries/helpers/html.html#HtmlHelper::css HtmlHelper::css
 */
	public function css($path, $options = array()) {
		$defaultOptions = array(
			'plugin' => false,
			'once' => true,
			'inline' => false
		);

		return $this->Html->css($path, Hash::merge($defaultOptions, $options));
	}

/**
 * Google JSON Style Guideに沿ってJSON形式の出力
 *
 * @param array $results 出力結果配列
 * @param string $name レスポンスメッセージ
 * @param int $status ステータスコード
 * @return string JSON形式の文字列
 * @link https://google.github.io/styleguide/jsoncstyleguide.xml Google JSON Style Guide
 */
	public function json($results = [], $name = 'OK', $status = 200) {
		//if (! $results) {
		//	$results = $this->_View->viewVars;
		//}
		$results = array_merge([
			'name' => $name,
			'code' => $status,
		], $results);

		$camelizeData = NetCommonsAppController::camelizeKeyRecursive($results);

		return json_encode($camelizeData);
	}

/**
 * URL生成処理
 *
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string URL
 */
	private function __getUrl($url = null, $options = array()) {
		//URLの設定
		if (is_array($url)) {
			if (! isset($url['plugin'])) {
				$url['plugin'] = $this->_View->request->params['plugin'];
			}
			if (! isset($url['controller'])) {
				$url['controller'] = $this->_View->request->params['controller'];
			}
			if (! isset($url['action'])) {
				$url['action'] = $this->_View->request->params['action'];
			}
			if ($url['plugin'] === 'pages') {
				$options['hasBlock'] = false;
			}
		}

		if (! is_array($options) || Hash::get($options, 'hasBlock', true)) {
			$url = NetCommonsUrl::blockUrl($url);
		} else {
			$url = NetCommonsUrl::actionUrlAsArray($url);
		}
		return $url;
	}

/**
 * ImageのURLの取得
 *
 * @param mixed $path URL
 * @param array $options HTML属性オプション
 * @return string URL
 * @link http://book.cakephp.org/2.0/ja/core-libraries/helpers/html.html#HtmlHelper::url HtmlHelper::url
 */
	public function image($path, $options = array()) {
		//URLの設定
		$path = $this->__getUrl($path, $options);
		$output = $this->Html->image($path, $options);
		return $output;
	}

/**
 * URLの取得
 *
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string URL
 * @link http://book.cakephp.org/2.0/ja/core-libraries/helpers/html.html#HtmlHelper::url HtmlHelper::url
 */
	public function url($url = null, $options = array()) {
		//URLの設定
		$url = $this->__getUrl($url, $options);
		$output = $this->Html->url($url, $options);
		return $output;
	}

/**
 * `<a>`タグの出力
 *
 * @param string $title `<a>`のタイトル
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string `<a>`タグ
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function link($title = '', $url = null, $options = array()) {
		$url = $this->__getUrl($url, $options);
		$output = $this->Html->link($title, $url, $options);
		return $output;
	}

/**
 * Creates a `<a>` tag for add link. The type attribute defaults
 * 後で削除予定(現状、ブロック設定の一覧のリンクで使っている)
 *
 * @param string $title The anchor's caption. Not automatically HTML encoded
 * @param mixed $url Link url
 * @param array $options Array of options and HTML attributes.
 * @return string A HTML button tag.
 * @link http://book.cakephp.org/2.0/en/core-libraries/helpers/form.html#FormHelper::button
 */
	public function editLink($title = '', $url = null, $options = array()) {
		//URLの設定
		if (! isset($url['plugin'])) {
			$url['plugin'] = $this->_View->request->params['plugin'];
		}
		if (! isset($url['controller'])) {
			if (! isset($this->_View->viewVars['editActionController'])) {
				$url['controller'] = $this->_View->request->params['controller'];
			} else {
				$url['controller'] = $this->_View->viewVars['editActionController'];
			}
		}
		if (! isset($url['action'])) {
			$url['action'] = 'edit';
		}
		$url = NetCommonsUrl::blockUrl($url);

		return $this->Html->link($title, $url, $options);
	}

}
