'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:BillingCtrl
 * @description
 * # BillingCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('BillingCtrl', function ($scope, $location, localStorageService, billing) {
    
  	//Get user login status
  	$scope.loggedIn = localStorageService.get('loggedIn') || false;

  	if(!$scope.loggedIn) {
    	$location.path('/signin').replace(); //Redirect user to home page if logged in
  	}
  	else {
  		
	    $scope.billing = {
	    	details : null,
	    	totalTransactions : 0,
	    	processing : true
	    };

	    //$scope.getBillingInformation = function() {
	    	billing.tenantBilling()
	    	  .then(function(success) {
		  		console.dir(success);
		  		$scope.billing.processing = false;
		  		$scope.billing.details = success.data.bill;
		  		$scope.billing.totalTransactions = success.data.total;
			}, function(error) {
		  		console.error(error);
		  		$scope.billing.processing = false;
	  		});
	    //};

	    //$scope.getBillingInformation();
	}

  });
