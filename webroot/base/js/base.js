var NetCommonsApp = angular.module('NetCommonsApp',
    [
      'ui.bootstrap',
      'ui.tinymce'
    ]
    );


/**
 * base controller
 */
NetCommonsApp.controller('NetCommons.base', function($scope) {

  /**
   * status published
   *
   * @const
   */
  $scope.STATUS_PUBLISHED = '1';

  /**
   * status approved
   *
   * @const
   */
  $scope.STATUS_APPROVED = '2';

  /**
   * status drafted
   *
   * @const
   */
  $scope.STATUS_DRAFTED = '3';

  /**
   * status disaproved
   *
   * @const
   */
  $scope.STATUS_DISAPPROVED = '4';

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
   * set flash
   *
   * @param {string} text message text
   * @param {string} type bootstrap css class name alert-xxx
   */
  $scope.flash = {
    message: '',
    type: '',
    close: function() {
      $scope.flash.message = '';
      $scope.flash.type = '';
      $('#nc-flash-message').addClass('hidden');
    },
    success: function(message) {
      $scope.flash.custom(message, 'alert-success', true);
    },
    info: function(message) {
      $scope.flash.custom(message, 'alert-info', true);
    },
    warning: function(message) {
      $scope.flash.custom(message, 'alert-warning', false);
    },
    danger: function(message) {
      $scope.flash.custom(message, 'alert-danger', false);
    },
    custom: function(message, type, fadeOut) {
      $scope.flash.message = message;
      $scope.flash.type = type;
      $('#nc-flash-message').removeClass('hidden');
      if (fadeOut) {
        $('#nc-flash-message').fadeIn(500).fadeTo(1000, 1).fadeOut(1500);
      } else {
        $('#nc-flash-message').fadeIn(500);
      }
    }
  };

});
