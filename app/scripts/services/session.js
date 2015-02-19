'use strict';

/**
 * @ngdoc service
 * @name myappApp.Session
 * @description
 * # Session
 * Service in the myappApp.
 */
angular.module('myappApp')
  .service('Session', function () {
    this.create = function (id, username) {
      this.id = id;
      this.username = username;
    };
    this.destroy = function () {
      this.id = null;
      this.username = null;
    };
    return this;
  });
