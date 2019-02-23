<?php
/**
 * Pages template.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<!DOCTYPE html>
<html lang="<?php echo Configure::read('Config.language') ?>" ng-app="NetCommonsApp">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo (isset($pageTitle) ? h($pageTitle) : ''); ?></title>

		<?php
			echo $this->element('NetCommons.common_favicon');
			echo $this->fetch('meta');

			echo $this->element('NetCommons.common_css');
			echo $this->fetch('css');
			echo $this->element('NetCommons.common_theme_css');

			echo $this->element('NetCommons.common_js');
			echo $this->fetch('script');
		?>
	</head>

	<body ng-controller="NetCommons.base">
		<?php echo $this->Flash->render(); ?>

		<?php echo $this->element('NetCommons.common_header'); ?>

		<main class="container" ng-init="hashChange()">
			<?php echo $this->fetch('content'); ?>
		</main>

		<?php echo $this->element('NetCommons.common_footer'); ?>
	</body>
</html>
