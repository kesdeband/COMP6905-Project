'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('MainCtrl', function ($scope, vehicle) {
    
    $scope.vehicle = {
    	registrationNo : null,
    	details : null,
    	showtable : false,
      	searching : false
    };

  	//Function to retrieve vehilce information from backend
	$scope.retrieveVehicleInfo = function(registrationNo) {

	  $scope.vehicle.searching = true;
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

  });
