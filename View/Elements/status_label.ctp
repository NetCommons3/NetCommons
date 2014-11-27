<?php
/**
 * status_label element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<span class="ng-hide" ng-show="<?php echo h($statusModel) ?>" ng-switch="<?php echo h($statusModel) ?>">
	<span class="label label-warning"
			ng-switch-when="<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>">
		<?php echo __d('net_commons', 'Approving'); ?>
	</span>

	<span class="label label-danger"
			ng-switch-when="<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED ?>">
		<?php echo __d('net_commons', 'Disapproving'); ?>
	</span>

	<span class="label label-info"
			ng-switch-when="<?php echo NetCommonsBlockComponent::STATUS_DRAFTED ?>">
		<?php echo __d('net_commons', 'Temporary'); ?>
	</span>

	<span ng-switch-default=""></span>
</span>
