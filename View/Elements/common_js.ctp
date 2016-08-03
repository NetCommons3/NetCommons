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
		'/components/angular/angular.min.js',
		'/components/angular-bootstrap/ui-bootstrap-tpls.min.js',
		'/net_commons/js/base.js',
		'/users/js/users.js',
	),
	array('plugin' => false)
);
?>

<script>
NetCommonsApp.constant('NC3_URL', '<?php echo h(Router::url('/', true)); ?>');
</script>