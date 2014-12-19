<?php
/**
 * Json CakePHP template.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<?php
	// It is better reference Google JSON Style Guide
	if (!isset($name)) {
		$name = 'OK';
	}
	if (!isset($status)) {
		$status = 200;
	}

	$result = array(
		'code' => $status,
		'name' => $name,
		'results' => $results
	);
	$this->set(compact('result'));
	$this->set('_serialize', 'result');

	echo $this->render();