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
 * @param array $types 表示するタイプ
 * @return array
 */
	public function getExpectedAnnouncement($types) {
		$results = [];

		foreach ($types as $type) {
			switch ($type) {
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
				case 'community_2':
					$results[] = '<p>Community Room 2 Announcement Content 1</p>';
					break;
			}
		}

		return $results;
	}

/**
 * セッティングモード
 *
 * @param string $type 表示するタイプ
 * @return array
 */
	public function getExpectedSettingMode($type) {
		if ($type === 'on') {
			return ['セッティングモードON'];
		} else {
			return ['セッティングモードOFF'];
		}
	}

/**
 * メニューフレーム
 *
 * @param array $types 表示するタイプ
 * @return array
 */
	public function getExpectedFrame($types) {
		$results = [];

		foreach ($types as $type) {
			switch ($type) {
				case 'menu':
					$results[] = '<span>Menu frame</span>';
					break;
			}
		}

		return $results;
	}

/**
 * メニューリスト
 *
 * @param array $types 表示するタイプ
 * @return array
 */
	public function getExpectedMenuList($types) {
		$results = [];

		foreach ($types as $type) {
			switch ($type) {
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
				case 'community_2':
					$results[] = '<span class="pull-left">Community room 2</span>';
					break;
			}
		}

		return $results;
	}

}
