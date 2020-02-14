<?php
session_start();
include_once ("connect_db.php");

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

//
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
  
  if($check['rank'] == "1" OR $check['rank'] == "2"){
	  
   if($check['username'] == "demo"){
	   $_SESSION['error'] = 'Nemate dozvolu';
	   header("location:/admin/index.php");
	   die();
   }

if (isset($_GET['task']) && $_GET['task'] == "search_s") {
    $hostname = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['hostname'])));
	$ip = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['ip'])));
	$game = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['game'])));
	$location = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['location'])));
	$mod = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mod'])));
	
	header("location:/admin/servers/&hostname=$hostname&ip=$ip&game=$game&location=$location&mod=$mod");
} else if (isset($_GET['task']) && $_GET['task'] == "restartuj_grafik") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[servernepostoji]";
		header("location:/admin/servers/");
		die();
	}
	
	$game = $info['game'];
	if($user['rank'] == "1"){
	  if($game == "cs16" OR $game == "css" OR $game == "csgo" OR $game == "cod2" OR $game == "cod4" OR $game == "tf2"){
	  $playercount_hour = "00,00,00,00,00,00,00,00,00,00,00,00";
      } else if($game == "minecraft" OR $game == "samp" OR $game == "teamspeak3"){
	  $playercount_hour = "0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000,0000";
      }
	   
	  mysql_query("UPDATE servers SET playercount_hour='$playercount_hour' WHERE id='$info[id]'");
      mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[ip]','','$_COOKIE[username]','$time','1')");
	  $_SESSION['ok'] = "$lang[adm_process_resg]";
	  header("location:/admin/server_info/$info[ip]");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
		header("location:/admin/server_info/$info[ip]");
		die();
	}
}  else if (isset($_GET['task']) && $_GET['task'] == "zamrzni_rank") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[servernepostoji]";
		header("location:/admin/servers/");
		die();
	}
	
	if($user['rank'] == "1"){
	  mysql_query("UPDATE servers SET rank='99999' WHERE id='$info[id]'");
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[ip]','','$_COOKIE[username]','$_COOKIE[userid]','$time','2')");
	  $_SESSION['ok'] = "$lang[adm_process_zamrzni]";
	  header("location:/admin/server_info/$info[ip]");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
		header("location:/admin/server_info/$info[ip]");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "odmrzni_rank") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[servernepostoji]";
		header("location:/admin/servers/");
		die();
	}
	
	if($user['rank'] == "1"){
	  mysql_query("UPDATE servers SET rank='99998' WHERE id='$info[id]'");
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[ip]','','$_COOKIE[username]','$_COOKIE[userid]','$time','3')");
	  $_SESSION['ok'] = "$lang[adm_process_odmrznut]";
	  header("location:/admin/server_info/$info[ip]");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
		header("location:/admin/server_info/$info[ip]");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_server") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[servernepostoji]";
		header("location:/admin/servers/");
		die();
	}
	
	if($user['rank'] == "1"){
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[ip]','$info[hostname]','$_COOKIE[username]','$_COOKIE[userid]','$time','4')");
 
	  mysql_query("DELETE FROM servers WHERE id='$id'");
	  mysql_query("DELETE FROM community_servers WHERE srvid='$id'");
	  mysql_query("DELETE FROM maps WHERE sid='$id'");
	  mysql_query("DELETE FROM obavestenja WHERE var='$id' AND type='1'");
	  mysql_query("DELETE FROM players WHERE sid='$id'");
	  mysql_query("DELETE FROM profile_log WHERE var3='$id' AND type='2'");
	  mysql_query("DELETE FROM shoutbox_s WHERE sid='$id'");
	  $_SESSION['ok'] = "$lang[adm_server_obrisan]";
	  header("location:/admin/server_info/$info[ip]");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
		header("location:/admin/server_info/$info[ip]");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_shoutbox") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[servernepostoji]";
		header("location:/admin/servers/");
		die();
	}
	
	if($user['rank'] == "1" OR $user['rank'] == "2"){
	  mysql_query("DELETE FROM obavestenja WHERE var='$id' AND type='1'");
	  mysql_query("DELETE FROM profile_log WHERE var3='$id' AND type='2'");
	  mysql_query("DELETE FROM shoutbox_s WHERE sid='$id'");
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[ip]','','$_COOKIE[username]','$_COOKIE[userid]','$time','5')");
	  $_SESSION['ok'] = "$lang[adm_shoutbox_obrisan]";
	  header("location:/admin/server_info/$info[ip]");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
		header("location:/admin/server_info/$info[ip]");
		die();
	}
} else if(isset($_GET['task']) && $_GET['task'] == "edit_server"){
	$sid = addslashes($_POST['sid']);
	$forum = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['forum'])));
	$game = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['game'])));
	$location = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['location'])));
	$mod = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['mod'])));
	$time = time();
	
	$test = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$sid'"));
	
	if($test['id'] == ""){
		header("location:/admin/servers/");
		die();
	}
	
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}

    if($user['rank'] == "1" OR $user['rank'] == "2"){
		mysql_query("UPDATE servers SET forum='$forum',game='$game',location='$location',gamemod='$mod' WHERE id='$sid'");
		mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$test[ip]','','$_COOKIE[username]','$_COOKIE[userid]','$time','6')");
		header("location:/admin/server_info/$test[ip]");
		$_SESSION['ok'] = "$lang[uspesno]";
	} else {
		header("location:/admin/server_info/$test[ip]");
		die();
	}
	
} else if (isset($_GET['task']) && $_GET['task'] == "server-admin-edit") {
   $id = addslashes($_POST['id']);
   $rank_pts = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['rank_pts'])));
   $playercount = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['playercount'])));
   $playercount_week = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['playercount_week'])));
   $playercount_6h = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['playercount_6h'])));
   $playercount_month = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['playercount_month'])));
   $playercount_hour = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['playercount_hour']))); 
   $time = time();
   
   
   $info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$id' "));
   
   	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}
   
   if($info['id'] == ""){
      $_SESSION['error'] = "$lang[servernepostoji]";
	  header("location:/index.php");
	  die();
   }
 
   if($user['rank'] == "1"){
    mysql_query("UPDATE servers SET rank_pts='$rank_pts',playercount='$playercount',playercount_week='$playercount_week',playercount_6h='$playercount_6h',playercount_month='$playercount_month',playercount_hour='$playercount_hour' WHERE id='$id' ");
	mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[ip]','','$_COOKIE[username]','$_COOKIE[userid]','$time','7')");
	header("location:./server_info/$info[ip]");
 	$_SESSION['ok'] = "$lang[uspesno]";
    } else {
     $_SESSION['error'] = "$lang[nemate_pristup]";
	 header("location:/index.php");
	 die();
   }
} else if (isset($_GET['task']) && $_GET['task'] == "banuj_ip") {
   $ip = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['ip'])));
   $razlog = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['razlog'])));
   $author = $_COOKIE['username'];
   $authorid = $_COOKIE['userid'];
   $time = time();
   $type = addslashes($_POST['type']);
   
   	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}   

 
   if($user['rank'] == "1"){
    mysql_query("INSERT INTO b_servers (ip,razlog,author,authorid,time,type) VALUES ('$ip','$razlog','$author','$authorid','$time','$type')") or die(mysql_error());
	mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$ip','','$_COOKIE[username]','$_COOKIE[userid]','$time','8')");
    header("location:./banned/servers");
 	$_SESSION['ok'] = "$lang[uspesno]";
    } else {
     $_SESSION['error'] = "$lang[nemate_pristup]";
	 header("location:/admin/banned/servers");
	 die();
   }
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_ban") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM b_servers WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[ban_nepostoji]";
		header("location:/admin/banned/servers");
		die();
	}
	
	if($user['rank'] == "1"){
	  mysql_query("DELETE FROM b_servers WHERE id='$id'");
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[ip]','','$_COOKIE[username]','$_COOKIE[userid]','$time','9')");
	  $_SESSION['ok'] = "$lang[adm_ban_obrisan]";
	  header("location:/admin/banned/servers");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	    header("location:/admin/banned/servers");
		die();
	}
}  else if (isset($_GET['task']) && $_GET['task'] == "obrisi_obv") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM acp_obavestenja WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[ban_nepostoji]";
		header("location:/admin/news");
		die();
	}
	
	if($user['rank'] == "1" OR $user['rank'] == "2"){
	  mysql_query("DELETE FROM acp_obavestenja WHERE id='$id'");
	  $_SESSION['ok'] = "$lang[adm_ban_obrisan]";
	  header("location:/admin/news");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	    header("location:/admin/news");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "search_u") {
    $name = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['name'])));
	
	header("location:/admin/?page=memberlist&name=$name");
} else if (isset($_GET['task']) && $_GET['task'] == "banuj_korisnika") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$id'"));
	
	if($info['userid'] == ""){
		$_SESSION['error'] = "$lang[korisniknepostoji]";
		header("location:/admin/memberlist");
		die();
	}

        if($info['rank'] == "1"){
		$_SESSION['error'] = "Error adminban";
		header("location:/admin/member/$info[username]");
		die();
        }
	
	if($user['rank'] == "1"){
	  mysql_query("UPDATE users SET ban='1',rank='4' WHERE userid='$id'");
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[userid]','','$_COOKIE[username]','$_COOKIE[userid]','$time','10')");
	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/admin/member/$info[username]");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	    header("location:/admin/member/$info[username]");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "unbanuj_korisnika") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$id'"));
	
	if($info['userid'] == ""){
		$_SESSION['error'] = "$lang[korisniknepostoji]";
		header("location:/admin/memberlist");
		die();
	}

        if($info['rank'] == "1"){
		$_SESSION['error'] = "Error adminban";
		header("location:/admin/member/$info[username]");
		die();
        }
	
	if($user['rank'] == "1"){
	  mysql_query("UPDATE users SET ban='0',rank='0' WHERE userid='$id'");
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[userid]','','$_COOKIE[username]','$_COOKIE[userid]','$time','11')");
	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/admin/member/$info[username]");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	    header("location:/admin/member/$info[username]");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_avatar") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$id'"));
	
	if($info['userid'] == ""){
		$_SESSION['error'] = "$lang[korisniknepostoji]";
		header("location:/admin/memberlist");
		die();
	}
	
	if($user['rank'] == "1" OR $user['rank'] == "2"){
	    $filename = "/avatars/$info[avatar]";
        mysql_query("UPDATE users SET avatar='nopic.png' WHERE userid='$id'");
		mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[userid]','','$_COOKIE[username]','$_COOKIE[userid]','$time','12')");
        header("location:/admin/member/$info[username]");
		$_SESSION['ok'] = "$lang[uspesno]";
	    unlink($filename);
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	    header("location:/admin/member/$info[username]");
		die();
	}
}  else if (isset($_GET['task']) && $_GET['task'] == "profil") {
    $ime = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['ime'])));
	$prezime = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['prezime'])));
	$email = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['email'])));
	$rank = htmlspecialchars(addslashes(mysql_real_escape_string($_POST['rank'])));
	$oldpass = md5(htmlspecialchars(addslashes(mysql_real_escape_string($_POST['oldpass']))));
	$password = md5(htmlspecialchars(addslashes(mysql_real_escape_string($_POST['password']))));
	$userid = addslashes($_POST['userid']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$userid'"));
	
	if($oldpass == ""|$password == ""){} else if($oldpass == $info['password']){
	  mysql_query("UPDATE users SET password='$password' WHERE userid='$info[userid]'");
	  header("location:/admin/member/$info[username]");
	  $_SESSION['ok'] = "$lang[uspesno]";
	} else {}
	
	
	if($user['rank'] == "1"){
	mysql_query("UPDATE users SET ime='$ime',prezime='$prezime',email='$email',rank='$rank' WHERE userid='$info[userid]' ");
	mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[userid]','','$_COOKIE[username]','$_COOKIE[userid]','$time','13')");
	header("location:/admin/member/$info[username]");
 	$_SESSION['ok'] = "$lang[uspesno]";
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	    header("location:/admin/member/$info[username]");
		die();
	}
	
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_korisnika") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$id'"));
	
	if($info['userid'] == ""){
		$_SESSION['error'] = "$lang[korisniknepostoji]";
		header("location:/admin/memberlist");
		die();
	}

        if($info['rank'] == "1"){
		$_SESSION['error'] = "Error admindel";
		header("location:/admin/member/$info[username]");
		die();
        }
	
	if($user['rank'] == "1"){
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[userid]','$info[username]','$_COOKIE[username]','$_COOKIE[userid]','$time','14')");

      mysql_query("DELETE FROM users WHERE userid='$id'");
	  mysql_query("DELETE FROM zahtevi WHERE od='$id' OR za='$id'");
	  mysql_query("DELETE FROM authorid WHERE authorid='$id'");
	  mysql_query("DELETE FROM profile_visits WHERE visitorid='$id'");
	  mysql_query("DELETE FROM profile_log WHERE userid='$id'");
	  mysql_query("DELETE FROM profile_feed WHERE userid='$id'");
	  mysql_query("DELETE FROM poruke WHERE za='$id' OR od='$id'");
	  mysql_query("DELETE FROM poruke WHERE nza='$id' OR nod='$id'");
	  mysql_query("DELETE FROM messages_answers WHERE authorid='$id'");
	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/admin/member/$info[username]");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
		header("location:/admin/member/$info[username]");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "search_c") {
    $name = htmlspecialchars(mysql_real_escape_string(addslashes($_POST['name'])));
	
	header("location:/admin/?page=communities&name=$name");
} else if (isset($_GET['task']) && $_GET['task'] == "edit_community") {
  $id = $_POST['id'];
  $naziv = mysql_real_escape_string(addslashes($_POST['naziv']));
  $forum = mysql_real_escape_string(addslashes($_POST['forum']));
  $opis = mysql_real_escape_string(addslashes($_POST['opis']));
  $time = time();
  
  $info = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));
  
  if($info['id'] == ""){
    $_SESSION['error'] = "$lang[zajednicanepostoji]";
	header("location:/index.php");
	die();
  }
  
	if($_COOKIE['userid'] == "" OR $_COOKIE['username'] == ""){
		$_SESSION['error'] = "$lang[prijavitese]";
		header("location:/login");
		die();
	}  

  if($user['rank'] == "1" OR $user['rank'] == "2"){
   mysql_query("UPDATE community SET naziv='$naziv',forum='$forum',opis='$opis' WHERE id='$id'");
   mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[id]','','$_COOKIE[username]','$_COOKIE[userid]','$time','15')");
   $_SESSION['ok'] = "$lang[uspesno]";
   header("location:/admin/community_info/$id");
  } else {
   $_SESSION['error'] = "$lang[sva_polja]";
   header("location:/admin/community_info/$id");
   die();
  }
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_zajednicu") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[zajednicanepostoji]";
		header("location:/admin/communities");
		die();
	}
	
	if($user['rank'] == "1"){
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[id]','$info[naziv]','$_COOKIE[username]','$_COOKIE[userid]','$time','16')");

	  mysql_query("DELETE FROM community WHERE id='$id'");
	  mysql_query("DELETE FROM community_servers WHERE srvid='$id'");
	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/admin/community_info/$id");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	     header("location:/admin/community_info/$id");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_poruke") {
	$time = time();
	
	if($user['rank'] == "1"){
	  mysql_query("DELETE FROM messages");
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('','','$_COOKIE[username]','$_COOKIE[userid]','$time','17')");
	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/admin/messages");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	    header("location:/admin/messages");
		die();
	}
}  else if (isset($_GET['task']) && $_GET['task'] == "obrisi_poruku") {
	$id = addslashes($_GET['id']);
	$time = time();
	
	$info = mysql_fetch_array(mysql_query("SELECT * FROM poruke WHERE id='$id'"));
	
	if($info['id'] == ""){
		$_SESSION['error'] = "$lang[poruka_nepostoji]";
		header("location:/admin/messages");
		die();
	}
	
	if($user['rank'] == "1"){
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('$info[id]','$info[title]','$_COOKIE[username]','$_COOKIE[userid]','$time','18')");

   	  mysql_query("DELETE FROM poruke WHERE id='$id'");
	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/admin/message_info/$id");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	    header("location:/admin/messages");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "obrisi_logove") {
	$time = time();
	
	if($user['rank'] == "1"){
	  mysql_query("DELETE FROM profile_log");
	  mysql_query("INSERT INTO admin_logs (var1,var2,author,authorid,time,type) VALUES ('','','$_COOKIE[username]','$_COOKIE[userid]','$time','19')");
	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/admin/user_log");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	  header("location:/admin/user_log");
		die();
	}
} else if (isset($_GET['task']) && $_GET['task'] == "dodaj_vest") {
	$title = addslashes(htmlspecialchars($_POST['title']));
	$text = addslashes(htmlspecialchars($_POST['text']));
	$author = $user['username'];
	$time = time();
	
	if(empty($title) OR empty($text)){
		header("Location:/admin/news");
		die();
	}
	
	if($user['rank'] == "1" OR $user['rank'] == "2"){
	  mysql_query("INSERT INTO acp_obavestenja (title,text,author,time) VALUES ('$title','$text','$author','$time')") or die(mysql_error());

	  $_SESSION['ok'] = "$lang[uspesno]";
	  header("location:/admin/news");
	
	} else {
		$_SESSION['error'] = "$lang[nemate_pristup]";
	    header("location:/admin/news");
		die();
	}
	
	
}


  } else {
	  $_SESSION['error'] = "Error";
	  header("location:/index.php");
	  die();
  }
?>