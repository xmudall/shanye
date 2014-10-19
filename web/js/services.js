'use strict';

/* Services */

var appstoreServices = angular.module('appstoreServices', ['ngResource']);

appstoreServices.factory('Contact', ['$resource',
    function($resource) {
        return $resource(
            resourcePath + '/shanye/server/contact/index/:id', 
            {id: '@id'}
        );
    }
]);

