<?php
/**
 * ValidateMergeTest.php
 *
 * @author Japan Science and Technology Agency
 * @author National Institute of Informatics
 * @link http://researchmap.jp researchmap Project
 * @link http://www.netcommons.org NetCommons Project
 * @license http://researchmap.jp/public/terms-of-service/ researchmap license
 * @copyright Copyright 2017, researchmap Project
 */
App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');

class ValidateMergeTest extends NetCommonsCakeTestCase {
	public function testMergeRepeatOK() {
		$validate = array(
			'page_container_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'box_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'page_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			),
			'container_type' => array(
				'inList' => array(
					'rule' => array('inList', array(
						'header',
						'major',
						'main',
						'minor',
						'footer',
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			),
			'is_published' => array(
				'boolean' => array(
					'rule' => array('boolean'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => false,
				),
			),
		);
		
		$after = ValidateMerge::merge($validate, $validate);
		$this->assertSame($after, $validate);
	}

	public function testMergeWhenAppend() {
		$validate = array(
			'page_container_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
			)
		);
		$append = array(
			'page_container_id' => array(
				'foo' => array(
					'rule' => array('foo'),
					'message' => 'foo message'
				)
			)
		);

		$after = ValidateMerge::merge($validate, $append);

		$expected = array(
			'page_container_id' => array(
				'numeric' => array(
					'rule' => array('numeric'),
					'message' => __d('net_commons', 'Invalid request.'),
				),
				'foo' => array(
					'rule' => array('foo'),
					'message' => 'foo message'
				)
			)
		);
		$this->assertSame($expected, $after);

		// もう一度$appendをたしても同じ
		$after = ValidateMerge::merge($after, $append);
		$this->assertSame($expected, $after);
	}

	public function testIntKey() {
		$validate = array(
			'container_type' => array(
				'inList' => array(
					'rule' => array('inList', array(
						'header',
						'major',
						'main',
						'minor',
						'footer',
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			));

		$append = array(
			'container_type' => array(
				'inList' => array(
					'rule' => array('inList', array(
						'append1',
						'append2'
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			)
		);

		$after = ValidateMerge::merge($validate, $append);

		$expected = array(
			'container_type' => array(
				'inList' => array(
					'rule' => array('inList', array(
						'header',
						'major',
						'main',
						'minor',
						'footer',
						'append1',
						'append2'
					)),
					'message' => __d('net_commons', 'Invalid request.'),
				)
			)
		);
		$this->assertSame($expected, $after);

		// もう一度$appendをたしても同じ

		$after = ValidateMerge::merge($after, $append);
		$this->assertSame($expected, $after);

	}
}