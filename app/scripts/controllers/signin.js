'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:SigninCtrl
 * @description
 * # SigninCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('SigninCtrl', function ($scope, $location, $cookieStore, localStorageService, tenant) {
    
    //Get user login status
  	$scope.loggedIn = localStorageService.get('loggedIn') || false;

  	if($scope.loggedIn) {
    	$location.path('/main').replace(); //Redirect user to main page if logged in
  	}
  	else {
  		//Initialize scope variables
    	$scope.user = {
      		username : null,
      		password : null,
      		remember : false,
          processing : false
    	};
  	}

  	//Function to sign in
  	$scope.signIn = function() {
      $scope.user.processing = true;
  		tenant.authenticate($scope.user.username, $scope.user.password)
    	  .then(function(success) {
    	  	console.dir(success.data);
    	  	if(success.data.token !== -1 && success.data.token !== 0) {
  		      $scope.user.processing = false;
            //Remember user credentials if option was selected
            if($scope.user.remember) {
              $cookieStore.put('username', $scope.user.username);
              $cookieStore.put('password', $scope.user.password);
            }
            else { //Remove user credentials
              $cookieStore.remove('username');
              $cookieStore.remove('password');
            }
            //Store user's token and related login information in local storage
            localStorageService.add('token', success.data.token);
            localStorageService.add('user', success.data.fname);
            localStorageService.add('tenantid', success.data.tenantid);
            localStorageService.add('usertype', success.data.usertype);
            localStorageService.add('username', success.data.username);
            localStorageService.add('loggedIn', true);
            $location.path('/main').replace();
            
  		    }
    	  }, function(error) { //Capture server-side errors
    	  	console.error(error);
    	  });
  	};

  });
