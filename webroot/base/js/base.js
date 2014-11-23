var NetCommonsApp = angular.module('NetCommonsApp',
    [
      'ui.bootstrap',
      'ui.tinymce'
    ]
    );


/**
 * base controller
 */
NetCommonsApp.controller('NetCommons.base',
    function($http, $scope, $modal, $modalStack, $location, $anchorScroll) {

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
       * tinymce optins
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

      /**
       * show dialog method
       *
       * @param {object} scope
       * @param {string} templateUrl
       * @param {string} controller
       * @return {string}
       */
      $scope.showDialog = function(scope, templateUrl, controller) {
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
                $scope.flash.danger(reason.data.name);
              } else if (reason === 'canceled') {
                //キャンセル
                $scope.flash.close();
              }
            }
        );
      };

      /**
       * top method
       *
       * @return {void}
       */
      $scope.top = function() {
        $location.hash('nc-modal-top');
        $anchorScroll();
      };

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
            return form['comment'].$invalid;
          },
          hasErrorTarget: function(statusModel, editStatusModel) {
            if (statusModel === editStatusModel ||
                editStatusModel !== $scope.STATUS_DISAPPROVED) {
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
