<?php
include_once("../daos/dao.php");

class ticket{

public static function setTicket(){

    $idEstado=$_GET["id_estado"];
    $user=$_GET["user"]; 
    $comentario=$_GET["comentario"];
    $archivo=$_GET["archivo"];
    $departamento=$_GET["departamento"];
    $idUser=$_GET["id_user"];
    $prioridad=$_GET["prioridad"];

    $obj=new dao();
    echo $obj->setTicket($idEstado,$user,$comentario,$archivo,$departamento,$idUser,$prioridad);

}

}


ticket::setTicket();



?>

