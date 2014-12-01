/**
 * @fileoverview Wysiwyg Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


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

      /**
       * sending
       *
       * @type {bool}
       */
      $scope.sending = false;

  });
