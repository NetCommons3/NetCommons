/**
 * datetime_picker_from_to_link
 *
 * @author ryuji@ryus.co.jp (Ryuji AMANO)
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */


/**
 * DatetimePickerのfrom to 制約
 *
 * @param {string} fromId fromの値を設定するinputタグのID
 * @param {string} toId toの値を設定するinputタグのID
 * @return {void}
 */
function datetimePickerFromToLink(fromId, toId) {
  $('#' + fromId).on('dp.change', function(e) {
    $('#' + toId).data('DateTimePicker').minDate(e.date);
  });
  $('#' + toId).on('dp.change', function(e) {
    $('#' + fromId).data('DateTimePicker').maxDate(e.date);
  });
}
