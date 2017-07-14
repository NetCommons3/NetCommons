<?php
/**
 * Error 400 テンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<h2 class="error-title" style="background-image: url(<?php echo $this->NetCommonsHtml->url('/net_commons/img/redirect_arrow.gif'); ?>)">

	<?php echo $message; ?>
</h2>

<?php if (Configure::read('debug') > 0) : ?>
	<article class="error-body">
		<strong><?php echo __d('net_commons', 'Error'); ?>: </strong>
		<?php echo __d('net_commons', 'The requested address \'%s\' was not found on this server.', $url); ?>
	</article>
<?php endif; ?>

<?php if (isset($redirect)) : ?>
	<div class="error-redirect">
		<?php echo __d('net_commons', 'The page will be automatically reloaded. If otherwise, please click <a href="%s">here</a>.', $redirect); ?>
	</div>
<?php endif; ?>

<?php
if (Configure::read('debug') > 0) {
	echo $this->element('exception_stack_trace');
} elseif (isset($redirect)) {
	echo $this->NetCommonsHtml->meta(
		null, null, array('http-equiv' => 'refresh', 'content' => $interval, 'url' => $redirect, 'inline' => false)
	);
}
?>

<?php if (! Configure::read('debug') && isset($redirect)) : ?>
	<script type="text/javascript">
		setTimeout(
			function() {
				location.href='<?php echo h($redirect); ?>'.replace(/&amp;/ig,"&");
			},
			<?php echo (int)$interval; ?>*1000
		);
	</script>
<?php endif;

