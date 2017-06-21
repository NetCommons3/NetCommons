<?php
/**
 * Element of common css
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

//即出力
echo $this->NetCommonsHtml->css(
	array(
		'bootstrap.min.css',
		'style',
	),
	array('plugin' => false, 'inline' => true, 'once' => false)
);
