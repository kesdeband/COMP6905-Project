'use strict';

/**
 * @ngdoc service
 * @name cloudApp.tenant
 * @description
 * # tenant
 * Factory in the cloudApp.
 */
angular.module('cloudApp')
  .factory('tenant', function ($http, $q, localStorageService, api) {
    // Service logic
    // ...

    var uri = api.url(); //get url from factory api

    var signUp = function(fname, lname, username, password, country, industry, company) {
      var deferred = $q.defer();

      $http.post(uri + '/tenants/account/', {
        fname : fname,
        lname : lname,
        username : username,
        password : password,
        country: country,
        industry: industry,
        company: company
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

    var logOut = function() {
      var deferred = $q.defer();
      var token;

      //get current token from cookie
      token = retrieveToken();
      console.debug(token);

      $http.put(uri + '/tenants/account/', {
        token : token
      })
      .then(function(success) {
        console.dir(success);
        deferred.resolve(success);
      }, function(error) {
        console.dir(error);
          deferred.reject(error);
      });
      return deferred.promise;
    };

    var retrieveToken = function() {
      var token;

      if (localStorageService.get('token') !== false) {
        token = localStorageService.get('token');
      }
      return token;
    };

    // Public API here
    return {
      authenticate: function (username, password) {
        return logIn(username, password);
      },
      register: function (fname, lname, username, password, country, industry, company) {
        return signUp(fname, lname, username, password, country, industry, company);
      },
      logout: function() {
        return logOut();
      }
    };
  });
