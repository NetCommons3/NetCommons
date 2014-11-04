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

      /**
       * show user information method
       *
       * @param {number} users.id
       * @return {string}
       */
      $scope.showUser = function(user_id) {
        alert('user_id:' + user_id);
      };

});
