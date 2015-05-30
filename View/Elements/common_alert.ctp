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
<div id="nc-flash-message"
		ng-init="flash.type='hidden'; flash.message='';"
		class="alert {{flash.type}} hidden">
	<button class="close pull-right" type="button" ng-click="flash.close()">
		<span class="glyphicon glyphicon-remove"> </span>
	</button>
	<span class='message'>{{flash.message}}</span>
</div>

<?php if ($flashMss = $this->Session->flash()) : ?>
	<!-- flash -->
	<div class="alert alert-danger alert-dismissable">
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		<?php echo $flashMss; ?>
	</div>
<?php endif;
