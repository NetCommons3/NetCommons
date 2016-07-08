/**
 * @fileoverview Questionnaire Javascript
 * @author info@allcreator.net (Allcreator Co.)
 */
NetCommonsApp.directive('ncColorPalettePicker', [
  'colorPaletteBaseColors', 'colorPaletteDefaultColors',
  function(colorPaletteBaseColors, colorPaletteDefaultColors) {
    return {
      scope: {
        colorValue: '@',
        customizedColors: '=colors',
        ngModel: '=',
        name: '@'
      },
      restrict: 'AE',
      transclude: true,
      template: '<div class="input-group">' +
          '<span class="input-group-btn">' +
          '<div class="input-group-addon nc-color-index" ' +
          'ng-attr-style="background-color:{{colorValue}};">&nbsp;</div>' +
          '</span>' +
          '<ng-transclude></ng-transclude>' +
          '<div class="input-group-btn">' +
          '<button type="button" ' +
          'class="btn btn-default dropdown-toggle" data-toggle="dropdown">' +
          '<span class="caret"></span></button>' +
          '<ul class="dropdown-menu nc-color-palette-dropdown pull-right">' +
          '<li>' +
          '<div ng-repeat="color in baseColors"' +
          ' class="nc-color-palette-bases" ' +
          'style="background-color:{{color}};" ng-click="pick(color)"></div>' +
          '<div ng-repeat="color in colors" class="nc-color-palette" ' +
          'style="background-color:{{color}};" ng-click="pick(color)"></div>' +
          '</li></ul></div></div>',
      link: {
        pre: function(scope, element, attr) {
          if (scope.customizedColors) {
            scope.baseColors = [];
            scope.colors = scope.customizedColors || colorPaletteDefaultColors;
          } else {
            scope.baseColors = colorPaletteBaseColors;
            scope.colors = colorPaletteDefaultColors;
          }
          scope.colorValue = scope.ngModel || scope.colorValue;
        },
        post: function(scope, element, attr) {
          scope.pick = function(color) {
            scope.colorValue = color;
            scope.ngModel = color;
            scope.$parent.colorValue = color;
          };
        }
      }
    };
  }]);


NetCommonsApp.controller('ncColorPalettePickerCtrl',
    ['$scope', '$attrs', function($scope, $attrs) {
      $scope.colorValue = $attrs.colorValue;
    }]
);
