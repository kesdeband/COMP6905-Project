'use strict';

/**
 * @ngdoc service
 * @name cloudApp.tenant
 * @description
 * # tenant
 * Factory in the cloudApp.
 */
angular.module('cloudApp')
  .factory('tenant', function ($http, $q, api) {
    // Service logic
    // ...

    var uri = api.url(); //get url from factory api

    var logIn = function(username, password) {
      var deferred = $q.defer();

      //console.debug(username+' '+password);

      $http.get(uri + '/tenants/account/', {
        params: {
          username : username,
          password : password
        }
      })
      .then(function (success) {
        console.dir(success);
        deferred.resolve(success);
      }, function(error) {
        console.dir(error);
        deferred.reject(error);
      });
      return deferred.promise;
    };

    // Public API here
    return {
      authenticate: function (username, password) {
        return logIn(username, password);
      }
    };
  });
