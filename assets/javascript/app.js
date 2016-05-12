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
            .when('/admin', {
                templateUrl: 'views/admin',
                controller: 'ataadminCtrl',
                resolve: {
                    isLogged: ['$resource', function($resource){
                        return $resource('views/admin',{},{ 'getView': { method: 'GET', tokenKey: 'adminKey'} }).getView({}).$promise;
                    }] 
                }
            })
            .otherwise({
                redirectTo: '/'
            });
    }]);
})(window, window.angular);

