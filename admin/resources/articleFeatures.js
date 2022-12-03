zaa.directive("articleFeatures", function() {
	return {
		restrict: "E",
		scope: {
			'model' : '=',
			'article' : '='
		},
		controller: ['$scope', '$http', function($scope, $http) {
			
			$scope.$watch('article', function(n, o) {
				console.log(n, o);
				if (n != null && n) {
					$scope.getArticleFeaturesData(n);
				}
			});
			
			$scope.$watch('model', function(n, o) {
				if (angular.isArray(n) || n == undefined) {
					$scope.model = {};
				}
			});
			
			$scope.getArticleFeaturesData = function(id) { 
				//console.log($scope.article);
				$http.get('admin/api-catalog-product/features?id=' + id).then(function(r) {
					$scope.data = r.data;
				});
			};
			
		}],
		templateUrl: 'catalogadmin/article/article-features'
	}
});