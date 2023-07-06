<?php
//-----------------------------------------------
// MySQL情報
//-----------------------------------------------
$gMysql["hostname"] = "localhost";
$gMysql["port"] = "3306";
$gMysql["username"] = "root";
$gMysql["password"] = "Maplebear1.";
$gMysql["database"] = "app_test01";

//-----------------------------------------------
// Memcached情報
//-----------------------------------------------
$gMemcache["hostname"] = array(array("host" => "127.0.0.1", "port" => 11211));
$gMemcache["time"] = 60;
$gMemcache["key"] = "APP_TEST01_"; //prefixとなる (APP_TEST01_<keyname>)

//-----------------------------------------------
// Session情報
//-----------------------------------------------
$gSession["time"] = 600;
$gSession["try"] = 10;

//-----------------------------------------------
// Gender
//-----------------------------------------------
$gGender["0"] = "指定しない";
$gGender["1"] = "女性";
$gGender["2"] = "男性";
$gGender["9"] = "カスタム";


?>
