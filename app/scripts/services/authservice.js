'use strict';

/**
 * @ngdoc service
 * @name myappApp.AuthService
 * @description
 * # AuthService
 * Service in the myappApp.
 */
angular.module('myappApp')
  .service('AuthService', function ($http, Session) {
    var login = function (credentials) {
      return $http
        .post('/login.do', credentials)
        .then(function (res) {
            Session.create(res.data.id, res.data.username);
            return res.data.username;
        });
    };
    var isAuthenticated = function () {
      return !!Session.id;
    };
    return {
      login: login,
      isAuthenticated: isAuthenticated
    };
  });
