<?php
require_once("../daos/dao.php");

class super{



public static function getSuper(){
  $id=$_GET["id"];
   $obj=new dao();
   echo $obj->getSuperTickets($id);
 }

}


super::getSuper();


?>