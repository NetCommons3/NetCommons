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

<div class="modal-content">
	<div class="modal-header">
		<button class="close" type="button"
				tooltip="<?php echo __d('net_commons', 'Close'); ?>"
				ng-click="cancel()">
			<span class="glyphicon glyphicon-remove small"></span>
		</button>

		<h4 class="modal-title"><?php echo $this->fetch('title_for_modal'); ?>&nbsp;</h4>
	</div>

	<div class="modal-body">
		<?php echo $this->fetch('content'); ?>
	</div>

	<?php if ($modalFooter = $this->fetch('footer_for_modal')) : ?>
		<div class="modal-footer">
			<div class="text-center">
				<?php echo $modalFooter; ?>
			</div>
		</div>
	<?php endif; ?>
</div>
