/**
 * @fileoverview Workflow Javascript
 * @author nakajimashouhei@gmail.com (Shohei Nakajima)
 */


/**
 * NetCommonsWorkflow factory
 * 後で削除したい
 */
NetCommonsApp.factory(
    'NetCommonsWorkflow',
    ['$http', 'NetCommonsBase',
     function($http, NetCommonsBase) {

       /**
        * functions
        *
        * @type {Object.<function>}
        */
       var functions = {
         new: function(scope) {
           return angular.extend(functions);
         },
         more: function() {
           $('div.comment:hidden').removeClass('hidden');
           $('button.more').hide(0);
         }
       };

       return functions.new({});
     }]
);
