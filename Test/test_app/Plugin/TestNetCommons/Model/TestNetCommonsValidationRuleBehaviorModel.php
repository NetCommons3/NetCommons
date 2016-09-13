<?php
/**
 * NetCommonsValidationRuleBehaviorテスト用Model
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppModel', 'Model');

/**
 * NetCommonsValidationRuleBehaviorテスト用Model
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Test\test_app\Plugin\TestNetCommons\Model
 */
class TestNetCommonsValidationRuleBehaviorModel extends AppModel {

/**
 * テーブル名
 *
 * @var mixed
 */
	public $useTable = false;

/**
 * 使用ビヘイビア
 *
 * @var array
 */
	public $actsAs = array(
		'NetCommons.NetCommonsValidationRule'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'field' => array(
			'alphaNumericSymbols' => array(
				'rule' => array('alphaNumericSymbols', false),
				'message' => 'Only alphabets, numbers and symbols are allowed to use for %s.',
				'allowEmpty' => false,
				'required' => true,
			),
		),
	);

}
