(function (angular, undefined) {
    "use strict";

    const MOD_PATH = BASE_URL + "modules/form";

    angular.module("form").registerState
        .state("form", {
            breadCrumbName: "Forms",
            parent: "main",
            url: "/form",
            templateUrl: MOD_PATH + "/components/templates/default/list.html",
            controller: "form.defaultController",
            resolve: {
                lazyLoadRouteAssets: ["$ocLazyLoad", function ($ocLazyLoad) {
                    // you can lazy load files for an existing module
                    return $ocLazyLoad.load([
                        {type: "css", path: MOD_PATH + "/resources/css/module.css"},
                        {type: "js", path: MOD_PATH + "/components/controllers/defaultController.js"},
                        {type: "js", path: MOD_PATH + "/components/controllers/listController.js"}
                    ]);
                }]
            }
        })
        .state("new-form", {
            breadCrumbName: "New form",
            parent: "main",
            url: "/form/new",
            templateUrl: MOD_PATH + "/components/templates/form/edit.html",
            controller: "form.formController",
            resolve: {
                formData: [ function () {
                    return {id:null};
                }],
                lazyLoadRouteAssets: ["$ocLazyLoad", function ($ocLazyLoad) {
                    // you can lazy load files for an existing module
                    return $ocLazyLoad.load([
                        {type: "js", path: MOD_PATH + "/components/controllers/formController.js"}
                    ]);
                }]
            }
        })
        .state("edit-form", {
            breadCrumbName: "Edit form",
            parent: "main",
            url: "/form/edit/:id",
            templateUrl: MOD_PATH + "/components/templates/form/edit.html",
            controller: "form.formController",
            resolve: {
                formData: ['$http', '$stateParams', function ($http, $stateParams) {
                    var backendUrl = config.backend + '/administration/form/' + $stateParams.id;
                    return $http.get(backendUrl)
                        .then(function (response) {
                                return eval(response.data);
                            }
                        );
                }],
                lazyLoadRouteAssets: ["$ocLazyLoad", function ($ocLazyLoad) {
                    // you can lazy load files for an existing module
                    return $ocLazyLoad.load([
                        {type: "js", path: MOD_PATH + "/components/controllers/formController.js"}
                    ]);
                }]
            }
        });
})(angular);
