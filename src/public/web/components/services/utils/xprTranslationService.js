/**
 * Service for translastions
 * @author Pablo Sanchez
 */

(function (angular, undefined) {
    "use strict";

    angular.module("xprTranslationService", [])
        .factory("xprTrans", ["$rootScope", function ($rootScope) {
            return function trans(what, params) {
                var language = $rootScope.getLanguage();
                for (var js_i in $rootScope.translations[language]) {
                    if ($rootScope.translations[language][js_i][what]) {
                        return $rootScope.translations[language][js_i][what];
                    }
                }
                return what;
            };
        }]).filter("xprTrans", ["xprTrans", function (trans) {
        return trans
    }]);

})(angular);