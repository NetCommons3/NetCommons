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
	<?php $titleForModal = $this->fetch('titleForModal'); ?>
	<?php if ($titleForModal) : ?>
		<?php echo $titleForModal; ?>
	<?php else : ?>
		<br />
	<?php endif; ?>
</div>

<div class="modal-body">
<?php $tabList = $this->fetch('tabList'); ?>
	<?php if ($tabList) : ?>
		<ul class="nav nav-tabs" role="tablist">
			<?php echo $tabList; ?>
		</ul>
		<br />
		<?php $tabId = $this->fetch('tabIndex'); ?>
		<div class="tab-content" ng-init="tab.setTab(<?php echo (int)$tabId; ?>)">
	<?php endif; ?>

	<?php echo $this->fetch('content'); ?>
	<?php echo $this->element('NetCommons.goto_top_button'); ?>

	<?php if ($tabList) : ?>
		</div>
	<?php endif; ?>

</div>
