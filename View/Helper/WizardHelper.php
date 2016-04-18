<?php
/**
 * Wizard Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * ウィザードHelper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class WizardHelper extends AppHelper {

/**
 * ヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Button',
		'NetCommons.NetCommonsHtml',
	);

/**
 * Before render callback. beforeRender is called before the view file is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		parent::beforeRender($viewFile);

		//ウィザード
		if (! isset($this->settings['navibar'])) {
			$this->settings['navibar'] = array();
		}
		if (! isset($this->settings['cancelUrl'])) {
			$this->settings['cancelUrl'] = NetCommonsUrl::backToPageUrl();
		}
	}

/**
 * ウィザードバー出力
 *
 * @param string $activeKey アクティブのキー
 * @param bool $small 小さいバーフラグ
 * @return string HTML出力
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function navibar($activeKey, $small = false) {
		$output = '';

		$stepWidth = ' style="width: ' . 100 / count($this->settings['navibar']) . '%;"';

		if ($small) {
			$smallCss = ' small';
		} else {
			$smallCss = '';
		}

		$output .= '<div class="progress wizard-steps">';

		$count = count($this->settings['navibar']);
		$index = 0;
		$backLink = true;
		foreach ($this->settings['navibar'] as $key => $step) {
			$index++;

			$badge = '<span class="badge">' . $index . '</span>';
			$currentClass = '';
			if ($key === $activeKey) {
				$currentClass = 'progress-bar ';
				$badge = '<span class="btn-primary">' . $badge . '</span>';
				$backLink = false;
			}
			$styleCss = $currentClass . 'wizard-step-item' . $smallCss . ' clearfix';
			$output .= '<div class="' . $styleCss . '"' . $stepWidth . '>';

			$output .= '<span class="wizard-step-item-title">' . $badge . ' ';

			if ($backLink) {
				$url = $this->NetCommonsHtml->url($step['url']);
				$output .= '<a href="' . $url . '">' . __d($step['label'][0], $step['label'][1]) . '</a>';
			} else {
				$output .= __d($step['label'][0], $step['label'][1]);
			}

			$output .= '</span>';
			if ($count > $index) {
				$output .= '<span class="glyphicon glyphicon-chevron-right pull-right"></span>';
			}

			$output .= '</div>';
		}

		$output .= '</div>';
		return $output;
	}

/**
 * URL出力
 *
 * @param string $activeKey アクティブのキー
 * @return string HTML出力
 */
	public function naviUrl($activeKey) {
		if ($activeKey === 'cancelUrl') {
			return $this->settings['cancelUrl'];
		} else {
			return Hash::get($this->settings['navibar'], $activeKey . '.url');
		}
	}

/**
 * ウィザードボタン
 *
 * @param string $activeKey アクティブのキー
 * @param array $cancelOptions キャンセルボタンのオプション
 * @param array $prevOptions 戻るボタンのオプション
 * @param array $nextOptions 次へ、決定ボタンのオプション
 * @return string HTML
 */
	public function buttons($activeKey, $cancelOptions = [], $prevOptions = [], $nextOptions = []) {
		$output = '';

		//キャンセルボタン
		$cancelUrl = $this->NetCommonsHtml->url(
			Hash::get($cancelOptions, 'url', $this->settings['cancelUrl'])
		);
		$cancelTitle = Hash::get($cancelOptions, 'title', __d('net_commons', 'Cancel'));
		$output .= $this->Button->cancel($cancelTitle, $cancelUrl, $cancelOptions);

		//ウィザードの状態取得
		$prev = null;
		$current = null;
		$next = null;
		$step = null;
		foreach ($this->settings['navibar'] as $key => $navibar) {
			if ($current) {
				$next = $step;
				break;
			}

			if ($key === $activeKey) {
				if ($step) {
					$prev = $step;
				}
				$current = $navibar;
			}

			$step = $navibar;
		}

		if ($prev) {
			$prevUrl = $this->NetCommonsHtml->url(Hash::get($prevOptions, 'url', $prev['url']));
			$prevlTitle = Hash::get($prevOptions, 'title', __d('net_commons', 'BACK'));
			$prevOptions['icon'] = Hash::get($prevOptions, 'icon', 'chevron-left');
			$output .= $this->Button->cancel($prevlTitle, $prevUrl, $prevOptions);
		}

		if ($next) {
			$nextTitle = Hash::get($nextOptions, 'title', __d('net_commons', 'NEXT'));
			$nextOptions['icon'] = Hash::get($nextOptions, 'icon', 'chevron-right');
		} else {
			$nextTitle = Hash::get($nextOptions, 'title', __d('net_commons', 'OK'));
		}
		$output .= $this->Button->save($nextTitle, $nextOptions);

		return $output;
	}

}
