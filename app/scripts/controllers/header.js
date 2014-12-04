'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:HeaderCtrl
 * @description
 * # HeaderCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('HeaderCtrl', function ($scope, $location, localStorageService, tenant) {
    
  	$scope.tenant = {
  		user : ''
  	};

  	//Check to see if user is logged in
  	$scope.loggedIn = localStorageService.get('loggedIn') || false;
	//console.debug($scope.loggedIn);

	if($scope.loggedIn) { //Yes, user is already logged in
	  $scope.tenant.user = localStorageService.get('user');
	}

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

  });
