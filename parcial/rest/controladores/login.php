<?php
include_once("../daos/dao.php");
class login{
    

    public static  function loginAuth()
    {
        $json = file_get_contents('php://input');
        $params=json_decode($json);
        $dao=new dao();
        echo $dao->setAuth($params);
    }


}

login::loginAuth();
?>