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
		'NetCommons.NetCommonsHtml'
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
		if (! isset($this->settings['navbar'])) {
			return;
		}
	}

/**
 * ウィザード出力
 *
 * @param string $active アクティブのキー
 * @return string HTML出力
 */
	public function outputWizard($active = null, $small = false) {
		$output = '';

		$stepWidth = ' style="width: ' . 100 / count($this->settings['navbar']) . '%;"';

		if ($small) {
			$smallCss = ' small';
		} else {
			$smallCss = '';
		}

		$output .= '<div class="progress wizard-steps">';

		$count = count($this->settings['navbar']);
		$index = 0;
		$backLink = true;
		foreach ($this->settings['navbar'] as $key => $step) {
			$index++;

			$badge = '<span class="badge">' . $index . '</span>';
			$currentClass = '';
			if ($key === $active) {
				$currentClass = 'progress-bar ';
				$badge = '<span class="btn-primary">' . $badge . '</span>';
				$backLink = false;
			}
			$output .= '<div class="' . $currentClass . 'wizard-step-item' . $smallCss . ' clearfix"' . $stepWidth . '>';

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

}
