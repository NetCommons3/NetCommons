<?php
/**
 * NetCommons用に拡張したページネーション Component
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PaginatorComponent', 'Controller/Component');

/**
 * NetCommons用に拡張したページネーション Component
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\NetCommons\Controller\Component
 */
class AppPaginatorComponent extends PaginatorComponent {

/**
 * Handles automatic pagination of model records.
 *
 * @param Model|string $object Model to paginate (e.g: model instance, or 'Model', or 'Model.InnerModel')
 * @param string|array $scope Additional find conditions to use while paginating
 * @param array $whitelist List of allowed fields for ordering. This allows you to prevent ordering
 *   on non-indexed, or undesirable columns. See PaginatorComponent::validateSort() for additional details
 *   on how the whitelisting and sort field validation works.
 * @return array Model query results
 * @throws MissingModelException
 * @throws NotFoundException
 */
	public function paginate($object = null, $scope = array(), $whitelist = array()) {
		$results = parent::paginate($object, $scope, $whitelist);

		if (in_array('Paginator', $this->Controller->helpers, true)) {
			$index = array_search('Paginator', $this->Controller->helpers, true);
			unset($this->Controller->helpers[$index]);
		} elseif (array_key_exists('Paginator', $this->Controller->helpers, true)) {
			unset($this->Controller->helpers['Paginator']);
		}
		$this->Controller->helpers['Paginator'] = array('className' => 'NetCommons.AppPaginator');

		return $results;
	}

}
