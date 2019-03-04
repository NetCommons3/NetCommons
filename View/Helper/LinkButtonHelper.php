<?php
/**
 * LinkButton Helper
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FormHelper', 'View/Helper');
App::uses('Container', 'Containers.Model');

/**
 * `<a>`のボタン Helper
 *
 * @package NetCommons\NetCommons\View\Helper
 */
class LinkButtonHelper extends FormHelper {

/**
 * 使用するヘルパ
 *
 * @var array
 */
	public $helpers = array(
		'Form',
		'Html',
		'NetCommons.Button',
		'NetCommons.NetCommonsHtml',
	);

/**
 * 追加ボタンHTMLの出力
 *
 * @param string $title タイトル
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string HTMLタグ
 */
	public function add($title = '', $url = null, $options = array()) {
		$output = '';

		if (! is_string($url)) {
			//URLの設定
			$defaultUrl = array(
				'plugin' => $this->_View->request->params['plugin'],
				'controller' => $this->_View->request->params['controller'],
			);
			if (! isset($url)) {
				$url = array(
					'action' => 'add',
					'frame_id' => Current::read('Frame.id'),
					//'page_id' => Current::read('Page.id'),
				);
			} elseif (count($url) === 1 && isset($url['block_id'])) {
				$url = array(
					'action' => 'add',
					'frame_id' => Current::read('Frame.id'),
					'block_id' => $url['block_id'],
				);
			}
			if (isset($this->_View->viewVars['addActionController'])) {
				$url['controller'] = $this->_View->viewVars['addActionController'];
			}
			$url = NetCommonsUrl::actionUrl(Hash::merge($defaultUrl, $url));
		}

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'plus',
			'iconSize' => $this->Button->getButtonSize(),
			'class' => 'btn btn-success nc-btn-style',
		), $options, array('escapeTitle' => false));

		//タイトル
		if (Hash::get($options, 'escapeTitle', true)) {
			$title = h($title);
		}
		if (! $title && $title !== false) {
			$title = __d('net_commons', 'Add');
		}

		$output .= $this->__getLinkHtml($title, $url, $inputOptions);
		return $output;
	}

/**
 * 編集ボタンHTMLの出力
 *
 * @param string $title タイトル
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string HTMLタグ
 */
	public function edit($title = '', $url = null, $options = array()) {
		$output = '';

		if (! isset($url)) {
			$url = array();
		}
		if (is_array($url)) {
			$defaultAction = Hash::get(
				$this->_View->viewVars, 'editActionController', $this->_View->request->params['controller']
			);
			$url['controller'] = Hash::get($url, 'controller', $defaultAction);
			$url['action'] = Hash::get($url, 'action', 'edit');
		}

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'edit',
			'iconSize' => $this->Button->getButtonSize(),
			'class' => 'btn btn-primary nc-btn-style'
		), $options, array('escapeTitle' => false));

		//タイトル
		if (Hash::get($options, 'escapeTitle', true)) {
			$title = h($title);
		}
		if (! $title && $title !== false) {
			$title = __d('net_commons', 'Edit');
		}

		$output .= $this->__getLinkHtml($title, $url, $inputOptions);
		return $output;
	}

/**
 * 検索ボタンHTMLの出力
 *
 * @param string $title タイトル
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string HTMLタグ
 */
	public function search($title = '', $url = null, $options = array()) {
		$output = '';

		if (! isset($url)) {
			$url = array();
		}
		if (is_array($url)) {
			$url = Hash::merge(array('action' => 'search'), $url);
		}

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'search',
			'iconSize' => $this->Button->getButtonSize(),
			'class' => 'btn btn-info nc-btn-style',
		), $options, array('escapeTitle' => false));

		//タイトル
		if (Hash::get($options, 'escapeTitle', true)) {
			$title = h($title);
		}
		if (! $title && $title !== false) {
			$title = __d('net_commons', 'Search');
		}

		$output .= $this->__getLinkHtml($title, $url, $inputOptions);
		return $output;
	}

/**
 * ソートボタンHTMLの出力
 *
 * @param string $title タイトル
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string HTMLタグ
 */
	public function sort($title = '', $url = null, $options = array()) {
		$output = '';

		if (! isset($url)) {
			$url = array();
		}
		if (is_array($url)) {
			$url = Hash::merge(array('action' => 'sort'), $url);
		}

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'sort',
			'iconSize' => $this->Button->getButtonSize(),
			'class' => 'btn btn-default nc-btn-style',
		), $options, array('escapeTitle' => false));

		if (Hash::get($options, 'escapeTitle', true)) {
			$title = h($title);
		}
		if (! $title && $title !== false) {
			$title = __d('net_commons', 'Sort');
		}

		$output .= $this->__getLinkHtml($title, $url, $inputOptions);
		return $output;
	}

/**
 * 一覧へボタンHTMLの出力
 *
 * @param string $title タイトル
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string HTMLタグ
 */
	public function toList($title = '', $url = null, $options = array()) {
		$output = '';

		if (! isset($url)) {
			$url = NetCommonsUrl::backToPageUrl(null, ['frame_id' => Current::read('Frame.id')]);
		}

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'arrow-left',
			'iconSize' => $this->Button->getButtonSize(),
			'class' => 'btn btn-default nc-btn-style',
		), $options, array('escapeTitle' => false));

		if (Hash::get($options, 'escapeTitle', true)) {
			$title = h($title);
		}
		if (! $title && $title !== false) {
			$title = __d('net_commons', 'To list');
		}

		$output .= $this->__getLinkHtml($title, $url, $inputOptions);
		return $output;
	}

/**
 * ソートボタンHTMLの出力
 *
 * @param string $title タイトル
 * @param mixed $url URL
 * @param array $options HTML属性オプション
 * @return string HTMLタグ
 */
	private function __getLinkHtml($title, $url, $options) {
		//センター以外は、ボタン文言を非表示にする
		$containerType = Current::read('Container.type');
		$ariaHidden = ' aria-hidden="true"';

		if (in_array($containerType, [Container::TYPE_MAJOR, Container::TYPE_MINOR], true) &&
				! empty($this->_View->request->params['requested'])) {
			$options['aria-label'] = $title;
			$title = '';
		} elseif (Hash::get($options, 'hiddenTitle', true) === false) {
			//hiddenTitle = falseにした場合、携帯の場合でもタイトルを表示する
		} else {
			$title = '<span class="hidden-xs">' . $title . '</span>';
		}
		$options = Hash::remove($options, 'hiddenTitle');

		if (substr($options['icon'], 0, strlen('glyphicon-')) === 'glyphicon-') {
			$glyphicon = 'glyphicon ' . h($options['icon']);
		} else {
			$glyphicon = 'glyphicon glyphicon-' . h($options['icon']);
		}

		$iconTag = '<span ' . 'class="' . $glyphicon . '"' . $ariaHidden . '></span> ';
		if (Hash::get($options, 'addIcon')) {
			if (substr($options['addIcon'], 0, strlen('glyphicon-')) === 'glyphicon-') {
				$glyphicon = 'glyphicon ' . h($options['addIcon']);
			} else {
				$glyphicon = 'glyphicon glyphicon-' . h($options['addIcon']);
			}
			$iconTag .= '<span ' . 'class="' . $glyphicon . '"' . $ariaHidden . '></span> ';
		}
		$title = $iconTag . $title;
		unset($options['icon']);

		//ボタンサイズ
		if ($options['iconSize']) {
			$options['class'] .= ' ' . trim(h($options['iconSize']));
		}
		unset($options['iconSize']);

		return $this->NetCommonsHtml->link($title, $url, $options);
	}

}
