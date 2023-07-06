<?php
function getHomedetail($search_word, $start_record_count, $get_record_count, $gMemcache, $mode=""){
  // memcache接続
  $memcache = fmemcache_connect($gMemcache);

  // cacheキー
  $key = sprintf("HOME_detail_#%s_#%d_#%d", $search_word, $start_record_count, $get_record_count);

  if($mode != "RESET") {
    $home_detail = fmemcache_get($gMemcache, $memcache, $key);
  }

  if(empty($home_detail)) {
    $query  = sprintf("select SQL_CALC_FOUND_ROWS a.home_id, a.home_name, a.home_url, a.home_rent, a.home_age, a.home_address from home_m as a");
    $query .= sprintf(" inner join home_traffic_t as b");
    $query .= sprintf(" on a.home_id = b.home_id");
    $query .= sprintf(" where b.home_traffic like \"%%%s%%\"",db_escape($search_word));
    $query .= sprintf(" or a.home_name like \"%%%s%%\"",db_escape($search_word));
    $query .= sprintf(" or a.home_address like \"%%%s%%\"",db_escape($search_word));
    $query .= sprintf(" group by a.home_id");
    $query .= sprintf(" order by a.home_rent ASC");
    $query .= sprintf(" limit %d, %d;", db_escape($start_record_count), db_escape($get_record_count));
    $home_detail = sen_mysql_query($query);

    //get record count
    $query = sprintf("SELECT FOUND_ROWS() as count;");
    $tmp = sen_mysql_query($query);
    $home_detail["count"] = $tmp[0]["count"];

    //-----------------------------------------------
    // キャッシュに登録
    //-----------------------------------------------
    fmemcache_add($gMemcache, $memcache, $key, $home_detail);
  }
  return $home_detail;
}

function getHometrafficdetail($search_word, $start_record_count, $get_record_count, $res1, $gMemcache, $mode=""){
  // memcache接続
  $memcache = fmemcache_connect($gMemcache);

  // cacheキー
  $key = sprintf("HOME_traffic_detail_#%s_#%d_#%d", $search_word, $start_record_count, $get_record_count);

  if($mode != "RESET") {
    $home_traffic_detail = fmemcache_get($gMemcache, $memcache, $key);
  }

  if(empty($home_traffic_detail)) {
    if(!empty($res1)){
      foreach($res1 as $k1 => $v1){
        $query  = sprintf("select home_id, home_traffic from home_traffic_t");
        $query .= sprintf(" where home_id = \"%s\";",db_escape($v1["home_id"]));
        $res2 = sen_mysql_query($query);
        foreach($res2 as $k2 => $v2){
          $home_traffic_detail[$v2["home_id"]][] = $v2["home_traffic"];
        }
      }
    }
    //-----------------------------------------------
    // キャッシュに登録
    //-----------------------------------------------
    fmemcache_add($gMemcache, $memcache, $key, $home_traffic_detail);
  }
  return $home_traffic_detail;
}
?>
