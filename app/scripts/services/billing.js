'use strict';

/**
 * @ngdoc service
 * @name cloudApp.billing
 * @description
 * # billing
 * Factory in the cloudApp.
 */
angular.module('cloudApp')
  .factory('billing', function ($http, $q, localStorageService, api) {
    // Service logic
    // ...

    var uri = api.url(); //get url from factory api

    var updateTransaction = function(tenantid, orgid, email) {
      var deferred = $q.defer();

      $http.post(uri + '/billing/transaction/', {
        tenantid : tenantid,
        orgid : orgid,
        email : email
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

    var billingInformation = function() {
      var deferred = $q.defer();
      var email = retrieveUserName();
      var tenantid = retrieveTenantId();

      //console.debug(registrationNo);

      $http.get(uri + '/billing/transaction/', {
        params: {
          tenantid : tenantid,
          email : email
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

    var retrieveUserName = function() {
      var username;

      if (localStorageService.get('username') !== false) {
        username = localStorageService.get('username');
      }
      return username;
    };

    var retrieveTenantId = function() {
      var tenantid;

      if (localStorageService.get('tenantid') !== false) {
        tenantid = localStorageService.get('tenantid');
      }
      return tenantid;
    };

    // Public API here
    return {
      recordTransaction: function (tenantid, orgid, email) {
        return updateTransaction(tenantid, orgid, email);
      },
      tenantBilling: function () {
        return billingInformation();
      }
    };
  });
