<?php
/**
 * Element of datetimepicker include
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

// datetimepicker
echo $this->NetCommonsHtml->script(
	array(
		'/components/moment/min/moment.min.js',
		'/components/moment/min/moment-with-locales.min.js',
		'/components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
		'/components/angular-bootstrap-datetimepicker-directive/angular-bootstrap-datetimepicker-directive.js',
	)
);
echo $this->NetCommonsHtml->css(
	'/components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'
);
?>

<?php echo $this->Html->scriptStart(array('inline' => false)); ?>
NetCommonsApp.requires.push('datetimepicker');
NetCommonsApp.config(
    [
      'datetimepickerProvider',
      function(datetimepickerProvider) {
        datetimepickerProvider.setOptions({
          locale: moment.locale('<?php echo Configure::read('Config.language') ?>'),
          format: 'YYYY-MM-DD HH:mm',
          sideBySide: true,
          stepping: 5
        });
      }
    ]
);
<?php echo $this->Html->scriptEnd();
