var NetCommonsApp = angular.module('NetCommonsApp',
    [
      'ui.bootstrap',
      'ui.tinymce'
    ]
  );

//NetCommonsApp.config(['$httpProvider', function($httpProvider) {
// $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
//}]);

//
///**
// * ncSetForm directive Javascript
// *
// * @param {string} directive name
// * @param {function()} directive
// */
//NetCommonsApp.directive('ncValidationClear', function(){
//
//  /**
//   * derective
//   *
//   * @type {Object.<string>}
//   */
//  var derective = {
//    require: 'ngModel',
//    link: function (scope, element, attrs, ctrl) {
////console.log('ncSetForm=' + scope.$id);
//      console.log(scope);
////      scope.form2 = scope[attrs.ncSetForm];
//      console.log(element);
//      console.log(attrs);
//      console.log(ctrl);
//
//      element.on('change', function () {
//        scope.$apply(function () {
//          console.log(attrs.ncValidationClear);
//        });
//
//      });
//
//    }
//  };
//
//	return derective;
//});

/**
 * NetCommonsFlash factory
 */
NetCommonsApp.factory('NetCommonsFlash', function () {

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
      '$anchorScroll', 'NetCommonsFlash',
      function ($http, $q, $modal, $modalStack, $location,
                $anchorScroll, NetCommonsFlash) {

    /**
     * variables
     *
     * @type {Object.<string>}
     */
    var urlVariables = {
      plugin: '',
      controller: '',
      action: '',
    };

  /**
   * functions
   *
   * @type {Object.<function>}
   */
  var urlFunctions = {
    initUrl: function (plugin, controller) {
      urlFunctions.setPlugin(plugin);
      urlFunctions.setController(controller);
      return angular.extend(urlVariables, urlFunctions);
    },
    setPlugin: function(plugin) {
      urlVariables.plugin = plugin;
    },
    setController: function(controller) {
      urlVariables.controller = controller;
    },
    setAction: function(action) {
      urlVariables.action = action;
    },
    getUrl: function(action, options) {
      var url = '/' + urlVariables.plugin + '/' + urlVariables.controller;
      if (! angular.isString(action)) {
        url = url + '/' + urlVariables.action;
      } else {
        url = url + '/' + action;
      }

      if (angular.isArray(options)) {
        for (var i = 0; i < options; i++) {
          url = url + '/' + options[i];
        }
      } else if (angular.isString(options)) {
         url = url + '/' + options;
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
      VALIDATE_MESSAGE_KEY: 'validationErrors',

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
        return angular.extend(variables, urlVariables, functions, urlFunctions);
      },

      /**
       * show setting method
       *
       * @param {string} editUrl
       * @param {function} callback
       * @param {Object.<string>}
       *               modalOptions is {scope, templateUrl, controller, ...}
       */
      showSetting: function(editUrl, callback, modalOptions) {
        functions.get(editUrl)
            .success(function(data) {
              //最新データセット
              if (angular.isFunction(callback)) {
                callback(data.results);
              }
               //ダイアログ呼び出し
              functions.showDialog(modalOptions).result.then(
                  function(result) {},
                  function(reason) {
                    if (typeof reason.data === 'object') {
                      //openによるエラー
                      NetCommonsFlash.danger(reason.data.name);
                    } else if (reason === 'canceled') {
                      //キャンセル
                      NetCommonsFlash.close();
                    }
                  }
              );
            })
            .error(function(data) {
              NetCommonsFlash.danger(data.name);
            });
      },

      /**
       * show dialog method
       *
       * @param {Object.<string>} options is {scope, templateUrl, controller}
       */
      showDialog: function(options) {
        if (! angular.isString(options['backdrop'])) {
          options['backdrop'] = 'static';
        }
//        if (! angular.isString(options['resolve'])) {
//          options['resolve'] = {
//            parentScope: function () {
//              return options['scope'];
//            }
//          };
//        }

        $modalStack.dismissAll('canceled');


console.log('NetCommonsBase->showDialog=' + options['scope'].$id);

        //ダイアログ表示
        return $modal.open(options);
      },

      /**
       * send get
       *
       * @param {string} url
       */
      get: function(url) {
        var deferred = $q.defer();
        var promise = deferred.promise;

        $http.get(url, {cache: false})
          .success(function(data) {
                //success condition
                deferred.resolve(data);
              })
          .error(function(data, status) {
                //error condition
                deferred.reject(data, status);
              });

        promise.success = function (fn) {
            promise.then(fn);
            return promise;
        };

        promise.error = function (fn) {
            promise.then(null, fn);
            return promise;
        };

        return promise;
      },

      /**
       * send delete
       *
       * @param {string} url
       */
      delete: function(url) {
        var deferred = $q.defer();
        var promise = deferred.promise;

        $http.delete(url, {cache: false})
          .success(function(data) {
                //success condition
                deferred.resolve(data);
              })
          .error(function(data, status) {
                //error condition
                deferred.reject(data, status);
              });

        promise.success = function (fn) {
            promise.then(fn);
            return promise;
        };

        promise.error = function (fn) {
            promise.then(null, fn);
            return promise;
        };

        return promise;
      },

      /**
       * send post
       *
       * @param {string} url
       * @param {Object.<string>} postParams
       */
      post: function(url, postParams) {
        var deferred = $q.defer();
        var promise = deferred.promise;

        $http.post(url, $.param(postParams),
            {cache: false,
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
              }
            })
          .success(function(data) {
                //success condition
                deferred.resolve(data);
              })
          .error(function(data, status) {
                //error condition
                deferred.reject(data, status);
              });

        promise.success = function (fn) {
            promise.then(fn);
            return promise;
        };

        promise.error = function (fn) {
            promise.then(null, fn);
            return promise;
        };

        return promise;
      },

      /**
       * save
       *
       * @param {Object} scope
       * @param {Object} form
       * @param {string} tokenUrl
       * @param {string} postUrl
       * @param {Object.<string>} postParams
       */
      save: function(scope, form, tokenUrl, postUrl, postParams, callback) {
        var deferred = $q.defer();
        var promise = deferred.promise;

        scope.sending = true;
console.log('NetCommonsBase->save=' + scope.$id);
console.log(scope);
console.log(form);
console.log(form.$invalid);

        functions.get(tokenUrl)
            .success(function(data) {
              postParams.data._Token = data._Token;

              //登録情報をPOST
              functions.post(postUrl, postParams)
                .success(function(data) {
                      if (angular.isFunction(callback)) {
                        callback(data);
                      }
                      NetCommonsFlash.success(data.name);
                      $modalStack.dismissAll('saved');

                      //success condition
                      deferred.resolve(data);
                    })
                .error(function(data, status) {
                      if (angular.isObject(data['results']) &&
                          angular.isObject(
                            data['results'][variables.VALIDATE_MESSAGE_KEY])) {

                        angular.forEach(
                                data['results'][variables.VALIDATE_MESSAGE_KEY],
                                function(value, key) {

                          if (! angular.isUndefined(form[key])) {
                            form[key].$setValidity(
                                    variables.VALIDATE_KEY, false);
                            form[key][variables.VALIDATE_MESSAGE_KEY] = value;
                          }
                        });
                      }

                      if (! form.$invalid) {
                        NetCommonsFlash.danger(data.name);
                      }
//
//
//                      form.comment.$setValidity('aaaa', false);
//                      form['comment']['errorMessage'] = {
//                        aaaa: 'error message'
//                      };
//                      //form.comment.$setViewValue('aaaa message');
console.log(form);
console.log(form.$invalid);
//console.log(form['comment']['$error']['aaaa']);
//console.log(form['comment']['$error']['aaaa']);


                      //error condition
                      deferred.reject(data, status);
                    })
                .finally (function() {
                      scope.sending = false;
                    });
                })
            .error(function(data, status) {
              //keyの取得に失敗
              scope.sending = false;
              //error condition
              deferred.reject(data, status);
            });

        promise.success = function (fn) {
            promise.then(fn);
            return promise;
        };

        promise.error = function (fn) {
            promise.then(null, fn);
            return promise;
        };

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
      },

      /**
       * serverValidationClear
       */
      serverValidationClear: function(form, key) {
        if (! angular.isUndefined(form[key].$error[variables.VALIDATE_KEY]) &&
                form[key].$error[variables.VALIDATE_KEY]) {
          form[key].$setValidity(variables.VALIDATE_KEY, true);
          form[key][variables.VALIDATE_MESSAGE_KEY] = '';
        }
      }

    };

    return functions.new();
  }]);


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
NetCommonsApp.controller('NetCommons.base', function(
        $scope, $modalStack, NetCommonsBase, NetCommonsFlash) {

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
      $modalStack.dismissAll('canceled');
    };

    /**
     * flash
     *
     * @type {object}
     */
    $scope.flash = NetCommonsFlash.new();

  });
