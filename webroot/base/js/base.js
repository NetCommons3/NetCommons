var NetCommonsApp = angular.module('NetCommonsApp',
    [
      'ui.bootstrap',
      'ui.tinymce',
      'dialogs.main'
    ]
    );


/**
 * base controller
 */
NetCommonsApp.controller('NetCommons.base', function($scope) {

  /**
   * HTMLエディタ:tinymceの設定
   *
   * @type {{mode: string, menubar: string, plugins: string, toolbar: string}}
   */
  $scope.tinymceOptions = {
    mode: 'exact',
    menubar: ' ',
    plugins: 'textcolor advlist autolink autoresize charmap code link ',
    toolbar: 'undo redo  |' +
        ' forecolor |' +
        ' styleselect |' +
        ' bold italic |' +
        ' alignleft aligncenter alignright alignjustify |' +
        ' bullist numlist outdent indent |' +
        ' link |'
  };

  /**
   * roomParts hierarchy
   * id room_part.part_id hierarchy room_part.hierarchy
   *
   * @type {{id: number, hierarchy: number}[]}
   */
  //$scope.roomParts = [
  //  {id: 1, hierarchy: 2147483647},
  //  {id: 2, hierarchy: 8000},
  //  {id: 3, hierarchy: 7000},
  //  {id: 4, hierarchy: 6000},
  //  {id: 5, hierarchy: 1000}
  //];

  /**
   * get hierarchy from id. ($scope.roomParts)
   *
   * @param {number} _id
   * @type {id: number, hierarchy: number}
   */
  //$scope.getHierarchy = function(_id) {
  //  return $.grep($scope.roomParts, function(item) {
  //    return item.id == _id;
  //  })[0];
  //};

  /**
   * flash
   * alertType bootstrap css alert-xxxx
   *
   * @type {{text: string, alertType: string}}
   */
  //$scope.flash = {
  //  text: '',
  //  alertType: ''
  //};

  /**
   * set flash
   *
   * @param {string} text message text
   * @param {string} alertCssClassName bootstrap css class name alert-xxx
   */
  //$scope.setFlash = function(text, alertCssClassName) {
  //  $scope.flash = {
  //    text: text,
  //    alertType: alertCssClassName
  //  };
  //};

});
