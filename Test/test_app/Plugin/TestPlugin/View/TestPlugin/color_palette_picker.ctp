<?php
/**
 * View/Elements/NetCommons/color_palette_pcikerテスト用Viewファイル
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author AllCreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

View/Elements/color_palette_picker

<?php echo $this->element('NetCommons.color_palette_picker', array(
'ngModel' => 'testNgModel.graphColor',
'ngAttrName' => 'data[testNgModel][{{testIndex}}][graph_color]',
'colorValue' => '{{testNgModel.graphColor}}',
'colors' => array('#00000F', '#F00000')
)); ?>
<?php echo $this->element('NetCommons.color_palette_picker', array(
'name' => 'testName'));

