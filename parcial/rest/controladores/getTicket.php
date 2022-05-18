<?php
require_once("../daos/dao.php");


class tickets{

    public static function getTickets()
    {
 
       $id=$_GET["id"];
        $obj=new dao();
        echo $obj->getTicket($id);
    }
 
  


}


tickets::getTickets();

?>