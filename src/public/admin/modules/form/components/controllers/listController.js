/**
 * Controller for the Map on main screen
 *
 * Based on documentation found at http://l-lin.github.io/angular-datatables/archives/#/serverSideProcessing
 *
 * @author Pablo Sanchez
 */
(function (angular, undefined) {
    'use strict';

    angular.module("app").controller(
        'form.listController',
        [
            '$rootScope', '$scope', '$state', '$stateParams', 'xprTrans', 'DTOptionsBuilder', 'DTColumnBuilder', '$http', '$cookies', '$compile',
            function ($rootScope, $scope, $state, $stateParams, xprTrans, DTOptionsBuilder, DTColumnBuilder, $http, $cookies, $compile) {

                var vm = this;

                var backendUrl = config.backend + 'administration/form/';

                vm.dtOptions = DTOptionsBuilder

                /**
                 * jQuery way - work with server side paging
                 */
                    .newOptions()
                    .withOption("scrollY", $rootScope.maxDataTableScrollY())
                    .withOption("scrollX", true)
                    .withOption('serverSide', true)
                    .withOption('ajax', {
                        url: backendUrl,
                        type: 'POST',
                        "data": function (data) {
                            data.searchData = $("#searchForm").serializeArray()
                        },
                        //Those are the options that make the Cross site voodoo possible, headers and withCredentials
                        headers: {
                            'X-XSRF-TOKEN': $cookies.get('XSRF-TOKEN')
                        },
                        xhrFields: {
                            withCredentials: true
                        },
                    })
                    .withDataProp('data')
                    .withOption('processing', true)
                    .withOption('bFilter', false)
                    .withPaginationType('full_numbers')
                    .withOption('createdRow', function (row, data, dataIndex) {
                        $compile(angular.element(row).contents())($scope);
                    })

                $scope.edit = function (id) {
                    if (config.env == 'dev') {
                        console.log('Editing ' + id);
                    }
                    $state.go($state.get('edit-form'), {id: id}, {reload: true});
                };
                $scope.delete = function (id) {
                    if (config.env == 'dev') {
                        console.log('Deleting' + id);
                    }
                    if (confirm('Are you sure you wish to remove this form?')) {
                        return $http(
                            {
                                method: 'delete',
                                url: backendUrl + id,
                                withCredentials: true,
                                headers: {
                                    'X-XSRF-TOKEN': $cookies.get('XSRF-TOKEN')
                                },
                            }
                        ).then(function () {
                            alert('Form successfully deleted');
                        });
                    }
                };

                vm.dtColumns = [
                    DTColumnBuilder.newColumn('name').withTitle(xprTrans('Form name')),
                    DTColumnBuilder.newColumn('description').withTitle(xprTrans('Description')),
                    DTColumnBuilder.newColumn('start_publish').withTitle(xprTrans('Start date')),
                    DTColumnBuilder.newColumn('updated_at').withTitle(xprTrans('End date')),
                    DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
                        .renderWith(function (data, type, full, meta) {
                            return '<button class="btn btn-primary" ng-click="edit(' + data.id + ')">' +
                                '   <i class="fa fa-edit"></i>' +
                                '</button>&nbsp;' +
                                '<button class="btn btn-danger" ng-click="delete(' + data.id + ')">' +
                                '   <i class="fa fa-trash-o"></i>' +
                                '</button>';
                        })
                ];
            }
        ]
    );
})(angular);
