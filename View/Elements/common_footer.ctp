<?php
/**
 * Element of html footer
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<footer id="nc-system-footer" role="contentinfo">
	<div class="box-footer">
		<div class="copyright">Powered by NetCommons</div>
	</div>
</footer>

<script type="text/javascript">
$(function() {
	$(document).on('keypress', 'input:not(.allow-submit)', function(event) {
		return event.which !== 13;
	});
	$('article > blockquote').css('display', 'none');
	$('<button class="btn btn-default nc-btn-blockquote"><span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span> </button>')
		.insertBefore('article > blockquote').on('click', function(event) {
			$(this).next('blockquote').toggle();
		});
});
</script>
