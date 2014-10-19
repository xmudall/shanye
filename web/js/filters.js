'use strict';

/* Filters */

angular.module('appstoreFilters', []).filter('checkmark', function() {
  return function(input) {
    return input ? '\u2713' : '\u2718';
  };
});
