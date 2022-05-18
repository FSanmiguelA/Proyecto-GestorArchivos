<?php
require_once("../daos/dao.php");

class usuarios{



public static function getUsuarios(){
   $obj=new dao();
   echo $obj->getUsuariosSis();
 }

}


usuarios::getUsuarios();


?>