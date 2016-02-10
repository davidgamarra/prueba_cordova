var app = {
    initialize: function() {
        this.bindEvents();
    },
    bindEvents: function() {
        document.addEventListener('deviceready', this.onDeviceReady, true);
    },

    onDeviceReady: function() {
        angular.element(document).ready(function() {
            angular.bootstrap(document);
        });
    },
};

var myAngular = angular.module("prueba", []);

myAngular.directive('itemList', ['$http', function($http){
    return {
        restrict: 'E', 
        templateUrl: 'template/item-list.html',
        controller: function(){
            var that = this;
            this.items;
            this.getList = function() {
                $http.get('http://davidgamarra.es.mialias.net/').success(function(datos){
                    that.items = datos.items;
                });
            };
            this.getItem = function(id){
                sessionStorage.setItem('id', id);
                location.href = "detail.html";
            };
            this.getList();
        }, 
        controllerAs: 'cItems'
    };
}]);

myAngular.directive('itemDetail', ['$http', '$timeout', function($http, $timeout){
    return {
        restrict: 'E', 
        templateUrl: 'template/item-detail.html',
        controller: function(){
            var that = this;
            this.item = {};
            this.images = [];
            this.getDetail = function() {
                $http.get('http://davidgamarra.es.mialias.net/?action=view&target=item&id='+sessionStorage.getItem('id')).success(function(datos){
                    that.item = datos.item;
                    that.images = datos.images;
                    $timeout(function(){
                        $("#fw-slider").owlCarousel({
                            autoPlay: 5000,
                            navigation : false, // Show next and prev buttons
                            slideSpeed : 300,
                            paginationSpeed : 400,
                            singleItem:true
                        });
                    });
                });
            };
            this.getDetail();
        }, 
        controllerAs: 'cDetail'
    };
}]);

app.initialize();