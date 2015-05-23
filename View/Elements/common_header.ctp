<?php
/**
 * Element of html header
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<header id="nc-system-header">
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="<?php echo $this->Layout->getContainerFluid(); ?>">
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
					<li><a href="/"><?php echo __d('net_commons', 'Home'); ?></a></li>
					<li>
						<?php if ($User = AuthComponent::user()): ?>
							<?php /*echo h($User['handle'])*/ ?>
							<?php echo $this->Html->link(__d('net_commons', 'Logout'), '/auth/logout') ?>
						<?php else: ?>
							<?php echo $this->Html->link(__d('net_commons', 'Login'), '/auth/login') ?>
						<?php endif; ?>
					</li>
					<?php if (AuthComponent::user('id')): ?>
						<li<?php echo $this->request->params['plugin'] === 'ThemeSettings' ? ' class="active"' : ''; ?>>
							<?php echo $this->Html->link(__d('net_commons', 'Theme setting'), '/theme_settings/site/') ?>
						</li>
						<li>
							<?php if (! Page::isSetting()): ?>
								<?php echo $this->Html->link(__d('pages', 'Setting mode on'), '/' . Page::SETTING_MODE_WORD . '/' . (isset($path) ? $path : $cancelUrl)) ?>
							<?php else: ?>
								<?php echo $this->Html->link(__d('pages', 'Setting mode off'), '/' . (isset($path) ? $path : $cancelUrl)) ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</header>
