<?php
/**
 * Switch language element
 *   - $languages: Languages data
 *   - $prefix: It is id attribute prefix
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('L10n', 'I18n');
$L10n = new L10n();
?>

<ul class="nav nav-pills pull-right small" role="tablist">
	<?php foreach ($languages as $langId => $langCode) : ?>
		<li class="<?php echo ($activeLangCode === $langCode ? 'active' : ''); ?>">
			<a class="nc-switch-language" href="#<?php echo $prefix . $langCode ?>" role="tab" data-toggle="tab"
				ng-click="activeLangCode = '<?php echo $langCode; ?>'">

				<?php $catalog = $L10n->catalog($langCode);
						echo __($catalog['language']); ?>
			</a>
		</li>
	<?php endforeach; ?>
</ul>

<input type="hidden" name="active_lang_code" ng-value="activeLangCode">
<?php $this->Form->unlockField('active_lang_code'); ?>
<br />
