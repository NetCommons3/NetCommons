var NetCommonsApp = angular.module('NetCommonsApp',
    [
        'ui.bootstrap',
        'ui.tinymce'
    ]
);

NetCommonsApp.controller('NetCommons.base', function($scope) {
    //HTMLエディタの設定
    $scope.tinymceOptions = {
        mode : "exact",
        menubar: " ",
        plugins: "textcolor advlist autolink autoresize charmap code link ",
        toolbar: "undo redo  | forecolor | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link ",
    };
});