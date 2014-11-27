<?php
/**
 * goto_top_button element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="text-right">
	<button type="button" class="btn btn-default" ng-click="top()"
			tooltip="<?php echo __d('net_commons', 'Go to Top'); ?>">
		<span class="glyphicon glyphicon-circle-arrow-up"> </span>
	</button>
</div>
