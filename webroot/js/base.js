var NetCommonsApp = angular.module('NetCommonsApp',
    [
      'ui.bootstrap',
      'ui.tinymce'
    ]
    );

//CakePHPがX-Requested-Withで判断しているため
NetCommonsApp.config(['$httpProvider', function($httpProvider) {
  $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
}]);


/**
 * ncHtmlContent filter
 *
 * @param {string} filter name
 * @param {Array} use service
 */
NetCommonsApp.filter('ncHtmlContent', ['$sce', function($sce) {
  return function(input) {
    return $sce.trustAsHtml(input);
  };
}]);


/**
 * NetCommonsFlash factory
 */
NetCommonsApp.factory('NetCommonsFlash', function() {
  return true;
});


/**
 * NetCommonsBase factory
 */
NetCommonsApp.factory(
    'NetCommonsBase',
    ['$http', '$q', '$modal', '$modalStack', '$location', '$anchorScroll',
      function(
         $http, $q, $modal, $modalStack, $location, $anchorScroll) {

        /**
         * variables
         *
         * @type {Object.<string>}
         */
        var urlVariables = {
          plugin: '',
          controller: '',
          action: ''
        };

        /**
         * functions
         *
         * @type {Object.<function>}
         */
        var urlFunctions = {
          /**
           * initUrl method
           *
           * @param {string} plugin name
           * @param {string} controller name
           * @return {Object.<Object|string|function>}
           */
          initUrl: function(plugin, controller) {
            urlFunctions.setPlugin(plugin);
            urlFunctions.setController(controller);
            return angular.extend(urlVariables, urlFunctions);
          },

          /**
           * setPlugin method
           *
           * @param {string} plugin name
           * @return {void}
           */
          setPlugin: function(plugin) {
            urlVariables.plugin = plugin;
          },

          /**
           * setController method
           *
           * @param {string} controller name
           * @return {void}
           */
          setController: function(controller) {
            urlVariables.controller = controller;
          },

          /**
           * getUrl method
           *
           * @param {string} action name
           * @param {Object.<string>} options
           * @return {string} url
           */
          getUrl: function(action, options) {
            var url = '/' + urlVariables.plugin + '/' + urlVariables.controller;
            if (! angular.isString(action)) {
              url = url + '/' + urlVariables.action;
            } else {
              url = url + '/' + action;
            }
            if (angular.isArray(options)) {
              for (var i = 0; i < options.length; i++) {
                url = url + '/' + options[i];
              }
            } else if (angular.isString(options)) {
              url = url + '/' + options;
            } else if (angular.isNumber(options)) {
              url = url + '/' + options.toString();
            }
            return url;
          }
        };

        /**
         * variables
         *
         * @type {Object.<string>}
         */
        var variables = {
          /**
           * Relative path to login form
           *
           * @const
           */
          LOGIN_URI: '/auth/login',

          /**
           * Relative path to login form
           *
           * @const
           */
          LOGOUT_URI: '/auth/logout',

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
          STATUS_IN_DRAFT: '3',

          /**
           * status disaproved
           *
           * @const
           */
          STATUS_DISAPPROVED: '4',

          /**
           * SERVER_VALIDATE_KEY
           *
           * @const
           */
          VALIDATE_KEY: 'validation',

          /**
           * SERVER_VALIDATE_KEY
           *
           * @const
           */
          VALIDATE_MESSAGE_KEY: 'validationErrors'

        };

        var deferred = $q.defer();

        /**
         * functions
         *
         * @type {Object.<function>}
         */
        var functions = {
          /**
           * new method
           *
           * @return {Object.<Object|string|function>}
           */
          new: function() {
            return angular.extend(variables, urlVariables,
                                  functions, urlFunctions);
          },

          /**
           * top method
           *
           * @return {void}
           */
          top: function() {
            $location.hash('nc-modal-top');
            $anchorScroll();
          },

          /**
           * getScopeById method
           *
           * @param {string} scopeId is $scope.$id
           * @return {Object | null}
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
          },

          /**
           * bool2intInArray
           *
           * @param {Object|Array} arrayVar
           * @return {Object}
           */
          bool2intInArray: function(arrayVar) {
            angular.forEach(arrayVar, function(value, key) {
              if (angular.isObject(arrayVar[key]) ||
                      angular.isArray(arrayVar[key])) {
                functions.bool2intInArray(arrayVar[key]);
              } else if (arrayVar[key] === true || arrayVar[key] === false) {
                arrayVar[key] = Number(arrayVar[key]);
              }
            });
            return arrayVar;
          }

        };

        return functions.new();
      }]);


/**
 * NetCommonsUser factory
 */
NetCommonsApp.factory('NetCommonsUser', function() {

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
     *
     * @return {Object.<Object|string|function>}
     */
    new: function() {
      return angular.extend(variables, functions);
    },

    /**
     * show user information method
     *
     * @param {number} users.id
     * @return {void}
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
NetCommonsApp.factory('NetCommonsTab', function() {

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
     *
     * @return {Object.<Object|string|function>}
     */
    new: function() {
      return angular.extend(variables, functions);
    },

    /**
     * setTab method
     *
     * @param {number} tabId
     * @return {void}
     */
    setTab: function(tabId) {
      variables.tabId = tabId;
    },

    /**
     * isSet method
     *
     * @param {number} tabId
     * @return {boolean}
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
NetCommonsApp.controller('NetCommons.base', function(
    $scope, $modalStack, NetCommonsBase) {

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

      /**
       * dialog cancel
       *
       * @return {void}
       */
      $scope.cancel = function() {
        history.back();
      };
    });
