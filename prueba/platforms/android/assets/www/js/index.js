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

//Listado de items
myAngular.directive('itemList', ['$http', function($http){
    return {
        restrict: 'E', 
        templateUrl: 'template/item-list.html',
        controller: function(){
            var that = this;
            this.email = sessionStorage.getItem('email');
            this.pass = sessionStorage.getItem('pass');
            this.items = [];
            this.login = "";
            this.getList = function() {
                $http.get('http://davidgamarra.es.mialias.net/').success(function(datos){
                    that.items = datos.items;
                });
            };
            this.getItem = function(id){
                sessionStorage.setItem('id', id);
                location.href = "detail.html";
            };
            this.getLogin = function(){
                that.email = document.getElementById("email").value;
                that.pass = document.getElementById("pass").value;
                sessionStorage.setItem('email', that.email);
                sessionStorage.setItem('pass', that.pass);
                $http.get('http://davidgamarra.es.mialias.net/?action=login&target=user&email='+that.email+'&pass='+that.pass).success(function(datos){
                    if(datos.response == 1) {
                        that.getList();
                        that.login = "";
                        document.getElementById("login").style.display = "none";
                    } else {
                        that.login = "Login incorrecto";
                    }
                });
            }
            this.doLogin = function(){
                $http.get('http://davidgamarra.es.mialias.net/?action=login&target=user&email='+that.email+'&pass='+that.pass).success(function(datos){
                    if(datos.response == 1) {
                        that.getList();
                        that.login = "";
                        document.getElementById("login").style.display = "none";
                    } else {
                        document.getElementById("login").style.display = "block";
                    }
                });
            }
            this.doLogin();
        }, 
        controllerAs: 'cItems'
    };
}]);

//Ver detalle de los items
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