<?php
/**
 * Error 500 テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<h2 class="error-title">
	<?php echo $this->NetCommonsHtml->image('/net_commons/img/redirect_arrow.gif'); ?>
	<?php echo $message; ?>
</h2>

<?php if (Configure::read('debug') > 0) : ?>
	<article class="error-body">
		<strong><?php echo __d('net_commons', 'Error'); ?>: </strong>
		<?php echo __d('net_commons', 'An Internal Error Has Occurred.'); ?>
	</article>

	<?php echo $this->element('exception_stack_trace'); ?>
<?php endif;