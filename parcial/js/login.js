
var login = angular.module("login", []);
login.controller("loginCtrl",["loginService","$scope", function (loginService,$scope) {


    $scope.auth = function (user) {
        console.log(user);
        loginService.login(user).then(function(response){
            console.log(response);
  
            if(response=="0"){
                alert("usuario no existe");
            }else if(response.idRol=="3"){
                location.href="admin.html";
            }else{
                location.href="dashboard.html";
            }
            localStorage.nombre=response.nombre;
            localStorage.id=response.id;
            localStorage.id_rol=response.idRol;
        
        });
    }

  

}]);

login.service("loginService", ["$http", "$q", function ($http, $q) {

    return {
        login: function (user) {
            var deferred = $q.defer();
            $http.post("/parcial/rest/controladores/login.php", user).success(function (data) {
                deferred.resolve(data);
            }).error(function (data,status) {
                deferred.reject({ 'data': data, 'status': status });
            });
            return deferred.promise;
        }

    }


}]);





