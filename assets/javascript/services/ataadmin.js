(function (window, angular, undefined) {
    'use strict';

    angular.module('authtokenauthenticatorApp')
        .factory('ataadminService', ['$resource', function ($resource) {
            var service = {
                getCounties: function (state) {
                    return apiResource.getCounties({state: state}).$promise;
                }
            };
            var apiResource = $resource('view',{},{
                'getCounties': {
                    method: 'GET', url: 'view/:name'
                }
            });
            
            
            
            return service;
        }]).filter('digits', function() {
            return function(input, padAmount) {
                padAmount = padAmount||3;
                if(input.length<padAmount)
                {
                    while(input.length<padAmount)
                    {
                        input = '0' + input;
                    }
                }      
                return input;
            };
        });

})(window, window.angular);