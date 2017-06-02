<?php
/**
 * Element of common javascript
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

echo $this->NetCommonsHtml->script(
	array(
		'/components/jquery/dist/jquery.min.js',
		'/components/bootstrap/dist/js/bootstrap.min.js',
		'/components/angular/angular.min.js',
		'/components/angular-bootstrap/ui-bootstrap-tpls.min.js',
		'/net_commons/js/base.js',
	),
	array('plugin' => false, 'inline' => true, 'once' => false)
);
?>

<script>
NetCommonsApp.constant('NC3_URL', '<?php echo h(substr(Router::url('/'), 0, -1)); ?>');
NetCommonsApp.constant('LOGIN_USER', <?php echo json_encode(['id' => Current::read('User.id')], JSON_FORCE_OBJECT); ?>);
</script>

<?php echo $this->NetCommonsHtml->script('/users/js/users.js');
