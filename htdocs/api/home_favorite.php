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

//REQUEST variable
/****************************************************************************/
$sid = $_COOKIE["sid"];
$user_id="";
$home_id = $_REQUEST["home_id"];
$err = "不正なアクセスです。";
if($_REQUEST["status"] == "thumbs-up"){
  $status = 1;
}else if($_REQUEST["status"] == "thumbs-down"){
  $status = 2;
}

// session authentication
if(!empty($sid)){
   $user_id = authSession($sid,$gSession);
   if(empty($user_id)){
     printf('{"response":[{"result":"%s"}]}', $err);
     exit();
   }
}

if(empty($home_id)){
  printf('{"response":[{"result":"%s"}]}', $err);
  exit();
}

/****************************************************************************/
//query
/****************************************************************************/

// Check home_favorite_t

// empty -> insert
$query  = "select * from home_favorite_t";
$query .= sprintf(" where user_id = \"%s\"", db_escape($user_id));
$query .= sprintf(" and home_id = \"%s\"", db_escape($home_id));
$res = sen_mysql_query($query);

if(empty($res[0])){
  $query  = "insert into home_favorite_t";
  $query .= " (user_id, home_id, status, intime) values" ;
  $query .= sprintf(" ('%s', '%s', '%s', now());", db_escape($user_id), db_escape($home_id), db_escape($status));
  sen_mysql_query($query);

}else if($res[0]["status"] == $status){
  $query  = "delete from home_favorite_t";
  $query .= sprintf(" where user_id = \"%s\"", db_escape($user_id));
  $query .= sprintf(" and home_id = \"%s\"", db_escape($home_id));
  sen_mysql_query($query);

}else{
  // hit -> update
  $query  = "update home_favorite_t";
  $query .= sprintf(" set status = \"%s\"", db_escape($status));
  $query .= ", intime = now()";
  $query .= sprintf(" where user_id = \"%s\"", db_escape($user_id));
  $query .= sprintf(" and home_id = \"%s\";", db_escape($home_id));
  sen_mysql_query($query);
}

printf('[{"home_id":"%s"}]', $home_id);
?>
