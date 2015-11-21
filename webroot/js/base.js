var NetCommonsApp = angular.module('NetCommonsApp',
    [
      'ui.bootstrap'
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
 * ServerDatetime filter
 *
 * @see https://github.com/NetCommons3/NetCommons3/issues/12
 * @param {string} filter name
 * @param {Array} use service
 */
NetCommonsApp.filter('ncDatetime', ['$filter', function($filter) {
  return function(input) {
    if (!input || input.length == 0) {
      return '';
    }
    var d = new Date(input.replace(/-/g, '/'));
    var nowD = new Date();
    if (d.getFullYear() == nowD.getFullYear() &&
        d.getMonth() == nowD.getMonth() &&
        d.getDate() == nowD.getDate()) {
      return $filter('date')(d, 'HH:mm');
    } else if (d.getFullYear() == nowD.getFullYear()) {
      return $filter('date')(d, 'MM/dd');
    } else {
      return $filter('date')(d, 'yyyy/MM/dd');
    }
  };
}]);


/**
 * Modal factory
 */
NetCommonsApp.factory('NetCommonsModal', ['$modal', function($modal) {
  return {
    show: function($scope, controller, url, options) {
      options = angular.extend({
        templateUrl: url,
        controller: controller,
        //backdrop: 'static',
        //size: 'lg',
        animation: false,
        scope: $scope
      }, options);

      return $modal.open(options);
    }
  }}]
);


/**
 * NetCommonsFlash factory
 */
NetCommonsApp.factory('NetCommonsFlash', function() {
  return true;
});


/**
 * NetCommonsBase factory
 * 後で削除したい
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
//NetCommonsApp.factory('NetCommonsUser', function() {
//
//  /**
//   * variables
//   *
//   * @type {Object.<string>}
//   */
//  var variables = {};
//
//  /**
//   * functions
//   *
//   * @type {Object.<function>}
//   */
//  var functions = {
//    /**
//     * new method
//     *
//     * @return {Object.<Object|string|function>}
//     */
//    new: function() {
//      return angular.extend(variables, functions);
//    },
//
//    /**
//     * show user information method
//     *
//     * @param {number} users.id
//     * @return {void}
//     */
//    showUser: function(user_id) {
//      alert('user_id:' + user_id);
//    }
//  };
//
//  return functions.new();
//});


/**
 * NetCommonsTab factory
 * 後で削除したい
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
    $scope, $location) {

      /**
       * Base URL
       *
       * @type {string}
       */
      $scope.baseUrl = '';

      /**
       * sending
       *
       * @type {boolean}
       */
      $scope.sending = false;

      /**
       * messages
       *
       * @type {Object}
       */
      $scope.messages = {};

      /**
       * top
       *
       * @type {function}
       */
      $scope.top = function() {
        $location.hash('nc-modal-top');
        $anchorScroll();
      };

      /**
       * flash message method
       *
       * @param {string} message
       * @param {string} messageClass
       * @param {int} interval
       * @return {void}
       */
      $scope.flashMessage = function(message, messageClass, interval) {
        $scope.flash = {
          message: message,
          class: messageClass
        };
        $('#nc-flash-message').removeClass('hidden');
        if (interval > 0) {
          $('#nc-flash-message').fadeIn(500).fadeTo(interval, 1).fadeOut(1500);
        } else {
          $('#nc-flash-message').fadeIn(500);
        }
      };

    });
