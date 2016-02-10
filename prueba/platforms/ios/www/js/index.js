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
					$http.get('http://192.168.1.108/prueba/www/php/index.php').success(function(datos){
						that.items = datos.items;
					}).error(function (response){
        alert(response);
    });
				};
				this.getList();
			}, 
			controllerAs: 'cItems'
		};
	}]);
	

app.initialize();