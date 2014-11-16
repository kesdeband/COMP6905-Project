'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('MainCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
