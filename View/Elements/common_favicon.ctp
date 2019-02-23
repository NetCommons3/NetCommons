<?php
/**
 * Element of common javascript
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

// app/webroot/favicon.icoが無ければ、app/webroot/nc_favicon.ico表示、それもなければ/net_commons/favicon.ico表示
if (file_exists(WWW_ROOT . 'favicon.ico')) {
	/* @see https://book.cakephp.org/2.0/ja/core-libraries/helpers/html.html#HtmlHelper::meta */
	echo $this->html->meta('icon', '/favicon.ico');
} elseif (file_exists(WWW_ROOT . 'nc_favicon.ico')) {
	echo $this->html->meta('icon', '/nc_favicon.ico');
} else {
	echo $this->html->meta('icon', '/net_commons/favicon.ico');
}
