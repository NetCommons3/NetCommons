<?php
/**
 * NetCommons bootstrap
 *
 * @author Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

// phpDocumentor Settings
// Put author name to netcommons.php or netcommons.yaml
/* $author = 'Noriko Arai, Ryuji Masukawa'; */
$author = 'Your Name <yourname@domain.com>';
$header = <<<EOF
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author $author
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
EOF;

Configure::write('PhpDocumentor.classHeader', $header);

// Load all plugins
$plugins = App::objects('plugins');
foreach ($plugins as $plugin) {
	$options = array();
	is_readable(ROOT . DS . 'app' . DS . 'Plugin' . DS . $plugin . DS . 'Config' . DS . 'bootstrap.php') &&
		$options['bootstrap'] = true;
	is_readable(ROOT . DS . 'app' . DS . 'Plugin' . DS . $plugin . DS . 'Config' . DS . 'routes.php') &&
		$options['routes'] = true;
	if (!CakePlugin::loaded($plugin)) {
		CakePlugin::load($plugin, $options);
	}
}

// Load application configurations
$conf = array();
$files = array('application.yml', 'application.local.yml');
foreach ($files as $file) {
	if (file_exists(APP . 'Config' . DS . $file)) {
		$conf = array_merge($conf, Spyc::YAMLLoad(APP . 'Config' . DS . $file));
		Configure::write($conf);
	}
}

Router::parseExtensions();

if (Configure::read('NetCommons.installed')) {
	return;
}

// Initialize application configurations
if (Configure::read('Security.salt') === 'DYhG93b0qyJfIxfs2guVoUubWwvniR2G0FgaC9mi' ||
	Configure::read('Security.cipherSeed') === '76859309657453542496749683645') {
	App::uses('File', 'Utility');
	App::uses('Security', 'Utility');
	Configure::write('Security.salt', Security::generateAuthKey());
	Configure::write('Security.cipherSeed', mt_rand() . mt_rand());
}
