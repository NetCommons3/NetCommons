/**
 * @fileoverview NetCommonsApp Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */

var NetCommonsApp = angular.module('NetCommonsApp', ['ngAnimate', 'ui.bootstrap']);

//CakePHPがX-Requested-Withで判断しているため
NetCommonsApp.config(['$httpProvider', function($httpProvider) {
  $httpProvider.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
  $httpProvider.defaults.headers.common['If-Modified-Since'] =
      new Date() . toUTCString();
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
NetCommonsApp.factory('NetCommonsModal', ['$uibModal', function($uibModal) {
  return {
    show: function($scope, controller, url, options) {
      var defaultOptions = {
        //templateUrl: url,
        controller: controller,
        //backdrop: 'static',
        //size: 'lg',
        animation: false,
        scope: $scope
      };
      if (url) {
        defaultOptions['templateUrl'] = url;
      }

      options = angular.extend(defaultOptions, options);
      return $uibModal.open(options);
    }
  }}]
);


/**
 * focus directive
 */
NetCommonsApp.directive('ncFocus', ['$timeout', function($timeout) {
  return {
    scope: {
      trigger: '@ncFocus'
    },
    link: function(scope, element) {
      scope.$watch('trigger', function(value) {
        if (value === 'true' || value === true) {
          $timeout(function() {
            element[0].focus();
          });
        }
      });
    }
  };
}]);


/**
 * AJAXのPOSTリクエスト送信処理 factory Javascript
 *
 * @param {string} Controller name
 * @param {function('$http', '$q', 'NC3_URL')} Controller
 */
NetCommonsApp.factory('ajaxSendPost', ['$http', '$q', 'NC3_URL', function($http, $q, NC3_URL) {
  return function(method, url, post) {

    var deferred = $q.defer();
    var promise = deferred.promise;

    $http.get(NC3_URL + '/net_commons/net_commons/csrfToken.json')
        .then(function(response) {
          if (!post._Token) {
            post._Token = {};
          }
          var token = response.data;
          post._Token.key = token.data._Token.key;

          //POSTリクエスト
          $http.post(
              NC3_URL + url,
              $.param({_method: method, data: post}),
              {cache: false,
                headers:
                    {'Content-Type': 'application/x-www-form-urlencoded'}
              }
          ).then(
              function(response) {
                //success condition
                deferred.resolve(response);
              },
              function(response) {
                //error condition
                deferred.reject(response);
              }
          );
        },
        function(response) {
          //Token error condition
          deferred.reject(response);
        });

    promise.success = function(fn) {
      promise.then(fn);
      return promise;
    };

    promise.error = function(fn) {
      promise.then(null, fn);
      return promise;
    };

    return promise;
  };
}]);


/**
 * base controller
 */
NetCommonsApp.controller('NetCommons.base',
    ['$scope', '$location', '$window', 'NC3_URL', function($scope, $location, $window, NC3_URL) {

      /**
       * Base URL
       *
       * @type {string}
       */
      $scope.baseUrl = NC3_URL;

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
        $('#nc-ajax-flash-message').removeClass('hidden');
        if (interval > 0) {
          $('#nc-ajax-flash-message').fadeIn(500).fadeTo(500, 1).fadeOut(interval);
        } else {
          $('#nc-ajax-flash-message').fadeIn(500);
        }
      };

      /**
       * submit
       *
       * @type {function}
       */
      $scope.submit = function($event) {
        if ($scope.sending) {
          $event.preventDefault();
        }
        $scope.sending = true;
      };

      /**
       * cancel
       *
       * @type {function}
       */
      $scope.cancel = function(url) {
        $scope.sending = true;
        if ($window.location.href === url) {
          $window.location.reload();
        } else {
          $window.location.href = url;
        }
      };

      /**
       * hashChange
       *
       * @return {void}
       */
      $scope.hashChange = function() {
        $($window).bind('hashchange', function() {
          var hash = $location.hash();
          var frameId = $window.location.href.match('frame_id=([0-9]+)');
          var element = null;
          try {
            if (hash) {
              if (hash.substr(0, 1) === '/') {
                element = $('#' + hash.substr(1));
              } else {
                element = $('#' + hash);
              }
            } else if (frameId) {
              element = $('#frame-' + frameId[1]);
            }
            var pos = element.offset().top;
            $window.scrollTo(0, pos - 100);
          } catch (err) {
            $window.scrollTo(0, 0);
          }
        }).trigger('hashchange');
      };
    }]);
