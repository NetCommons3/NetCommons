/**
 * @fileoverview Questionnaire Javascript
 * @author info@allcreator.net (Allcreator Co.)
 */
NetCommonsApp.directive('ncColorPalettePicker', [function() {
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
        '<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">' +
        '<span class="caret"></span></button>' +
        '<ul class="dropdown-menu nc-color-palette-dropdown pull-right">' +
        '<li>' +
        '<div ng-repeat="color in baseColors" class="nc-color-palette-bases" ' +
        'style="background-color:{{color}};" ng-click="pick(color)"></div>' +
        '<div ng-repeat="color in colors" class="nc-color-palette" ' +
        'style="background-color:{{color}};" ng-click="pick(color)"></div>' +
        '</li></ul></div></div>',
        link:  {
            pre: function(scope, element, attr) {
                var baseColors = [
                    '#f79e61', '#f25a62', '#50add6', '#4cccc6', '#63c97b', '#7c4f6c', '#9c9b7f', '#4d5361', '#464747', '#cccccc'
                ];
                var defaultColors = [
                  '#f4d7c3', '#f4ced3', '#c0e4ed', '#c2efe9', '#d1edd5', '#e3d1dc', '#e0e4cd', '#d4dbe8', '#898989', '#f4f4f4',
                  '#efb791', '#ee9da3', '#95cbdb', '#95dcd5', '#a3d9ad', '#b8a0b1', '#c0c2a9', '#9ca2ae', '#5e5e5e', '#d9d9d9',
                  '#ea9760', '#e86c74', '#69b1c9', '#68cac2', '#75c686', '#906f86', '#9fa086', '#636974', '#323232', '#bebebe',
                  '#e5772e', '#e23b44', '#3e98b7', '#3bb7ae', '#47b25e', '#683e5b', '#7f7e62', '#2b303a', '#070707', '#a3a3a3'
                ];
                if (scope.customizedColors) {
                    scope.baseColors = [];
                    scope.colors = scope.customizedColors || defaultColors;
                } else {
                    scope.baseColors = baseColors;
                    scope.colors = defaultColors;
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
    function($scope, $attrs) {
        $scope.colorValue = $attrs.colorValue;
    }
);