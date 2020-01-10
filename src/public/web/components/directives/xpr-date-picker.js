/**
 * DatePicker
 * @author Pablo Sanchez
 */
(function (angular, undefined) {
    'use strict';

    angular.module("xprDatePicker", [])
        .directive("xprDatePicker", function () {
            return {
                restrict: "A",
                require: "ngModel",
                link: function (scope, element, attrs, ngModelController) {

                    scope.tempDt = null;

                    var options = {
                        changeMonth: true,
                        changeYear: true,
                        showOtherMonths: true,
                        selectOtherMonths: true,
                        format: config.dateFormat ? config.dateFormat: "dd/mm/yyyy",
                        onSelect: function (dateText) {
                            // console.log(dateText);
                            scope.$apply(function() {
                                ngModelController.$setViewValue(dateText);
                                onSelect(scope, {
                                    $value: ngModelController.$modelValue
                                });
                            });
                            element.trigger('blur');
                        }
                    };

                    function numOnKeyDown(keyCode) {
                        switch (keyCode) {
                            case 48:
                                return 0;
                            case 49:
                                return 1;
                            case 50:
                                return 2;
                            case 51:
                                return 3;
                            case 52:
                                return 4;
                            case 53:
                                return 5;
                            case 54:
                                return 6;
                            case 55:
                                return 7;
                            case 56:
                                return 8;
                            case 57:
                                return 9;
                            case 96:
                                return 0;
                            case 97:
                                return 1;
                            case 98:
                                return 2;
                            case 99:
                                return 3;
                            case 100:
                                return 4;
                            case 101:
                                return 5;
                            case 102:
                                return 6;
                            case 103:
                                return 7;
                            case 104:
                                return 8;
                            case 105:
                                return 9;
                        }
                    }


                    function validDatesOnly(e) {
                        var key = e.keyCode;
                        if (key == 8 ||
                            key == 9 ||
                            key == 46 ||
                            (key >= 35 && key <= 40)
                        ) {
                            return true;
                        }
                        var currNumber = numOnKeyDown(key);

                        if (isNaN(currNumber)) {
                            e.preventDefault();
                            return false;
                        }

                        var date = ($(this).val().replace(/_/g, '')).split('/');
                        var day = date[0];
                        var month = date[1];
                        var year = date[2];

                        if (((day + '').length) < 2) {
                            day = parseInt(day + '' + currNumber);
                        }

                        if (((month + '').length) < 2) {
                            month = parseInt(month + '' + currNumber);
                        }

                        if (((year + '').length) < 4) {
                            year = parseInt(year + '' + currNumber);
                        }

                        if (isNaN(day) || day > 31) {
                            e.preventDefault();
                        }
                        ;
                        if (isNaN(month) || month > 12) {
                            e.preventDefault();
                        }
                        ;
                        if (!isNaN(month) && (month == 4 || month == 6 || month == 9 || month == 11) && day == 31) {
                            e.preventDefault();
                        }
                        if (!isNaN(month) && month == 2 && (day > 29 || ( !isNaN(year) && (year + '').length == 4 && (day == 29 && year % 4 != 0)))) {
                            e.preventDefault();
                        }
                        ;
                        if (date[0] + '' + currNumber == '00' || date[1] + '' + currNumber == '00') {
                            e.preventDefault();
                        }

                    }

                    element.keydown(validDatesOnly)

                    //Aplica a máscara do jquery masked input
                    element.mask('99/99/9999');

                    //Corrige o problema entre o masked input e ngModel
                    // element.bind('keyup', function() {
                    //     var strDate = datepickerParser(element.val());
                    //     var timestamp = Date.parse(strDate);
                    //     if (isNaN(timestamp) === false) {
                    //         scope.tempDt = new Date(timestamp);
                    //     } else {
                    //         scope.tempDt = null;
                    //     }
                    // });

                    element.on('change', function () {
                        $(this).datepicker('hide');
                    });

                    element.datepicker(options);

                }
            }
        });
})(angular);