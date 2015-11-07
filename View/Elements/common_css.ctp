<?php
/**
 * Element of common javascript
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

echo $this->Html->css(
	array(
		'bootstrap.min.css',
		'style',
		'/components/bootstrap/dist/css/bootstrap.min.css',
		'/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
		'/frames/css/style.css',
		'/net_commons/css/style.css',
		'/pages/css/style.css',
		'/user_attributes/css/style.css',
	),
	array('plugin' => false)
);
