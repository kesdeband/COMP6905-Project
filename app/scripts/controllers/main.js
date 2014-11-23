'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('MainCtrl', function ($scope, $location, localStorageService, vehicle, tenant) {
    

    //Get user login status
  	$scope.loggedIn = localStorageService.get('loggedIn') || false;

  	if(!$scope.loggedIn) {
    	$location.path('/signin').replace(); //Redirect user to home page if logged in
  	}
  	else {
  		
	    $scope.vehicle = {
	    	registrationNo : null,
	    	details : null,
	    	showtable : false,
	      	searching : false
	    };

	    //Function to retrieve vehilce information from backend
		$scope.retrieveVehicleInfo = function(registrationNo) {

		  $scope.vehicle.searching = true;
		  $scope.vehicle.showtable = false;
		  var regno = encodeURIComponent(registrationNo);
		  vehicle.getDetails(regno)
		    .then(function(success) {
			  console.dir(success);
			  $scope.vehicle.searching = false;
			  $scope.vehicle.showtable = true;
			  $scope.vehicle.details = success.data;
			}, function(error) {
			  console.error(error);
		  });
		};

		//Logout user
		$scope.signOut = function () { //Logout
	      tenant.logout()
		    .then(function(success) {
			  console.dir(success.data.logout);
			  if(success.data.logout) {
			    localStorageService.clearAll();
				$location.path('/signin').replace();
			  }
			}, function(error) {
			  console.error(error);
		  });
	    };
	}

  });
