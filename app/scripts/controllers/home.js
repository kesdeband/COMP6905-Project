'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:HomeCtrl
 * @description
 * # HomeCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('HomeCtrl', function ($scope, $location, localStorageService) {
    
  	//Get user login status
  	$scope.loggedIn = localStorageService.get('loggedIn') || false;

  	if($scope.loggedIn) {
    	$location.path('/main').replace(); //Redirect user to main page if logged in
  	}

  });
