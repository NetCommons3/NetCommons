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
    link: function (scope, element, attrs) {
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
    link: function (scope, element, attrs) {
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
    ['$http', 'NetCommonsBase', 'NetCommonsFlash',
      function ($http, NetCommonsBase, NetCommonsFlash) {

   /**
    * master
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
    * variables
    *
    * @type {Object.<string>}
    */
    var variables = {
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
        angular.copy(master.comments, variables.comments);
        variables.currentStatus = master.currentStatus;
        variables.editStatus = master.editStatus;
      },
      new: function (scope) {
        functions.clear();
        variables.scope = scope;
        return angular.extend(variables, functions);
      },
      init: function(comments) {
        if (typeof comments !== 'undefined') {
          variables.comments.current = comments.current;
          variables.comments.limit = comments.limit;
          variables.comments.hasPrev = comments.hasPrev;
          variables.comments.hasNext = comments.hasNext;
          variables.comments.data = comments.data;
          variables.comments.disabled =
                            comments.data.length === 0 ? true : false;
          variables.comments.visibility =
                            comments.data.length === 0 ? false : true;
        }
      },
      get: function(page) {
        $http.get('/comments/comments/index/' +
                  variables.comments.plugin_key + '/' +
                  variables.comments.content_key + '/' +
                  'page:' + page + '.json', {cache: false})
            .success(function(data) {
              var comments = data.results.comments;
              variables.comments.current = comments.current;
              variables.comments.hasPrev = comments.hasPrev;
              variables.comments.hasNext = comments.hasNext;
              if (page === 1 &&
                      comments.limit > variables.comments.data.length) {
                variables.comments.data = comments.data;
              } else {
                variables.comments.data =
                    variables.comments.data.concat(comments.data);
              }
            })
            .error(function(data) {
              NetCommonsFlash.danger(data.name);
            });
      },
      input: {
        placeholder: function() {
          if (variables.currentStatus === NetCommonsBase.STATUS_APPROVED) {
            return variables.scope.messages.workflow_placeholder +
                          variables.scope.messages.workflow_placeholder_approved;
          } else {
            return variables.scope.messages.workflow_placeholder;
          }
        },
        invalid: function() {
          if (variables.form['comment']['$viewValue']) {
            variables.form['comment'].$setValidity(NetCommonsBase.VALIDATE_KEY, true);
          } else {
            variables.form['comment'].$setValidity(NetCommonsBase.VALIDATE_KEY, false);
          }
          return variables.form['comment'].$invalid;
        },
        hasErrorTarget: function() {
          if (variables.currentStatus === variables.editStatus ||
              variables.editStatus !== NetCommonsBase.STATUS_DISAPPROVED) {
            return false;
          } else {
            return true;
          }
        },
        class: function() {
          if (! variables.input.hasErrorTarget()) {
            return '';
          } else {
            return (variables.input.invalid() ?
                    'has-error' : 'has-success');
          }
        },
        required: function() {
          return (variables.editStatus === NetCommonsBase.STATUS_DISAPPROVED);
        },
        glyphicon: function() {
          if (! variables.input.hasErrorTarget()) {
            return '';
          } else {
            return (variables.input.invalid() ?
                    'glyphicon glyphicon-remove' : 'glyphicon glyphicon-ok');
          }
        },
        showMessage: function() {
          return (variables.input.hasErrorTarget() && variables.input.invalid());
        }
      }
    };

    return functions.new({});
  }]);

