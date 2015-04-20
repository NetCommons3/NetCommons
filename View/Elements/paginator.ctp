<?php
/**
 * Paginator template
 *   - $modulus: `modulus` how many numbers to include on either side of the current page, defaults to 8(display of 7 pages).
 *   - $url: Url of the action. See Router::url()
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php if ((int)$this->Paginator->param('count') > 0) : ?>

	<ul class="pagination">
		<?php echo $this->Paginator->first('«', array(
				'tag' => 'li',
				'url' => (isset($url) ? $url : null)
			)); ?>

		<?php echo $this->Paginator->numbers(array(
				'tag' => 'li',
				'currentTag' => 'a',
				'currentClass' => 'active',
				'separator' => '',
				'first' => false,
				'last' => false,
				'modulus' => isset($modulus) ? $modulus : null,
				'url' => (isset($url) ? $url : null)
			)); ?>

		<?php echo $this->Paginator->last('»', array(
				'tag' => 'li',
				'url' => (isset($url) ? $url : null)
			)); ?>
		</li>
	</ul>

<?php endif;
