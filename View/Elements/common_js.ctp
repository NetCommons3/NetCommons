<?php
/**
 * Element of common javascript
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

echo $this->Html->script(
	array(
		'/components/jquery/dist/jquery.min.js',
		'/components/bootstrap/dist/js/bootstrap.min.js',
		'/components/tinymce-dist/tinymce.min.js',
		'/components/angular/angular.min.js',
		'/components/angular-bootstrap/ui-bootstrap-tpls.min.js',
		'/components/angular-ui-tinymce/src/tinymce.js',
		'/net_commons/js/base.js',
		'/frames/js/frames.js',
		'/pages/js/pages.js',
	),
	array('plugin' => false)
);
echo $this->element('NetCommons.datetimepicker');
