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

//Check User Session
/****************************************************************************/
//OK -> mypage.php へredirect
//NG -> signin.php へredirect

// get cookie
$sid = $_COOKIE["sid"];
$user_id="";

// session authentication
if(!empty($sid)){
   $user_id = authSession($sid,$gSession);
   // ブラウザにセッション情報があり、DBにセッション情報がない場合はsignin.phpへ
   if(!empty($user_id)){
     sen_mysql_close();
     header("Location: mypage.php");
   }
}

//REQUEST, variable
/****************************************************************************/
$err_message = "";

if($_REQUEST["mode"] == "login"){
  if(!empty($_REQUEST["mail"]) && !empty($_REQUEST["passwd"])){
    if($sid = authenticate_user($_REQUEST["mail"],$_REQUEST["passwd"],1,$gSession)){
      sen_mysql_close();
      header("Location: mypage.php");
      exit();
    }else{
      $err_message = "入力情報に誤りがあります。";
    }
  }else{
    $err_message = "入力情報に誤りがあります。";
  }
}

/****************************************************************************/
/* execute query*/
/****************************************************************************/
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
  echo displayNavbar($user_id);
?>
<section class="section">
  <div class="container">
    <div class="columns is-centered">
      <div class="column is-two-fifths">

        <form action="./signin.php" method="post">
          <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left has-icons-right">
              <input class="input is-normal" type="email" placeholder="xx@xx.com" name="mail">
              <span class="icon is-small is-left">
                <i class="fas fa-envelope"></i>
              </span>
            </div>
          </div>

          <div class="field">
            <label class="label" style="float">Password
            <a class="has-text-link" style="float:right;" href="password_reset.php">Forgot password?</a>
            </label>
            <div class="control has-icons-left has-icons-right">
              <input class="input is-normal" type="password" placeholder="password" name="passwd">
              <span class="icon is-small is-left">
                <i class="fas fa-key"></i>
              </span>
            </div>
            <p class="help has-text-grey-light">※ 半角英数字, 12文字以上</p>
          </div>
          
          <input type="hidden" name="mode" value="login">

          <div class="field">
            <div class="control">
              <button class="button is-primary is-fullwidth">Sign in</button>
            </div>
          </div>
        </form>
        <div class = "err has-text-danger"><?php echo $err_message; ?></div>
      </div>
    </div>
  </div>
</section>

</body>
<script src="../js/vue.js"></script>
<script src="../js/common_script.js"></script>
</html>
