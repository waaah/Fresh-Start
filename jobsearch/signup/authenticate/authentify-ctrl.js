var app = angular.module("myApp",['ngMessages']);

app.controller('authentication-controller',function($scope,$timeout,$http){
	$scope.hidden = false;
	$scope.none = false;

	$scope.hideMessage = function(){
		$scope.hidden = true;
		$timeout(function(){
			$scope.none = true;
		},800)
		
	};
	$scope.authentify = function(form){
		if(form.$valid){
			swal({
				type:"question",
				title:"Do you want to confirm"
			})
			var data = {
				'password':$scope.password,
				'code':$scope.key
			};
			$http.post('authentify-server.php',data).then(
				function(response){
					var state = response.data;
					(state.success) ? customSwal('Success!',state.message,"success").then(function(){location.href="/jobsearch/index.php"}) : swal('Error!',"Account has not been verified! Please check if the password matches with your own.","error");

				},
				function(error){
					swal("Error","There seems to be problem with server communication!","error").catch(swal.noop);
				}
			);
		}

	}
	function customSwal(title,text,type){
		return swal({
			title:title,
			text:text,
			type:type,
			allowOutsideClick:false
		})
	}
});
app.directive('matchField',matchField);
//functions for directive
function matchField(){
	return{
		restrict:'A',
		require:'?ngModel',
		link:function(scope,elem,attrs,ngModel){
			scope.$watch(attrs.ngModel,function(){
				validate();
			});
			attrs.$observe('matchField',function(val){
				validate();
			});
			var validate = function(){
				var val1 = ngModel.$viewValue;
				var val2 = attrs.matchField;
				ngModel.$setValidity('matchField',val1 === val2);
			};
		}

	};
}
