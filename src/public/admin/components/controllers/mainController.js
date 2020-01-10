/**
 * Controller for the main screen that has all other functions under it
 * @author Pablo Sanchez
 */
(function (angular, undefined) {
    'use strict';

    angular.module("app").controller(
        'app.mainController',
        [
            '$rootScope', '$scope', '$window', '$state', '$http', '$cookies', 'xprTrans', 'crAcl',
            function ($rootScope, $scope, $window, $state, $http, $cookies, xprTrans, crAcl) {

                var backendUrl = config.backend + 'logout/';

                /**
                 * Due the scope inheritance, all controllers will have access to the user data
                 */
                $scope.user = {
                    name: 'Username'
                };

                /**
                 * Get sidebar status
                 */
                $scope.getPageSidebarClosed = function () {
                    if ($cookies.get('pageSidebarClosed') === undefined) {
                        return false;
                    }
                    if ($cookies.get('pageSidebarClosed') === 'true' || $cookies.get('pageSidebarClosed') === true) {
                        return true;
                    }
                    return false;
                };

                /**
                 * Page menu flag
                 * @type {boolean}
                 */
                $scope.pageSidebarClosed = $scope.getPageSidebarClosed();

                $scope.toggleMenu = function () {
                    $scope.pageSidebarClosed = !$scope.pageSidebarClosed;
                    $cookies.put('pageSidebarClosed', $scope.pageSidebarClosed);

                    $("body").toggleClass("mini-navbar");
                    if ($scope.pageSidebarClosed) {
                        // Hide menu in order to smoothly turn on when maximize menu
                        $('#side-menu').hide();
                        // For smoothly turn on menu
                        setTimeout(
                            function () {
                                $('#side-menu').fadeIn(400);
                            }, 200);
                    } else {
                        $('#side-menu').hide();
                        setTimeout(
                            function () {
                                $('#side-menu').fadeIn(400);
                            }, 100);
                    }
                }

                if ($scope.pageSidebarClosed) {
                    $("body").toggleClass("mini-navbar");
                }

                /**
                 * Logout the current user
                 */
                $scope.logout = function () {
                    $http(
                        {
                            method: 'post',
                            url: backendUrl,
                            withCredentials: true,
                            headers: {
                                'X-XSRF-TOKEN': $cookies.get('XSRF-TOKEN')
                            },
                            data: $scope.formData
                        }
                    ).then(function (data) {
                            crAcl.setRole("ROLE_GUEST");
                            $state.go('loginPage');
                            $rootScope.toastr.success('Logout successful');
                        }, function (data) {
                            $rootScope.toastr.error('Logout failed: contact support immediately');
                        }
                    );
                }

                /**
                 * Control de Main Area minimum height
                 */
                $scope.mainMinHeight = function () {
                    var height = "innerHeight" in window
                        ? window.innerHeight
                        : document.documentElement.offsetHeight;

                    return {minHeight: (height) + 'px'};
                }
            }
        ]
    );
})(angular);
