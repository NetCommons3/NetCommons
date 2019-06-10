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
if (! isset($isSettingMode)) {
	$isSettingMode = Current::isSettingMode();
}
/* 未ログイン時にはヘッダーメニューを表示しないこともカスタマイズでできるようにcss追加 */
if (AuthComponent::user()) {
	$ncSystemHeaderCss = 'nc-system-header-loggedin';
} else {
	$ncSystemHeaderCss = 'nc-system-header-nologgedin';
}

if (empty($navbarStyle)) {
	$navbarStyle = 'navbar-inverse';
}
?>

<?php if ($flashMessage = $this->fetch('flashMessage')) : ?>
	<?php echo $flashMessage; ?>
<?php endif; ?>

<header id="nc-system-header" class="<?php echo $ncSystemHeaderCss; ?>">
	<nav class="navbar <?php echo h($navbarStyle); ?> navbar-fixed-top" role="navigation">
		<div class="<?php echo $pageContainerCss; ?> clearfix text-nowrap">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#nc-system-header-navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<?php if ($this->params['plugin'] !== 'pages' && ! Current::isControlPanel()) : ?>
					<?php echo $this->NetCommonsHtml->link(
							'<span class="glyphicon glyphicon-arrow-left"> </span>',
							NetCommonsUrl::backToPageUrl(),
							array('escape' => false, 'class' => 'nc-page-refresh pull-left visible-xs navbar-brand')
						); ?>
					<?php echo $this->NetCommonsHtml->link(
							'<span class="glyphicon glyphicon-arrow-left"> </span>',
							NetCommonsUrl::backToPageUrl(),
							array('escape' => false, 'class' => 'nc-page-refresh pull-left hidden-xs navbar-brand')
						); ?>
				<?php endif; ?>

				<?php echo $this->NetCommonsHtml->link(
						SiteSettingUtil::read('App.site_name'), '/', array('class' => 'navbar-brand')
					); ?>
			</div>
			<div id="nc-system-header-navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php if (! empty($hasSwitchLang)) : ?>
						<li class="dropdown">
							<?php echo $this->element('M17n.switch_language_form'); ?>
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

					<?php if ($this->params['plugin'] === 'pages' && $this->params['controller'] === 'pages_edit') : ?>
						<li>
							<?php echo $this->NetCommonsHtml->link(__d('pages', 'Page Setting off'), NetCommonsUrl::backToPageUrl()); ?>
						</li>
					<?php /* elseif (Current::hasSettingMode() && $isSettingMode && Current::permission('page_editable', Current::read('Page.room_id'))) : */ ?>
					<?php elseif (Current::hasSettingMode() && Current::permission('page_editable', Current::read('Page.room_id'))) : ?>
						<li>
							<?php echo $this->NetCommonsHtml->link(__d('pages', 'Page Setting on'),
									'/pages/pages_edit/index/' . Current::read('Page.room_id') . '/' . Current::read('Page.id')); ?>
						</li>
					<?php endif; ?>

					<?php if (Current::hasSettingMode()) : ?>
						<li>
							<?php if (! $isSettingMode) : ?>
								<?php echo $this->NetCommonsHtml->link(
									__d('pages', 'Setting mode on'), '/pages/change_setting_mode/?mode=1&page_id=' . Current::read('Page.id')
								); ?>
							<?php else: ?>
								<?php echo $this->NetCommonsHtml->link(
									__d('pages', 'Setting mode off'), '/pages/change_setting_mode/?mode=0&page_id=' . Current::read('Page.id')
								); ?>
							<?php endif; ?>
						</li>
					<?php endif; ?>

					<?php if (AuthComponent::user()) : ?>
						<li class="visible-sm">
							<?php echo $this->NetCommonsHtml->avatarLink(Current::read(), [], [], 'User.id'); ?>
						</li>
						<li class="hidden-sm">
							<?php echo $this->NetCommonsHtml->handleLink(Current::read(), ['avatar' => true], [], 'User'); ?>
						</li>
					<?php endif; ?>

					<?php if (AuthComponent::user()) : ?>
						<li>
							<?php echo $this->NetCommonsHtml->link(__d('net_commons', 'Logout'), '/auth/logout'); ?>
						</li>
					<?php else: ?>
						<?php if (! SiteSettingUtil::read('App.close_site') && SiteSettingUtil::read('AutoRegist.use_automatic_register', false)) : ?>
							<li>
								<?php echo $this->NetCommonsHtml->link(__d('auth', 'Sign up'), '/auth/auto_user_regist/request'); ?>
							</li>
						<?php endif; ?>
						<li>
							<?php echo $this->NetCommonsHtml->link(__d('net_commons', 'Login'), '/auth/login'); ?>
						</li>
					<?php endif; ?>

				</ul>
			</div>
		</div>
	</nav>
</header>

<?php
echo $this->Session->read('appendHtml');
CakeSession::delete('appendHtml');
?>

<div id="loading" class="nc-loading" ng-show="sending" ng-cloak>
	<?php echo $this->NetCommonsHtml->image('/net_commons/img/loading.svg'); ?>
</div>
