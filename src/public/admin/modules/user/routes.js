(function (angular, undefined) {
    "use strict";

    const MOD_PATH = BASE_URL + "modules/user";

    angular.module("user").registerState
        .state("user", {
            breadCrumbName: "user",
            parent: "main",
            url: "/user",
            templateUrl: MOD_PATH + "/components/templates/default/index.html",
            controller: "user.defaultController",
            resolve: {
                lazyLoadRouteAssets: ["$ocLazyLoad", function ($ocLazyLoad) {
                    // you can lazy load files for an existing module
                    return $ocLazyLoad.load([
                        {type: "css", path: MOD_PATH + "/resources/css/module.css"},
                        {type: "js", path: MOD_PATH + "/components/controllers/defaultController.js"}
                    ]);
                }]
            }
        });
})(angular);
