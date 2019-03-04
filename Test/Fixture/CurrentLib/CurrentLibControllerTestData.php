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
class CurrentLibControllerTestData {

/**
 * お知らせ
 *
 * @param array $keys 当メソッドで内部的に処理するキーリスト
 * @return array assertContains(assertNotContains)の結果配列
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
			case 'private_plan':
				$results[] = '<h1 data-calendar-name="dispTitle">Private plan 1</h1>';
				break;
//			case 'public_plan':
//				$results[] = '<p>Public Announcement Content 1</p>';
//				break;
//			case 'community_1':
//				$results[] = '<p>Community Room 1 Announcement Content 1</p>';
//				break;
//			case 'community_2':
//				$results[] = '<p>Community Room 2 Announcement Content 1</p>';
//				break;
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
//			case 'public_plan':
//				$results[] = '<p>Public Announcement Content 1</p>';
//				break;
//			case 'community_1':
//				$results[] = '<p>Community Room 1 Announcement Content 1</p>';
//				break;
//			case 'community_2':
//				$results[] = '<p>Community Room 2 Announcement Content 1</p>';
//				break;
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
//			case 'public_plan':
//				$results[] = '<p>Public Announcement Content 1</p>';
//				break;
//			case 'community_1':
//				$results[] = '<p>Community Room 1 Announcement Content 1</p>';
//				break;
//			case 'community_2':
//				$results[] = '<p>Community Room 2 Announcement Content 1</p>';
//				break;
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

}
