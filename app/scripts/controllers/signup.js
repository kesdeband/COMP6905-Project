'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:SignupCtrl
 * @description
 * # SignupCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('SignupCtrl', function ($scope, $location, $cookieStore, localStorageService, tenant) {

    
  	//Get user login status
  	$scope.loggedIn = localStorageService.get('loggedIn') || false;

  	if($scope.loggedIn) {
    	$location.path('/main').replace(); //Redirect user to home page if logged in
  	}
  	else {
    	//Initialize controller variables for form submission
    	$scope.register = {
      		fname : null,
      		lname : null,
      		username : null,
      		password : null,
          country : '',
          industry : '',
      		service : 'B',
          company : ''
   	 	};
   	}

   	//Registration function
	$scope.signUp = function() {

    if($scope.register.company === '') { $scope.register.company = 'None'; }
    if($scope.register.industry === '') { $scope.register.industry = 'None'; }

    //console.debug($scope.register.country);

		tenant.register($scope.register.fname, $scope.register.lname, $scope.register.username, $scope.register.password, 
			$scope.register.country, $scope.register.industry, $scope.register.company)
          .then(function(success) {
            if(success.data.created) { //Account successfully created
              $location.path('/signin').replace(); //Redirect user to sign-in page
            }
          }, function(error) {
          	console.error(error);
        });
	};

  });
