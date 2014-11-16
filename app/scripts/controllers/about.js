'use strict';

/**
 * @ngdoc function
 * @name cloudApp.controller:AboutCtrl
 * @description
 * # AboutCtrl
 * Controller of the cloudApp
 */
angular.module('cloudApp')
  .controller('AboutCtrl', function ($scope) {
    $scope.awesomeThings = [
      'HTML5 Boilerplate',
      'AngularJS',
      'Karma'
    ];
  });
