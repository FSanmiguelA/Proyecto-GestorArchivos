<?php
require_once("../daos/dao.php");


class ticketsAsing{

    public static function getTickets()
    {
 
       $id=$_GET["id"];
        $obj=new dao();
        echo $obj->getTicketAdmins($id);
    }
 
  


}


ticketsAsing::getTickets();

?>