var admin = angular.module("admin", []);
admin.controller("adminCrtl", ["adminService", "$scope", function (adminService, $scope) {
  $scope.idRol = localStorage.id_rol;
  $scope.nombre = localStorage.nombre;

  $scope.cerrar = function () {
    location.href = "login.html";
  }



  $scope.guardar = function (user) {
    adminService.setUser(user).then(function (response) {
      var res = response;
      alert(res);
      location.reload();
    });
  }


  $scope.pasar = function (ticket) {
    var id = ticket.id;
    var estado = 4;
    adminService.updateTicket(id, estado).then(function (response) {
      console.log(response);
      getTiketsSuperAdmin()
    });
  }
  $scope.devolver = function (ticket) {
    var id = ticket.id;
    var estado = 3;
    adminService.updateTicket(id, estado).then(function (response) {
      console.log(response);
      getTiketsSuperAdmin()
    });
  }


  getTiketsSuperAdmin()

  function getTiketsSuperAdmin() {
    var id = localStorage.id;
    adminService.getTiketsSuperAdmin(id).then(function (response) {
      $scope.ticketsAdmin = response;
      console.log(response);
    });
  }


  getUsuariosSisi();

  function getUsuariosSisi() {
    adminService.getUsuariosSis().then(function (response) {
      $scope.ordenamiento = [];
      $scope.usuariosSis = response;
      for (var y = 3; y > 0; y--) {
        for (var x = 0; x < response.length; x++) {
           if(response[x].id_rol==y){
             $scope.ordenamiento.push(response[x]);
           }

        }
      }
    
    });
  }
}]);




admin.service("adminService", ["$http", "$q", function ($http, $q) {

  return {
    setUser: function (user) {
      var deferred = $q.defer();
      $http.post("/parcial/rest/controladores/usuarios.php", user).success(function (data) {
        deferred.resolve(data);
      }).error(function (data, status) {
        deferred.reject({ 'data': data, 'status': status });
      });
      return deferred.promise;
    },
    getTiketsSuperAdmin: function (id) {
      var deferred = $q.defer();
      $http.post("/parcial/rest/controladores/superAdminTicket.php?id=" + id).success(function (data) {
        deferred.resolve(data);
      }).error(function (data, status) {
        deferred.reject({ 'data': data, 'status': status });
      });
      return deferred.promise;
    },
    updateTicket: function (id, estado) {
      var deferred = $q.defer();
      $http.post("/parcial/rest/controladores/updateTicket.php?id=" + id + "&estado=" + estado).success(function (data) {
        deferred.resolve(data);
      }).error(function (data, status) {
        deferred.reject({ 'data': data, 'status': status });
      });
      return deferred.promise;
    },
    getUsuariosSis: function () {
      var deferred = $q.defer();
      $http.post("/parcial/rest/controladores/getUsuariosSis.php?").success(function (data) {
        deferred.resolve(data);
      }).error(function (data, status) {
        deferred.reject({ 'data': data, 'status': status });
      });
      return deferred.promise;
    }


  }



}]);