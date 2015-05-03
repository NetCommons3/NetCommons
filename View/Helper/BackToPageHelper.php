<?php
/**
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
 * getPageTopButton 最初のページに戻る
 *
 * @param int $frameId フレームID
 * @param string $title ボタンに表示するタイトル文字列
 * @param string $icon ボタンに表示するアイコン(bootstrap componentsのgliphsの最後のキーワードのみ指定する)
 * @param string $size  '' デフォルトサイズ : xs / sm / xs
 * @return string
 */
	public function backToPageButton($frameId, $title, $icon = '', $size = '') {
		if (isset($this->request->params['requested'])) {
			return '';
		}

		$Frame = Classregistry::init('Frames.Frame');
		$Page = Classregistry::init('Pages.Page');

		$frames = $Frame->find('first',
			array('conditions' => array('Frame.id' => $frameId)));
		$pages = $Page->find('first',
			array('conditions' => array('Page.id' => $frames['Box']['page_id'])));

		$topUrl = $pages['Page']['permalink'];
		$iconElement = '';
		if ($icon != '') {
			$iconElement = '<span class="glyphicon glyphicon-' . $icon . '"></span>';
		}
		$sizeAttr = '';
		if ($size != '') {
			$sizeAttr = 'btn-' . $size;
		}
		$html = '<a class="btn btn-default' . $sizeAttr . '" href="/' . $topUrl . '">' . $iconElement . $title . '</a>';

		return $html;
	}

}