<?php
/**
 * Element of html header
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

if (! isset($pageContainerCss)) {
	$pageContainerCss = 'container';
}
?>

<?php if ($flashMessage = $this->fetch('flashMessage')) : ?>
	<?php echo $flashMessage; ?>
<?php endif; ?>

<header id="nc-system-header">
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="<?php echo $pageContainerCss; ?>">
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
					<?php if ($user = AuthComponent::user()) : ?>
						<li>
							<?php echo $this->NetCommonsHtml->link($user['handlename'], NetCommonsUrl::userActionUrl()); ?>
						</li>
						<li>
							<?php echo $this->NetCommonsHtml->link(__d('net_commons', 'Logout'),
									NetCommonsUrl::actionUrl(array('plugin' => 'auth', 'controller' => 'logout'))); ?>
						</li>
					<?php else: ?>
						<li>
							<?php echo $this->NetCommonsHtml->link(__d('net_commons', 'Login'),
									NetCommonsUrl::actionUrl(array('plugin' => 'auth', 'controller' => 'login'))); ?>
						</li>
					<?php endif; ?>

					<?php if (Current::hasSettingMode() && $isSettingMode && Current::permission('page_editable')) : ?>
						<li class="dropdown">
							<?php echo $this->element('Pages.dropdown_menu'); ?>
						</li>
					<?php endif; ?>

					<?php if (Current::hasSettingMode()) : ?>
						<li>
							<?php if (! $isSettingMode) : ?>
								<?php echo $this->NetCommonsHtml->link(__d('pages', 'Setting mode on'), NetCommonsUrl::backToPageUrl(true)); ?>
							<?php else: ?>
								<?php echo $this->NetCommonsHtml->link(__d('pages', 'Setting mode off'), NetCommonsUrl::backToPageUrl()); ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>

					<?php if (Current::hasControlPanel()) : ?>
						<li>
							<?php if (! Current::isControlPanel()): ?>
								<?php echo $this->NetCommonsHtml->link(__d('control_panel', 'Control Panel'),
										array('plugin' => 'control_panel', 'controller' => 'control_panel', 'action' => 'index')); ?>
							<?php else : ?>
								<?php echo $this->NetCommonsHtml->link(__d('control_panel', 'Back to the Rooms'), NetCommonsUrl::backToPageUrl()); ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>

				</ul>
			</div>
		</div>
	</nav>
</header>
