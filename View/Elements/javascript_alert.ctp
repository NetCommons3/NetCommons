<?php
/**
 * Element of common javascript
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<?php $this->startIfEmpty('flashMessage'); ?>
<div id="nc-flash-message" class="alert alert-{{flash.type}} alert-dismissable hidden">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<div>
		{{flash.message}}
	</div>
</div>
<?php $this->end();
