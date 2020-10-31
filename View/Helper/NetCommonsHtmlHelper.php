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
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
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
 * 一度変換を行ったものは、何度も変換処理(preg_match)を行わないようにするため
 *
 * @var array
 */
	private static $__convertPaths = [];

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
 * webrootパスの変換を行う
 *
 * @param array $paths URLパス(css,js,img)
 * @return array
 */
	private function __convertWebrootPath($paths) {
		$paths = (array)$paths;
		$covPaths = [];

		foreach ($paths as $path) {
			if (isset(self::$__convertPaths[$path])) {
				$covPaths[] = self::$__convertPaths[$path];
				continue;
			}

			$match = [];
			$convUrl = $path;
			if (is_string($path) &&
					preg_match('#^/([a-z_0-9]+)/(img|css|js)/(.+)$#', $path, $match)) {
				$wwwWebrootPath = WWW_ROOT . $match[2] . DS . $match[1] . DS . $match[3];
				// ucwords()の第2引数は、php5.4.32, 5.5.16から追加された。CentOS7のphpは5.4.16 のため、動かない。see) http://php.net/manual/ja/function.ucwords.php
				//$plugin = preg_replace('/_/', '', ucwords($match[1], '_'));
				$plugin = preg_replace('/_/', ' ', $match[1]);
				$plugin = preg_replace('/ /', '', ucwords($plugin));
				if (CakePlugin::loaded($plugin)) {
					$pluginWebrootPath =
							CakePlugin::path($plugin) . WEBROOT_DIR . DS . $match[2] . DS . $match[3];
					if (file_exists($wwwWebrootPath) && file_exists($pluginWebrootPath)) {
						$wwwTimeStamp = filemtime($wwwWebrootPath);
						$pluginTimeStamp = filemtime($pluginWebrootPath);
						if ($wwwTimeStamp >= $pluginTimeStamp) {
							$convUrl = '/' . $match[2] . '/' . $match[1] . '/' . $match[3];
						}
					}
				}
			}
			self::$__convertPaths[$path] = $convUrl;
			$covPaths[] = $convUrl;
		}

		return $covPaths;
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

		$url = $this->__convertWebrootPath($url);
		$url = $this->__convertCDNUrls($url);
		return $this->Html->script($url, array_merge($defaultOptions, $options));
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

		$path = $this->__convertWebrootPath($path);
		$path = $this->__convertCDNUrls($path);
		return $this->Html->css($path, array_merge($defaultOptions, $options));
	}

/**
 * Google JSON Style Guideに沿ってJSON形式の出力
 *
 * @param array $results 出力結果配列
 * @param string $name レスポンスメッセージ
 * @param int $status ステータスコード
 * @param bool $camelConv キャメル形式にコンバートするかどうか
 * @return string JSON形式の文字列
 * @link https://google.github.io/styleguide/jsoncstyleguide.xml Google JSON Style Guide
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function json($results = [], $name = 'OK', $status = 200, $camelConv = true) {
		//if (! $results) {
		//	$results = $this->_View->viewVars;
		//}
		$results = array_merge([
			'name' => $name,
			'code' => $status,
		], $results);

		if ($camelConv) {
			$camelizeData = NetCommonsAppController::camelizeKeyRecursive($results);
		} else {
			$camelizeData = $results;
		}
		$encodeOption = JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT;
		return json_encode($camelizeData, $encodeOption);
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
		if (is_string($path)) {
			$paths = $this->__convertWebrootPath($path);
			$path = $paths[0];
		}
		$path = $this->__convertCDNUrls($path);
		$path = $this->__getUrl($path, $options);
		$output = $this->Html->image($path, $options);
		return $output;
	}

/**
 * URLの取得
 *
 * @param string|array|null $url URL
 * @param bool|array $full フルパスで表示するか否か
 *   arrayを指定する場合、
 *    - escape - エスケープの有無
 *    - full - フルパスで出力するか否か
 *    - hasBlock - block_idをURLに含めるか否か
 * @return string URL
 * @link http://book.cakephp.org/2.0/ja/core-libraries/helpers/html.html#HtmlHelper::url HtmlHelper::url
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function url($url = null, $full = false) {
		//URLの設定
		if (is_string($url)) {
			$paths = $this->__convertWebrootPath($url);
			$url = $paths[0];
		}

		if (is_array($full)) {
			$options = $full;
		} else {
			$options = [];
		}

		$url = $this->__getUrl($url, $options);
		if ($full) {
			$output = $this->Html->url($url, $full);
		} else {
			$output = $this->__convertUrlString($url);
		}
		return $output;
	}

/**
 * URLコンバート処理
 *
 * @param array|string|null $url URL
 * @return string URL
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	private function __convertUrlString($url) {
		if (is_array($url) &&
				isset($url['plugin']) && isset($url['controller']) && isset($url['action'])) {
			$urlString = '/' . $url['plugin'] . '/' . $url['controller'] . '/' . $url['action'];
			unset($url['plugin'], $url['controller'], $url['action']);

			foreach ($url as $k => $u) {
				if ($k === '?') {
					continue;
				}
				if (is_numeric($k)) {
					$urlString .= '/' . rawurlencode($u);
				} else {
					$urlString .= '/' . rawurlencode($k) . ':' . rawurlencode($u);
				}
			}
			if (!empty($url['?'])) {
				$urlString .= '?' . http_build_query($url['?'], null, '&');
			}
		} else {
			$urlString = $url;
		}

		//URLの設定
		if (is_string($urlString)) {
			if (substr($urlString, 0, 1) === '/' &&
					! substr($urlString, 1, 1) === '/') {
				return $this->_View->request->base . h($urlString);
			} elseif ($urlString === '#') {
				return $urlString;
			} else {
				return $this->Html->url($urlString);
			}
		} else {
			return $this->Html->url($urlString);
		}
	}

/**
 * タイトル,urlの生成
 *
 * @param string $title `<a>`のタイトル
 * @param string|array $url URL
 * @param array &$options HTML属性オプション
 * @return array
 */
	private function __parseLink($title, $url, &$options) {
		$escapeTitle = true;
		if ($url !== null) {
			$url = $this->__convertUrlString($url);
		} else {
			$url = $this->__convertUrlString($title);
			$title = htmlspecialchars_decode($url, ENT_QUOTES);
			$title = h(urldecode($title));
			$escapeTitle = false;
		}

		if (isset($options['escapeTitle'])) {
			$escapeTitle = $options['escapeTitle'];
			unset($options['escapeTitle']);
		} elseif (isset($options['escape'])) {
			$escapeTitle = $options['escape'];
		}

		if ($escapeTitle === true) {
			$title = h($title);
		} elseif (is_string($escapeTitle)) {
			$title = htmlentities($title, ENT_QUOTES, $escapeTitle);
		}

		return ['title' => $title, 'url' => $url];
	}

/**
 * CDNを介するようなURLに変換
 *
 * @param string|array $urls 変換するURL
 * @return string
 */
	private function __convertCDNUrls($urls) {
		$httpHost = $_SERVER['HTTP_HOST'] ?? '';
		if (strncmp($httpHost, 'member-', 7) !== 0) {
			return $urls;
		}
		if (is_string($urls)) {
			return $this->__convertCDNUrl($urls);
		}
		foreach ($urls as &$url) {
			$url = $this->__convertCDNUrl($url);
		}
		return $urls;
	}

/**
 * CDNを介するようなURLに変換
 *
 * @param string $url 変換するURL
 * @return string
 */
	private function __convertCDNUrl($url) {
		if (strncmp($url, '/', 1) === 0 && strpos($url, 'bootstrap.min.css') == false
				&& strpos($url, 'tinymce.min.js') == false) {
			$httpHost = $_SERVER['HTTP_HOST'] ?? '';
			$url = 'https://' . substr($httpHost, 7) . $url;
		}
		return $url;
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
		if (!empty($options['confirm']) || array_key_exists('default', $options)) {
			$output = $this->Html->link($title, $url, $options);
		} else {
			$link = $this->__parseLink($title, $url, $options);
			$parseAttribute = $this->_parseAttributes($options);
			$output = sprintf('<a href="%s"%s>%s</a>', $link['url'], $parseAttribute, $link['title']);
		}
		return $output;
	}

/**
 * 表示切替element
 * displayTypeによってcss, js, elementを切り替えます。
 * ### 以下必要
 * * NetCommonsHtmlHelper::elementDisplayChange()呼び出し
 * * 対応するプラグインのframe_settings系テーブルに displayType 追加  ex) menu_frame_settings.display_type
 * * 表示設定画面。基本はブロック設定画面にタブで「表示設定」を作る。メニュープラグインは例外。
 * * frame_settings系テーブルのモデル
 * * コントローラでframe_settings系のデータをviewにセット
 *
 * @param string $displayType 表示タイプ
 * @return string HTMLタグ
 * @see https://github.com/NetCommons3/Menus/blob/master/View/Helper/MenuHelper.php#L60 参考：renderMain()、NetCommonsHtmlHelper::elementDisplayChange()呼び出し
 * @see https://github.com/NetCommons3/Menus/blob/master/View/Menus/index.ctp 参考：renderMain()呼び出し
 * @see https://github.com/NetCommons3/Menus/blob/master/Config/Schema/schema.php#L56 参考：対応するプラグインのframe_settings系テーブルに displayType 追加
 * @see https://github.com/NetCommons3/Menus/blob/master/View/MenuFrameSettings/edit.ctp 参考：表示設定画面
 * @see https://github.com/NetCommons3/Menus/blob/master/Model/MenuFrameSetting.php 参考：frame_settings系テーブルのモデル
 * @see https://github.com/NetCommons3/Menus/blob/master/Model/MenuFrameSetting.php 参考：コントローラでframe_settings系のデータをセット
 * @see https://github.com/NetCommons3/Menus/blob/master/Controller/MenusController.php#L56 参考：コントローラでframe_settings系のデータをviewにセット
 * @see https://github.com/NetCommons3/Menus/tree/master/View/Elements/Menus 参考：Elements/Menusのディレクトリ構成
 */
	public function elementDisplayChange($displayType) {
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
			$html .= $this->css('/' . $pluginUnderscore . '/css/' . $displayType . '/style.css');
		} elseif (file_exists($cssPathDefault)) {
			$html .= $this->css('/' . $pluginUnderscore . '/css/style.css');
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
			$html .= $this->script('/' . $pluginUnderscore .
				'/js/' . $displayType . '/' . $pluginUnderscore . '.js');
		} elseif (file_exists($jsPathDefault)) {
			$html .= $this->script('/' . $pluginUnderscore .
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
