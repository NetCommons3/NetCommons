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

<?php if ($contentPublishable) : ?>
	<span class="nc-tooltip" tooltip="<?php echo __d('net_commons', 'Accept'); ?>">
		<button type="button" class="btn btn-warning ng-hide"
				ng-hide="(<?php echo h($status) ?> !== '<?php echo NetCommonsBlockComponent::STATUS_APPROVED ?>')"
				ng-disabled="sending"
				ng-click="publish();">

			<span class="glyphicon glyphicon-ok"></span>
		</button>
	</span>
<?php endif;