/**
 * User menu (profile, etc)
 * @author Pablo Sanchez
 */
(function (angular, undefined) {
    'use strict';

    angular.module("xprUserMenu", [])
        .directive(
            'xprUserMenu',
            function () {
                return {
                    templateUrl: BASE_URL + 'components/templates/directives/xpr-user-menu.html'
                }
            }
        );
})(angular);
