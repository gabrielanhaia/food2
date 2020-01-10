/**
 * Lazy Load Modular Application Core
 * @author Pablo Sanchez
 */

/**
 * Setups constants for the application - BASE_URL, MODULES_PATH, etc
 */
const BASE_URL = document.currentScript.src.replace("app.js", "");
const MODULES_FILE = BASE_URL + "modules.js";

(function (angular, undefined) {
    "use strict";

    // toastr.options = {
    //     closeButton: true,
    //     progressBar: true,
    //     showMethod: 'slideDown',
    //     timeOut: 4000
    // };
    //
    // toastr.success('Responsive Admin Theme', 'Welcome to INSPINIA');

    /**
     * SystemJS setup
     */
    SystemJS.config({
        baseURL: BASE_URL
    });

    /**
     * AngularJS Application configured to work with a modular approach
     *
     * @type {angular.Module}
     */
    angular.module("app", [
        "ngSanitize",
        "ngAnimate",
        "ngResource",
        "oc.lazyLoad",
        "ui.router",
        "cr.acl",
        'datatables',
    ]).controller(
        "app.appController",
        ["$rootScope", "$scope", "$state", "$location", "$document", "$window", "crAcl", "$cookies",
            function ($rootScope, $scope, $state, $location, $document, $window, crAcl, $cookies) {

                toastr.options = {
                    closeButton: true,
                    progressBar: true,
                    showMethod: 'slideDown',
                    timeOut: 5000
                };

                $rootScope.toastr = toastr;

                /**
                 * Configuration
                 */
                $rootScope.baseUrl = BASE_URL;
                if (config.env == "dev") {
                    console.log(config);
                }

                /**
                 * Menu
                 * @type {Array}
                 */
                $rootScope.menu = [];

                /**
                 * Translation strings
                 */
                $rootScope.translations = [];

                /**
                 * Get current language in use
                 */
                $rootScope.getLanguage = function () {
                    if ($cookies.get('language') === undefined) {
                        return "en";
                    }
                    return $cookies.get('language');
                };

                /**
                 * Set Current Language
                 * @param string role
                 */
                $rootScope.setLanguage = function (language) {
                    $cookies.put('language', language);
                };

                /**
                 * Visual helper based on the theme for max height inside portlets
                 * @returns {number}
                 */
                $rootScope.maxContentHeight = function () {
                    var height = "innerHeight" in window
                        ? window.innerHeight
                        : document.documentElement.offsetHeight;

                    return height - 350;
                }

                /**
                 * Max height for datatables
                 * @returns {number}
                 */
                $rootScope.maxDataTableScrollY = function () {
                    return ($rootScope.maxContentHeight() - 148);
                }

                /**
                 *  getNestedStateUrl
                 */
                $rootScope.getNestedStateUrl = function (state) {
                    var url = state.url;
                    if (state.parent) {
                        var parentState = $state.get(state.parent);
                        url = $rootScope.getNestedStateUrl(parentState) + url;
                    }
                    return url;
                }

                /**
                 * ACL for the routes and menu construction
                 */
                SystemJS.import(BASE_URL + "acl.js").then(function (acl) {
                    crAcl.setInheritanceRoles(acl);
                });

                /**
                 * System main menu
                 */
                SystemJS.import(BASE_URL + "menu.js").then(function (menu) {
                    $rootScope.menu[menu.index] = menu;
                })

                /**
                 * Default skeleton routes
                 */
                SystemJS.import(BASE_URL + "routes.js");

                /**
                 * Module translations according to config definition
                 */
                angular.forEach(config.languages, function (value, key) {
                    if (angular.isUndefined($rootScope.translations[value])) {
                        $rootScope.translations[value] = [];
                    }
                    SystemJS.import(BASE_URL + "resources/translations/" + value + ".js").then(function (trans) {
                            $rootScope.translations[value] = $rootScope.translations[value].concat(trans);
                        }
                    );
                });

                /**
                 * Convert CSV to JSON
                 */
                $rootScope.csvToJson = function (csv) {
                    var lines = csv.split("\n");
                    var result = [];
                    var headers = lines[0].split(",");
                    for (var i = 1; i < lines.length; i++) {
                        var obj = {};
                        var currentline = lines[i].split(",");
                        for (var j = 0; j < headers.length; j++) {
                            obj[headers[j]] = currentline[j];
                        }
                        result.push(obj);
                    }
                    return JSON.stringify(result);
                }

                /**
                 * Modules load and register (configs, routes, menus, etc)
                 */
                $rootScope.loadModules = function () {

                    SystemJS.import(MODULES_FILE).then(function (modules) {
                        var totalMods = Object.keys(modules).length
                        var counterMods = 0;
                        angular.forEach(modules, function (modulePath, moduleName) {
                            modulePath = BASE_URL + modulePath;
                            /**
                             * Module import
                             */
                            SystemJS.import(modulePath + "/module.js").then(function (module) {
                                /**
                                 * Expose the application state provider to permit modules to register routes dynamically
                                 * For some reason, this is the only way that worked with the lazy load approach used
                                 * @type {*}
                                 */
                                angular.module(moduleName).registerState = angular.module("app").registerState;
                                /**
                                 * Module config
                                 */
                                SystemJS.import(modulePath + "/config.js");
                                /**
                                 * Module translations according to config definition
                                 */
                                angular.forEach(config.languages, function (value, key) {
                                    if (angular.isUndefined($rootScope.translations[value])) {
                                        $rootScope.translations[value] = [];
                                    }
                                    SystemJS.import(modulePath + "/resources/translations/" + value + ".js").then(function (trans) {
                                            $rootScope.translations[value] = $rootScope.translations[value].concat(trans);
                                        }
                                    );
                                })

                                /**
                                 * Module routes registered to app
                                 */
                                SystemJS.import(modulePath + "/routes.js");
                                /**
                                 * Module Menu
                                 */
                                SystemJS.import(modulePath + "/menu.js").then(function (menu) {
                                    /**
                                     * Avoid overwriting or the require to reindex everything if you added
                                     * something manually
                                     */
                                    while ($rootScope.menu[menu.index]) {
                                        menu.index++;
                                    }
                                    /**
                                     * Set menu
                                     */
                                    $rootScope.menu[menu.index] = menu;
                                    counterMods++;
                                    /**
                                     * Broadcast that all modules have been registered for lazy processing
                                     */
                                    if (totalMods == counterMods) {
                                        $rootScope.$broadcast('modulesRegistered');
                                    }
                                });

                                if (config.env == "dev") {
                                    console.info("app.moduleRegistered " + angular.module(moduleName).name);
                                }
                            });
                        });
                    });
                }

                $rootScope.loadModules();
            }]
    );

    angular.module("app").factory(
        'httpRequestInterceptor',
        [
            '$injector',
            function ($injector) {
                return {
                    request: function (config) {
                        var sestkn = window.localStorage.getItem('_____sesstkn');
                        if (sestkn && sestkn !== null) {
                            config.headers.Authorization  = 'Bearer ' + sestkn;
                        }
                        return config;
                    }
                };
            }
        ]
    );

    angular.module("app").factory(
        'httpResponseInterceptor',
        ['$q', '$injector',
            function ($q, $injector) {
                return {
                    response: function (response) {
                        return response;
                    },
                    responseError: function (response) {
                        //avoiding circular dependency
                        var $state = $injector.get('$state');
                        switch (response.status) {
                            case 401:
                                console.log('Got 401 from some request');
                                $state.go('unauthorized');
                                break;
                            case 403:
                                console.log('Got 403 from some request');
                                $state.go('forbidden');
                                break;
                            case 404:
                                console.log('Got 404 from some request');
                                $state.go('notFound');
                                break;
                        }
                        return $q.reject(response);
                    }
                };
            }
        ]
    );

    /**
     * Sets up the Controller Provider and Route Provider to be used globally
     */
    angular.module("app").config(
        ["$stateProvider", "$ocLazyLoadProvider", "$httpProvider", "$locationProvider",
            "$sceProvider",
            function ($stateProvider, $ocLazyLoadProvider, $httpProvider, $locationProvider,
                      $sceProvider) {
                $locationProvider.html5Mode(true);
                $locationProvider.hashPrefix('!');
                $sceProvider.enabled(false);

                $httpProvider.interceptors.push('httpRequestInterceptor');
                $httpProvider.interceptors.push('httpResponseInterceptor');

                /**
                 * Expose the application state provider to permit modules to register routes dynamically
                 * So far this exposure was the only way to make it work with the module lazy load.
                 */
                angular.module("app").registerState = $stateProvider;

                /**
                 * Setup ocLazyLoader to broadcast lazyloading on dev mode
                 */
                $ocLazyLoadProvider.config({
                    debug: (config.env === 'dev'),
                    events: true
                });
            }
        ]);


    /**
     * Block screen while loading
     */
    angular.module("app").run(
        [
            "$document", "$rootScope", "$location", "$urlMatcherFactory", "$state",
            function ($document, $rootScope, $location, $urlMatcherFactory, $state) {

                /**
                 * Loading page blocker listener setup
                 */
                $rootScope.loading = false;
                $rootScope.$on("$stateChangeStart", function (event, route) {
                    $rootScope.loading = true;
                });

                function stateChangeEnd() {
                    if ($rootScope.loading) {
                        $rootScope.loading = false;
                    }
                    $rootScope.stateName;
                }

                $rootScope.$on("$stateChangeSuccess", stateChangeEnd);
                $rootScope.$on("$stateChangeError", stateChangeEnd);

                if (config.dev == "dev") {
                    $rootScope.$on("$stateChangeError", function (event, newRoute, last, error) {
                        console.warn("System.Router: fail to load route: %o", error);
                    });
                }

                /**
                 * Fix lazy load for routes and redirects to the correct route when loaded
                 */
                $rootScope.$on("modulesRegistered", (function () {

                    $urlMatcherFactory.strictMode(false);
                    var search = $location.search();
                    var path = $location.path();

                    /**
                     * Path should always redirect to something, at least '/'
                     * @type {string}
                     */
                    path = path ? path : config.defaultStatePath;
                    /**
                     * Forces all paths to end on / (remember this when declaring routes!)
                     */
                    if (!path.endsWith('/')) {
                        path = path + '/';
                    }

                    var stateParams = [];
                    var found = false;
                    var foundState;
                    var foundStateParams;

                    angular.forEach($state.get(), function (state) {
                        var nestedStateUrl = $rootScope.getNestedStateUrl(state);
                        var urlMatcher = $urlMatcherFactory.compile(nestedStateUrl);

                        stateParams = urlMatcher.exec(path, search);

                        if (stateParams && state.url !== "") {
                            if (path.slice(-1) === "/") {
                                if ($location.path() !== "/") {
                                    $rootScope.redirect = true;
                                } else {
                                    $rootScope.redirect = false;
                                }
                            } else {
                                $rootScope.redirect = false;
                            }
                            found = true;
                            foundState = state;
                            foundStateParams = stateParams;

                            if (config.env === 'local') {
                                console.info('App.bootRedirection: ' + path
                                    + " matches route regexp: "
                                    + nestedStateUrl
                                    + " state name " + state.name
                                );
                            }
                        }
                    });

                    /**
                     * Force loading only the current language
                     */
                    if (search.lang !== undefined || search.language !== undefined) {
                        var lang = search.lang ? search.lang : search.language;
                        $rootScope.setLanguage(lang);
                    }

                    if (found) {
                        $state.go(foundState, foundStateParams, {reload: true});
                    } else if (!found) {
                        console.error("NOT FOUND!!! >>>> " + path);
                        $state.go('notFound');
                    }
                }));
            }
        ]
    );
})(angular);
