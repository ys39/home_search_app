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
    <div class="container">
      <h1 class="title">Find Good Home</h1>
      <h2 class="subtitle">
        A simple container to divide your page into <strong>sections</strong>, like the one you're currently reading
      </h2>
      <div class="tabs is-centered is-boxed">
        <ul>
          <li
            v-bind:class="{ 'is-active': isActive == 'keywords' }"
          >
            <a
              v-on:click="isActive = 'keywords'"
            >
            <span class="icon is-small"><i class="fas fa-lightbulb" aria-hidden="true"></i></span>
            <span>Keywords</span>
            </a>
          </li>
          <li
            v-bind:class="{ 'is-active': isActive == 'googlemap' }"
          >
            <a
              v-on:click="isActive = 'googlemap'"
            >
            <span class="icon is-small"><i class="fas fa-map" aria-hidden="true"></i></span>
            <span>GoogleMap</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="tab-contents">
        <div class="content" v-bind:class="{ 'is-active': isActive == 'keywords' }">
          <form action="./search_result.php" method="get">
            <div class="field">
              <label class="label">関連キーワードを入力してください</label>
              <div class="control">
                <input class="input" type="text" name="search_word" placeholder="Text input">
              </div>
              <p class="help has-text-grey-light">例）池袋駅</p>
              <label class="label">圏内距離を選択してください</label>
              <div class="field">
                <div class="control has-icons-left">
                  <div class="select">
                    <select name="search_length">
                      <option selected>1km</option>
                      <option>2km</option>
                      <option>3km</option>
                      <option>5km</option>
                      <option>10km</option>
                    </select>
                  </div>
                  <div class="icon is-small is-left">
                    <i class="fas fa-walking"></i>
                  </div>
                </div>
              </div>
              <div class="field is-grouped is-grouped-right">
                <p class="control">
                  <input class="button is-primary" type="submit" value="Search">
                </p>
                <p class="control">
                  <button type="button" class="button is-light cancel_button">
                    Cancel
                  </button>
                </p>
              </div>
            </div>
          </form>
        </div>
        <div class="content" v-bind:class="{ 'is-active': isActive == 'googlemap' }">
          <div id="map">
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?php
  echo displayFooter();
?>
</body>
<script src="http://maps.google.com/maps/api/js?key={}"></script>
<script src="../js/vue.js"></script>
<script src="../js/index_vue.js"></script>
<script src="../js/common_script.js"></script>
<script src="../js/googlemap.js"></script>
</html>
