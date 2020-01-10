/**
 * Controller for the Login screen
 * @author Pablo Sanchez
 */
(function (angular, undefined) {
    'use strict';

    angular.module("app").controller(
        'app.loginController',
        [
            '$rootScope', '$scope', '$state', '$http', '$cookies', 'crAcl',
            function ($rootScope, $scope, $state, $http, $cookies, crAcl) {

                var backendUrl = config.backend + 'login/';

                $scope.formData = {
                    login: '',
                    password: ''
                }

                $scope.doEnter = function (keyEvent) {
                    if (keyEvent.which === 13) {
                        $scope.login();
                    }
                }

                var validate = function () {
                    var errors = 0;

                    if ($scope.formData.login.trim() == '') {
                        $rootScope.toastr.error('You must inform your username');
                        errors++;
                    }

                    if ($scope.formData.password.trim() == '') {
                        $rootScope.toastr.error('You must inform your password');
                        errors++;
                    }

                    return (errors == 0);
                }

                $scope.login = function () {
                    if (validate()) {
                        $http(
                            {
                                method: 'post',
                                url: backendUrl,
                                withCredentials: true,
                                data: $scope.formData
                            }
                        ).then(function (response) {

                                /**
                                 * Set Current Role
                                 */
                                crAcl.setRole("ROLE_ADMIN");

                                window.localStorage.setItem('_____sesstkn', response.data.token.access_token);

                                /**
                                 * Redirect to last accessed page
                                 */
                                var stateName =
                                    (crAcl.getFromState() === undefined || (crAcl.getFromState() == null)) ?
                                        'main' : crAcl.getFromState().name;
                                var params = (crAcl.getFromParams() === undefined) ? [] : crAcl.getFromParams();
                                $state.go(stateName, params);
                                crAcl.resetFromState();

                                $rootScope.toastr.success('Login successful');
                            }, function (data) {
                                $rootScope.toastr.error('Login failed: check your credentials');
                            }
                        );
                    }
                }
            }
        ]
    );
})(angular);
