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

<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Manage'); ?>">
	<button class="btn btn-primary"
			ng-disabled="sending"
			ng-click="showSetting()">

		<span class="glyphicon glyphicon-cog"> </span>
	</button>
</span>
