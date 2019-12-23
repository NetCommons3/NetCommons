<?php
/**
 * DB 保存時に CDN キャッシュを削除する
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @author Wataru Nishimoto <watura@willbooster.com>
 * @author Kazunori Sakamoto <exkazuu@willbooster.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ModelBehavior', 'Model');
App::uses('NetCommonsCDNCache', 'NetCommons.Utility');

/**
 * DB 保存時に CDN キャッシュを削除する
 * @author Wataru Nishimoto <watura@willbooster.com>
 * @author Kazunori Sakamoto <exkazuu@willbooster.com>
 * @package NetCommons\NetCommons\Model\Befavior
 */
class CDNCacheInvalidateBehavior extends ModelBehavior {

/**
 * Delete CDN Cache after save
 *
 * @param Model $model Model using this behavior
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return bool
 * @see Model::save()
 * @throws InternalErrorException
 */
	public function afterSave(Model $model, $created, $options = array()) {
		$cdn = new NetCommonsCDNCache();
		$cdn->clear();
		return true;
	}
}
