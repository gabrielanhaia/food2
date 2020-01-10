/**
 * Modular menu display
 * @author Pablo Sanchez
 */
(function (angular, undefined) {
    'use strict';

    angular.module("xprSidebarSubmenu", [])
        .directive(
            'xprSidebarSubmenu',
            ['$rootScope', '$state', 'xprTrans',
                function ($rootScope, $state, xprTrans) {

                    return {
                        restrict: 'E',
                        replace: true,
                        scope: {
                            menu: '='
                        },
                        controllerAs: 'subMenu',
                        controller: [
                            '$state', '$rootScope', '$rootScope',
                            function ($state, $rootScope, $scope) {
                                this.getStateUrl = function (stateName) {
                                    return $rootScope.getNestedStateUrl($state.get(stateName));
                                }
                            }
                        ],
                        templateUrl: BASE_URL + 'components/templates/directives/xpr-sidebar-submenu.html'
                    }
                }]
        );
})(angular);
