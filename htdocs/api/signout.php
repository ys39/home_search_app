<?php     
/****************************************************************************/
/* Before Process*/
/****************************************************************************/
          
//REQUIRE   
/****************************************************************************/
require_once('../../include/config.php');
require_once('../../include/view_function.php');
require_once('../../include/common_function.php');
require_once('../../include/cache.php');
      
//DB_connect
/****************************************************************************/
$db_connect_f = db_connect($gMysql);

// get cookie
$sid = $_COOKIE["sid"];

//Logout
/****************************************************************************/
if(!empty($sid)) {
  // kill session(logout)
  killSession($sid);

  sen_mysql_close();
  header("Location: ../index.php");
  exit();
}
?>
