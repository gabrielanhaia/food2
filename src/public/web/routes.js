/**
 * Base routes for the application (login, main page, and error pages)
 */
(function (angular, undefined) {
    "use strict";

    angular.module("app").registerState
        .state("loginPage", {
            url: '/',
            templateUrl: BASE_URL + 'components/templates/default/login.html',
            controller: 'app.loginController',
            resolve: {
                lazyLoadRouteAssets: ['$ocLazyLoad', function ($ocLazyLoad) {
                    // you can lazy load files for an existing module
                    return $ocLazyLoad.load([
                        //Core Services
                        {type: 'js', path: BASE_URL + 'components/services/utils/xprTranslationService.js'},
                        //Authentication Service and Authenticated User Provider
                        {type: 'js', path: BASE_URL + 'components/services/clients/authServiceClient.js'},
                        {type: 'js', path: BASE_URL + 'components/services/providers/authUserProvider.js'},
                        //Login Controller
                        {type: 'js', path: BASE_URL + 'components/controllers/loginController.js'},
                        //CSS
                        {type: 'css', path: BASE_URL + 'resources/css/login.css'},
                        //Directive
                        {type: 'js', path: BASE_URL + 'components/directives/xpr-date-picker.js'}
                    ]);
                }]
            }
        })
        .state("main", {
            breadCrumbName: "Home",
            url: '/main',
            templateUrl: BASE_URL + 'components/templates/main/main.html',
            controller: 'app.mainController',
            resolve: {
                lazyLoadRouteAssets: ['$ocLazyLoad', function ($ocLazyLoad) {
                    // you can lazy load files for an existing module
                    return $ocLazyLoad.load([
                        //Core Services
                        {type: 'js', path: BASE_URL + 'components/services/utils/xprTranslationService.js'},
                        //Authentication Service and Authenticated User Provider
                        {type: 'js', path: BASE_URL + 'components/services/clients/authServiceClient.js'},
                        {type: 'js', path: BASE_URL + 'components/services/providers/authUserProvider.js'},
                        //MainController
                        {type: 'js', path: BASE_URL + 'components/controllers/mainController.js'},
                        {type: 'js', path: BASE_URL + 'components/controllers/searchController.js'},
                        //Directives
                        {type: 'js', path: BASE_URL + 'components/directives/xpr-user-menu.js'},
                        {type: 'js', path: BASE_URL + 'components/directives/xpr-bread-crumbs.js'},
                        {type: 'js', path: BASE_URL + 'components/directives/xpr-sidebar-menu.js'},
                        {type: 'js', path: BASE_URL + 'components/directives/xpr-sidebar-submenu.js'},
                        {type: 'js', path: BASE_URL + 'components/directives/xpr-date-picker.js'}
                    ]);
                }]
            }
            ,data:{
                 is_granted: ["ROLE_USER"]
            }
        })
        .state("notFound", {
            breadCrumbName: "404 - Not found",
            url: "/404",
            templateUrl: BASE_URL + 'components/templates/default/404.html',
            resolve: {
                lazyLoadRouteAssets: ['$ocLazyLoad', function ($ocLazyLoad) {
                    // you can lazy load files for an existing module
                    return $ocLazyLoad.load([
                        {type: 'css', path: BASE_URL + 'resources/css/40x.css'}
                    ]);
                }]
            }
        })
        .state("forbidden", {
            breadCrumbName: "403 - Forbidden",
            url: "/403",
            templateUrl: BASE_URL + 'components/templates/default/403.html',
            resolve: {
                lazyLoadRouteAssets: ['$ocLazyLoad', function ($ocLazyLoad) {
                    // you can lazy load files for an existing module
                    return $ocLazyLoad.load([
                        {type: 'css', path: BASE_URL + 'resources/css/40x.css'}
                    ]);
                }]
            }
        })
        .state("unauthorized", {
            breadCrumbName: "401 - Unauthorized",
            url: "/401",
            templateUrl: BASE_URL + 'components/templates/default/401.html',
            resolve: {
                lazyLoadRouteAssets: ['$ocLazyLoad', function ($ocLazyLoad) {
                    // you can lazy load files for an existing module
                    return $ocLazyLoad.load([
                        {type: 'css', path: BASE_URL + 'resources/css/40x.css'}
                    ]);
                }]
            }
        });
})(angular);
