var ticket = angular.module("tickets", []);

ticket.controller("ticketCtrl", ["serviceTicket", "$scope", function (serviceTicket, $scope) {
  $scope.nombre = localStorage.nombre;
  $scope.idRol = localStorage.id_rol;

  $scope.cerrar = function () {
    location.href = "login.html";
  }


  $scope.sendTicket = function (ticket) {
    var $archivos = document.querySelector("#archivosU");
    console.log($archivos.files);
    let archivos = $archivos.files;
    ticket.archivo = archivos[0].name;
    var formdata = new FormData();
    var configuracion;
    angular.forEach(archivos, function (archivo) {
      formdata.append(archivo.name, archivo);
    });
    formdata.append("nombre", $scope.nombre);

    configuracion = {
      headers: {
        "Content-Type": undefined,
      },
      transformRequest: angular.identity,
    };
    serviceTicket.setTicket(formdata, configuracion, ticket).then(function (response) {
      console.log(response);
      if (response == 1) {
        alert("se envio el ticket correctamente");

      }
      getTiketsUser();
    })

  }

  ////////////
  setTimeout(() => {
    llamarUser();
  }, 500);
  ///////////////////
  function llamarUser() {
    $("#nombre").val(localStorage.nombre);
  }
  ////////////////
  getUsers();
  function getUsers() {
    serviceTicket.getUserNdos().then(function (response) {
      $scope.usuariosNivelDos = response;
    });
  }

  getTiketsUser();


  function getTiketsUser() {
    var id = localStorage.id;
    serviceTicket.getTickets(id).then(function (response) {
      $scope.ticketsUser = response;
    });
  }


  getTiketsUserAdmin();


  function getTiketsUserAdmin() {
    var id = localStorage.id;
    serviceTicket.getTicketsAdmin(id).then(function (response) {
      $scope.ticketsAdmin = response;
    });
  }


  $scope.pasar=function(ticket){
   var id=ticket.id;
   var estado=2;
   serviceTicket.updateTicket(id,estado).then(function(response){
     console.log(response);
     getTiketsUserAdmin();
   });
  }
  $scope.devolver=function(ticket){
    var id=ticket.id;
    var estado=3;
    serviceTicket.updateTicket(id,estado).then(function(response){
      console.log(response);
      getTiketsUserAdmin();
    });
  }

}]);
//////////
ticket.service("serviceTicket", ["$http", "$q", function ($http, $q) {
  return {
    setTicket: function (formdata, configuracion, ticket) {
      var deferred = $q.defer();
      $http.post("/parcial/rest/controladores/ticket.php?id_estado=" + ticket.id_estado + "&user=" + localStorage.id + "&comentario=" + ticket.comentario + "&archivo=" + ticket.archivo
        + "&departamento=" + ticket.id_departamento + "&id_user=" + ticket.id_user.id + "&prioridad=" + ticket.id_prioridad, formdata, configuracion).success(function (data) {
          deferred.resolve(data);
        }).error(function (data, status) {
          deferred.reject({ 'data': data, 'status': status });
        });
      return deferred.promise;
    },
    getUserNdos: function () {
      var deferred = $q.defer();
      $http.post("/parcial/rest/controladores/getUsers.php").success(function (data) {
        deferred.resolve(data);
      }).error(function (data, status) {
        deferred.reject({ 'data': data, 'status': status });
      });
      return deferred.promise;
    },
    getTickets: function (id) {
      var deferred = $q.defer();
      $http.post("/parcial/rest/controladores/getTicket.php?id=" + id).success(function (data) {
        deferred.resolve(data);
      }).error(function (data, status) {
        deferred.reject({ 'data': data, 'status': status });
      });
      return deferred.promise;
    },
    getTicketsAdmin: function (id) {
      var deferred = $q.defer();
      $http.post("/parcial/rest/controladores/ticketAsing.php?id=" + id).success(function (data) {
        deferred.resolve(data);
      }).error(function (data, status) {
        deferred.reject({ 'data': data, 'status': status });
      });
      return deferred.promise;
    },
    updateTicket: function (id,estado) {
      var deferred = $q.defer();
      $http.post("/parcial/rest/controladores/updateTicket.php?id=" + id+"&estado="+estado).success(function (data) {
        deferred.resolve(data);
      }).error(function (data, status) {
        deferred.reject({ 'data': data, 'status': status });
      });
      return deferred.promise;
    }

  }




}])