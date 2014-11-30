var NetCommonsApp = angular.module('NetCommonsApp',
    [
      'ui.bootstrap',
      'ui.tinymce'
    ]
  );

//NetCommonsApp.config(['$httpProvider', function($httpProvider) {
// $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
//}]);

/**
 * NetCommonsFlush factory
 */
NetCommonsApp.factory('NetCommonsFlush', function () {

  /**
   * element
   *
   * @type {Object.<string>}
   */
  var element = angular.element('#nc-flash-message');

  /**
   * scope
   *
   * @type {Object.<string>}
   */
  var scope = element.scope();

  /**
   * variables
   *
   * @type {Object.<string>}
   */
  var variables = {
    message: '',
    type: ''
  };

  /**
   * functions
   *
   * @type {Object.<function>}
   */
  var functions = {
    /**
     * new method
     */
     new: function () {
      return angular.extend(variables, functions);
    },

    /**
     * close method
     */
     close: function() {
      scope.flash.message = '';
      scope.flash.type = '';
      element.addClass('hidden');
    },

    /**
     * success method
     *
     * @param {string} message
     */
    success: function(message) {
      functions.custom(message, 'alert-success', true);
    },

    /**
     * info method
     *
     * @param {string} message
     */
    info: function(message) {
      functions.custom(message, 'alert-info', true);
    },

    /**
     * warning method
     *
     * @param {string} message
     */
    warning: function(message) {
      functions.custom(message, 'alert-warning', false);
    },

    /**
     * danger method
     *
     * @param {string} message
     */
    danger: function(message) {
      functions.custom(message, 'alert-danger', false);
    },

    /**
     * custom method
     *
     * @param {string} message
     * @param {string} type
     * @param {boolean} true is fadeOut, false is no fadeOut.
     */
    custom: function(message, type, fadeOut) {
      scope.flash.message = message;
      scope.flash.type = type;
      element.removeClass('hidden');
      if (fadeOut) {
        element.fadeIn(500).fadeTo(1000, 1).fadeOut(1500);
      } else {
        element.fadeIn(500);
      }
    }
  };

  return functions.new();
});

/**
 * NetCommonsBase factory
 */
NetCommonsApp.factory('NetCommonsBase',
    ['$http', '$q', '$modal', '$modalStack', '$location',
      '$anchorScroll', 'NetCommonsFlush',
      function ($http, $q, $modal, $modalStack, $location,
                $anchorScroll, NetCommonsFlush) {

    /**
     * variables
     *
     * @type {Object.<string>}
     */
    var variables = {
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
    };

    /**
     * functions
     *
     * @type {Object.<function>}
     */
    var functions = {
      /**
       * new method
       */
      new: function () {
        return angular.extend(variables, functions);
      },

      /**
       * show dialog method
       *
       * @param {string} scopeId
       * @param {string} templateUrl
       * @param {string} controller
       */
      showDialog: function(scopeId, templateUrl, controller) {
        var scope = this.getElementByScopeId(scopeId).scope();
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
                NetCommonsFlush.danger(reason.data.name);
              } else if (reason === 'canceled') {
                //キャンセル
                NetCommonsFlush.close();
              }
            }
        );
      },

      /**
       * send get
       *
       * @param {string} url
       */
      get: function(url) {
        return $http.get(url, {cache: false});
      },

      /**
       * send delete
       *
       * @param {string} url
       */
      delete: function(url) {
        return $http.delete(url, {cache: false});
      },

      /**
       * send post
       *
       * @param {string} url
       * @param {Object.<string>} postParams
       */
      post: function(url, postParams) {
        return $http.post(url, $.param(postParams),
            {cache: false,
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              }
            });
      },

      /**
       * save
       *
       * @param {string} tokenUrl
       * @param {string} postUrl
       * @param {Object.<string>} postParams
       */
      save: function(tokenUrl, postUrl, postParams) {
        var deferred = $q.defer();
        var promise = deferred.promise;

        functions.get(tokenUrl)
            .success(function(data) {
              postParams.data._Token = data._Token;

              //登録情報をPOST
              functions.post(postUrl, postParams)
                .success(function(data) {
                      NetCommonsFlush.success(data.name);
                      //success condition
                      deferred.resolve(data);
                    })
                .error(function(data, status) {
                      NetCommonsFlush.danger(data.name);
                      //error condition
                      deferred.reject(data, status);
                    });
            })
            .error(function(data, status) {
              //keyの取得に失敗
              //error condition
              deferred.reject(data, status);
            });

        promise.success = function (fn) {
            promise.then(fn);
            return promise;
        }

        promise.error = function (fn) {
            promise.then(null, fn);
            return promise;
        }

        return promise;
      },

      /**
       * top method
       */
      top: function() {
        $location.hash('nc-modal-top');
        $anchorScroll();
      },

      /**
       * getScopeById method
       *
       * @param {string} scopeId is $scope.$id
       */
      getElementByScopeId: function(scopeId) {
        var scopes = angular.element('.ng-scope');
        var element = null;
        for (var i = 0; i < scopes.length; i++) {
          element = angular.element(scopes[i]);
          if (element.scope().$id === scopeId) {
              return element;
          }
        }
        return null;
      }

    };

    return functions.new();
  }]);


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

  /**
   * variables
   *
   * @type {Object.<string>}
   */
  var variables = {
    options: options
  };

  /**
   * functions
   *
   * @type {Object.<function>}
   */
  var functions = {
    /**
     * new method
     */
     new: function () {
      return angular.extend(variables, functions);
    }
  };

  return functions.new();
});


/**
 * NetCommonsUser factory
 */
NetCommonsApp.factory('NetCommonsUser', function () {

  /**
   * variables
   *
   * @type {Object.<string>}
   */
  var variables = {};

  /**
   * functions
   *
   * @type {Object.<function>}
   */
  var functions = {
    /**
     * new method
     */
    new: function () {
      return angular.extend(variables, functions);
    },

    /**
     * show user information method
     *
     * @param {number} users.id
     */
    showUser: function(user_id) {
      alert('user_id:' + user_id);
    }
  };

  return functions.new();
});


/**
 * NetCommonsTab factory
 */
NetCommonsApp.factory('NetCommonsTab', function () {

  /**
   * variables
   *
   * @type {Object.<string|number>}
   */
  var variables = {
    tabId: 0
  };

  /**
   * functions
   *
   * @type {Object.<function>}
   */
  var functions = {
    /**
     * new method
     */
    new: function () {
      return angular.extend(variables, functions);
    },

    /**
     * setTab method
     *
     * @param {number} tabId
     */
    setTab: function(tabId) {
      variables.tabId = tabId;
    },

    /**
     * isSet method
     *
     * @param {number} tabId
     */
    isSet: function(tabId) {
      return variables.tabId === tabId;
    }
  };

  return functions.new();
});


/**
 * base controller
 */
NetCommonsApp.controller('NetCommons.base', function($scope, NetCommonsBase) {

  /**
   * messages
   *
   * @type {Object}
   */
  $scope.messages = {};

  /**
   * placeholder
   *
   * @type {string}
   */
  $scope.placeholder = '';

  /**
   * top
   *
   * @type {function}
   */
  $scope.top = NetCommonsBase.top;

});
