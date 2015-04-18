<?php
/**
 * Setting tabs template
 *   - $tabs: Array data is 'block_index' => URL1 or 'frame_settings' => URL2 or 'role_permissions' => URL3.
 *   - $active: Active tab key. Value is 'block_index or 'frame_settings' or 'role_permissions'.
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<ul class="nav nav-tabs" role="tablist">
	<?php if (isset($tabs['block_index'])) : ?>
		<li class="<?php echo ($active === 'block_index' ? 'active' : ''); ?>">
			<a href="<?php echo $this->Html->url($tabs['block_index']); ?>">
				<?php echo __d('net_commons', 'List'); ?>
			</a>
		</li>
	<?php endif; ?>

	<?php if (isset($tabs['frame_settings'])) : ?>
		<li class="<?php echo ($active === 'frame_settings' ? 'active' : ''); ?>">
			<a href="<?php echo $this->Html->url($tabs['frame_settings']); ?>">
				<?php echo __d('net_commons', 'Frame settings'); ?>
			</a>
		</li>
	<?php endif; ?>

	<?php if (isset($tabs['role_permissions'])) : ?>
		<li class="<?php echo ($active === 'role_permissions' ? 'active' : ''); ?>">
			<a href="<?php echo $this->Html->url($tabs['role_permissions']); ?>">
				<?php echo __d('net_commons', 'Role permission settings'); ?>
			</a>
		</li>
	<?php endif; ?>
</ul>

<br />
