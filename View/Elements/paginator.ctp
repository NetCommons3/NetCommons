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

$firstOption = array(
	'tag' => 'li',
);
$numbersOption = array(
	'tag' => 'li',
	'currentTag' => 'a',
	'currentClass' => 'active',
	'separator' => '',
	'first' => false,
	'last' => false,
);
$lastOption = array(
	'tag' => 'li',
);

if (isset($modulus)) {
	$numbersOption['modulus'] = $modulus;
}
if (isset($url)) {
	$firstOption['url'] = $url;
	$numbersOption['url'] = $url;
	$lastOption['url'] = $url;
}

?>

<?php if ((int)$this->Paginator->param('count') > 0) : ?>
	<div class="text-center">
		<ul class="pagination">
			<?php echo $this->Paginator->first('«', $firstOption); ?>

			<?php echo $this->Paginator->numbers($numbersOption); ?>

			<?php echo $this->Paginator->last('»', $lastOption); ?>
		</ul>
	</div>
<?php endif;
