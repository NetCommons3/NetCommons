/**
 * @fileoverview Workflow Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * NcWorkflowForm directive Javascript
 *
 * @param {string} directive name
 * @param {function()} directive
 */
NetCommonsApp.directive('ncWorkflowIndex', function(){

  /**
   * derective
   *
   * @type {Object.<string>}
   */
  var derective = {
    templateUrl:
        '/net_commons/base/template/workflow/index.html?' + Math.random(),
    link: function (scope, element, attrs, ctrl) {
      scope.messages['more'] = attrs.ncMessageMore;
    }
  };

	return derective;
});


/**
 * NcWorkflowForm directive Javascript
 *
 * @param {string} directive name
 * @param {function()} directive
 */
NetCommonsApp.directive('ncWorkflowForm', function(){

  /**
   * derective
   *
   * @type {Object.<string>}
   */
  var derective = {
    templateUrl:
        '/net_commons/base/template/workflow/form.html?' + Math.random(),
    link: function (scope, element, attrs, ctrl) {
      scope.messages['error_required'] = attrs.ncMessageErrorRequired;
      scope.messages['workflow_placeholder'] = attrs.ncMessagePlaceholder;
      scope.messages['workflow_placeholder_approved'] =
                                          attrs.ncMessagePlaceholderApproved;
      scope.messages['workflow_label'] = attrs.ncMessageLabel;

      scope.workflow.form = scope[attrs.ncWorkflowForm];
    }
  };

	return derective;
});


/**
 * NetCommonsWorkflow factory
 */
NetCommonsApp.factory('NetCommonsWorkflow',
    ['$http', 'NetCommonsBase', 'NetCommonsFlush',
      function ($http, NetCommonsBase, NetCommonsFlush) {

    /**
     * comments
     *
     * @type {Object.<string>}
     */
    var master = {
      comments: {
        data: {},
        plugin_key: '',
        content_key: '',
        current: 0,
        hasPrev: false,
        hasNext: false,
        disabled: false,
        visibility: false,
        limit: 0
      },
      currentStatus: 0,
      editStatus: 0,
      input: {
        comment: ''
      }
    };

   /**
     * factory
     *
     * @type {Object.<string>}
     */
    var factory = {
      scope: {},
      comments: {},
      form: {},
      currentStatus: master.currentStatus,
      editStatus: master.editStatus,
      input: {
        comment: ''
      }
    };

    /**
     * functions
     *
     * @type {Object.<function>}
     */
    var functions = {
      clear: function () {
        angular.copy(master.comments, factory.comments);
        factory.currentStatus = master.currentStatus;
        factory.editStatus = master.editStatus;
      },
      new: function (scope) {
        functions.clear();
        factory.scope = scope;
        return angular.extend(factory, functions);
      },
      init: function(comments) {
        if (typeof comments !== 'undefined') {
          factory.comments.current = comments.current;
          factory.comments.limit = comments.limit;
          factory.comments.hasPrev = comments.hasPrev;
          factory.comments.hasNext = comments.hasNext;
          factory.comments.data = comments.data;
          factory.comments.disabled =
                            comments.data.length === 0 ? true : false;
          factory.comments.visibility =
                            comments.data.length === 0 ? false : true;
        }
      },
      get: function(page) {
        $http.get('/comments/comments/index/' +
                  factory.comments.plugin_key + '/' +
                  factory.comments.content_key + '/' +
                  'page:' + page + '.json', {cache: false})
            .success(function(data) {
              var comments = data.results.comments;
              factory.comments.current = comments.current;
              factory.comments.hasPrev = comments.hasPrev;
              factory.comments.hasNext = comments.hasNext;
              if (page === 1 &&
                      comments.limit > factory.comments.data.length) {
                factory.comments.data = comments.data;
              } else {
                factory.comments.data =
                    factory.comments.data.concat(comments.data);
              }
            })
            .error(function(data) {
              NetCommonsFlush.danger(data.name);
            });
      },
      input: {
        placeholder: function() {
          if (factory.currentStatus === NetCommonsBase.STATUS_APPROVED) {
            return factory.scope.messages.workflow_placeholder +
                          factory.scope.messages.workflow_placeholder_approved;
          } else {
            return factory.scope.messages.workflow_placeholder;
          }
        },
        invalid: function() {
          return (! factory.form['comment']['$viewValue']);
        },
        hasErrorTarget: function() {
          if (factory.currentStatus === factory.editStatus ||
              factory.editStatus !== NetCommonsBase.STATUS_DISAPPROVED) {
            return false;
          } else {
            return true;
          }
        },
        class: function() {
          if (! factory.input.hasErrorTarget()) {
            return '';
          } else {
            return (factory.input.invalid() ?
                    'has-error' : 'has-success');
          }
        },
        required: function() {
          return (factory.editStatus === NetCommonsBase.STATUS_DISAPPROVED);
        },
        glyphicon: function() {
          if (! factory.input.hasErrorTarget()) {
            return '';
          } else {
            return (factory.input.invalid() ?
                    'glyphicon glyphicon-remove' : 'glyphicon glyphicon-ok');
          }
        },
        showMessage: function() {
          return (factory.input.hasErrorTarget() && factory.input.invalid());
        }
      }
    };

    return functions.new({});
  }]);

