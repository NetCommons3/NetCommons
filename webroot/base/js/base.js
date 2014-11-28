var NetCommonsApp = angular.module('NetCommonsApp',
    [
      'ui.bootstrap',
      'ui.tinymce'
    ]
    );

//NetCommonsApp.config(['$httpProvider', function($httpProvider) {
//      $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
//  }]);

/**
 * NetCommons factory
 */
NetCommonsApp.factory('NetCommons',
    ['$http', '$q', '$modal', '$modalStack', '$location', '$anchorScroll',
      function ($http, $q, $modal, $modalStack, $location, $anchorScroll) {

      return {
        /**
         * status published
         *
         * @const
         */
        STATUS_PUBLISHED: '1',

        /**
         * status approved
         *
         * @const
         */
        STATUS_APPROVED: '2',

        /**
         * status drafted
         *
         * @const
         */
        STATUS_DRAFTED: '3',

        /**
         * status disaproved
         *
         * @const
         */
        STATUS_DISAPPROVED: '4',

        /**
         * show dialog method
         *
         * @param {object} scope
         * @param {string} templateUrl
         * @param {string} controller
         * @return {string}
         */
        showDialog: function(scope, templateUrl, controller) {
          $modalStack.dismissAll('canceled');

          //ダイアログ表示
          $modal.open({
            templateUrl: templateUrl,
            controller: controller,
            backdrop: 'static',
            scope: scope
          }).result.then(
              function(result) {},
              function(reason) {
                if (typeof reason.data === 'object') {
                  //openによるエラー
                  scope.flash.danger(reason.data.name);
                } else if (reason === 'canceled') {
                  //キャンセル
                  scope.flash.close();
                }
              }
          );
        },

        /**
         * send get
         *
         * @param {string} url
         * @return {void}
         */
        get: function(url) {
          return $http.get(url, {cache: false});
        },

        /**
         * send delete
         *
         * @param {string} url
         * @return {void}
         */
        delete: function(url) {
          return $http.delete(url, {cache: false});
        },

        /**
         * send post
         *
         * @param {string} url
         * @param {Object.<string>} postParams
         * @return {void}
         */
        post: function(url, postParams) {
          return $http.post(url, $.param(postParams),
              {cache: false,
                headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
        },

        /**
         * top method
         *
         * @return {void}
         */
        top: function() {
          $location.hash('nc-modal-top');
          $anchorScroll();
        }
      };
  }]);


/**
 * NetCommonsFlush factory
 */
NetCommonsApp.factory('NetCommonsFlush', function () {

    /**
     * factory
     *
     * @type {Object.<string>}
     */
    var factory = {
      scope: {},
      message: '',
      type: '',
      close: function() {
        factory.scope.flash.message = '';
        factory.scope.flash.type = '';
        $('#nc-flash-message').addClass('hidden');
      },
      success: function(message) {
        factory.scope.flash.custom(message, 'alert-success', true);
      },
      info: function(message) {
        factory.scope.flash.custom(message, 'alert-info', true);
      },
      warning: function(message) {
        factory.scope.flash.custom(message, 'alert-warning', false);
      },
      danger: function(message) {
        factory.scope.flash.custom(message, 'alert-danger', false);
      },
      custom: function(message, type, fadeOut) {
        factory.scope.flash.message = message;
        factory.scope.flash.type = type;
        $('#nc-flash-message').removeClass('hidden');
        if (fadeOut) {
          $('#nc-flash-message').fadeIn(500).fadeTo(1000, 1).fadeOut(1500);
        } else {
          $('#nc-flash-message').fadeIn(500);
        }
      }
    };

    return {
      init: function(scope) {
        factory.scope = scope;
        return factory;
      }
    };
  });



/**
 * NetCommonsWysiwyg factory
 */
NetCommonsApp.factory('NetCommonsWysiwyg', function () {

    /**
     * tinymce optins
     *
     * @type {{mode: string, menubar: string, plugins: string, toolbar: string}}
     */
    var options = {
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

    return {
      options: options
    };
  });


/**
 * base controller
 */
NetCommonsApp.controller('NetCommons.base',
    function($http, $scope, $modal, $modalStack, $location, $anchorScroll, NetCommons, NetCommonsFlush) {

//      /**
//       * status published
//       *
//       * @const
//       */
//      $scope.STATUS_PUBLISHED = '1';
//
//      /**
//       * status approved
//       *
//       * @const
//       */
//      $scope.STATUS_APPROVED = '2';
//
//      /**
//       * status drafted
//       *
//       * @const
//       */
//      $scope.STATUS_DRAFTED = '3';
//
//      /**
//       * status disaproved
//       *
//       * @const
//       */
//      $scope.STATUS_DISAPPROVED = '4';

//      /**
//       * tinymce optins
//       *
//       * @type {{mode: string, menubar: string, plugins: string, toolbar: string}}
//       */
//      $scope.tinymceOptions = {
//        mode: 'exact',
//        menubar: ' ',
//        plugins: 'textcolor advlist autolink autoresize charmap code link ',
//        toolbar: 'undo redo  |' +
//            ' forecolor |' +
//            ' styleselect |' +
//            ' bold italic |' +
//            ' alignleft aligncenter alignright alignjustify |' +
//            ' bullist numlist outdent indent |' +
//            ' link |'
//      };

      /**
       * set flash
       *
       * @param {string} text message text
       * @param {string} type bootstrap css class name alert-xxx
       */
      $scope.flash = NetCommonsFlush.init($scope);
//      $scope.flash = {
//        message: '',
//        type: '',
//        close: function() {
//          $scope.flash.message = '';
//          $scope.flash.type = '';
//          $('#nc-flash-message').addClass('hidden');
//        },
//        success: function(message) {
//          $scope.flash.custom(message, 'alert-success', true);
//        },
//        info: function(message) {
//          $scope.flash.custom(message, 'alert-info', true);
//        },
//        warning: function(message) {
//          $scope.flash.custom(message, 'alert-warning', false);
//        },
//        danger: function(message) {
//          $scope.flash.custom(message, 'alert-danger', false);
//        },
//        custom: function(message, type, fadeOut) {
//          $scope.flash.message = message;
//          $scope.flash.type = type;
//          $('#nc-flash-message').removeClass('hidden');
//          if (fadeOut) {
//            $('#nc-flash-message').fadeIn(500).fadeTo(1000, 1).fadeOut(1500);
//          } else {
//            $('#nc-flash-message').fadeIn(500);
//          }
//        }
//      };

      /**
       * show user information method
       *
       * @param {number} users.id
       * @return {string}
       */
      $scope.showUser = function(user_id) {
        alert('user_id:' + user_id);
      };

      /**
       * show dialog method
       *
       * @param {object} scope
       * @param {string} templateUrl
       * @param {string} controller
       * @return {string}
       */
//      $scope.showDialog = function(scope, templateUrl, controller) {
//        $modalStack.dismissAll('canceled');
//
//        //ダイアログ表示
//        $modal.open({
//          templateUrl: templateUrl,
//          controller: controller,
//          backdrop: 'static',
//          scope: scope
//        }).result.then(
//            function(result) {},
//            function(reason) {
//              if (typeof reason.data === 'object') {
//                //openによるエラー
//                $scope.flash.danger(reason.data.name);
//              } else if (reason === 'canceled') {
//                //キャンセル
//                $scope.flash.close();
//              }
//            }
//        );
//      };

//      /**
//       * send get
//       *
//       * @param {string} url
//       * @return {void}
//       */
//      $scope.get = function(url) {
//        return $http.get(url, {cache: false});
//      };
//
//      /**
//       * send delete
//       *
//       * @param {string} url
//       * @return {void}
//       */
//      $scope.delete = function(url) {
//        return $http.delete(url, {cache: false});
//      };
//
//      /**
//       * send post
//       *
//       * @param {string} url
//       * @param {Object.<string>} postParams
//       * @return {void}
//       */
//      $scope.post = function(url, postParams) {
//        return $http.post(url, $.param(postParams),
//            {cache: false,
//              headers: {'Content-Type': 'application/x-www-form-urlencoded'}});
//      };

      /**
       * top method
       *
       * @return {void}
       */
      $scope.top = NetCommons.top;

      /**
       * tab
       *
       * @type {object}
       */
      $scope.tab = {
        tabId: 1,
        setTab: function(tabId) {
          $scope.tabId = tabId;
        },
        isSet: function(tabId) {
          return $scope.tabId === tabId;
        }
      };

      /**
       * comments
       *
       * @type {Object}
       */
      $scope.comments = {
        data: {},
        plugin_key: '',
        content_key: '',
        current: 0,
        hasPrev: false,
        hasNext: false,
        disabled: false,
        visibility: false,
        limit: 0,
        init: function(comments, plugin_key, content_key) {
          $scope.comments.plugin_key = plugin_key;
          $scope.comments.content_key = content_key;
          $scope.comments.current = comments.current;
          $scope.comments.limit = comments.limit;
          $scope.comments.hasPrev = comments.hasPrev;
          $scope.comments.hasNext = comments.hasNext;
          $scope.comments.data = comments.data;
          $scope.comments.disabled =
                            comments.data.length === 0 ? true : false;
          $scope.comments.visibility =
                            comments.data.length === 0 ? false : true;
        },
        get: function(page) {
          $http.get('/comments/comments/index/' +
                    $scope.comments.plugin_key + '/' +
                    $scope.comments.content_key + '/' +
                    'page:' + page + '.json', {cache: false})
              .success(function(data) {
                var comments = data.results.comments;
                $scope.comments.current = comments.current;
                $scope.comments.hasPrev = comments.hasPrev;
                $scope.comments.hasNext = comments.hasNext;
                if (page === 1 &&
                        comments.limit > $scope.comments.data.length) {
                  $scope.comments.data = comments.data;
                } else {
                  $scope.comments.data =
                      $scope.comments.data.concat(comments.data);
                }
              })
              .error(function(data) {
                $scope.flash.danger(data.name);
              });
        },
        input: {
          invalid: function(form) {
            return (! form['comment']['$viewValue']);
          },
          hasErrorTarget: function(statusModel, editStatusModel) {
            if (statusModel === editStatusModel ||
                editStatusModel !== NetCommons.STATUS_DISAPPROVED) {
              return false;
            } else {
              return true;
            }
          },
          class: function(form, statusModel, editStatusModel) {
            if (! $scope.comments.input.hasErrorTarget(statusModel,
                                                       editStatusModel)) {
              return '';
            } else {
              return ($scope.comments.input.invalid(form) ?
                      'has-error' : 'has-success');
            }
          },
          glyphicon: function(form, statusModel, editStatusModel) {
            if (! $scope.comments.input.hasErrorTarget(statusModel,
                                                       editStatusModel)) {
              return '';
            } else {
              return ($scope.comments.input.invalid(form) ?
                      'glyphicon glyphicon-remove' : 'glyphicon glyphicon-ok');
            }
          },
          showMessage: function(form, statusModel, editStatusModel) {
            return ($scope.comments.input.hasErrorTarget(statusModel,
                              editStatusModel) &&
                    $scope.comments.input.invalid(form));
          }
        }
      };
    });
