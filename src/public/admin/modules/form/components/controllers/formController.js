(function (angular, undefined) {
    "use strict";

    angular.module("form").controller(
        "form.formController",
        [
            "$rootScope", "$scope", "$state", "$window", "$http", "$cookies", "formData",
            function ($rootScope, $scope, $state, $window, $http, $cookies, formData) {

                var backendUrl = config.backend + 'administration/form/';

                $scope.formData = formData;

                $scope.deleted = {
                    'questions': [],
                    'answers': [],
                }

                var questionModel = {
                    id: null,
                    form_id: $scope.formData.id,
                    description: '',
                    mandatory: 0,
                    type: 'text',
                    answers: []
                };

                var answerModel = {
                    id: null,
                    valid_value: null
                };

                $scope.questionTypes = [
                    'text',
                    'date',
                    'number',
                    'radio',
                    'dropdown'
                ];

                $scope.booleanType = [0, 1];

                $scope.boolToStr = function (arg) {
                    return arg ? 'Yes' : 'No'
                }

                $scope.capitalize = function (input) {
                    return (!!input) ? input.charAt(0).toUpperCase() + input.substr(1).toLowerCase() : '';
                }

                $scope.addQuestion = function () {
                    if ($scope.formData.questions === undefined) {
                        $scope.formData.questions = [];
                    }
                    $scope.formData.questions.push(angular.copy(questionModel));
                }

                $scope.delQuestion = function (question) {
                    if (confirm('Are you sure you wish to remove this question?')) {
                        for (var js_i in $scope.formData.questions) {
                            if ($scope.formData.questions[js_i] == question) {
                                if (question.id) {
                                    $scope.deleted.questions.push(question.id);
                                }
                                $scope.formData.questions.splice(js_i, 1);
                            }
                        }
                    }
                }

                $scope.addAnswer = function (question) {
                    if (question.answers === undefined) {
                        question.answers = [];
                    }
                    question.answers.push(angular.copy(answerModel));
                }

                $scope.delAnswer = function (question, answer) {
                    if (confirm('Are you sure you wish to remove this answer?')) {
                        for (var js_i in question.answers) {
                            if (question.answers[js_i] == answer) {
                                if (answer.id) {
                                    $scope.deleted.answers.push(answer.id);
                                }
                                question.answers.splice(js_i, 1);
                            }
                        }
                    }
                }

                $scope.cancel = function () {
                    $state.go($state.get('form'), null, {reload: true});
                }

                var prepareDataToSubmit = function () {
                    /**
                     * Ugly way - for some reason, datepicker is not formating the javascript Date object
                     * @type {string}
                     */
                    $scope.formData.start_publish = $scope.formData.start_date.split('/').reverse().join('-');
                    $scope.formData.end_publish = $scope.formData.end_date.split('/').reverse().join('-');
                    $scope.formData.deleted = $scope.deleted;
                }

                $scope.save = function () {
                    prepareDataToSubmit()
                    if ($scope.validate()) {
                        $http(
                            {
                                method: 'put',
                                url: backendUrl,
                                withCredentials: true,
                                headers: {
                                    'X-XSRF-TOKEN': $cookies.get('XSRF-TOKEN')
                                },
                                data: $scope.formData
                            }
                        ).then(function (data) {
                                $scope.formData = data.data;
                                $scope.deleted.questions = [];
                                $scope.deleted.answers = [];
                                processFormData();
                                $rootScope.toastr.success('Form successfully saved');
                                if (!$scope.formData.id) {
                                    $state.go($state.get('edit-form'), {id: data.data.id}, {reload: true});
                                }
                            }, function (data) {
                                $rootScope.toastr.error('Form could not be saved: ' + data.data);
                            }
                        );
                    }
                }

                $scope.validate = function () {
                    var errors = 0;

                    /**
                     * Require name
                     */
                    if ($scope.formData.name.trim() == "") {
                        $rootScope.toastr.error('Invalid form name');
                        errors++;
                    }

                    var date = new Date().toISOString().slice(0, 10);
                    if ($scope.formData.start_publish &&
                        parseInt($scope.formData.start_publish.replace(/\-/g, '')) < parseInt(date.replace(/\-/g, ''))) {
                        $rootScope.toastr.error('Start publishing date cannot be in the past');
                        errors++;
                    }

                    /**
                     * Compare start publishing and end dates
                     */
                    if ($scope.formData.end_publish &&
                        parseInt($scope.formData.end_publish.replace(/\-/g, '')) <= parseInt($scope.formData.start_publish.replace(/\-/g, ''))) {
                        $rootScope.toastr.error('Invalid publishing period');
                        errors++;
                    }

                    /**
                     * Require at least 1 question
                     */
                    if ($scope.formData.questions.length == 0) {
                        $rootScope.toastr.error('You need to add at least one question');
                        errors++;
                    }

                    /**
                     * Require filled answers for dropbox and radio
                     */
                    for (var q in $scope.formData.questions) {
                        if ($scope.formData.questions[q].description.trim() == '') {
                            $rootScope.toastr.error('You need to inform a description for Question #' + ( 1 + parseInt(q) ));
                            errors++;
                        }
                        if ($scope.formData.questions[q].type == 'radio' || $scope.formData.questions[q].type == 'dropbox') {
                            if ($scope.formData.questions[q].answers.length < 2) {
                                $rootScope.toastr.error('You need to add at least two answers for Question #' + ( 1 + parseInt(q) ));
                                errors++;
                            }
                        }
                    }

                    $scope.formData.questions

                    return (errors == 0);
                }

                /**
                 * Prepare form data for the editing
                 */
                function processFormData() {
                    $scope.formData.start_date = '';
                    $scope.formData.end_date = '';

                    if ($scope.formData.id === null) {
                        $scope.formData.name = "";
                        $scope.formData.description = "";
                        $scope.formData.introduction = "";
                        $scope.formData.questions = [];
                        $scope.formData.start_publish = ''
                        $scope.formData.end_publish = ''
                    }

                    /**
                     * Ugly way - for some reason, datepicker is not formating the javascript Date object
                     * @type {string}
                     */
                    if ($scope.formData.start_publish && $scope.formData.start_publish != '0000-00-00 00:00:00') {
                        $scope.formData.start_date = $scope.formData.start_publish.split(' ')[0].split('-').reverse().join('/');
                    } else {
                        $scope.formData.start_publish = '';
                    }

                    if ($scope.formData.end_publish && $scope.formData.end_publish != '0000-00-00 00:00:00') {
                        $scope.formData.end_date = $scope.formData.end_publish.split(' ')[0].split('-').reverse().join('/');
                    } else {
                        $scope.formData.end_publish = '';
                    }
                }

                processFormData();
            }
        ]
    );
})(angular);
