'use strict';

/**
 * @ngdoc function
 * @name myappApp.controller:AppCtrl
 * @description
 * # AppCtrl
 * Controller of the myappApp
 */
angular.module('myappApp')
  .controller('AppCtrl', function ($scope, AuthService) {
    $scope.currentUser = null;
    $scope.isAuthenticated = AuthService.isAuthenticated;
    $scope.setErrorMessage = function (message) {
      $scope.errorMessage = message;
    };
    $scope.setCurrentUsername = function (username) {
      $scope.currentUsername = username;
    };
  });
