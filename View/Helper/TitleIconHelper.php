<?php
/**
 * TitleIconHelper
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');

/**
 * Title Icon Helper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class TitleIconHelper extends AppHelper {

/**
 * 概要
 *
 * タイトルアイコンを設定するピッカーを生成するHelper、および
 * 設定されたタイトルアイコンを表示するHelperを提供します。
 *
 * タイトルアイコンピッカー：
 * これを使うことでinput(type=text)の前にタイトルアイオンピッカーのボタンを
 * アドオンとして付与することができます
 * Cakephp通常のinput要素に付ける場合と、Angularで生成されるinput要素に付ける場合で
 * 使用方法が異なります
 * 現在のバージョンはCakephp通常のinput要素に付与する場合のメソッドのみ提供しています
 *
 * 利用方法
 * 通常のHelper利用と同様です NetCommons.TitleIconをHelperとして組み込んでください。
 * Viewでは、inputWithTitleIconメソッドを呼び出します。
 * inputWithTitleIconでは最低限、タイトルアイコンデータを設定するフィールド名と
 * タイトルデータを設定するフィールド名を引数として与える必要があります。
 * その他、タイトルinput-textに与える追加のoption情報を与えることができます。
 * optionではbetweenとafterが使用できません。これは内部でタイトルアイコンピッカーのaddonを
 * 設定するためにbetweenとafterを占有しているからです。
 *
 * #### サンプルコード
 * ```
 * 	public $helpers = array(
 *     'NetCommons.TitleIcon',
 *  );
 * <?php echo $this->TitleIcon->inputWithTitleIcon('title', 'Questionnaire.title_icon',
 *     array('label' => __d('questionnaires', 'Title'),
 *           'ng-model' => 'questionnaires.questionnaire.title'
 *   ));?>
 * ```
 */
/**
 * Other helpers used by FormHelper
 *
 * @var array
 */
	public $helpers = array(
		'NetCommonsForm',
		'NetCommonsHtml',
		'Form',
		'Html'
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
		$this->NetCommonsHtml->script('/net_commons/js/title_icon_picker.js');
		parent::beforeRender($viewFile);
	}

/**
 * Get input type text with title icon picker button
 *
 * @param string $fieldName input field name
 * @param string $titleIconFieldName title icon field name
 * @param array $options option for input
 * @return string input and title icon picker button
 */
	public function inputWithTitleIcon($fieldName, $titleIconFieldName, $options = array()) {
		$options['between'] = $this->titleIconPicker($titleIconFieldName);
		$options['after'] = '</div>';
		$html = $this->NetCommonsForm->input($fieldName, $options);
		return $html;
	}
/**
 * Get title icon picker
 *
 * @param string $name title icon field name
 * @param string $titleIcon title icon value (if you want to display images diffrent from name field value)
 * @return string title icon picker and input field.
 */
	public function titleIconPicker($name, $titleIcon = null) {
		if (! isset($titleIcon)) {
			$titleIcon = $this->request->data($name);
		}

		$html = $this->_getTitleIconPickerOpenTag($titleIcon);

		$html .= $this->NetCommonsForm->unlockField($name);
		$html .= $this->NetCommonsForm->hidden($name, array('value' => '{{titleIcon}}'));

		$html .= $this->_getTitleIconPickerCloseTag();

		return $html;
	}

/**
 * Get title icon picker ( for angular )
 *
 * @param string $ngAttrName title icon field name
 * @param string $ngModel ng-model name
 * @param string $titleIcon title icon value
 * @return string title icon picker and input field.
 */
	public function ngTitleIconPicker($ngAttrName, $ngModel, $titleIcon) {
		$ngModelAttribute = ' ng-model="' . $ngModel . '" ';

		$html = $this->_getTitleIconPickerOpenTag($titleIcon, $ngModelAttribute);

		$html .= $this->NetCommonsForm->unlockField($ngAttrName);
		$html .= '<input type="hidden" ng-attr-name="' . $ngAttrName . '" ng-value="' . $ngModel . '" />';

		$html .= $this->_getTitleIconPickerCloseTag();

		return $html;
	}

/**
 * Creates a `<img>` tag for title icon.
 *
 * @param string $filePath The title icon's file path.
 * @return string img tag.
 */
	public function titleIcon($filePath) {
		if (empty($filePath)) {
			return '';
		}
		$fileName = basename($filePath);
		if (! file_exists(APP . 'Plugin/NetCommons/webroot/img/title_icon/' . $fileName)) {
			return '';
		}
		$alt = $this->_getAltName($fileName);
		$output = $this->Html->image($filePath, array('alt' => $alt, 'title' => $alt, 'class' => 'nc-title-icon'));
		return $output;
	}

/**
 * getTitleIconPickerOpenTag
 *
 * @param string $titleIcon title icon value
 * @param string $ngModelAttribute ng-model
 * @return string open tag for title icon picker
 */
	protected function _getTitleIconPickerOpenTag($titleIcon, $ngModelAttribute = '') {
		$icons = $this->_getIconFiles();
		$html = '<div class="input-group" ng-controller="ncTitleIconPickerCtrl" title-icon="' . $titleIcon . '">';
		$html .= '<nc-title-icon-picker class="input-group-btn" title-icon="' . $titleIcon . '" ' . $ngModelAttribute . ' icons="' . str_replace('"', '\'', $icons) . '">';
		return $html;
	}
/**
 * _getTitleIconPickerCloseTag
 *
 * @return string end tag for title icon picker
 */
	protected function _getTitleIconPickerCloseTag() {
		return '</nc-title-icon-picker>';	//</div>';
	}

/**
 * _getIconFiles
 *
 * @return string icon file paths
 */
	protected function _getIconFiles() {
		// アイコンフォルダー
		$dir = new Folder(APP . 'Plugin/NetCommons/webroot/img/title_icon');
		// アイコンファイル名取り出し
		$iconFileNames = $dir->find('.*\.svg', true);

		$icons = array();
		$icons[] = array(
			'path' => '',
			'alt' => __d('net_commons', 'icon_cancel')
		);
		foreach ($iconFileNames as $file) {
			$path = '/net_commons/img/title_icon/' . $file;
			$alt = $this->_getAltName($file);
			$icons[] = array(
				'path' => $path,
				'alt' => $alt
			);
		}
		return json_encode($icons);
	}

/**
 * _getAltName
 *
 * @param string $file icon file name
 * @return string icon file alts
 */
	protected function _getAltName($file) {
		return __d('net_commons', preg_replace('/^[0-9]{2}_[0-9]{3}_/', '', pathinfo($file, PATHINFO_FILENAME)));
	}
}
