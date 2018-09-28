<?php
/**
 * 必須マークテンプレート
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

if (! isset($size)) {
	$size = 'h4';
}
echo '<strong class="text-danger ' . h($size) . '">' . __d('net_commons', '*') . '</strong>';
