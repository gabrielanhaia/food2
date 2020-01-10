/**
 * State based breadcrumbs.
 * @author Pablo Sanchez
 */
(function (angular, undefined) {
    'use strict';

    angular.module("xprBreadcrumb", [])
        .directive(
            'xprBreadcrumb',
            ['$rootScope', '$state',
                function ($rootScope, $state) {

                    $rootScope.breadCrumbs = '';

                    function buildCrumb(isParent) {
                        $rootScope.breadCrumbs = recursiveBuild($state.current, false);
                    }

                    function recursiveBuild(state, isParent) {
                        var breadCrumbs = '';

                        if (state.breadCrumbName) {
                            breadCrumbs += '<li>';
                            if (!state.parent) {
                                breadCrumbs += '<i class="icon-home"></i> ';
                            }
                            breadCrumbs += '<a href="#!' + $rootScope.getNestedStateUrl(state) + '">'
                                + state.breadCrumbName + '</a>';
                            breadCrumbs += '</li>';
                        }

                        if (state.parent) {
                            breadCrumbs = recursiveBuild($state.get(state.parent), (true && state.breadCrumbName)) + breadCrumbs;
                        }

                        return breadCrumbs;
                    }


                    $rootScope.$on("$viewContentLoaded", buildCrumb);

                    return {
                        templateUrl: BASE_URL + 'components/templates/directives/xpr-bread-crumbs.html',
                    }
                }]);
})(angular);
