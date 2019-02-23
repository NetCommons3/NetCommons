<?php
/**
 * Error レイアウト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('SiteSettingUtil', 'SiteManager.Utility');
?>
<!DOCTYPE html>
<html lang="<?php echo Configure::read('Config.language') ?>" ng-app="NetCommonsApp">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>
		<?php echo SiteSettingUtil::read('App.site_name'); ?>
	</title>
	<?php
			echo $this->element('NetCommons.common_favicon');
		echo $this->fetch('meta');

		echo $this->element('NetCommons.common_css', [], ['cache' => true]);
		echo $this->element('NetCommons.common_theme_css', [], ['cache' => true]);
		echo $this->element('NetCommons.common_js', [], ['cache' => true]);
	?>
</head>

<body ng-controller="NetCommons.base">
	<?php echo $this->Flash->render(); ?>

	<main class="container">
		<?php echo $this->fetch('content'); ?>
	</main>

	<?php echo $this->element('NetCommons.common_footer', [], ['cache' => true]); ?>
</body>
</html>
