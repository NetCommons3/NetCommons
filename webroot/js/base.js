/**
 * @fileoverview NetCommonsApp Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */

var NetCommonsApp = angular.module('NetCommonsApp', ['ui.bootstrap']);

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
        $('#nc-flash-message').removeClass('hidden');
        if (interval > 0) {
          $('#nc-flash-message').fadeIn(500).fadeTo(interval, 1).fadeOut(1500);
        } else {
          $('#nc-flash-message').fadeIn(500);
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
          var hash = $location.path();
          var frameId = $window.location.href.match('frame_id=([0-9]+)');
          var element = null;
          if (hash) {
            element = $('#' + hash.substr(1));
          } else if (frameId) {
            element = $('#frame-' + frameId[1]);
          }
          try {
            var pos = element.offset().top;
            $window.scrollTo(0, pos - 100);
          } catch (err) {
            $window.scrollTo(0, 0);
          }
        }).trigger('hashchange');
      };

    }]);
