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
   * factory
   *
   * @type {Object.<string>}
   */
  var factory = {
    message: '',
    type: ''
  };

  /**
   * functions
   *
   * @type {Object.<function>}
   */
  var functions = {
    new: function () {
      return angular.extend(factory, functions);
    },
    close: function() {
      scope.flash.message = '';
      scope.flash.type = '';
      element.addClass('hidden');
    },
    success: function(message) {
      functions.custom(message, 'alert-success', true);
    },
    info: function(message) {
      functions.custom(message, 'alert-info', true);
    },
    warning: function(message) {
      functions.custom(message, 'alert-warning', false);
    },
    danger: function(message) {
      functions.custom(message, 'alert-danger', false);
    },
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
     * factory
     *
     * @type {Object.<string>}
     */
    var factory = {
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
        return angular.extend(factory, functions);
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
   * factory
   *
   * @type {Object.<string>}
   */
  var factory = {
    options: options
  };

  /**
   * functions
   *
   * @type {Object.<function>}
   */
  var functions = {
    new: function () {
      return angular.extend(factory, functions);
    }
  };

  return functions.new();
});


/**
 * NetCommonsUser factory
 */
NetCommonsApp.factory('NetCommonsUser', function () {

  /**
   * factory
   *
   * @type {Object.<string>}
   */
  var factory = {};

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
      return angular.extend(factory, functions);
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
   * factory
   *
   * @type {Object.<string>}
   */
  var factory = {
    tabId: 0
  };

  /**
   * functions
   *
   * @type {Object.<function>}
   */
  var functions = {
    new: function () {
      return angular.extend(factory, functions);
    },
    setTab: function(tabId) {
      factory.tabId = tabId;
    },
    isSet: function(tabId) {
      return factory.tabId === tabId;
    }
  };

  return functions.new(true);
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
   * messages
   *
   * @type {Object}
   */
  $scope.placeholder = '';

  /**
   * top
   */
  $scope.top = NetCommonsBase.top;
});
