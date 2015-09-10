<?php
/**
 * Display number element of index
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<span class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
		<?php echo $displayNumberOptions[$currentLimit]; ?>
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu" role="menu">
		<?php foreach ($displayNumberOptions as $count => $label) : ?>
			<li<?php echo (int)$currentLimit === $count ? ' class="active"' : ''; ?>>
				<?php echo $this->Paginator->link($label, array('limit' => $count), array('url' => $url)); ?>
			</li>
		<?php endforeach; ?>
	</ul>
</span>
