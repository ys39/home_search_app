<?php
function displayNavbar($user_id="",$user_last_name=""){
$result = <<<EOD
<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php">
      <img src="../image/logo_black.png">
    </a>

    <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          More
        </a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="about.php">
            About
          </a>
          <a class="navbar-item" href="recruit.php">
            Recruit
          </a>
          <a class="navbar-item" href="contact.php">
            Contact
          </a>
EOD;
if(!empty($user_id)){
$result .= <<<EOD
          <hr class="navbar-divider">
          <a class="navbar-item" href="./api/signout.php">
            Sign out
          </a>
EOD;
}
$result .= <<<EOD
        </div>
      </div>
    </div>

    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a class="button is-dark signup_button" href="./signup.php">
            <strong>Sign up</strong>
          </a>
EOD;
if(empty($user_id)){
$result .= <<<EOD
          <a class="button is-light signin_button" href="./signin.php">
            Sign in
          </a>
EOD;
}else{
$result .= <<<EOD
          <a class="button is-light mypage_button has-tooltip-bottom" href="./mypage.php" data-tooltip=$user_last_name> 
            MyPage
          </a>
EOD;
}
$result .= <<<EOD
        </div>
      </div>
    </div>
  </div>
</nav>
EOD;
return $result;
}

function displayFooter(){
return <<<EOD
<footer class="footer">
  <div class="content has-text-centered">
    <p>
      <strong>Bulma</strong> by <a href="https://jgthms.com">Jeremy Thomas</a>. The source code is licensed
      <a href="http://opensource.org/licenses/mit-license.php">MIT</a>. The website content
      is licensed <a href="http://creativecommons.org/licenses/by-nc-sa/4.0/">CC BY NC SA 4.0</a>.
    </p>
  </div>
</footer>
EOD;
}

function displayHomelist($home_id, $home_name, $home_url, $home_rent, $home_age, $home_address, $home_traffic_detail, $home_favorite=0){
$result = <<<EOD
<article class="media">
  <div class="media-content">
    <div class="content">
      <div class="tile is-ancestor">
        <div class="tile is-vertical is-8">

          <div class="tile">
            <div class="tile is-parent is-10">
              <article class="tile is-child notification is-primary">
                <a href = "$home_url" target = "_blank"><p class="title">$home_name</p></a>
              </article>
            </div>

            <div class="tile is-vertical">
              <div class="tile is-parent">

                <a class="thumbs-up-$home_id level-item" data-home-id=$home_id style="text-decoration:none;">
EOD;
if($home_favorite == 1) {
$result .= <<<EOD
                  <article class="tile is-child notification is-danger">
EOD;
}else{
$result .= <<<EOD
                  <article class="tile is-child notification is-light">
EOD;
}
$result .= <<<EOD
                   <nav class="level is-mobile">
                     <div class="level-left">
                       <span class="icon is-small"><i class="fas fa-thumbs-up"></i></span>
                     </div>
                   </nav>
                  </article>
                </a>
              </div>
              <div class="tile is-parent">
                <a class="thumbs-down-$home_id level-item" data-home-id=$home_id style="text-decoration:none;">
EOD;
if($home_favorite == 2) {
$result .= <<<EOD
                  <article class="tile is-child notification is-danger">
EOD;
}else{
$result .= <<<EOD
                  <article class="tile is-child notification is-light">
EOD;
}
$result .= <<<EOD
                    <nav class="level is-mobile">
                      <div class="level-left">
                        <span class="icon is-small"><i class="fas fa-thumbs-down"></i></span>
                      </div>
                    </nav>
                  </article>
                </a>
              </div>
            </div>
          </div>

          <div class="tile">
            <div class="tile is-parent is-vertical">
              <article class="tile is-child notification is-light">
                <figure class="image">
                  <img src="https://bulma.io/images/placeholders/640x480.png">
                </figure>
              </article>
            </div>
            <div class="tile is-parent">
              <article class="tile is-child notification is-warning">
                <div class="table-container">
                  <table class="table is-hoverable is-fullwidth">
                    <tr>
                    <td>賃貸料</td>
                    <td>$home_rent 万円</td>
                    </tr>
                    <tr>
                    <td>築年数</td>
                    <td>$home_age 年</td>
                    </tr>
                    <tr>
                    <td>住所</td>
                    <td>$home_address</td>
                    </tr>
                  </table>
                </div>
              </article>
            </div>
          </div>
        </div>
        <div class="tile is-parent">
          <article class="tile is-child notification is-info">
                <p class="title">最寄り駅</p>
EOD;
        foreach($home_traffic_detail as $k1 => $v1){
$result .= <<<EOD
        <p>$v1</p>
EOD;
        }
$result .= <<<EOD
          </article>
        </div>
      </div>
    </div>
  </div>
</article>
<br><br />
EOD;
return($result);
}

function displayNohomelist(){
return <<<EOD
<article class="media">
  <figure class="media-left">
    <p class="image is-64x64">
      <img src="https://bulma.io/images/placeholders/128x128.png">
    </p>
  </figure>
  <div class="media-content">
    <div class="content">
      <p>
        <strong>検索結果なし</strong>
        <br>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.
      </p>
    </div>
  </div>
</article>
EOD;
}

function displayPagination($page_num, $get_record_count, $all_count){
  $paging = new Paging();
  $urlparams = filter_input_array(INPUT_GET);
  $last_page_num = ceil($all_count/$get_record_count);
  $before_page_num = $page_num - 1;
  $after_page_num = $page_num + 1;
  
$result = <<<EOD
<nav class="pagination is-centered" role="navigation" aria-label="pagination">
EOD;
if($page_num == 1){
$result .= <<<EOD
  <a class="pagination-previous" disabled>Previous</a>
EOD;
}else{
$result .= <<<EOD
  <a class="pagination-previous" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $before_page_num)}">Previous</a>
EOD;
}
if($page_num == $last_page_num){
$result .= <<<EOD
  <a class="pagination-next" disabled>Next page</a>
EOD;
}else{
$result .= <<<EOD
  <a class="pagination-next" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $after_page_num)}">Next page</a>
EOD;
}
if($page_num == 1){
  if($all_count <= $get_record_count){
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link is-current" aria-label="Page 1" aria-current="page" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}">1</a></li>
  </ul>
EOD;
  }else if($all_count > $get_record_count and $all_count <= 2*$get_record_count){
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link is-current" aria-label="Page 1" aria-current="page" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}">1</a></li>
    <li><a class="pagination-link" aria-label="Goto page 2" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 2)}">2</a></li>
  </ul>
EOD;
  }else if($all_count > $get_record_count*2 and $all_count <= 3*$get_record_count){
$result .= <<<EOD
    <ul class="pagination-list">
      <li><a class="pagination-link is-current" aria-label="Page 1" aria-current="page" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}">1</a></li>
      <li><a class="pagination-link" aria-label="Goto page 2" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 2)}">2</a></li>
      <li><a class="pagination-link" aria-label="Goto page 3" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 3)}">3</a></li>
    </ul>
EOD;
  }else{
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link is-current" aria-label="Page 1" aria-current="page" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}">1</a></li>
    <li><a class="pagination-link" aria-label="Goto page 2" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 2)}">2</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page $last_page_num" href="{$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $last_page_num)}">$last_page_num</a></li>
  </ul>
EOD;
  }
}else if($page_num == 2){
  if($all_count > $get_record_count and $all_count <= 2*$get_record_count){
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link" aria-label="Goto page 1" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}>1</a></li>
    <li><a class="pagination-link is-current" aria-label="Page 2" aria-current="page" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 2)}>2</a></li>
  </ul>
EOD;
  }else if($all_count > $get_record_count*2 and $all_count <= 3*$get_record_count){
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link" aria-label="Goto page 1" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}>1</a></li>
    <li><a class="pagination-link is-current" aria-label="Page 2" aria-current="page" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 2)}>2</a></li>
    <li><a class="pagination-link" aria-label="Goto page 3" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 3)}>3</a></li>
  </ul>
EOD;
  }else{
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link" aria-label="Goto page 1" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}>1</a></li>
    <li><a class="pagination-link is-current" aria-label="Page 2" aria-current="page" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 2)}>2</a></li>
    <li><a class="pagination-link" aria-label="Goto page 3" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 3)}>3</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page $last_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $last_page_num)}>$last_page_num</a></li>
  </ul>
EOD;
  }
//}else if( $page_num >= 3 and $page_num <= ($last_page_num-2) ){
}else if( $page_num >= 3){
  if($page_num < ($last_page_num - 1) and $all_count > $get_record_count*2 and $all_count <= 3*$get_record_count){
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link" aria-label="Goto page 1" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}>1</a></li>
    <li><a class="pagination-link" aria-label="Goto page $before_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $before_page_num)}>$before_page_num</a></li>
    <li><a class="pagination-link is-current" aria-label="Page $page_num" aria-current="page" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $page_num)}>$page_num</a></li>
  </ul>
EOD;
  }else if($page_num < ($last_page_num - 1) and $all_count > $get_record_count*3 and $all_count <= 4*$get_record_count){
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link" aria-label="Goto page 1" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}>1</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page $before_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $before_page_num)}>$before_page_num</a></li>
    <li><a class="pagination-link is-current" aria-label="Page $page_num" aria-current="page" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $page_num)}>$page_num</a></li>
    <li><a class="pagination-link" aria-label="Goto page $after_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $after_page_num)}>$after_page_num</a></li>
  </ul>
EOD;
  }else if( $page_num == ($last_page_num-1) ){
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link" aria-label="Goto page 1" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}>1</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page $before_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $before_page_num)}>$before_page_num</a></li>
    <li><a class="pagination-link is-current" aria-label="Page $page_num" aria-current="page" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $page_num)}>$page_num</a></li>
    <li><a class="pagination-link" aria-label="Goto page $last_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $last_page_num)}>$last_page_num</a></li>
  </ul>
EOD;
  }else if( $page_num == $last_page_num ){
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link" aria-label="Goto page 1" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}>1</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page $before_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $before_page_num)}>$before_page_num</a></li>
    <li><a class="pagination-link is-current" aria-label="Page $page_num" aria-current="page" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $page_num)}>$page_num</a></li>
  </ul>
EOD;
  }else{
$result .= <<<EOD
  <ul class="pagination-list">
    <li><a class="pagination-link" aria-label="Goto page 1" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, 1)}>1</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page $before_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $before_page_num)}>$before_page_num</a></li>
    <li><a class="pagination-link is-current" aria-label="Page $page_num" aria-current="page" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $page_num)}>$page_num</a></li>
    <li><a class="pagination-link" aria-label="Goto page $after_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $after_page_num)}>$after_page_num</a></li>
    <li><span class="pagination-ellipsis">&hellip;</span></li>
    <li><a class="pagination-link" aria-label="Goto page $last_page_num" href={$paging->set_paging_url($_SERVER['SCRIPT_NAME'], $urlparams, $last_page_num)}>$last_page_num</a></li>
  </ul>
EOD;
  }
}
$result .= <<<EOD
</nav>
EOD;
return ($result);
}

function displayLevel($search_word, $all_count){
$result = <<<EOD
<nav class="level">
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">検索ワード</p>
      <p class="title">$search_word</p>
    </div>
  </div>
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">ヒット数</p>
      <p class="title">$all_count 件</p>
    </div>
  </div>
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">Good!</p>
      <p class="title">- 件</p>
    </div>
  </div>
  <div class="level-item has-text-centered">
    <div>
      <p class="heading">Bad..</p>
      <p class="title">- 件</p>
    </div>
  </div>
</nav>
EOD;
return $result;
}
?>
