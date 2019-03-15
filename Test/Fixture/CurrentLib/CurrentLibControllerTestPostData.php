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
					'headers.Location' =>
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

/**
 * カレンダーの予定追加
 *
 * @param string|int|null $frameId フレームID
 * @return string POSTのURL
 */
	public function getPostUrlAddCalendarPlan($frameId) {
		if ($frameId) {
			$url = '/calendars/calendar_plans/add/?frame_id=' . $frameId . '&year=2019&month=3&day=6';
		} else {
			$url = '/calendars/calendar_plans/add/?year=2019&month=3&day=6&page_id=4';
		}

		return $url;
	}

/**
 * カレンダーの予定編集
 *
 * @param string|int $originEventId 予定ID
 * @param string|int|null $frameId フレームID
 * @return string POSTのURL
 */
	public function getPostUrlEditCalendarPlan($originEventId, $frameId) {
		$eventKey = 'calendar_event_key_' . $originEventId;
		if ($frameId) {
			$url = '/calendars/calendar_plans/edit/' . $eventKey . '?frame_id=' . $frameId . '&year=2019&month=3&day=6';
		} else {
			$url = '/calendars/calendar_plans/edit/' . $eventKey . '?year=2019&month=3&day=6&page_id=4';
		}
		return $url;
	}

/**
 * カレンダーの予定削除
 *
 * @param string|int $originEventId 予定ID
 * @param string|int|null $frameId フレームID
 * @return string POSTのURL
 */
	public function getPostUrlDeleteCalendarPlan($originEventId, $frameId) {
		$eventKey = 'calendar_event_key_' . $originEventId;
		if ($frameId) {
			$url = '/calendars/calendar_plans/delete/' . $eventKey . '?frame_id=' . $frameId;
		} else {
			$url = '/calendars/calendar_plans/delete/' . $eventKey;
		}
		return $url;
	}

/**
 * カレンダーの予定追加
 *
 * @param string|int $planRoomId 公開範囲のルームID
 * @param string|int|null $frameId フレームID
 * @return array POSTの内容
 */
	public function getPostDataAddCalendarPlan($planRoomId, $frameId) {
		switch ($planRoomId) {
			case '1':
				$title = 'Add Public Plan 1';
				break;
			case '5':
				$title = 'Add Private Plan 1';
				break;
			case '6':
				$title = 'Add Private Plan 2';
				break;
			case '8':
				$title = 'Add Room 1 Plan 1';
				break;
			case '11':
				$title = 'Add Room 2 Plan 1';
				break;
			case '3':
				$title = 'Add All Member Plan 1';
				break;
		}
		$addPost = [
			'CalendarActionPlan' => [
				'origin_event_id' => '0',
				'origin_event_key' => '',
				'origin_event_recurrence' => '0',
				'origin_event_exception' => '0',
				'origin_rrule_id' => '0',
				'origin_rrule_key' => '',
				'origin_num_of_event_siblings' => '0',
				'first_sib_event_id' => '0',
				'first_sib_year' => '2019',
				'first_sib_month' => '3',
				'first_sib_day' => '7',
				'title' => $title,
				'enable_time' => '0',
				'detail_start_datetime' => '2019-03-07',
				'detail_end_datetime' => '2019-03-07',
				'is_repeat' => '0',
				'repeat_freq' => 'DAILY',
				'rrule_byday' => [
					'WEEKLY' => [
						0 => 'TH',
					],
					'MONTHLY' => '',
					'YEARLY' => '',
				],
				'rrule_term' => 'COUNT',
				'rrule_until' => '2019-03-07',
				'plan_room_id' => $planRoomId,
			],
			'CalendarActionPlanForDisp' => [
				'detail_start_datetime' => '2019-03-07',
				'detail_end_datetime' => '2019-03-07',
			],
		];

		$post = $this->__getCommonPostDataCalendarPlan($frameId);
		$post['_method'] = 'POST';
		$post['data']['CalendarActionPlan'] = array_merge(
			$post['data']['CalendarActionPlan'], $addPost['CalendarActionPlan']
		);
		$post['data']['CalendarActionPlanForDisp'] = array_merge(
			$post['data']['CalendarActionPlanForDisp'], $addPost['CalendarActionPlanForDisp']
		);

		return $post;
	}

/**
 * カレンダーの予定編集
 *
 * @param string|int $originEventId 予定ID
 * @param string|int $editRrule 編集ルール 0:この予定のみ、1:それ以降、2:すべて
 * @param string|int|null $frameId フレームID
 * @return array POSTの内容
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function getPostDataEditCalendarPlan($originEventId, $editRrule, $frameId) {
		switch ($originEventId) {
			case '2':
				$title = 'Edit Repeat Public Plan 1';
				$editPost = [
					'CalendarActionPlan' => [
						'origin_event_id' => $originEventId,
						'origin_event_key' => 'calendar_event_key_2',
						'origin_event_recurrence' => '0',
						'origin_event_exception' => '0',
						'origin_rrule_id' => '1',
						'origin_rrule_key' => 'calendar_rrule_key_1',
						'origin_num_of_event_siblings' => '157',
						'first_sib_event_id' => '1',
						'first_sib_year' => '2019',
						'first_sib_month' => '3',
						'first_sib_day' => '4',
						'title' => $title,
						'enable_time' => '0',
						'detail_start_datetime' => '2019-03-11',
						'detail_end_datetime' => '2019-03-11',
						'is_repeat' => '1',
						'edit_rrule' => $editRrule,
						'repeat_freq' => 'WEEKLY',
						'rrule_byday' => [
							'WEEKLY' => [
								0 => 'MO',
							],
							'MONTHLY' => '',
							'YEARLY' => '',
						],
						'rrule_term' => 'UNTIL',
						'rrule_until' => '2022-03-04',
						'plan_room_id' => '1',
					],
					'CalendarActionPlanForDisp' => [
						'detail_start_datetime' => '2019-03-11',
						'detail_end_datetime' => '2019-03-11',
					],
				];
				break;
			case '472':
				$title = 'Edit Repeat Private Plan 1';
				$editPost = [
					'CalendarActionPlan' => [
						'origin_event_id' => $originEventId,
						'origin_event_key' => 'calendar_event_key_472',
						'origin_event_recurrence' => '0',
						'origin_event_exception' => '0',
						'origin_rrule_id' => '3',
						'origin_rrule_key' => 'calendar_rrule_key_3',
						'origin_num_of_event_siblings' => '314',
						'first_sib_event_id' => '472',
						'first_sib_year' => '2019',
						'first_sib_month' => '3',
						'first_sib_day' => '6',
						'title' => $title,
						'enable_time' => '0',
						'detail_start_datetime' => '2019-03-06',
						'detail_end_datetime' => '2019-03-06',
						'is_repeat' => '1',
						'edit_rrule' => $editRrule,
						'repeat_freq' => 'WEEKLY',
						'rrule_byday' => [
							'WEEKLY' => [
								0 => 'WE',
							],
							'MONTHLY' => '',
							'YEARLY' => '',
						],
						'rrule_term' => 'UNTIL',
						'rrule_until' => '2025-03-04',
						'plan_room_id' => '5',
					],
					'CalendarActionPlanForDisp' => [
						'detail_start_datetime' => '2019-03-06',
						'detail_end_datetime' => '2019-03-06',
					],
				];
				break;
			case '1100':
				$title = 'Edit Public Plan 1';
				$editPost = [
					'CalendarActionPlan' => [
						'origin_event_id' => $originEventId,
						'origin_event_key' => 'calendar_event_key_1100',
						'origin_event_recurrence' => '0',
						'origin_event_exception' => '0',
						'origin_rrule_id' => '5',
						'origin_rrule_key' => 'calendar_rrule_key_5',
						'origin_num_of_event_siblings' => '1',
						'first_sib_event_id' => '1100',
						'first_sib_year' => '2019',
						'first_sib_month' => '3',
						'first_sib_day' => '7',
						'title' => $title,
						'enable_time' => '0',
						'detail_start_datetime' => '2019-03-07',
						'detail_end_datetime' => '2019-03-07',
						'is_repeat' => '0',
						'plan_room_id' => '1',
					],
					'CalendarActionPlanForDisp' => [
						'detail_start_datetime' => '2019-03-07',
						'detail_end_datetime' => '2019-03-07',
					],
				];
				break;
			case '1101':
				$title = 'Edit Private Plan 1';
				$editPost = [
					'CalendarActionPlan' => [
						'origin_event_id' => $originEventId,
						'origin_event_key' => 'calendar_event_key_1101',
						'origin_event_recurrence' => '0',
						'origin_event_exception' => '0',
						'origin_rrule_id' => '6',
						'origin_rrule_key' => 'calendar_rrule_key_6',
						'origin_num_of_event_siblings' => '1',
						'first_sib_event_id' => '1101',
						'first_sib_year' => '2019',
						'first_sib_month' => '3',
						'first_sib_day' => '8',
						'title' => $title,
						'enable_time' => '0',
						'detail_start_datetime' => '2019-03-08',
						'detail_end_datetime' => '2019-03-08',
						'is_repeat' => '0',
						'plan_room_id' => '5',
					],
					'CalendarActionPlanForDisp' => [
						'detail_start_datetime' => '2019-03-08',
						'detail_end_datetime' => '2019-03-08',
					],
				];
				break;
			case '1102':
				$title = 'Edit Room Plan 1';
				$editPost = [
					'CalendarActionPlan' => [
						'origin_event_id' => $originEventId,
						'origin_event_key' => 'calendar_event_key_1102',
						'origin_event_recurrence' => '0',
						'origin_event_exception' => '0',
						'origin_rrule_id' => '7',
						'origin_rrule_key' => 'calendar_rrule_key_7',
						'origin_num_of_event_siblings' => '1',
						'first_sib_event_id' => '1102',
						'first_sib_year' => '2019',
						'first_sib_month' => '3',
						'first_sib_day' => '9',
						'title' => $title,
						'enable_time' => '0',
						'detail_start_datetime' => '2019-03-09',
						'detail_end_datetime' => '2019-03-09',
						'is_repeat' => '0',
						'plan_room_id' => '8',
					],
					'CalendarActionPlanForDisp' => [
						'detail_start_datetime' => '2019-03-09',
						'detail_end_datetime' => '2019-03-09',
					],
				];
				break;
		}

		$post = $this->__getCommonPostDataCalendarPlan($frameId);
		$post['_method'] = 'POST';
		$post['data']['CalendarActionPlan'] = array_merge(
			$post['data']['CalendarActionPlan'], $editPost['CalendarActionPlan']
		);
		$post['data']['CalendarActionPlanForDisp'] = array_merge(
			$post['data']['CalendarActionPlanForDisp'], $editPost['CalendarActionPlanForDisp']
		);

		return $post;
	}

/**
 * カレンダーの予定削除
 *
 * @param string|int $originEventId 予定ID
 * @param string|int $editRrule 編集ルール 0:この予定のみ、1:それ以降、2:すべて
 * @return array POSTの内容
 */
	public function getPostDataDeleteCalendarPlan($originEventId, $editRrule) {
		switch ($originEventId) {
			case '2':
				$post = [
					'_method' => 'DELETE',
					'data' => [
						'delete' => '',
						'CalendarDeleteActionPlan' => [
							'is_repeat' => '1',
							'first_sib_event_id' => '1',
							'origin_event_id' => $originEventId,
							'is_recurrence' => '0',
							'edit_rrule' => $rrule,
						],
					],
				];
				break;
			case '472':
				$post = [
					'_method' => 'DELETE',
					'data' => [
						'delete' => '',
						'CalendarDeleteActionPlan' => [
							'is_repeat' => '1',
							'first_sib_event_id' => '472',
							'origin_event_id' => $originEventId,
							'is_recurrence' => '0',
							'edit_rrule' => $rrule,
						],
					],
				];
				break;
			case '1100':
			case '1101':
			case '1102':
				$post = [
					'_method' => 'DELETE',
					'data' => [
						'delete' => '',
						'CalendarDeleteActionPlan' => [
							'is_repeat' => '0',
							'first_sib_event_id' => $originEventId,
							'origin_event_id' => $originEventId,
							'is_recurrence' => '0',
							'edit_rrule' => '0',
						],
					],
				];
				break;
		}

		return $post;
	}

/**
 * カレンダーの共通POSTデータ
 *
 * @param string|int|null $frameId フレームID
 * @return array POSTの内容
 */
	private function __getCommonPostDataCalendarPlan($frameId) {
		if ($frameId == '11') {
			$framePost = [
				'id' => '11',
				'room_id' => '1',
				'plugin_key' => 'calendars',
				'key' => 'frame_key_9',
			];
		} else {
			$framePost = [
				'id' => '',
				'room_id' => '',
				'plugin_key' => '',
				'key' => '',
			];
		}

		$post = [
			'data' => [
				'save_1' => '',
				'Frame' => $framePost,
				//'Block' => [
				//	'id' => '7',
				//	'key' => 'block_key_4',
				//],
				'CalendarActionPlan' => [
					'origin_event_id' => '0',
					'origin_event_key' => '',
					'origin_event_recurrence' => '0',
					'origin_event_exception' => '0',
					'origin_rrule_id' => '0',
					'origin_rrule_key' => '',
					'origin_num_of_event_siblings' => '0',
					'first_sib_event_id' => '0',
					'first_sib_year' => '2019',
					'first_sib_month' => '3',
					'first_sib_day' => '7',
					'easy_start_date' => '',
					'easy_hour_minute_from' => '',
					'easy_hour_minute_to' => '',
					'is_detail' => '1',
					'title_icon' => '',
					'title' => '',
					'enable_time' => '0',
					'detail_start_datetime' => '',
					'detail_end_datetime' => '',
					'is_repeat' => '0',
					'repeat_freq' => 'DAILY',
					'rrule_interval' => [
						'DAILY' => '1',
						'WEEKLY' => '1',
						'MONTHLY' => '1',
						'YEARLY' => '1',
					],
					'rrule_byday' => [
						'WEEKLY' => [
							0 => 'TH',
						],
						'MONTHLY' => '',
						'YEARLY' => '',
					],
					'rrule_bymonthday' => [
						'MONTHLY' => '',
					],
					'rrule_bymonth' => [
						'YEARLY' => [
							0 => '3',
						],
					],
					'rrule_term' => 'COUNT',
					'rrule_count' => '3',
					'rrule_until' => '2019-03-07',
					'plan_room_id' => '',
					'enable_email' => '',
					'email_send_timing' => '5',
					'location' => '',
					'contact' => '',
					'description' => '',
					'timezone_offset' => 'Asia/Tokyo',
				],
				'CalendarActionPlanForDisp' => [
					'detail_start_datetime' => '2019-03-07',
					'detail_end_datetime' => '2019-03-07',
				],
				'WorkflowComment' => [
					'comment' => '',
				],
			],
		];

		return $post;
	}

/**
 * カレンダーの予定追加(編集)のdataProviderで使用する共通正常データ
 *
 * @param string|int|null $frameId フレームID
 * @return array
 */
	public function getSuccessCommonDataByEditCalendarPlan($frameId) {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		if ($frameId) {
			$commonResults = [
				'controller' => 'Calendars.CalendarPlans',
				'url' => '',
				'post' => [],
				'expects' => [
					'headers.Location' =>
						$ExpectedData->getExpectedRedirectAfterPost('calendar_plan_with_frame_' . $frameId),
				],
				'exception' => false,
			];
		} else {
			$commonResults = [
				'controller' => 'Calendars.CalendarPlans',
				'url' => '',
				'post' => [],
				'expects' => [
					'headers.Location' =>
						$ExpectedData->getExpectedRedirectAfterPost('calendar_plan_without_frame'),
				],
				'exception' => false,
			];
		}
		return $commonResults;
	}

/**
 * カレンダーの予定削除のdataProviderで使用する共通正常データ
 *
 * @param string|int|null $frameId フレームID
 * @return array
 */
	public function getSuccessCommonDataByDeleteCalendarPlan($frameId) {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		if ($frameId) {
			$commonResults = [
				'controller' => 'Calendars.CalendarPlans',
				'url' => '',
				'post' => [],
				'expects' => [
					'headers.Location' =>
						$ExpectedData->getExpectedRedirectAfterPost('public_calendars_page'),
				],
				'exception' => false,
			];
		} else {
			$commonResults = [
				'controller' => 'Calendars.CalendarPlans',
				'url' => '',
				'post' => [],
				'expects' => [
					'headers.Location' =>
						$ExpectedData->getExpectedRedirectAfterPost('delete_calendar_plan_without_frame'),
				],
				'exception' => false,
			];
		}
		return $commonResults;
	}

/**
 * カレンダーの予定追加のdataProviderで使用する共通異常データ
 *
 * バリデーションエラーになるため、Exceptionではない。
 *
 * @param string|int|null $frameId フレームID
 * @return array
 */
	public function getFailureCommonDataByEditCalendarPlan($frameId) {
		//@var CurrentLibControllerTestExpectedData
		$ExpectedData = new CurrentLibControllerTestExpectedData();

		$commonResults = [
			'controller' => 'Calendars.CalendarPlans',
			'url' => '',
			'post' => [],
			'expects' => [
				'validationErrors' => [
					'plan_room_id' => [
						0 => '権限が不正です。'
					],
				],
				'assertContains' => array_merge([],
					$ExpectedData->getExpectedFrame(['menu'])
				),
			],
			'exception' => false,
		];

		return $commonResults;
	}

/**
 * アップロード
 *
 * @param string $key 当メソッドで内部的に処理するキーリスト
 * @return array POSTの内容
 */
	public function getPostDataUploads($key) {
		switch ($key) {
			case 'wysiwyg_image':
			case 'wysiwyg_file':
				$post = [
					'Block' => [
						'key' => '',
						'room_id' => '1',
					],
					'Room' => [
						'id' => '1',
					],
					'_FILES' => [
						'data' => [
							'name' => [
								'Wysiwyg' => [
									'file' => 'Test.png',
								],
							],
							'type' => [
								'Wysiwyg' => [
									'file' => 'image/png',
								],
							],
							'tmp_name' => [
								'Wysiwyg' => [
									'file' => NetCommonsCurrentLibTestUtility::getTmpDir() . 'phpGeqf03',
								],
							],
							'error' => [
								'Wysiwyg' => [
									'file' => 0,
								],
							],
							'size' => [
								'Wysiwyg' => [
									'file' => 6403,
								],
							],
						],
					],
					'_fileInfo' => [
						'name' => 'Test.png',
						'type' => 'image/png',
						'tmp_name' => NetCommonsCurrentLibTestUtility::getTmpDir() . 'phpGeqf03',
						'error' => 0,
						'size' => 6385,
					]
				];
				break;
		}

		return $post;
	}

/**
 * アップロード
 *
 * @param string $key 当メソッドで内部的に処理するキーリスト
 * @return array POSTの内容
 */
	public function getPostDataGroupAdd($key) {
//		switch ($key) {
//			case 'wysiwyg_image':
//			case 'wysiwyg_file':
//				$post = [
//					'Block' => [
//						'key' => '',
//						'room_id' => '1',
//					],
//					'Room' => [
//						'id' => '1',
//					],
//					'_FILES' => [
//						'data' => [
//							'name' => [
//								'Wysiwyg' => [
//									'file' => 'Test.png',
//								],
//							],
//							'type' => [
//								'Wysiwyg' => [
//									'file' => 'image/png',
//								],
//							],
//							'tmp_name' => [
//								'Wysiwyg' => [
//									'file' => NetCommonsCurrentLibTestUtility::getTmpDir() . 'phpGeqf03',
//								],
//							],
//							'error' => [
//								'Wysiwyg' => [
//									'file' => 0,
//								],
//							],
//							'size' => [
//								'Wysiwyg' => [
//									'file' => 6403,
//								],
//							],
//						],
//					],
//					'_fileInfo' => [
//						'name' => 'Test.png',
//						'type' => 'image/png',
//						'tmp_name' => NetCommonsCurrentLibTestUtility::getTmpDir() . 'phpGeqf03',
//						'error' => 0,
//						'size' => 6385,
//					]
//				];
//				break;
//		}

		return $post;
	}

}
