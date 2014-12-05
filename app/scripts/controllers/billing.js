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
  		var date = new Date();
		var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);

		var name = localStorageService.get('user') + ' ' + localStorageService.get('lastname');
  		
	    $scope.billing = {
	    	details : null,
	    	totalTransactions : 0,
	    	vat : 0.15,
	    	rate : 0,
	    	subTotal : 0,
	    	vatTotal : 0,
	    	grandTotal : 0,
	    	tenantAccount : localStorageService.get('tenantid'),
	    	tenantEmail : localStorageService.get('username'),
	    	date : lastDay,
	    	tenantName : name,
	    	processing : true,
	    	tablehead : true,
	    	showStatement : false,
	    	showPaymentMethod : false,
	    	cardname : null,
	    	cardno : null,
	    	expmth : null,
	    	expyr : null,
	    	cvc : null,
	    	cardprocessing : false,
	    	cardonfile : false
	    };

	    var usertype = localStorageService.get('usertype');
	    if(usertype === 'Dealer') {
	    	$scope.billing.rate = 0.99;
	    }
	    else if(usertype === 'Insurance') {
	    	$scope.billing.rate = 1.99;
	    }
	    else if(usertype === 'Security') {
	    	$scope.billing.rate = 2.99;
	    }
	    else {
	    	$scope.billing.rate = 0.49;
	    }

	    $scope.getBillingInformation = function() {
	    	billing.tenantBilling()
	    	  .then(function(success) {
		  		console.dir(success);
		  		$scope.billing.processing = false;
		  		if(success.data.bill === 0) {
		  			$scope.billing.tablehead = false;
		  		}
		  		else {
		  			$scope.billing.tablehead = true;
		  			$scope.billing.details = success.data.bill;
		  		}
		  		
		  		$scope.billing.totalTransactions = success.data.total;
		  		$scope.billing.subTotal = $scope.billing.totalTransactions * $scope.billing.rate;
		  		$scope.billing.vatTotal = $scope.billing.totalTransactions * $scope.billing.rate * $scope.billing.vat;
		  		$scope.billing.grandTotal = $scope.billing.vatTotal + $scope.billing.subTotal;
			}, function(error) {
		  		console.error(error);
		  		$scope.billing.processing = false;
	  		});
	    };

	    $scope.getBillingInformation();

	    $scope.showStatement = function() {
	    	$scope.billing.showStatement = true;
	    };

	    $scope.hideStatement = function() {
	    	$scope.billing.showStatement = false;
	    };

	    $scope.showPaymentMethod = function() {
	    	$scope.billing.showPaymentMethod = true;
	    };

	    $scope.closePaymentMethod = function() {
	    	$scope.billing.showPaymentMethod = false;
	    };

	    $scope.paymentDetails = function() {
	    	$scope.billing.cardprocessing = true;
	    	billing.cardStore($scope.billing.tenantAccount, $scope.billing.cardname, $scope.billing.cardno, $scope.billing.expmth, 
	    		$scope.billing.expyr, $scope.billing.cvc)
	    	  .then(function(success) {
	    	  	$scope.billing.cardprocessing = false;
		  		console.dir(success);
		  		if(success.data.response === true) {
		  			$scope.billing.showPaymentMethod = false;
		  			$scope.billing.cardonfile = true;
		  		}
			}, function(error) {
				$scope.billing.cardprocessing = false;
		  		console.error(error);
	  		});
	    	  $scope.billing.cardname = null;
	    	  $scope.billing.cardno = null;
	    	  $scope.billing.expmth = null;
	    	  $scope.billing.expyr = null;
	    	  $scope.billing.cvc = null;
	    };
	}

  });
