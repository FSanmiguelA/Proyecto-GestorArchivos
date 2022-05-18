<?php

include_once("../coneccion/coneccion.php");
include_once("../coneccion/coneccionIceberg.php");

class dao
{
    public static $con;

    public function setUsuarios($usuario)
    {
        $id_rol = $usuario->id_rol;
        $nombre = $usuario->nombre;
        $id_departamento = $usuario->id_departamento;
        $id_cargo = $usuario->id_cargo;
        $id_ciudad = $usuario->id_ciudad;
        $nick = $usuario->nick;
        //encriptacion
        $password = md5($usuario->password);
        /////////////
        $id_sede = $usuario->id_sede;
        $con = coneccion::conectarBd();
        $query = "insert into usuarios (id_rol,nombre,id_departamento,id_cargo,id_ciudad,nick,password,id_sede)" .
            "values($id_rol,'$nombre',$id_departamento,$id_cargo,$id_ciudad,'$nick','$password',$id_sede);";
        $res = mysqli_query($con, $query);
        if ($res) {
            return "registrado Correctamente";
        } else {
            return mysqli_error($con);
        }
    }

    public function setAuth($usuario)
    {
        $array = [];
        $nick = $usuario->nick;
        $pass = md5($usuario->pass);
        $con = coneccion::conectarBd();
        $query = "select * from usuarios where nick='$nick' and password='$pass'";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($file = mysqli_fetch_row($res)) {
                $obj = new stdClass();
                $obj->id = $file[0];
                $obj->idRol = $file[1];
                $obj->nombre = $file[2];
                $obj->idCargo = $file[3];
                $array = $obj;
            }
            return json_encode($array);
        } else {
            return "0";
        }
    }


    public function getUsuariosSis(){
        $array = [];
        $con = coneccion::conectarBd();
        $query = "select * from usuarios";
        $sql = mysqli_query($con, $query);
        if (mysqli_num_rows($sql) > 0) {
            while ($file = mysqli_fetch_row($sql)) {
                $obj = new stdClass();
                $obj->id_rol = $file[1];
                $obj->nombre = $file[2];
                $obj->idDepartamento = $file[3];
                $obj->idCargo = $file[4];
                $obj->idCiudad = $file[5];
                $obj->nick = $file[6];
                $array[] = $obj;
            }
            return json_encode($array);
        }
        return "0";

    }

    public function getUser()
    {
        $array = [];
        $con = coneccion::conectarBd();
        $query = "select * from usuarios where id_rol=2";
        $sql = mysqli_query($con, $query);
        if (mysqli_num_rows($sql) > 0) {
            while ($file = mysqli_fetch_row($sql)) {
                $obj = new stdClass();
                $obj->id = $file[0];
                $obj->nombre = $file[2];
                $array[] = $obj;
            }
            return json_encode($array);
        }
        return "0";
    }


    public function setTicket($idEstado, $user, $comentario, $arch, $departamento, $idUser, $prioridad)
    {
        foreach ($_FILES as $archivo) {
            $name = $archivo['name'];
        }
        $arch = "archivos/" . $arch;
        $url = "../../archivos/" . $name;
        $con = coneccion::conectarBd();
        $query = "insert into tickets(id_estado,id_usuario,comentario,archivo,id_departamento,id_user_asignado,id_prioridad)" .
            "values($idEstado,$user,'$comentario','$arch',$departamento,$idUser,$prioridad)";
        $res = mysqli_query($con, $query);
        if ($res) {
            move_uploaded_file($archivo["tmp_name"], $url);
            return "1";
        } else {
            return mysqli_error($con);
        }
    }


    public function getTicket($id)
    {
        $array = [];
        $con = coneccion::conectarBd();
        $query = "select a.*,b.nombre,b.nick from tickets as a inner join usuarios as b on a.id_user_asignado=b.id and a.id_usuario='$id' order by id desc";
        $sql = mysqli_query($con, $query);
        if (mysqli_num_rows($sql) > 0) {
            while ($file = mysqli_fetch_row($sql)) {
                $obj = new stdClass();
                $obj->id = $file[0];
                $obj->estado = $file[1];
                $obj->fecha_carga = $file[2];
                $obj->usuario = $file[3];
                $obj->comentario = $file[4];
                $obj->archivo = $file[5];
                $obj->departamento = $file[6];
                $obj->fecha_act = $file[7];
                $obj->prioridad = $file[9];
                $obj->usuarioAsignado = $file[10];
                $obj->nick = $file[11];
                $array[] = $obj;
            }
            return json_encode($array);
        }
        return mysqli_error($con);
    }

    public function getTicketAdmins($id)
    {
        $array = [];
        $con = coneccion::conectarBd();
        $query = "select a.*,b.nick from tickets as a inner join usuarios as b on a.id_user_asignado='$id' and b.id=a.id_user_asignado order by id desc";
        $sql = mysqli_query($con, $query);
        if (mysqli_num_rows($sql) > 0) {
            while ($file = mysqli_fetch_row($sql)) {
                $obj = new stdClass();
                $obj->id = $file[0];
                $obj->estado = $file[1];
                $obj->fecha_carga = $file[2];
                $obj->usuario = $file[3];
                $obj->comentario = $file[4];
                $obj->archivo = $file[5];
                $obj->departamento = $file[6];
                $obj->fecha_act = $file[7];
                $obj->prioridad = $file[9];
                $obj->usuarioAsignado = $file[10];
                
                $array[] = $obj;
            }
            return json_encode($array);
        }
        return mysqli_error($con);
    }


    public function getSuperTickets($id){
        $array = [];
        $con = coneccion::conectarBd();
        $query = "select a.*,b.nick from tickets as a inner join usuarios as b on a.id_estado='2' and b.id_rol = '3' and b.id='$id'  order by id desc";
        $sql = mysqli_query($con, $query);
        if (mysqli_num_rows($sql) > 0) {
            while ($file = mysqli_fetch_row($sql)) {
                $obj = new stdClass();
                $obj->id = $file[0];
                $obj->estado = $file[1];
                $obj->fecha_carga = $file[2];
                $obj->usuario = $file[3];
                $obj->comentario = $file[4];
                $obj->archivo = $file[5];
                $obj->departamento = $file[6];
                $obj->fecha_act = $file[7];
                $obj->prioridad = $file[9];
                $obj->usuarioAsignado = $file[10];
           
                
                $array[] = $obj;
            }
            return json_encode($array);
        }
        return mysqli_error($con);
    }

   public function updateTicketData($id,$estado){
    $con = coneccion::conectarBd();
    $query="update tickets set id_estado = $estado , fecha_actualizacion=NOW() where id=$id";
    $res=mysqli_query($con,$query);
    if ($res) {
        return "1";
    } else {
        return mysqli_error($con);
    }

   }


/////

    public function loginUpdate($user, $pass)
    {
        $usuario = $user;
        $password = $pass;
        $con = coneccionDos::conectarBdDos();
        $query = "update user_login set user='$usuario', password = '$password' where id= 1";
        $res = mysqli_query($con, $query);
        if ($res) {
            return "1";
        } else {
            return "0";
        }
    }

    public function getUserData()
    {
        $array = [];
        $con = coneccionDos::conectarBdDos();
        $query = "select user,password from user_login";
        $res = mysqli_query($con, $query);
        if (mysqli_num_rows($res) > 0) {
            while ($file = mysqli_fetch_row($res)) {
                $obj = new stdClass();
                $obj->user = $file[0];
                $obj->pass = $file[1];
                $array = $obj;
            }
            return json_encode($array);
        } else {
            return "0";
        }
    }
}
