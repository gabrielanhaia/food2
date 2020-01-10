(function (angular, undefined) {
    "use strict";

    angular.module("result", []);
    angular.module("app").requires.push("result");
})(angular);
