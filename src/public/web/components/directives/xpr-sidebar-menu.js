/**
 * Modular menu display
 * @author Pablo Sanchez
 */
(function (angular, undefined) {
    'use strict';

    angular.module("xprSidebarMenu", [])
        .directive(
            'xprSidebarMenu',
            ['$rootScope', '$state', 'xprTrans',
                function ($rootScope, $state, xprTrans) {

                    $rootScope.getStateUrl = function(stateName) {
                        return $rootScope.getNestedStateUrl($state.get(stateName));
                    }

                    return {
                        templateUrl: BASE_URL + 'components/templates/directives/xpr-sidebar-menu.html'
                    }
                }]
        );
})(angular);
