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

/**
 * フレーム追加のdataProvider
 *
 * @return array
 */
	public function getDataProviderByFrameAdd() {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$plugins = [
			'announcements' => [
				'name' => 'お知らせ',
				'frame_add_action' => '/announcements/announcements/edit',
			],
			'bbses' => [
				'name' => '掲示板',
				'frame_add_action' => '/bbses/bbs_blocks',
			],
			'blogs' => [
				'name' => 'ブログ',
				'frame_add_action' => '/blogs/blog_blocks',
			],
			'calendars' => [
				'name' => 'カレンダー',
				'frame_add_action' => '/calendars/calendar_frame_settings/edit',
			],
			'circular_notices' => [
				'name' => '回覧板',
				'frame_add_action' => '/circular_notices/circular_notice_frame_settings/edit',
			],
			'faqs' => [
				'name' => 'FAQ',
				'frame_add_action' => '/faqs/faq_blocks',
			],
			'menus' => [
				'name' => 'メニュー',
				'frame_add_action' => '/menus/menu_frame_settings/edit',
			],
			'photo_albums' => [
				'name' => 'フォトアルバム',
				'frame_add_action' => '/photo_albums/photo_albums/setting',
			],
			'questionnaires' => [
				'name' => 'アンケート',
				'frame_add_action' => '/questionnaires/questionnaire_blocks',
			],
			'reservations' => [
				'name' => '施設予約',
				'frame_add_action' => '/reservations/reservation_frame_settings/edit',
			],
			'rss_readers' => [
				'name' => 'RSSリーダー',
				'frame_add_action' => '/rss_readers/rss_readers/edit',
			],
			'searches' => [
				'name' => '検索ボックス',
				'frame_add_action' => '/searches/search_frame_settings/edit',
			],
			'tasks' => [
				'name' => 'ToDo',
				'frame_add_action' => '/tasks/task_blocks',
			],
			'topics' => [
				'name' => '新着',
				'frame_add_action' => '/topics/topic_frame_settings/edit',
			],
			'videos' => [
				'name' => '動画',
				'frame_add_action' => '/videos/video_blocks',
			],
		];

		foreach ($plugins as $key => $plugin) {
			$caseKey = sprintf('%s(%s)プラグイン追加', $plugin['name'], $key);

			$results[$caseKey] = [
				'post' => [
					'save' => '',
					'Frame' => [
						'room_id' => '1',
						'language_id' => '2',
						'box_id' => '105',
						'plugin_key' => $key,
					],
					'Plugin' => [
						'name' => $plugin['name'],
					],
				],
				'expects' => [
					'Location' =>
						$ExpectedData->getExpectedFrameAddRedirectAfterPost($plugin['frame_add_action']),
				],
			];
		}

		unset($ExpectedData);

		return $results;
	}

/**
 * フレーム編集のプラグインリスト
 *
 * @return array
 */
	public function getPostDataByFrameEdit() {
		$post = [
			'_method' => 'PUT',
			'data' => [
				'Frame' => [
					'id' => '12',
					'header_type' => 'default',
				],
				'FramesLanguage' => [
					'id' => '10',
					'name' => 'Annoucnement Edit',
				],
				'_Frame' => [
					'redirect' => '/setting/announcements_page',
				],
			],
		];

		return $post;
	}

/**
 * フレーム削除のプラグインリスト
 *
 * @return array
 */
	public function getPostDataByFrameDelete() {
		$post = [
			'_method' => 'DELETE',
			'data' => [
				'Frame' => [
					'id' => '14',
				],
			],
		];

		return $post;
	}

}
