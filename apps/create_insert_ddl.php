<?php
// read json
$url1 = "./data/kanto_home.json";
$json1 = file_get_contents($url1);
$json1 = mb_convert_encoding($json1, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$json1 = json_decode($json1,true);

$url2 = "./data/kanto_home_traffic.json";
$json2 = file_get_contents($url2);
$json2 = mb_convert_encoding($json2, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$json2 = json_decode($json2,true);

// set sql
$str1 = 'INSERT INTO `home_m` VALUES ';
foreach($json1 as $key => $val){
  $rent = preg_replace('/[^0-9a-zA-Z.]/', '', $val["rent"]);
  $age = preg_replace('/[^0-9a-zA-Z.]/', '', $val["age"]);
  if(empty($age)){
    $age = 0;
  }
  if ($val === end($json1)) {
    $str1 .= "('".$val["id"]."','".$val["name"]."','".$val["url"]."','".$rent."','".$age."','".$val["address"]."','0',now(),now())";
  }else{
    $str1 .= "('".$val["id"]."','".$val["name"]."','".$val["url"]."','".$rent."','".$age."','".$val["address"]."','0',now(),now()),";
  }
}

$str2 = 'INSERT INTO `home_traffic_t` VALUES ';
foreach($json2 as $key => $val){
  if ($val === end($json2)) {
    $str2 .= "('".$val["id"]."','".$val["traffic"]."')";
  }else{
    $str2 .= "('".$val["id"]."','".$val["traffic"]."'),";
  }
}

// put file
$insert_sql1 = "./mysql/insert_home_m.sql";
file_put_contents($insert_sql1, $str1);

$insert_sql2 = "./mysql/insert_home_traffic_t.sql";
file_put_contents($insert_sql2, $str2);
?>

