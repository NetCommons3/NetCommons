/**
 * @fileoverview Questionnaire Javascript
 * @author info@allcreator.net (Allcreator Co.)
 */
NetCommonsApp.directive('ncTitleIconPicker', [function() {
  return {
    scope: {
      titleIcon: '@',
      icons: '=icons',
      ngModel: '=',
      name: '@'
    },
    restrict: 'AE',
    transclude: true,
    template: '<div class="input-group">' +
        '<span class="input-group-addon nc-title-icon-index">' +
        '<img src="{{titleIcon}}" class="nc-title-icon" />' +
        '</span>' +
        '<ng-transclude></ng-transclude>' +
        '<div class="input-group-btn">' +
        '<button type="button" ' +
        'class="btn btn-default dropdown-toggle" data-toggle="dropdown">' +
        '<span class="caret"></span></button>' +
        '<ul class="dropdown-menu nc-title-icon-dropdown pull-right">' +
        '<li>' +
        '<div ng-repeat="(icon, alt) in icons" class="nc-icon-palette">' +
        '<img src="{{icon}}" alt="{{alt}}" title="{{alt}}" ' +
        ' class="nc-title-icon" ng-click="pick(icon)" />' +
        '</div>' +
        '</li></ul></div></div>',
    link: {
      pre: function(scope, element, attr) {
        scope.titeIcon = scope.ngModel || scope.titleIcon;
      },
      post: function(scope, element, attr) {
        scope.pick = function(icon) {
          scope.titleIcon = icon;
          if (scope.ngModel) {
            scope.ngModel = icon;
          }
          scope.$parent.titleIcon = icon;
        };
      }
    }
  };
}]);
NetCommonsApp.controller('ncTitleIconPickerCtrl',
    function($scope, $attrs) {
      $scope.titleIcon = $attrs.titleIcon;
    }
);
