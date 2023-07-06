<?php
//-----------------------------------------------
// db接続
//-----------------------------------------------
function db_connect($gMysql){
  // グローバル変数
  global $dbh;
  //$dbh = sen_mysql_connect($gMysql["hostname"],$gMysql["username"],$gMysql["password"],$gMysql["database"]);
  $dbh = sen_mysql_connect($gMysql["hostname"],$gMysql["username"],$gMysql["password"],$gMysql["database"]);
  /*
  $dbh = mysqli_connect($gMysql["hostname"],$gMysql["username"],$gMysql["password"]);
  if(!$dbh){
    throw new BaseErrorException(mysqli_connect_error(), 1, mysqli_connect_errno(), __FILE__, __LINE__);
  }
  mysqli_set_charset($dbh, "utf8");
  $rs = mysqli_select_db($dbh, $gMysql["database"]);
  if(!$rs){
    throw new BaseErrorException(mysqli_error($dbh), 1, mysqli_errno($dbh), __FILE__, __LINE__);
  }
  */
  return $dbh;
}

//-----------------------------------------------
// エスケープ処理(変数の値をSQL文にセットする際に利用)
//-----------------------------------------------
function db_escape($str){
  $esc = sen_mysql_real_escape_string($str);
  return $esc;
}

//-----------------------------------------------
// 正の整数判定
//-----------------------------------------------
function is_positive_integer($value) {
  $options = ['options' => ['min_range' => 1]];
  return is_int(filter_var($value, \FILTER_VALIDATE_INT, $options));
}

//-----------------------------------------------
// 取得件数設定
//-----------------------------------------------
function set_get_record_count($get_record_count){
  if(!empty($get_record_count)){
   if(is_positive_integer($get_record_count)){
     if($get_record_count == 10 or $get_record_count == 20 or $get_record_count == 30){
       $get_record_count = sen_htmlspecialchars($get_record_count);
     }else{
       $get_record_count = 10;
     }
   }else{
     $get_record_count = 10;
   }
  }else{
   $get_record_count = 10;
  }
 return $get_record_count;
}

//-----------------------------------------------
// 取得開始数設定
//-----------------------------------------------
function set_start_record_count($page_num, $get_record_count){
  if($page_num == 1){
    $start_record_count = 0;
  }else{
    $start_record_count = ($page_num-1) * $get_record_count;
  }
  return $start_record_count;
}

//-----------------------------------------------
// pagingする際のURL設定
//-----------------------------------------------
Class Paging {
  function set_paging_url($url, $input_array, $page_num){
    // page_numが存在していれば値を変更する
    if (array_key_exists('page_num', $input_array)) {
      foreach($input_array as $k1 => $v1){
        if ($v1 === reset($input_array)) {
          if($k1 != "page_num"){
            $url .= "?".$k1."=".$v1;
          }else{
            $url .= "?page_num=".$page_num;
          }
        }else{
          if($k1 != "page_num"){
            $url .= "&".$k1."=".$v1;
          }else{
            $url .= "&page_num=".$page_num;
          }
        }
      }
    // page_numがなければ追加する
    }else{
      if(!empty($input_array)){
        foreach($input_array as $k1 => $v1){
          if ($v1 === reset($input_array)) {
            $url .= "?".$k1."=".$v1;
          }else{
            $url .= "&".$k1."=".$v1;
          }
        }
        $url .= "&page_num=".$page_num;
      }else{
        $url .= "?page_num=".$page_num;
      }
    }
   return $url;
  }
}

//-----------------------------------------------
// Memcache接続
//-----------------------------------------------
function fmemcache_connect($gMemcache) {
  $memcache = new Memcached;
  if(is_array($gMemcache["hostname"])){
    $c = count($gMemcache["hostname"]);
    for($i = 0;$i < $c;$i++){
      $memcache->addServer($gMemcache["hostname"][$i]["host"], $gMemcache["hostname"][$i]["port"]);
    }
  }
  return $memcache;
}

//-----------------------------------------------
// Memcache追加
//-----------------------------------------------
function fmemcache_add($gMemcache, $memcache,$key,$var,$time = 0) {
  // グローバル変数
  $key = $gMemcache["key"] . $key;
  $memcache->delete($key);
  if(!empty($time)) {
    $memcache->add($key, $var, time() + $time);
  }else{
    $memcache->add($key, $var);
  }
}

//-----------------------------------------------
// Memcache取得
//-----------------------------------------------
function fmemcache_get($gMemcache, $memcache,$key) {
  // グローバル変数
  $key = $gMemcache["key"] . $key;
  $data = $memcache->get($key);
  return $data;
}

//-----------------------------------------------
// Memcache削除
//-----------------------------------------------
function fmemcache_delete($gMemcache, $memcache,$key) {
  // グローバル変数
  $key = $gMemcache["key"] . $key;
  $data = $memcache->delete($key);
}

//-----------------------------------------------
// Memcache切断
//-----------------------------------------------
function fmemcache_close($gMemcache, $memcache) {
  $memcache->close();
}

//-----------------------------------------------
// user authentication
//-----------------------------------------------
function authenticate_user($mail,$passwd,$expiref=1,$gSession){
  if(!empty($mail) && !empty($passwd)){
    $query  = "select user_id from user_m U";
    $query .= sprintf(" where U.user_mail = '%s'",db_escape($mail));
    $query .= sprintf(" and U.passwd = '%s'",db_escape($passwd));
    $query .= " and U.delf = 0";
    $res = sen_mysql_query($query);

    // fail authentication
    if(empty($res)){
      return false;
    }else{
      // publish session
      $sid = getSession($res[0]["user_id"],$gSession);
    }
  }else{
    // fail authentication
    return false;
  }

  if($expiref==1){
    // keep login
    $expire = time()+$gSession["time"]*60;
  }else{
    // fail login
    $expire = 0;
  }

  // set cokkie
  setcookie("sid",$sid,$expire,"/");

  return $sid;
}

// publish session key
function getSession($user_id,$gSession) {

  // delete user_session
  $query  = "delete from user_session_t";
  $query .= sprintf(" where user_id = '%s'", db_escape($user_id));
  sen_mysql_query($query);

  // get current timestamp
  $timestamp = date("Y-m-d H:i:s");

  // get session key
  for ($i = 0; $i < $gSession["try"]; $i++){
    // issue session key
    $sid = getSessionKey();

    if(!empty($sid)){
      $query  = "select count(*) as scount from user_session_t";
      $query .= sprintf(" where session_id = '%s'",db_escape($sid));
      $res = sen_mysql_query($query);

      if(empty($res[0]["scount"])){
        // insert user_session_t
        $query  = "insert into user_session_t";
        $query .= " (user_id, session_id, login_time, logout_time) values" ;
        $query .= sprintf(" ('%s', '%s', now(), date_add(now(), interval %d minute))", $user_id, $sid, $gSession["time"]);
        sen_mysql_query($query);
        break;
      }
    }
  }
  return $sid;
}

//-----------------------------------------------
// issue session key
//-----------------------------------------------
function getSessionKey($length = 23) {
  // initialize random
  mt_srand ((double) microtime() * 1000000);

  // issue session key
  $key = substr(md5(uniqid(mt_rand(),true)),-$length);

  return $key;
}

//-----------------------------------------------
// Authenticatite session
//-----------------------------------------------
function authSession($sid,$gSession) {

  // clean session overtime
  cleanSession();

  // get current timestamp
  $timestamp = date("Y-m-d H:i:s");

  // authentication
  if(!empty($sid)){
    $query  = "select user_id from user_session_t";
    $query .= sprintf(" where session_id = '%s'", db_escape($sid));
    $res = sen_mysql_query($query);

    // fail
    if(empty($res)){
      return false;
    }else{
      // update set user_session_t
      $query  = "update user_session_t";
      $query .= sprintf(" set logout_time = date_add(now(), interval %d minute)", $gSession["time"]);
      $query .= sprintf(" where session_id = '%s'", db_escape($sid));
      sen_mysql_query($query);

      // set cookie
      setcookie("sid",$sid,time()+$gSession["time"]*60,"/");

      return $res[0]["user_id"];
    }

  }else{
    return false;
  }
}

// clean session
function cleanSession(){
  // clean
  $query  = "delete from user_session_t";
  $query .= " where logout_time <= now()";
  sen_mysql_query($query);
}

// kill session
function killSession($sid){
  // kill
  $query  = "delete from user_session_t";
  $query .= sprintf(" where session_id = '%s'", db_escape($sid));
  sen_mysql_query($query);
}

// Get User Informartion
function getUserinfo($user_id){
  $query  = "select * from user_m";
  $query .= sprintf(" where user_id = \"%d\"", db_escape($user_id));
  $query .= " and delf = 0";
  $res = sen_mysql_query($query);
  return $res;
}
?>
