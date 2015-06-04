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
<div id="<?php echo $elementId . '-' . $frameId; ?>"></div>

<?php $imagePath = $path . 'captcha_image' . DS . $frameId; ?>
<?php $audioPath = $path . 'captcha_audio' . DS . $frameId; ?>
<?php $startPath = $path . 'captcha' . DS . $frameId; ?>
<?php $imageDisplayCount = empty($imageDisplayCount) ? 5 : $imageDisplayCount; ?>

<script>
    var WEB_ROOT = '<?php echo $this->webroot; ?>';
    $(document).ready(function() {
        var imageDisplayCount = <?php echo $imageDisplayCount; ?>;
        var el = $('#<?php echo $elementId . '-' . $frameId; ?>').visualCaptcha({
            imgPath: WEB_ROOT + 'components/visualcaptcha.jquery/img/',  // visual_captcha - according to Plugin's name
            captcha: {
                numberOfImages: imageDisplayCount,
                url: WEB_ROOT,
                routes: {
                    image : '<?php echo $imagePath; ?>',
                    audio : '<?php echo $audioPath; ?>',
                    start : '<?php echo $startPath; ?>'
                }
            },
            language: {
                accessibilityAlt: "<?php echo __d('net_commons', 'Sound icon'); ?>",
                accessibilityTitle: "<?php echo __d('net_commons', 'Accessibility option: listen to a question and answer it!'); ?>",
                accessibilityDescription: "<?php echo __d('net_commons', 'Type below the <strong>answer</strong> to what you hear. Numbers or words:'); ?>",
                explanation: "<?php echo __d('net_commons', 'Click or touch the <strong>ANSWER</strong>'); ?>",
                refreshAlt: "<?php echo __d('net_commons', 'Refresh/reload icon'); ?>",
                refreshTitle: "<?php echo __d('net_commons', 'Refresh/reload: get new images and accessibility option!'); ?>",
            }
        });
        var captcha = el.data('captcha');
    });
</script>