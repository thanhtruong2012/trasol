<?php
$config['modules'] = array(
    MODULES_PATH . "mch_core",
    /*MODULES_PATH . "mch_config",
    MODULES_PATH . "mch_hotel",
    MODULES_PATH . "mch_tour",
	MODULES_PATH . "mch_user",*/
);

if(strpos($_SERVER['SERVER_NAME'],"ginatours.com") === false){
    //localhost server
    $user1 = "root";
    $pass1 = "";
    $host1 = "localhost";
    $db1 = "exoticasia";
   
    $user2 = "root";
    $pass2 = "";
    $host2 = "localhost";
    $db2 = "toursys_int";
}else{
    //real server
    $user1 = "toursys_db";
    $pass1 = "Asdfer@!4578#$";
    $host1 = "10.10.1.30";
    $db1 = "toursys_db";

    $user2 = "toursys_db";
    $pass2 = "Asdfer@!4578#$";
    $host2 = "10.10.1.30";
    $db2 = "toursys_int";
}

$config['database'] = array(
    "conn1" => array(
        'type' => 'mysql',
        'user' => $user1,
        'pass' => $pass1,
        'host' => $host1,
        'port'     => FALSE,
		'socket'   => FALSE,
        'database' => $db1,
        'character_set' => 'utf8'
    ),

    "conn2" => array(
        'type' => 'mysql',
        'user' => $user2,
        'pass' => $pass2,
        'host' => $host2,
        'port'     => FALSE,
		'socket'   => FALSE,
        'database' => $db2,
        'character_set' => 'utf8'
    ),
);

?>

