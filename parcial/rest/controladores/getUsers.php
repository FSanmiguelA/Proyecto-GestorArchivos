<?php

require_once("../daos/dao.php");
class getUser{

    public static function getUserNdos(){
    $obj=new dao();
    echo $obj->getUser();

    }


}


getUser::getUserNdos();

?>