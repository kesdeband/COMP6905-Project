'use strict';

/**
 * @ngdoc service
 * @name cloudApp.vehicle
 * @description
 * # vehicle
 * Factory in the cloudApp.
 */
angular.module('cloudApp')
  .factory('vehicle', function ($http, $q, localStorageService, api) {
    // Service logic
    // ...

    var uri = api.url(); //get url from factory api

    var vehicleInformation = function(registrationNo, country) {
      var deferred = $q.defer();
      var usertype = retrieveUserType();

      //console.debug(registrationNo);

      $http.get(uri + '/vehicle/details/', {
        params: {
          regno : registrationNo,
          country : country,
          usertype : usertype
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

    var retrieveUserType = function() {
      var usertype;

      if (localStorageService.get('usertype') !== false) {
        usertype = localStorageService.get('usertype');
      }
      return usertype;
    };

    // Public API here
    return {
      getDetails: function (registrationNo, country, usertype) {
        return vehicleInformation(registrationNo, country, usertype);
      }
    };
  });
