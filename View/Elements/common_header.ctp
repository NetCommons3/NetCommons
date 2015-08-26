<?php
/**
 * Element of html header
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

if (! isset($path)) {
	$path = isset($cancelUrl) ? $cancelUrl : '';
}

$pageEditable = isset($pageEditable) ? $pageEditable : null;
if (! isset($isPageSetting)) {
	$isPageSetting = Page::isSetting();
}

if (! isset($container)) {
	$container = 'container';
}
?>

<?php if ($flashMessage = $this->fetch('flashMessage')) : ?>
	<?php echo $flashMessage; ?>
<?php endif; ?>


<header id="nc-system-header">
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="<?php echo ! empty($this->PageLayout) ? $this->PageLayout->getContainerFluid() : $container; ?>">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">NetCommons3</a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav">
					<li>
						<a href="/"><?php echo __d('net_commons', 'Home'); ?></a>
					</li>
					<?php if ($user = AuthComponent::user()): ?>
						<!--
						<li>
							<a href="#">
								<?php //echo h($user['handle']); ?>
							</a>
						</li>
						-->
						<li>
							<?php echo $this->Html->link(__d('net_commons', 'Logout'), '/auth/logout') ?>
						</li>
					<?php else: ?>
						<li>
							<?php echo $this->Html->link(__d('net_commons', 'Login'), '/auth/login') ?>
						</li>
					<?php endif; ?>

					<?php if ($isPageSetting && $pageEditable): ?>
						<li class="dropdown">
							<?php echo $this->element('Pages.dropdown_menu'); ?>
						</li>
					<?php endif; ?>

					<?php if (AuthComponent::user('id') && isset($pageEditable) && $pageEditable): ?>
						<li>
							<?php if (! $isPageSetting): ?>
								<?php echo $this->Html->link(__d('pages', 'Setting mode on'), '/' . Page::SETTING_MODE_WORD . '/' . $path); ?>
							<?php else: ?>
								<?php echo $this->Html->link(__d('pages', 'Setting mode off'), '/' . $path); ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>

					<?php if (isset($hasControlPanel) && $hasControlPanel): ?>
						<li>
							<?php if (! $isControlPanel): ?>
								<?php echo $this->Html->link(__d('control_panel', 'Control Panel'), '/control_panel/control_panel'); ?>
							<?php else : ?>
								<?php echo $this->Html->link(__d('control_panel', 'Back to the Rooms'), $cancelUrl); ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>

				</ul>
			</div>
		</div>
	</nav>
</header>

<?php if ($isPageSetting && $pageEditable): ?>
	<?php echo $this->element('Pages.edit_layout'); ?>
<?php endif;
