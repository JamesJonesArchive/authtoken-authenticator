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
        'ngResource',
        'ngSanitize',
        'ngRoute',
        'ngAnimate',
        'ngAria',
        'UsfCAStokenAuth'
    ])
    .config(['$routeProvider', function ($routeProvider) {
        $routeProvider
            .when('/', {
                templateUrl: '/views/home',
                controller: 'atamainCtrl'
            })
            .otherwise({
                redirectTo: '/'
            });
    }]);
})(window, window.angular);

