'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('MainCtrl', function ($scope, $location, localStorageService, vehicle) {
    

    //Get user login status
  	$scope.loggedIn = localStorageService.get('loggedIn') || false;

  	if(!$scope.loggedIn) {
    	$location.path('/signin').replace(); //Redirect user to home page if logged in
  	}
  	else {
  		
	    $scope.vehicle = {
	    	registrationNo : null,
	    	country : '',
	    	details : null,
	    	showtable : false,
	      	searching : false,
	      	nodata : false,
	      	usertype : localStorageService.get('usertype')
	    };

	    //Function to retrieve vehilce information from backend
		$scope.retrieveVehicleInfo = function() {

		  $scope.vehicle.searching = true;
		  $scope.vehicle.showtable = false;
		  var regno = encodeURIComponent($scope.vehicle.registrationNo);
		  vehicle.getDetails(regno, $scope.vehicle.country)
		    .then(function(success) {
			  console.dir(success);
			  $scope.vehicle.searching = false;
			  if(success.data) {
			  	$scope.vehicle.nodata = false;
			  	$scope.vehicle.showtable = true;
			  	$scope.vehicle.details = success.data;
			  }
			  else {
			  	$scope.vehicle.showtable = false;
			  	$scope.vehicle.nodata = true;
			  }
			}, function(error) {
			  console.error(error);
		  });
		};
	}

  });
