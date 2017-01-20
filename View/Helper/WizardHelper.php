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
 * #### コントローラの定義(helpersのサンプル)
 * https://github.com/NetCommons3/Rooms/blob/master/Controller/RoomsAppController.php#L73-L98
 * ```
 * 	public $helpers = array(
 * 		'NetCommons.Wizard' => array(
 * 			'navibar' => array(
 * 				self::WIZARD_ROOMS => array(
 * 					'url' => array(
 * 						'controller' => 'rooms',
 * 						'action' => 'add',
 * 					),
 * 					'label' => array('rooms', 'General setting'),
 * 				),
 * 				self::WIZARD_ROOMS_ROLES_USERS => array(
 * 					'url' => array(
 * 						'controller' => 'rooms_roles_users',
 * 						'action' => 'edit',
 * 					),
 * 					'label' => array('rooms', 'Edit the members to join'),
 * 				),
 * 				self::WIZARD_PLUGINS_ROOMS => array(
 * 					'url' => array(
 * 						'controller' => 'plugins_rooms',
 * 						'action' => 'edit',
 * 					),
 * 					'label' => array('rooms', 'Select the plugins to join'),
 * 				),
 * 			),
 * 			'cancelUrl' => null
 * 		),
 * 	);
 * ```
 *
 * #### viewファイルのWizardバーサンプル
 * https://github.com/NetCommons3/Rooms/blob/master/View/PluginsRooms/edit.ctp#L17
 * ```
 * echo $this->Wizard->navibar(RoomsAppController::WIZARD_PLUGINS_ROOMS);
 * ```
 *
 * ##### viewファイルのボタンサンプル
 * (ワークフローなし)<br>
 * https://github.com/NetCommons3/Rooms/blob/master/View/PluginsRooms/edit.ctp#L17
 * ```
 * echo $this->Wizard->buttons(RoomsAppController::WIZARD_PLUGINS_ROOMS);
 * ```
 * (ワークフローあり)
 * ```
 * echo $this->Wizard->workflowButtons('Questionnaire.status');
 * ```
 *
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
		'Workflow.Workflow',
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
			$this->settings['cancelUrl'] = NetCommonsUrl::backToPageUrl(null);
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

			if ($backLink && isset($step['url'])) {
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
 * @param string $actKey アクティブのキー
 * @param array $cancelOpt キャンセルボタンのオプション
 * @param array $prevOpt 前へボタンのオプション
 * @param array $nextOpt 次へ、決定ボタンのオプション
 * @param array $isBlock ブロックに関するプラグインのウィザードかどうか
 * @return string HTML
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function buttons($actKey, $cancelOpt = [], $prevOpt = [], $nextOpt = [], $isBlock = false) {
		$output = '';

		//ウィザードの状態取得
		list($prev, $next) = $this->__wizardStep($actKey);

		//キャンセルボタン
		if ($isBlock) {
			$cancelUrl = NetCommonsUrl::blockUrl(
				Hash::get($cancelOpt, 'url', $this->settings['cancelUrl'])
			);
		} else {
			$cancelUrl = NetCommonsUrl::actionUrlAsArray(
				Hash::get($cancelOpt, 'url', $this->settings['cancelUrl'])
			);
		}
		$cancelTitle = Hash::get($cancelOpt, 'title', __d('net_commons', 'Cancel'));
		$output .= $this->Button->cancel($cancelTitle, $cancelUrl, $cancelOpt);

		//前へボタン
		if ($prev) {
			if ($isBlock) {
				$prevUrl = NetCommonsUrl::blockUrl(Hash::get($prevOpt, 'url', $prev['url']));
			} else {
				$prevUrl = NetCommonsUrl::actionUrlAsArray(Hash::get($prevOpt, 'url', $prev['url']));
			}
			$prevlTitle = Hash::get($prevOpt, 'title', __d('net_commons', 'BACK'));
			$prevOpt['icon'] = Hash::get($prevOpt, 'icon', 'chevron-left');
			$output .= $this->Button->cancel($prevlTitle, $prevUrl, $prevOpt);
		}

		//次へ・決定ボタン
		if ($next) {
			$nextTitle = Hash::get($nextOpt, 'title', __d('net_commons', 'NEXT'));
			$nextOpt['icon'] = Hash::get($nextOpt, 'icon', 'chevron-right');
		} else {
			$nextTitle = Hash::get($nextOpt, 'title', __d('net_commons', 'OK'));
		}
		$output .= $this->Button->save($nextTitle, $nextOpt);

		return $output;
	}

/**
 * ウィザードボタン
 *
 * @param string $statusName ステータスのフィールド名("Modelname.fieldname")
 * @param array $cancelUrl キャンセルURL
 * @param array $prevUrl 前へURL
 * @param array $panel panel-footerを表示するかどうか
 * @return string HTML
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function workflowButtons($statusName, $cancelUrl = null, $prevUrl = null, $panel = false) {
		$output = '';

		$keys = array_keys($this->settings['navibar']);
		$activeKey = array_pop($keys);

		//ウィザードの状態取得
		list($prev, ) = $this->__wizardStep($activeKey);

		//キャンセルURL
		if (! $cancelUrl) {
			$cancelUrl = $this->settings['cancelUrl'];
		}

		//前へURL
		if (! $prevUrl && $prev) {
			$prevUrl = NetCommonsUrl::blockUrl($prev['url']);
		}

		$output .= $this->Workflow->buttons($statusName, $cancelUrl, $panel, $prevUrl, true);

		return $output;
	}

/**
 * ウィザードの状態取得
 *
 * @param string $activeKey アクティブのキー
 * @return array $activeKeyがnullの場合、$nextは最後の
 */
	private function __wizardStep($activeKey) {
		//ウィザードの状態取得
		$current = null;
		$prev = null;
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

		return array($prev, $next);
	}

}
