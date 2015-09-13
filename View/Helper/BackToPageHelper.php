<?php
/**
 * 後で削除
 * BackToPageHelper Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator co. <info@allcreator>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppHelper', 'View/Helper');

/**
 * BackToPageHelper Helper
 *
 * @author AllCreator co. <info@allcreator>
 * @package NetCommons\NetCommons\View\Helper
 */
class BackToPageHelper extends AppHelper {

/**
 * backToPageButton Go back to the page where the plugin has been first displayed
 *
 * @param string $title Title string to be displayed on the button
 * @param string $icon Icon to be displayed on the button (only to specify the last keyword of gliphs of bootstrap components)
 * @param string $size  '' is the default size : lg / sm / xs
 * @return string
 */
	public function backToPageButton($title, $icon = '', $size = '') {
		if (isset($this->request->params['requested'])) {
			return '';
		}
		$topUrl = $this->_View->viewVars['cancelUrl'];
		$iconElement = '';
		if ($icon != '') {
			$iconElement = '<span class="glyphicon glyphicon-' . $icon . '"></span>';
		}
		$sizeAttr = '';
		if ($size != '') {
			$sizeAttr = 'btn-' . $size;
		}
		$html = '<a class="btn btn-default ' . $sizeAttr . '" href="/' . $topUrl . '">' . $iconElement . $title . '</a>';

		return $html;
	}
}
