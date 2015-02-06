<?php
/**
 * setting_button element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Edit'); ?>">
	<a href="<?php echo $this->Html->url('/announcements/announcements/edit/' . $frameId) ?>" class="btn btn-primary">
		<span class="glyphicon glyphicon-edit"> </span>
	</a>
</span>
