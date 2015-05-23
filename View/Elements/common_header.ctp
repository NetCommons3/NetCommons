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
		<div class="container">
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
					<li <?php
						if (isset($this->request->params['plugin'])
							&& $this->request->params['plugin'] == 'ThemeSettings') {
						echo 'class="active"';
						}
					?>>
						<?php echo $this->Html->link(__d('net_commons', 'Theme setting'), '/theme_settings/site/') ?>
					</li>
					<li>
						<?php if (!Page::isSetting()): ?>
							<?php echo $this->Html->link(__d('pages', 'Setting mode on'), '/' . Page::SETTING_MODE_WORD . '/' . $path) ?>
						<?php else: ?>
							<?php echo $this->Html->link(__d('pages', 'Setting mode off'), '/' . $path) ?>
						<?php endif; ?>
					</li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div>
</header>
