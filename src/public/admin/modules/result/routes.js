(function (angular, undefined) {
    "use strict";

    const MOD_PATH = BASE_URL + "modules/result";

    angular.module("result").registerState
        .state("result", {
            breadCrumbName: "result",
            parent: "main",
            url: "/result",
            templateUrl: MOD_PATH + "/components/templates/default/index.html",
            controller: "result.defaultController",
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
