<?php
/**
 * Element of datetimepicker include
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

// datetimepicker
echo $this->Html->script(
	array(
		'/components/moment/min/moment.min.js',
		'/components/moment/min/moment-with-locales.min.js',
		'/components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
		'/components/angular-bootstrap-datetimepicker-directive/angular-bootstrap-datetimepicker-directive.js',
	),
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
echo $this->Html->css(
	'/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
