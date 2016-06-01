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
				);
				if (isset($this->_View->viewVars['addActionController'])) {
					$url['controller'] = $this->_View->viewVars['addActionController'];
				}
			}
			$url = NetCommonsUrl::actionUrl(Hash::merge($defaultUrl, $url));
		}

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'plus',
			'iconSize' => $this->Button->getButtonSize(),
			'class' => 'btn btn-success nc-btn-style',
		), $options, array('escapeTitle' => false));

		if (! $title) {
			$tooltip = Hash::get($options, 'tooltip', __d('net_commons', 'Add'));
			if (is_string($tooltip)) {
				$title = $tooltip;
			} else {
				$title = __d('net_commons', 'Add');
			}
			unset($inputOptions['tooltip']);
		}

		//iconの有無
		$iconElement = '<span class="glyphicon glyphicon-' . h($inputOptions['icon']) . '"></span> ';
		unset($inputOptions['icon']);
		//ボタンサイズ
		if ($inputOptions['iconSize']) {
			$inputOptions['class'] .= ' ' . trim(h($inputOptions['iconSize']));
		}
		unset($inputOptions['iconSize']);

		//span tooltipタグの出力
		//if (Hash::get($options, 'tooltip', false)) {
		//	if (is_string($options['tooltip'])) {
		//		$tooltip = $options['tooltip'];
		//	} else {
		//		$tooltip = __d('net_commons', 'Add');
		//	}
		//	$output .= '<span class="nc-tooltip" tooltip="' . $tooltip . '">';
		//	unset($inputOptions['tooltip']);
		//}

		$output .= $this->Html->link($iconElement . $title, $url, $inputOptions);
		if (Hash::get($options, 'tooltip', false)) {
			$output .= '</span>';
		}
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

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'edit',
			'iconSize' => $this->Button->getButtonSize(),
			'class' => 'btn btn-primary nc-btn-style'
		), $options, array('escapeTitle' => false));

		if (Hash::get($options, 'escapeTitle', true)) {
			$title = h($title);
		}
		$title = __d('net_commons', 'Edit');
		//if (! $title) {
		//	$tooltip = Hash::get($options, 'tooltip', __d('net_commons', 'Edit'));
		//	if (is_string($tooltip)) {
		//		$title = $tooltip;
		//	} else {
		//		$title = __d('net_commons', 'Edit');
		//	}
		//	unset($inputOptions['tooltip']);
		//}

		//iconの有無
		$iconElement = '<span class="glyphicon glyphicon-' . h($inputOptions['icon']) . '"></span> ';
		unset($inputOptions['icon']);

		//ボタンサイズ
		if ($inputOptions['iconSize']) {
			$inputOptions['class'] .= ' ' . trim(h($inputOptions['iconSize']));
		}
		unset($inputOptions['iconSize']);

		//span tooltipタグの出力
		//$tooltip = Hash::get($options, 'tooltip', false);
		//if ($tooltip) {
		//	if (is_string($options['tooltip'])) {
		//		$tooltip = $options['tooltip'];
		//	} else {
		//		$tooltip = __d('net_commons', 'Edit');
		//	}
		//	$output .= '<span class="nc-tooltip" tooltip="' . $tooltip . '">';
		//	unset($inputOptions['tooltip']);
		//}

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

		$output .= $this->NetCommonsHtml->link($iconElement . $title, $url, $inputOptions);
		if (isset($options['tooltip']) && $options['tooltip']) {
			$output .= '</span>';
		}
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

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'search',
			'iconSize' => $this->Button->getButtonSize(),
			'class' => 'btn btn-info nc-btn-style',
		), $options, array('escapeTitle' => false));

		if (Hash::get($options, 'escapeTitle', true)) {
			$title = h($title);
		}

		//iconの有無
		$iconElement = '<span class="glyphicon glyphicon-' . h($inputOptions['icon']) . '"></span> ';
		unset($inputOptions['icon']);

		//ボタンサイズ
		if ($inputOptions['iconSize']) {
			$inputOptions['class'] .= ' ' . trim(h($inputOptions['iconSize']));
		}
		unset($inputOptions['iconSize']);

		//span tooltipタグの出力
		if (Hash::get($options, 'tooltip', false)) {
			if (is_string($options['tooltip'])) {
				$tooltip = $options['tooltip'];
			} else {
				$tooltip = __d('net_commons', 'Search');
			}
			$output .= '<span class="nc-tooltip" tooltip="' . $tooltip . '">';
			unset($inputOptions['tooltip']);
		}

		if (! isset($url)) {
			$url = array();
		}
		if (is_array($url)) {
			$url = Hash::merge(array('action' => 'search'), $url);
		}
		$output .= $this->NetCommonsHtml->link($iconElement . $title, $url, $inputOptions);

		if (isset($options['tooltip']) && $options['tooltip']) {
			$output .= '</span>';
		}
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

		//Linkオプションの設定
		$inputOptions = Hash::merge(array(
			'icon' => 'sort',
			'iconSize' => $this->Button->getButtonSize(),
			'class' => 'btn btn-default nc-btn-style',
		), $options, array('escapeTitle' => false));

		if (Hash::get($options, 'escapeTitle', true)) {
			$title = h($title);
		}

		//iconの有無
		$iconElement = '<span class="glyphicon glyphicon-' . h($inputOptions['icon']) . '"></span> ';
		unset($inputOptions['icon']);

		//ボタンサイズ
		if ($inputOptions['iconSize']) {
			$inputOptions['class'] .= ' ' . trim(h($inputOptions['iconSize']));
		}
		unset($inputOptions['iconSize']);

		//span tooltipタグの出力
		if (Hash::get($options, 'tooltip', false)) {
			if (is_string($options['tooltip'])) {
				$tooltip = $options['tooltip'];
			} else {
				$tooltip = __d('net_commons', 'Sort');
			}
			$output .= '<span class="nc-tooltip" tooltip="' . $tooltip . '">';
			unset($inputOptions['tooltip']);
		}

		if (! isset($url)) {
			$url = array();
		}
		if (is_array($url)) {
			$url = Hash::merge(array('action' => 'sort'), $url);
		}
		$output .= $this->NetCommonsHtml->link($iconElement . $title, $url, $inputOptions);

		if (isset($options['tooltip']) && $options['tooltip']) {
			$output .= '</span>';
		}
		return $output;
	}

}
