<?php

require_once("../daos/dao.php");

class updateT{

public static function updateTicket(){
$id=$_GET["id"];
$estado=$_GET["estado"];
$obj=new dao();
echo $obj->updateTicketData($id,$estado);

}





}

updateT::updateTicket();


?>