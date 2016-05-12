<?php
/**
 * サイトの一時停止View
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="site-close jumbotron">
	<h1>
		<?php echo SiteSettingUtil::read('App.site_name'); ?>
	</h1>
	<p>
		<?php echo nl2br($siteClosingReason); ?>
	</p>
</div>