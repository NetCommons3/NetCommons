<?php
/**
 * NetCommonsCakeTestCase
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Current::initialize()のControllerテスト
 *
 * @package NetCommons\Test\Fixture\CurrentLib
 * @codeCoverageIgnore
 */
class CurrentLibControllerTestPostData {

/**
 * お知らせ
 *
 * @param string $key 当メソッドで内部的に処理するキーリスト
 * @return array POSTの内容
 */
	public function getPostDataAnnouncement($key) {
		switch ($key) {
			case 'toppage_announcement':
				$post = [
					'save_1' => '',
					'Frame' => [
						'id' => '18',
					],
					'Block' => [
						'id' => '12',
						'key' => 'block_key_9',
						'room_id' => '1',
					],
					'Announcement' => [
						'id' => '9',
						'key' => 'announcement_key_8',
						'block_id' => '12',
						'language_id' => '2',
						'status' => '1',
						'content' => '<p>Top page Announcement Content Edit</p>',
					],
					'WorkflowComment' => [
						'comment' => '',
					],
				];
				break;
			case 'public_announcement_2':
				$post = [
					'save_1' => '',
					'Frame' => [
						'id' => '12',
					],
					'Block' => [
						'id' => '8',
						'key' => 'block_key_5',
						'room_id' => '1',
					],
					'Announcement' => [
						'id' => '5',
						'key' => 'announcement_key_4',
						'block_id' => '8',
						'language_id' => '2',
						'status' => '1',
						'content' => '<p>Public Announcement Content 2 Edit</p>',
					],
					'WorkflowComment' => [
						'comment' => '',
					],
				];
				break;
		}

		return $post;
	}

}
