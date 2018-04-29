var app = angular.module("myApp",['ngMessages']);
app.controller('appController',function($scope,$http,SecurityManager){
	var notyf = new Notyf();
	$scope.savedQuestions = [
		"What is the first and last name of your first boyfriend or girlfriend?",
		"Which phone number do you remember most from your childhood?",
		"What was your favorite place to visit as a child?",
		"Who is your favorite actor, musician, or artist?",
		"What is the name of your favorite pet?",
		"In what city were you born?",
		"What high school did you attend?",
		"What is the name of your first school?",
		"What is your favorite movie?",
		"What is your mother's maiden name?",
		"What street did you grow up on?",
		"What was the make of your first car?",
		"When is your anniversary?",
		"What is your favorite color?",
		"What is your father's middle name?",
		"What is the name of your first grade teacher?",
		"What was your high school mascot?",
		"Which is your favorite web browser?",
	];
	$scope.savedfirstIndex = $scope.savedQuestions[1];
	$scope.questions = [];
	$scope.questionCount = 0;
	$scope.addQuestions = function(form){
		var savedQuestions = $scope.savedQuestions;
		if(form.$valid){
			if($scope.questionCount < 3){
				$scope.questions.push({
					question:$scope.security_question,
					answer:$scope.security_answer
				})
				$scope.questionCount++;
				savedQuestions.splice(savedQuestions.indexOf($scope.security_question),1);
				notyf.confirm("Success! A question has been added!");
				$scope.security_question = $scope.savedQuestions[0];
			}
			else
				alert("Sorry! You cannot exceed 3 questions!")
		}
		else{
			form.$setSubmitted();
			form.answer.$setDirty();
			form.security_question.$setDirty();
		}
		

	};
	$scope.isSaved = null;
	$scope.deleteQuestion = function($item){
		$scope.questions.splice($scope.questions.indexOf($item),1);
		$scope.questionCount--;
		$scope.savedQuestions.push($item.question);
		if($scope.questionCount===0){
			$('#questionModal').modal('close');
		}
		notyf.confirm("A question has been deleted!");
	};
	$scope.enableSubmit = function(){
		return !($scope.questionCount === 3);
	};
	$scope.saveData = function(){
		swal({
			title:"Question",
			type:"question",
			text:"Do you want to save your progress?",
			allowOutsideClick:false,
			showCancelButton:true,
			showLoaderOnConfirm: true,
			 preConfirm: function () {
			    return new Promise(function (resolve, reject) {
			    setTimeout(function(){
			      SecurityManager.setParamater($scope.questions);
			      SecurityManager.saveSecurityQuestion(resolve);
			  	},2000);
			    })
			  }
		}).then(function(response){
			console.log(SecurityManager.getStatus());
			if(SecurityManager.getStatus()==="1"){
				swal("Success!","Data has been saved! Please press OK to go back to the main page.","success").then(function(){
					location.href="/jobsearch/";
				});
			}
			else{
				console.log(SecurityManager.getStatus());
				swal("Error!",SecurityManager.getStatus(),"error")
			}
		}).catch(swal.noop);
	}			
	
});	

app.factory('SecurityManager',function($http){
	return {
		saveSecurityQuestion:saveSecurityQuestion,
		setParamater:setParamater,
		getStatus:getStatus
	}
	var status;
	function setParamater(data){
		this.data = data;
		console.log(data);
	}
	function saveSecurityQuestion(resolve){
		$http.post("security-server.php",{'questions':this.data}).then(
			function(response){
			    setStatus(response.data);
			    resolve();
			},
			function(err){
				resolve();
			}
		);
	}
	function setStatus(param){
		status = param
	}
	function getStatus(){
		return status;
	}
	
});

