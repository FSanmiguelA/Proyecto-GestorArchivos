<?php
require_once("../daos/dao.php");


class usuariosController{

    public static function objectUser()
    {
 
        $json = file_get_contents('php://input');
        $params=json_decode($json);
        $dao=new dao();
        echo $dao->setUsuarios($params);
    }
 
  


}


usuariosController::objectUser();

?>