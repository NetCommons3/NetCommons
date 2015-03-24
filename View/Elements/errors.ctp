<?php
/**
 * errors element template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if ($errors[$model]): ?>
<div class="has-error">
	<?php if (isset($errors[$model][$field])): ?>
	<?php foreach ($errors[$model][$field] as $message): ?>
		<div class="help-block">
			<?php echo $message ?>
		</div>
	<?php endforeach ?>
	<?php endif ?>
</div>
<?php endif ?>
