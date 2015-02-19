'use strict';

/**
 * @ngdoc function
 * @name myappApp.controller:LoginCtrl
 * @description
 * # LoginCtrl
 * Controller of the myappApp
 */
angular.module('myappApp')
  .controller('LoginCtrl', function ($scope, $location, AuthService) {
    $scope.credentials = {
      username: '',
      password: ''
    };
    $scope.login = function (credentials) {
      AuthService.login(credentials).then(function (username) {
        $scope.setErrorMessage(null);
        $scope.setCurrentUsername(username);
        $location.path('/');
      }, function (response) {
        $scope.setErrorMessage(response.data.error.message);
      });
    };
  });
