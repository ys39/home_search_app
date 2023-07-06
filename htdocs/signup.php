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
<section class="section">
  <div class="container">
    <div class="columns is-centered">
      <div class="column is-two-fifths">

        <div class="field">
          <label class="label">Name</label>
          <div class="field-body is-horizontal">
            <div class="field">
              <p class="control is-expanded has-icons-left">
                <input class="input" type="text" placeholder="Last Name">
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </p>
            </div>
            <div class="field">
              <p class="control is-expanded has-icons-left">
                <input class="input" type="text" placeholder="First Name">
                <span class="icon is-small is-left">
                  <i class="fas fa-user"></i>
                </span>
              </p>
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Email</label>
          <div class="field-body">
            <div class="field">
              <div class="control has-icons-left has-icons-right">
                <input class="input is-normal" type="email" placeholder="xx@xx.com">
                <span class="icon is-small is-left">
                  <i class="fas fa-envelope"></i>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="field">
          <label class="label">Password</label>
          <div class="field-body">
            <div class="field">
              <div class="control has-icons-left has-icons-right">
                <input class="input is-normal" type="password" placeholder="password">
                <span class="icon is-small is-left">
                  <i class="fas fa-key"></i>
                </span>
              </div>
            </div>
          </div>
          <p class="help has-text-grey-light">※ 半角英数字, 12文字以上</p>
        </div>

        <div class="field">
          <label class="label">Gender</label>
          <div class="field-body">
            <div class="field">
              <div class="control">
                <div class="select">
                  <select>
                    <option>Select dropdown</option>
                    <option value="1">女性</option>
                    <option value="2">男性</option>
                    <option value="0">指定しない</option>
                    <option value="9">カスタム</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="field">
          <div class="control">
            <button class="button is-primary is-fullwidth" data-tooltip="未実装" disabled >Create Account</button>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

</body>
<script src="../js/vue.js"></script>
<script src="../js/common_script.js"></script>
</html>
