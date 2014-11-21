'use strict';

/**
 * @ngdoc service
 * @name cloudApp.vehicle
 * @description
 * # vehicle
 * Factory in the cloudApp.
 */
angular.module('cloudApp')
  .factory('vehicle', function ($http, $q, api) {
    // Service logic
    // ...

    var uri = api.url(); //get url from factory api

    var vehicleInformation = function(registrationNo) {
      var deferred = $q.defer();

      //console.debug(registrationNo);

      $http.get(uri + '/vehicle/details/', {
        params: {
          regno : registrationNo
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
      getDetails: function (registrationNo) {
        return vehicleInformation(registrationNo);
      }
    };
  });
