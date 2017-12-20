<?php
/**
 * NetCommonsValidationRuleテスト用Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * NetCommonsValidationRuleテスト用Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\test_app\Plugin\TestNetCommons\Model
 */
class TestNetCommonsValidationRuleModel extends AppModel {

/**
 * テーブル名
 *
 * @var mixed
 */
	public $useTable = false;

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

}
