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
// OK -> mypage.phpへ(後続の処理)
// NG -> signin.phpへredirect

// get cookie
$sid = $_COOKIE["sid"];
$user_id="";
$user_last_name="";

// session authentication
// ブラウザのセッション情報、もしくはDBにセッション情報がない場合はsignin.phpへ
if(!empty($sid)){
   $user_id = authSession($sid,$gSession);
   if(!empty($user_id)){
     $t = getUserinfo($user_id);
     $user_last_name = $t[0]["user_last_name"];
   }else{
     header("Location: signin.php");
   }
}else{
  header("Location: signin.php");
}

/****************************************************************************/
/* execute query*/
/****************************************************************************/
// Get User Informartion
$query  = "select * from user_m";
$query .= sprintf(" where user_id = \"%d\"", db_escape($user_id));
$query .= " and delf = 0";
$res = sen_mysql_query($query);

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
  echo displayNavbar($user_id, $user_last_name);
?>
  <div id="app1">
    <section class="section">
      <div class="container">
        <h1 class="title">My Page</h1>
        <h2 class="subtitle">
          Account detail 
        </h2>
        <div class="tabs is-centered is-boxed">
          <ul>
            <li
              v-bind:class="{ 'is-active': isActive == 'account' }"
            >
              <a
                v-on:click="isActive = 'account'"
              >
              <span class="icon is-small"><i class="fas fa-user-circle" aria-hidden="true"></i></span>
              <span>Account</span>
              </a>
            </li>
            <li
              v-bind:class="{ 'is-active': isActive == 'good' }"
            >
              <a
                v-on:click="isActive = 'good'"
              >
              <span class="icon is-small"><i class="fas fa-thumbs-up" aria-hidden="true"></i></span>
              <span>Good</span>
              </a>
            </li>
            <li
              v-bind:class="{ 'is-active': isActive == 'bad' }"
            >
              <a
                v-on:click="isActive = 'bad'"
              >
              <span class="icon is-small"><i class="fas fa-thumbs-down" aria-hidden="true"></i></span>
              <span>Bad</span>
              </a>
            </li>
          </ul>
        </div>
        <div class="tab-contents">
          <div class="content" v-bind:class="{ 'is-active': isActive == 'account' }">

            <section class="section">
              <div class="container">
                <div class="columns is-centered">
                  <div class="column is-two-fifths">

                    <div class="field">
                      <label class="label">Name</label>
                      <div class="field-body is-horizontal">
                        <div class="field">
                          <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="Last Name" value=<?php echo $res[0]["user_last_name"]; ?>>
                            <span class="icon is-small is-left">
                              <i class="fas fa-user"></i>
                            </span>
                          </p>
                        </div>
                        <div class="field">
                          <p class="control is-expanded has-icons-left">
                            <input class="input" type="text" placeholder="First Name" value=<?php echo $res[0]["user_first_name"]; ?>>
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
                            <input class="input is-normal" type="email" placeholder="xx@xx.com" value=<?php echo $res[0]["user_mail"]; ?>>
                            <span class="icon is-small is-left">
                              <i class="fas fa-envelope"></i>
                            </span>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="field">
                      <label class="label">Gender</label>
                      <div class="field-body">

                        <div class="field">
                          <div class="control has-icons-left has-icons-right">
                            <div class="select">
                              <select>
<?php
foreach($gGender as $k => $v){
?>
                                <option value=<?php echo $k; ?> <?php if($k == $res[0]["user_gender"]){ echo "selected"; } ?>><?php echo $v; ?></option>
<?php
}
?>
                              </select>
                            <span class="icon is-small is-left">
                              <i class="fas fa-genderless"></i>
                            </span>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="field">
                      <div class="control">
                        <button class="button is-primary is-fullwidth" data-tooltip="未実装" disabled >Update Account</button>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </section>

          </div>
          <div class="content" v-bind:class="{ 'is-active': isActive == 'good' }">
            good
          </div>
          <div class="content" v-bind:class="{ 'is-active': isActive == 'bad' }">
            bad
          </div>
        </div>
      </div>
    </section>
  </div>

<?php
  echo displayFooter();
?>
</body>
<script src="../js/vue.js"></script>
<script src="../js/mypage_vue.js"></script>
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
