<?php
/**
 * workflow_buttons element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
		/* <button type="button" class="btn btn-default ng-hide" */
		/* 		ng-disabled="(sending || form.$invalid)" */
		/* 		ng-hide="workflow.currentStatus === '<?php echo (NetCommonsBlockComponent::STATUS_APPROVED); ?>'" */
		/* 		ng-click="save('<?php echo NetCommonsBlockComponent::STATUS_INDRAFT; ?>')"> */

		/* 	<?php echo __d('net_commons', 'Save temporally'); ?> */
		/* </button> */
?>

	<button type="button" class="btn btn-default" ng-click="cancel()" ng-disabled="sending">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('net_commons', 'Cancel'); ?>
	</button>

	<?php if ($contentPublishable) : ?>
		<button type="button" name="status" class="btn btn-danger"
				ng-disabled="(sending || form.$invalid)"
				ng-hide="workflow.currentStatus !== '<?php echo (NetCommonsBlockComponent::STATUS_APPROVED); ?>'"
				ng-click="save('<?php echo NetCommonsBlockComponent::STATUS_DISAPPROVED; ?>')">

			<?php echo __d('net_commons', 'Disapproval'); ?>
		</button>

		<?php if ($contentStatus !== NetCommonsBlockComponent::STATUS_APPROVED) : ?>
		<?php echo $this->Form->button(
			__d('net_commons', 'Save temporally'),
			array(
				'class' => 'btn btn-default',
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_IN_DRAFT,
			)) ?>
		<?php endif; ?>
	<?php else : ?>
		<?php echo $this->Form->button(
			__d('net_commons', 'Save temporally'),
			array(
				'class' => 'btn btn-default',
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_IN_DRAFT,
			)) ?>
	<?php endif; ?>

	<?php if ($contentPublishable) : ?>
		<?php echo $this->Form->button(
			__d('net_commons', 'OK'),
			array(
				'class' => 'btn btn-primary',
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_PUBLISHED,
			)) ?>
	<?php else : ?>
		<?php echo $this->Form->button(
			__d('net_commons', 'OK'),
			array(
				'class' => 'btn btn-primary',
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_APPROVED,
			)) ?>
	<?php endif;
