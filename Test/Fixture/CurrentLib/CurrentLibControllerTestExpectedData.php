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
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
class CurrentLibControllerTestExpectedData {

/**
 * お知らせ
 *
 * @param array $keys 当メソッドで内部的に処理するキーリスト
 * @return array assertContains(assertNotContains)の結果配列
 * @SuppressWarnings(PHPMD.CyclomaticComplexity)
 */
	public function getExpectedAnnouncement($keys) {
		$results = [];

		foreach ($keys as $key) {
			switch ($key) {
				case 'toppage':
					$results[] = '<p>Top page Announcement Content</p>';
					break;
				case 'private':
					$results[] = '<p>Private Announcement Content</p>';
					break;
				case 'public_1':
					$results[] = '<p>Public Announcement Content 1</p>';
					break;
				case 'public_2':
					$results[] = '<p>Public Announcement Content 2</p>';
					break;
				case 'public_3':
					$results[] = '<p>Public Announcement Content 3</p>';
					break;
				case 'community_1':
					$results[] = '<p>Community Room 1 Announcement Content 1</p>';
					break;
				case 'community_1_edit':
					$results[] = 'name="data[Frame][id]" value="16"';
					$results[] = 'name="data[Block][id]" value="11"';
					$results[] = 'name="data[Block][key]" value="block_key_8"';
					$results[] = 'name="data[Announcement][id]" value="8"';
					$results[] = '&lt;p&gt;Community Room 1 Announcement Content 1&lt;/p&gt;</textarea>';
					break;
				case 'community_2':
					$results[] = '<p>Community Room 2 Announcement Content 1</p>';
					break;
			}
		}

		return $results;
	}

/**
 * カレンダーの予定
 *
 * @param string $key 当メソッドで内部的に処理するキー
 * @return array assertContains(assertNotContains)の結果配列
 */
	public function getExpectedCalendarPlanView($key) {
		$results = [];

		switch ($key) {
			case 'private_plan_1':
				$results[] = '<h1 data-calendar-name="dispTitle">Private plan 1</h1>';
				break;
			case 'private_plan_2':
				$results[] = '<h1 data-calendar-name="dispTitle">Private plan 2</h1>';
				break;
		}

		return $results;
	}

/**
 * カレンダーの予定
 *
 * @param array $keys 当メソッドで内部的に処理するキーリスト
 * @return array assetRegExpの結果配列の結果配列
 */
	public function getExpectedCalendar($keys) {
		$results = [];

		foreach ($keys as $key) {
			switch ($key) {
				case 'public_plan_1':
					$result =
						'<a href=".*?/calendars/calendar_plans/view/calendar_event_key_[0-9]+\?frame_id=11">' .
							'Repeat Plan 1' .
						'</a>';
					break;
				case 'private_plan_1':
					$result =
						'<a href=".*?/calendars/calendar_plans/view/calendar_event_key_[0-9]+\?frame_id=11">' .
							'Private plan 1' .
						'</a>';
					break;
				case 'private_plan_2':
					$result =
						'<a href=".*?/calendars/calendar_plans/view/calendar_event_key_[0-9]+\?frame_id=11">' .
							'Private plan 2' .
						'</a>';
					break;
				case 'community_plan_1':
					$result =
						'<a href=".*?/calendars/calendar_plans/view/calendar_event_key_[0-9]+\?frame_id=11">' .
							'Room plan 1' .
						'</a>';
					break;
			}
			$results[] = '#' . $result . '#';
		}

		return $results;
	}

/**
 * 掲示板の記事詳細の予定
 *
 * @param string $key 当メソッドで内部的に処理するキー
 * @return array assertContains(assertNotContains)の結果配列
 */
	public function getExpectedBbsArticleView($key) {
		$results = [];

		switch ($key) {
			case 'community_1_bbs_article_1':
				$results[] = 'Community room 1 bbs 1 article 1 title';
				break;
		}

		return $results;
	}

/**
 * 一覧へのリンク
 *
 * @param string $key 当メソッドで内部的に処理するキー
 * @return array assetRegExpの結果配列の結果配列
 */
	public function getExpectedToBackLink($key) {
		$results = [];

		switch ($key) {
			case 'community_1_bbs_article_1':
				$result =
					'<a href=".*?/community/room_1_bbs_page\?frame_id=20".*?>' .
						' <span class="hidden-xs">一覧へ</span>' .
					'</a>';
				break;
		}

		$results[] = '#' . $result . '#';

		return $results;
	}

/**
 * セッティングモード
 *
 * dataProviderで使用するため、__d()を行っても英語になってしまう。
 * そのため、結果と異なってしまうので、日本語を直書きとする
 *
 * @param string $key 当メソッドで内部的に処理するキー
 * @return array assertContains(assertNotContains)の結果配列
 */
	public function getExpectedSettingMode($key) {
		if ($key === 'on') {
			return ['セッティングモードON'];
		} else {
			return ['セッティングモードOFF'];
		}
	}

/**
 * ブロック設定タブ
 *
 * @param string $key 当メソッドで内部的に処理するキー
 * @param string $active アクティブの項目
 * @return array assetRegExpの結果配列
 */
	public function getExpectedBlockSettingTabs($key, $active) {
		$results = [];

		if ($key === 'annoucnement') {
			foreach (['block_setting', 'mail_setting', 'block_role_permission'] as $tabKey) {
				if ($active === $tabKey) {
					$result = '<li class="active">';
				} else {
					$result = '<li class="">';
				}
				if ($tabKey === 'block_setting') {
					$result .= '<a href=".*?">ブロック設定</a>';
				} elseif ($tabKey === 'mail_setting') {
					$result .= '<a href=".*?">メール設定</a>';
				} elseif ($tabKey === 'block_role_permission') {
					$result .= '<a href=".*?">権限設定</a>';
				}

				$result .= '</li>';

				$results[] = '#' . $result . '#';
			}
		}

		return $results;
	}

/**
 * フレームタイトル
 *
 * @param array $keys 当メソッドで内部的に処理するキーリスト
 * @return array assertContains(assertNotContains)の結果配列
 */
	public function getExpectedFrame($keys) {
		$results = [];

		foreach ($keys as $key) {
			switch ($key) {
				case 'menu':
					$results[] = '<span>Menu frame</span>';
					break;
				case 'community_1_announcement_edit_1':
					$results[] = 'value="Community Room 1 Annoucnement frame 1"';
					break;
			}
		}

		return $results;
	}

/**
 * メニューリスト
 *
 * @param array $keys 当メソッドで内部的に処理するキーリスト
 * @return array assertContains(assertNotContains)の結果配列
 */
	public function getExpectedMenuList($keys) {
		$results = [];

		foreach ($keys as $key) {
			switch ($key) {
				case 'public':
					$results[] = '<span class="pull-left">Home</span>';
					$results[] = '<span class="pull-left">Public room 1</span>';
					$results[] = '<span class="pull-left">Announcements Page</span>';
					break;
				case 'private':
					$results[] = '<span class="pull-left">プライベート</span>';
					break;
				case 'community_1':
					$results[] = '<span class="pull-left">Community room 1</span>';
					break;
				case 'community_1_bbs_page':
					$results[] = '<span class="pull-left">Community room 1 Bbs Page</span>';
					break;
				case 'community_2':
					$results[] = '<span class="pull-left">Community room 2</span>';
					break;
			}
		}

		return $results;
	}

/**
 * メニューのアクティブ
 *
 * @param string $key 当メソッドで内部的に処理するキー
 * @return array assetRegExpの結果配列の結果配列
 */
	public function getExpectedActiveMenu($key) {
		switch ($key) {
			case 'toppage':
				$result =
					'<a href=".*?/".*?active">' .
						'<span class="pull-left">Home</span>';
				break;
			case 'public_announcement_page':
				$result =
					'<a href=".*?/announcements_page".*?active">' .
						'<span class="pull-left">Announcements Page</span>';
				break;
			case 'public_calendar_page':
				$result =
					'<a href=".*?/calendars_page".*?active">' .
						'<span class="pull-left">Calendars Page</span>';
				break;
			case 'private_administrator':
				$result =
					'<a href=".*?/private/private_room_system_admistrator".*?active">' .
						'<span class="pull-left">プライベート</span>';
				break;
			case 'private_general_user_1':
				$result =
					'<a href=".*?/private/private_room_general_user_1".*?active">' .
						'<span class="pull-left">プライベート</span>';
				break;
			case 'community_1':
				$result =
					'<a href=".*?/community/community_room_1".*?active">' .
						'<span class="pull-left">Community room 1</span>';
				break;
			case 'community_1_bbs_page':
				$result =
					'<a href=".*?/community/room_1_bbs_page".*?active">' .
						'<span class="pull-left">Community room 1 Bbs Page</span>';
				break;
			case 'community_2':
				$result =
					'<a href=".*?/community/community_room_2".*?active">' .
						'<span class="pull-left">Community room 2</span>';
				break;
		}

		return ['#' . $result . '#'];
	}

/**
 * POST後のリダイレクトURL
 *
 * @param string $key 当メソッドで内部的に処理するキー
 * @return array assetRegExpの結果配列の結果配列
 */
	public function getExpectedRedirectAfterPost($key) {
		$fullBaseUrl = preg_quote(Configure::read('App.fullBaseUrl'), '#');
		switch ($key) {
			case 'toppage':
				$result =
					'^' . $fullBaseUrl . '.*?/$';
				break;
			case 'public_announcement_page':
				$result =
					'^' . $fullBaseUrl . '.*?/announcements_page$';
				break;
			case 'public_announcement_page_setting_mode':
				$result =
					'^' . $fullBaseUrl . '.*?/setting/announcements_page$';
				break;
		}

		return '#' . $result . '#';
	}

/**
 * POST後のリダイレクトURL
 *
 * @param string $frameAddAction Frame追加後に実行するアクション
 * @return array assetRegExpの結果配列の結果配列
 */
	public function getExpectedFrameAddRedirectAfterPost($frameAddAction) {
		$fullBaseUrl = preg_quote(Configure::read('App.fullBaseUrl'), '#');
		$result =
			'^' . $fullBaseUrl . '.*?' . $frameAddAction . '\?frame_id=21&page_id=10\#frame-21' . '$';
		return '#' . $result . '#';
	}

}
