(function (angular, undefined) {
    "use strict";

    angular.module("user", []);
    angular.module("app").requires.push("user");
})(angular);
