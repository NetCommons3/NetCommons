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
?>
	<a href="<?php echo $this->Html->url('/' . $cancelUrl) ?>" class="btn btn-default btn-workflow">
		<span class="glyphicon glyphicon-remove"></span>
		<?php echo __d('net_commons', 'Cancel') ?>
	</a>

	<?php if ($contentPublishable) : ?>
		<?php if ($contentStatus === NetCommonsBlockComponent::STATUS_APPROVED) : ?>
		<?php echo $this->Form->button(
			__d('net_commons', 'Disapproval'),
			array(
				'class' => 'btn btn-warning btn-workflow',
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_DISAPPROVED,
			)) ?>
		<?php endif; ?>
		<?php if ($contentStatus !== NetCommonsBlockComponent::STATUS_APPROVED) : ?>
		<?php echo $this->Form->button(
			__d('net_commons', 'Save temporally'),
			array(
				'class' => 'btn btn-info btn-workflow',
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_IN_DRAFT,
			)) ?>
		<?php endif; ?>
	<?php else : ?>
		<?php echo $this->Form->button(
			__d('net_commons', 'Save temporally'),
			array(
				'class' => 'btn btn-info btn-workflow',
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_IN_DRAFT,
			)) ?>
	<?php endif; ?>

	<?php if ($contentPublishable) : ?>
		<?php echo $this->Form->button(
			__d('net_commons', 'OK'),
			array(
				'class' => 'btn btn-primary btn-workflow',
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_PUBLISHED,
			)) ?>
	<?php else : ?>
		<?php echo $this->Form->button(
			__d('net_commons', 'OK'),
			array(
				'class' => 'btn btn-primary btn-workflow',
				'name' => 'save_' . NetCommonsBlockComponent::STATUS_APPROVED,
			)) ?>
	<?php endif;
