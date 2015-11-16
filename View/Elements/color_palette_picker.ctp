<?php
/**
 * Element of color palette picker include
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

echo $this->NetCommonsHtml->script(
	array(
    '/net_commons/js/color_palette_picker.js',
	)
);
?>

<div class="input-group" ng-controller="ncColorPalettePickerCtrl" color-value='<?php echo $colorValue; ?>'>

    <nc-color-palette-picker
        color-value='<?php echo $colorValue; ?>'
        <?php if (isset($ngModel)): ?> ng-model="<?php echo $ngModel; ?>" <?php endif ?>
        <?php if (isset($colors)): ?> colors="<?php echo str_replace('"', '\'', $colors); ?>" <?php endif ?>
        >

        <?php if (isset($name)): ?>
            <?php echo $this->Form->input($name, array(
                'label' => false,
                'div' => false,
                'class' => 'form-control',
                'value' => '{{colorValue}}')); ?>
        <?php elseif (isset($ngAttrName)): ?>
            <input type="text" ng-attr-name="<?php echo $ngAttrName; ?>" class="form-control" ng-model="<?php echo $ngModel; ?>" size="8"></input>
        <?php endif ?>

    </nc-color-palette-picker>

</div>