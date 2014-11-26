<?php
/**
 * modal layout
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div id="nc-modal-top"></div>

<div class="modal-header">
	<button class="close" type="button"
			tooltip="<?php echo __d('net_commons', 'Close'); ?>"
			ng-click="cancel()">
		<span class="glyphicon glyphicon-remove small"></span>
	</button>

	<?php //TODO:titleForModal ?>
	<?php echo $this->fetch('title_for_modal'); ?>
</div>

<div class="modal-body">
	<?php //TODO: tablist⇒tabList。 空かどうかチェックしてbrを出す ?>
	<?php echo $this->fetch('tablist'); ?>
	<br />

	<?php $tabId = $this->fetch('tabIndex'); ?>
	<?php //TODO: tablistを空かどうかチェックする ?>
	<div class="tab-content" ng-init="tab.setTab(<?php echo (int)$tabId; ?>)">
		<?php echo $this->fetch('content'); ?>

		<?php echo $this->element('goto_top_button', array(), array('plugin' => 'NetCommons')); ?>
	</div>
</div>
