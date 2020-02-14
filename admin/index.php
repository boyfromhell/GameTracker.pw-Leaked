<?php
session_start();
include_once("connect_db.php");


  //** Vazno
  if (empty($_COOKIE['sesija'])) {} else {
  $check = mysql_query("SELECT * FROM users WHERE sesija = '$_COOKIE[sesija]' AND userid = '$_COOKIE[userid]' AND username = '$_COOKIE[username]'");
  if (mysql_num_rows($check) == 0) { 
      header("location:/logout.php");
	  die();
  }
  $check = mysql_fetch_assoc($check);
  $user = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE userid = '$check[userid]'"));
  mysql_query("UPDATE users SET activity = '".time()."' WHERE userid = '$check[userid]'");
  }
  
   //lang
if($_COOKIE['language'] == "srb"){
    define("access", 1); 
	
   include("./languages/lang.srb.php");
} else if($_COOKIE['language'] == "en"){
   define("access", 1);


   include("./languages/lang.en.php");
} 

if($_COOKIE['language'] == ""){
    define("access", 1); 
	
   include("./languages/lang.srb.php");
}
  
  
  if($check['rank'] == "1" OR $check['rank'] == "2"){
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?> - MyGame AdminPanel</title>
<link href="/img/mygame.png" rel="shortcut icon" />
<link href="/admin/style.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.0/jquery.min.js" type="text/javascript"></script>
<script src="http://www.w3resource.com/twitter-bootstrap/twitter-bootstrap-v2/js/bootstrap-modal.js"></script>

</head>
<body>
<!--
Powered By SWIFT Panel (www.SwiftPanel.com)
Copyright @ 2009 All Rights Reservered.
-->
<div id="topbg"></div>
<div id="nav">
  <div id="home"><img style="max-height:50px;" src="/img/logo-gt.png"></div>
  <div id="left">
    <ul class="menutabs">
      <li class="home"><a href="/admin/index.php"><?php echo $lang['adm_pocetna']; ?></a></li>
      <li class="servers"><a href="/admin/servers"><?php echo $lang['adm_serveri']; ?></a></li>
	  <li class="users"><a href="/admin/memberlist"><?php echo $lang['adm_users']; ?></a></li>
	  <li class="communities"><a href="/admin/communities"><?php echo $lang['adm_comm']; ?></a></li>
    </ul>
  </div>
  <div id="right">
    <ul class="menutabs">
	  <li class="logout"><a href="/admin/admin_log">Admin Log</a></li>
	  <li class="logout"><a href="/admin/user_log">User Log</a></li>
	  <li class="logout"><a href="/admin/messages"><?php echo $lang['adm_poruke']; ?></a></li>
      <li class="account"><a href="/admin/member/<?php echo $user['username']; ?>"><?php echo $user['username']; ?></a></li>
      <li class="logout"><a href="/logout.php" title="Clients">Logout</a></li>
    </ul>
  </div>
</div>

<div class="sidebar-lang">
  <ul>
     
    <li <?php if($_COOKIE['language'] == "srb"){ ?> class="active" <?php } ?>>
            <a href="/process.php?task=lang&lang=srb">
                <img src="/ime/flags/RS.png" alt="" width="16" height="11" />
                Serbian 
			</a>
     </li>
    <li <?php if($_COOKIE['language'] == "en"){ ?> class="active" <?php } ?>>
            <a href="/process.php?task=lang&lang=en">
                <img src="/ime/flags/EN.png" alt="" width="16" height="11" />
                English
		    </a>
     </li>
	 
 </ul>
</div>

<div id="page">
  <div id="content">
  <div id="container">

	 <?php
     if(isset($_SESSION['ok'])){
	 $ok = $_SESSION['ok'];
	 echo "
	 <div id='infobox'><strong>OK!</strong> <br /> {$ok}</div>
	 ";
	 unset($_SESSION['ok']);
     } else {}
     if(isset($_SESSION['error'])){
  	 $greske = $_SESSION['error'];
	 echo "
	 <div id='infobox'><strong>Error!</strong> <br /> {$greske}</div>
	 ";	 unset($_SESSION['error']);
     } else {}
     ?>

   <?php
   define("access", 1);
   
   if($_GET['page'] == "servers"){
	   include("servers.php");
   } else if($_GET['page'] == "server_info"){
	   include("server_info.php");
   } else if($_GET['page'] == "banned_s"){
	   include("banned_s.php");
   } else if($_GET['page'] == "memberlist"){
	   include("memberlist.php");
   } else if($_GET['page'] == "member"){
	   include("member.php");
   } else if($_GET['page'] == "communities"){
	   include("communities.php");
   } else if($_GET['page'] == "community_info"){
	   include("community_info.php");
   } else if($_GET['page'] == "messages"){
	   include("messages.php");
   } else if($_GET['page'] == "message_info"){
	   include("message_info.php");
   } else if($_GET['page'] == "user_log"){
	   include("user_log.php");
   } else if($_GET['page'] == "admin_log"){
	   include("admin_log.php");
   }  else if($_GET['page'] == "news"){
	   include("news.php");
   } else {
	   include("main.php");
   }
   ?>

</div>
</div>
<div id="footer">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td class="left"></td>
    <td class="center"></td>
    <td class="right"></td>
  </tr>
</table>
</div>
</div>
<!--
Powered By SWIFT Panel (www.SwiftPanel.com)
Copyright @ 2009 All Rights Reservered.
-->
</body>
</html>

<script>
$(document).ready(function() {
    $(".tabs-menu a").click(function(event) {
        event.preventDefault();
        $(this).parent().addClass("current");
        $(this).parent().siblings().removeClass("current");
        var tab = $(this).attr("href");
        $(".tab-content").not(tab).css("display", "none");
        $(tab).fadeIn();
    });
});
</script>

  <?php } else {
	  header("location:/index.php");
	  die();
  } ?>