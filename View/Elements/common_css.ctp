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
		'/components/bootstrap/dist/css/bootstrap.min.css',
		'/net_commons/css/style.css',
	),
	array('plugin' => false)
);
