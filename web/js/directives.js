'use strict';

/* Directives */
angular.module('appstoreDirective', [])
    .directive('navBar', function() {
        return {
            replace: true,
            scope: {
                act: '@navBar',
                update: '=update'
            },
            templateUrl: 'partials/nav_bar.html',
        };
    })
    .directive('detailNavBar', function() {
        return {
            replace: true,
            templateUrl: 'partials/detail_nav_bar.html',
        };
    })
    .directive('simpleNavBar', function() {
        return {
            replace: true,
            templateUrl: 'partials/simple_nav_bar.html',
        };
    })
    .directive('searchBar', function() {
        return {
            replace: true,
            templateUrl: 'partials/search_bar.html',
        };
    })
    .directive('typeBar', function() {
        return {
            replace: true,
            templateUrl: 'partials/type_bar.html',
            scope: {
                categories: '=categories',
                category: '=category',
            },
            controller: 'TypebarCtrl',
        };
    })
    .directive('billboard', function() {
        return {
            replace: true,
            templateUrl: 'partials/billboard.html',
            scope: {
                list: '=billboard',
                resourcePath: '=baseUrl',
            },
            controller: 'BillboardCtrl',
        };
    })
    .directive('scrollableList', function() {
        return {
            replace: true,
            templateUrl: 'partials/scrollable_list.html',
            scope: {
                resource: '=scrollableList',
                isSearch: '=isSearch',
                keyword: '=keyword',
                type: '=type',
                category: '=category',
                resourcePath: '=baseUrl',
                comment: '=comment',
                myid: '=myid',
            },
            controller: 'ScrollableListCtrl',
        };
    })
    .directive('musicItem', function() {
        return {
            replace: true,
            templateUrl: 'partials/music_item.html',
            scope: {
                item: '=item',
                baseUrl: '=baseUrl',
            },
            controller: 'MusicItemCtrl',
        };
    })
    .directive('movieItem', function() {
        return {
            replace: true,
            templateUrl: 'partials/movie_item.html',
            scope: {
                item: '=item',
                baseUrl: '=baseUrl',
            },
            controller: 'MovieItemCtrl',
        };
    })
    .directive('appGameItem', function() {
        return {
            replace: true,
            templateUrl: 'partials/app_game_item.html',
            scope: {
                item: '=item',
                baseUrl: '=baseUrl',
            },
            controller: 'AppGameItemCtrl',
        };
    })
    .directive('appView', function() {
        return {
            templateUrl: 'partials/app_view.html',
            scope: {
                image: '=image',
                appTitle: '@',
                app_eval: '=appEval',
                installed_num: '=installedNum',
                app_size: '=appSize',
                app_install: '=appInstall',
                app_intro: '=appIntro',
                app_type: '=appType'
            },
        };
    })
    .directive('manageAppsList', function() {
        return {
            replace: true,
            templateUrl: 'partials/manage_app_list.html'
        };
    })
    .directive('fallbackSrc', function() {
        var fallbackSrc = {
            link: function postLink(scope, iElement, iAttrs) {
                iElement.bind('error', function() {
                    angular.element(this).attr("src", iAttrs.fallbackSrc);
                });
            }
        }
        return fallbackSrc;
    })
    .directive('mgDetailBasic', function() {
        return {
            templateUrl: 'partials/mg_detail_basic.html'
        };
    })
    .directive('mgDetailUpdate', function() {
        return {
            templateUrl: 'partials/mg_detail_update.html'
        };
    })
    .directive('playtools', function() {
        return {
            templateUrl: 'partials/playtools.html'
        };
    })
    .directive('tab', function() {
        return {
            templateUrl: 'partials/tab.html'
        };
    })
    .directive('review', function() {
        return {
            replace: true,
            templateUrl: 'partials/review.html'
        };
    })
    .directive('commentItem', function() {
        return {
            templateUrl: 'partials/comment_item.html'
        };
    })
    // calculate dom`s height based on viewport width dynamically
    // height = vw * percent;
    // vw is the viewport width, percent is the given param
    .directive('heightByWidth', function() {
        return {
            link: function($scope, $element, $attrs) {
                $scope.$watch(
                    function() {
                        return $('html').width();
                    },
                    function(nv, ov) {
                        $element.outerHeight(Math.ceil($attrs.heightByWidth * nv));
                    }
                );
            },
        };
    })
    // calculate dom`s height based on viewport width and viewport height dynamically
    // height = vh - vw * percent;
    // vh is the viewport height, vw is the viewport width, percent is the given param
    .directive('heightMinusWidthPercent', function() {
        return {
            link: function($scope, $element, $attrs) {
                $scope.$watch(
                    function() {
                        return $('html').width();
                    },
                    function(nv, ov) {
                        var totalHeight = $('html').innerHeight();
                        $element.outerHeight(Math.floor(totalHeight - $attrs.heightMinusWidthPercent * nv));
                    }
                );
            },
        };
    })
    .directive('fillRemain', function() {
        return {
            link: function($scope, $element) {
                var parent = $element.parent();
                var children = parent.children();

                var _watch = function(item) {
                    $scope.$watch(
                        function() {
                            return item.outerHeight();
                        },
                        function(nv, ov) {
                            var height = 0;
                            // calaculate sum of all children`s height, except element itself
                            for (var i = 0; i < children.length; i++) {
                                if (children[i] == $element[0]) {
                                    // except itself
                                    continue;
                                }
                                var _item = $(children[i]);
                                var pos = _item.css('position');
                                // except float element
                                if (pos != 'absolute' && pos != 'fixed') {
                                    height += _item.outerHeight();
                                }
                            }
                            $element.outerHeight(parent.innerHeight() - height);
                        }
                    );
                }

                // register watch to parent and all siblings
                _watch(parent);
                for (var i = 0; i < children.length; i++) {
                    if (children[i] == $element[0]) {
                        // except itself
                        continue;
                    }
                    var item = $(children[i]);
                    var pos = item.css('position');
                    // except float element
                    if (pos != 'absolute' && pos != 'fixed') {
                        _watch(item);
                    }
                }
            },
        };
    })
    // calculate home list height dynamically
    .directive('homeList', function() {
        return {
            link: function($scope, $element) {
                var parent = $element.parent();
                var navbar = parent.find('.navbar');

                // register watch to parent and all siblings
                $scope.$watch(
                    function() {
                        return navbar.outerHeight();
                    },
                    function(nv, ov) {
                        $element.outerHeight(parent.innerHeight() - navbar.height());
                    }
                );
            },
        };
    });
