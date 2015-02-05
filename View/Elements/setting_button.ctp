<?php
/**
 * setting_button element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
		'/?back_url=' . $_SERVER['REQUEST_URI']) ?>" class="btn btn-primary">
		) ?>" class="btn btn-primary">
 */
?>

<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Manage'); ?>">
	<a href="<?php echo $this->Html->url(
		'/announcements/announcements/edit/' . $frameId .
		'/?back_url=' . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/')) ?>" class="btn btn-primary">
		<span class="glyphicon glyphicon-cog"> </span>
	</a>
</span>
