<?php
/**
 * Element of common css
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

echo $this->NetCommonsHtml->css(
	array(
		'/components/bootstrap/dist/css/bootstrap.min.css',
		'/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
		'bootstrap.min.css',
		'style',
		'/frames/css/style.css',
		'/net_commons/css/style.css',
		'/pages/css/style.css',
		'/users/css/style.css',
		'/user_attributes/css/style.css',
		'/wysiwyg/css/style.css',
	),
	array('plugin' => false, 'inline' => true, 'once' => false)
);
