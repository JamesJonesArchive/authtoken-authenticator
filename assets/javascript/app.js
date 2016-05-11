(function (window, angular, undefined) {
    'use strict';

/**
 * 
 *        'ngResource',
 *        'ngSanitize',
 *        'ngRoute',
 *        'ngAnimate',
 *        'ngAria'
 * 
 * 
 */

    angular
    .module('authtokenauthenticatorApp', [
        'ngRoute'
    ])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: '/view/home',
                controller: 'atamainCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });
    }]);
})(window, window.angular);

