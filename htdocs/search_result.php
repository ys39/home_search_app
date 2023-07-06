<?php
/****************************************************************************/
/* Before Process*/
/****************************************************************************/

//REQUIRE
/****************************************************************************/
require_once('../include/config.php');
require_once('../include/view_function.php');
require_once('../include/common_function.php');
require_once('../include/cache.php');

//DB_connect
/****************************************************************************/
$db_connect_f = db_connect($gMysql);

//REQUEST, variable
/****************************************************************************/
// get cookie
$sid = $_COOKIE["sid"];
$user_id="";
$user_last_name="";

// session authentication
if(!empty($sid)){
   $user_id = authSession($sid,$gSession);
   if(!empty($user_id)){
     $t = getUserinfo($user_id);
     $user_last_name = $t[0]["user_last_name"];
   }
}

//page_num
if(!empty($_REQUEST["page_num"])){
 if(is_positive_integer($_REQUEST["page_num"])){
   $page_num = sen_htmlspecialchars($_REQUEST["page_num"]);
 }else{
   $page_num = 1;
 }
}else{
 $page_num = 1;
}

//record_count
$get_record_count = set_get_record_count($_REQUEST["get_record_count"]);
$start_record_count = set_start_record_count($page_num, $get_record_count);

//search word
if(!empty($_REQUEST["search_word"])){
  $s_flag = 1;
  $search_word = sen_htmlspecialchars($_REQUEST["search_word"]);
}else{
  $s_flag = 0;
  $search_word = "";
  $query = "";
}

//search length
if(!empty($_REQUEST["search_length"])){
  $search_length = sen_htmlspecialchars($_REQUEST["search_length"]);
}else{
  $search_length = "1km";
}

/****************************************************************************/
/* execute query*/
/****************************************************************************/
if(!empty($s_flag)){
  //get home detail
  $res1 = getHomedetail($search_word, $start_record_count, $get_record_count, $gMemcache);
  $all_count = $res1["count"];
  $res1 = array_diff_key($res1, array_flip(['count']));
  
  //get home traffic detail
  $home_traffic_detail = getHometrafficdetail($search_word, $start_record_count, $get_record_count, $res1, $gMemcache);

  $query  = "select home_id, status from home_favorite_t";
  $query .= sprintf(" where user_id = \"%s\"", db_escape($user_id));
  $res2 = sen_mysql_query($query);
  foreach($res2 as $k2 => $v2){
    $home_favorite[$v2["home_id"]] = $v2["status"];
  }
}
?>
<?php
/****************************************************************************/
/* View*/
/****************************************************************************/
?>
<!DOCTYPE html>
<html lang="ja">
<title>Home Site</title>
<meta charset="utf-8">
<head>
  <link rel="stylesheet" href="../css/bulma.min.css" />
  <link rel="stylesheet" href="../css/common_style.css" />
  <link rel="stylesheet" href="../css/bulma-tooltip/dist/bulma-tooltip.css" />
  <script src="../js/0d434b10e8.js" crossorigin="anonymous"></script>
  <script src="../js/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
</head>
<body>
<?php
  echo displayNavbar($user_id,$user_last_name);
?>
<div id="app">
  <section class="section">
<?php
if(!empty($s_flag)){
  if(!empty($res1)){
    echo displayLevel($search_word, $all_count);
    echo displayPagination($page_num, $get_record_count, $all_count);
    foreach($res1 as $k1 => $v1){
      echo displayHomelist
       (
       sen_htmlspecialchars($v1["home_id"]),
       sen_htmlspecialchars($v1["home_name"]),
       sen_htmlspecialchars($v1["home_url"]),
       sen_htmlspecialchars($v1["home_rent"]),
       sen_htmlspecialchars($v1["home_age"]),
       sen_htmlspecialchars($v1["home_address"]),
       $home_traffic_detail[sen_htmlspecialchars($v1["home_id"])],
       $home_favorite[sen_htmlspecialchars($v1["home_id"])]
       );
    }
    echo displayPagination($page_num, $get_record_count, $all_count);
  }else{
    // no hit
    echo displayNohomelist();
  }
}else{
  echo displayNohomelist();
}
?>
  </section>
</div>

<?php
echo displayFooter();
?>
</body>
<script src="../js/vue.js"></script>
<script src="../js/common_script.js"></script>
</html>

<?php
/****************************************************************************/
/* After Process*/
/****************************************************************************/

//DB_close
/****************************************************************************/
sen_mysql_close();
?>
