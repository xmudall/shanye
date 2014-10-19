'use strict';

/* App Module */

var appstoreApp = angular.module('appstoreApp', [
    'ngRoute',
    'appstoreControllers',
    'appstoreFilters',
    'appstoreServices',
    'appstoreDirective',
]);

appstoreApp.config(['$routeProvider',
    function($routeProvider) {
        $routeProvider.
        when('/home', {
            templateUrl: 'partials/home.html',
            controller: 'HomeCtrl'
        }).
        when('/contacts', {
            templateUrl: 'partials/contact_list.html',
            controller: 'ContactsCtrl'
        }).
        when('/contact/new', {
            templateUrl: 'partials/contact_edit.html',
            controller: 'ContactEditCtrl'
        }).
        when('/contact/edit/:id', {
            templateUrl: 'partials/contact_edit.html',
            controller: 'ContactEditCtrl'
        }).
        when('/contact/:id', {
            templateUrl: 'partials/contact_detail.html',
            controller: 'ContactDetailCtrl'
        }).
        when('/activities', {
            templateUrl: 'partials/activities.html',
            controller: 'ActivitiesCtrl'
        }).
        when('/contact_us', {
            templateUrl: 'partials/contact_us.html',
        }).
        otherwise({
            redirectTo: '/home'
        });
    }
]);

// global constants
var context = {};
var resourcePath = "http://localhost";

// global functions
function getRealPath(path) {
    return resourcePath + path;
}

function back() {
    backservice.onBackPressed();
}

function calcTotalHeight(wrap) {
    var children = wrap.children();
    var height = 0;
    for (var i = 0; i < children.length; i++) {
        var item = $(children[i]);
        var pos = item.css('position');
        if (pos != 'absolute' && pos != 'fixed') {
            height += item.outerHeight(true);
        }
    }
    return height;
}

function calcTotalWidth(wrap) {
    var children = wrap.children();
    var width = 0;
    for (var i = 0; i < children.length; i++) {
        var item = $(children[i]);
        var pos = item.css('position');
        if (pos != 'absolute' && pos != 'fixed') {
            width += item.outerWidth(true);
        }
    }
    return width;
}
