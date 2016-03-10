<?php
/**
 * Created by PhpStorm.
 * User: ryuji
 * Date: 15/03/06
 * Time: 14:57
 */
App::uses('AppHelper', 'View/Helper');

/**
 * Class BlogsFormatHelper
 * ex)
 *
 * Controller
 *
 * ```php
 * $helpers = [
 *     'NetCommons.SnsButton',
 * ];
 * ```
 *
 * View
 *
 * ```view.ctp
 * echo $this->SnsButton->twitter($contentPermLink);
 * echo $this->SnsButton->facebook($contentPermLink);
 * ```
 */
class SnsButtonHelper extends AppHelper {

/**
 * @var array helpers
 */
	public $helpers = array(
		'Html',
	);

/**
 * @var bool scriptロード済みならtrue
 */
	protected static $_loaded = [
		'facebook' => false,
		'twitter' => false,
	];

/**
 * facebookボタン用script
 *
 * @return string
 */
	protected function _facebookScript() {
		$out = '';
		if (self::$_loaded['facebook'] === false) {
			$this->Html->scriptBlock(
				"(function (d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s);
				js.id = id;
				js.src = \"//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.3\";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));",
				['inline' => false]
			);
			self::$_loaded['facebook'] = true;
			$out .= '<div id="fb-root"></div>';
		}
		return $out;
	}

/**
 * twitterボタン用script
 *
 * @return string
 */
	protected function _twitterScript() {
		$out = '';
		if (self::$_loaded['twitter'] === false) {
			$this->Html->scriptBlock(
				"!function (d, s, id) {
							var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
							if (!d.getElementById(id)) {
								js = d.createElement(s);
								js.id = id;
								js.src = p + '://platform.twitter.com/widgets.js';
								fjs.parentNode.insertBefore(js, fjs);
							}
						}(document, 'script', 'twitter-wjs');",
				['inline' => false]
			);
			self::$_loaded['twitter'] = true;
		}
		return $out;
	}

/**
 * facebook ボタン
 *
 * @param string $permLink コンテンツのパーマリンク
 * @return string ボタンタグ
 */
	public function facebook($permLink) {
		$out = $this->_facebookScript();
		$out .= '<div class="fb-like pull-left" data-href="' . $permLink . '" data-layout="button_count" data-action="like"
				 data-show-faces="false" data-share="false"></div>';
		return $out;
	}

/**
 * twitter ボタン
 *
 * @param string $permLink コンテンツのパーマリンク
 * @return string ボタンタグ
 */
	public function twitter($permLink) {
		$out = $this->_twitterScript();
		$out .= '<a href="https://twitter.com/share" class="twitter-share-button" data-url="' . $permLink . '">Tweet</a>';
		return $out;
	}
}