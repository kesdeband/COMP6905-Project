'use strict';

/**
 * @ngdoc service
 * @name cloudApp.api
 * @description
 * # api
 * Factory in the cloudApp.
 */
angular.module('cloudApp')
  .factory('api', function () {
    // Service logic
    // ...

    var api = 'http://localhost/cloud/server/index.php/api';
    //var api = 'http://vots.azurewebsites.net/server/index.php/api';

    // Public API here
    return {
      url: function () {
        return api;
      }
    };
  });
