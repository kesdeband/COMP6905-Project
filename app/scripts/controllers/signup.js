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
          company : '',
          orgid : '',
          numusers : '',
          orgcode : '',
          orgcreated : '',
          processing : false
   	 	};
   	}

   	//Registration function tenant
	  $scope.signUp = function() {

      $scope.register.processing = true;
      if($scope.register.service === 'B') {
        $scope.register.orgcreated = false;
        if($scope.register.orgid === '') { $scope.register.orgid = -1; }

        //if($scope.register.industry === '') { $scope.register.industry = 'None'; }
        //console.debug($scope.register.country);

        tenant.register($scope.register.fname, $scope.register.lname, $scope.register.orgid, $scope.register.username, $scope.register.password,
          $scope.register.country)
          .then(function(success) {
            if(success.data.created) { //Account successfully created
              $scope.register.processing = false;
              $location.path('/signin').replace(); //Redirect user to sign-in page
            }
          }, function(error) {
            console.error(error);
        });
      }
      else {

        tenant.registerCompany($scope.register.company, $scope.register.username, $scope.register.industry, $scope.register.numusers)
          .then(function(success) {
            if(success.data.created) { //Account successfully created
              //$location.path('/signin').replace(); //Redirect user to sign-in page
              $scope.register.processing = false;
              $scope.register.username = '';
              $scope.register.service = 'B';
              $scope.register.orgcode = success.data.key;
              $scope.register.orgcreated = success.data.created;
            }
          }, function(error) {
            console.error(error);
        });
      }
      
	  };

  });
