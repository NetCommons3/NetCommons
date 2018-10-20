/**
 * @fileoverview Questionnaire Javascript
 * @author info@allcreator.net (Allcreator Co.)
 */
NetCommonsApp.directive('ncTitleIconPicker', ['TITLE_ICON_URL', function(TITLE_ICON_URL) {
  return {
    scope: {
      titleIcon: '@',
      icons: '=icons',
      ngModel: '=',
      name: '@'
    },
    restrict: 'AE',
    transclude: true,
    template: '' +
        '<button type="button" ' +
        'class="btn btn-default dropdown-toggle nc-title-icon-btn" ' +
        'data-toggle="dropdown">' +
        '<span class="nc-title-icon-index">' +
        '<img ng-src="{{image(titleIcon)}}" class="nc-title-icon" />' +
        '</span>' +
        '</button>' +
        '<ul class="dropdown-menu nc-title-icon-dropdown pull-right">' +
        '<li>' +
        '<div ng-repeat="icon in icons" class="nc-icon-palette">' +
        '<img ng-src="{{image(icon.path)}}" alt="{{icon.alt}}" title="{{icon.alt}}" ' +
        ' class="nc-title-icon" ng-click="pick(icon.path)" />' +
        '</div>' +
        '</li></ul><ng-transclude></ng-transclude>',
    link: {
      pre: function(scope, element, attr) {
        scope.titeIcon = scope.ngModel || scope.titleIcon;
      },
      post: function(scope, element, attr) {
        scope.image = function(icon) {
          if (icon) {
            return TITLE_ICON_URL + icon;
          } else {
            return '';
          }
        };
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
    ['$scope', '$attrs', function($scope, $attrs) {
      $scope.titleIcon = $attrs.titleIcon;
    }]
);
