<?php
defined("access") or die("Nedozvoljen pristup");

// vazno
			include_once ('function.php');

        	$p_id = (int) (!isset($_GET["p"]) ? 1 : $_GET["p"]);
    	    $limit = 20;
    	    $startpoint = ($p_id * $limit) - $limit;
			
            //to make pagination
	        $statement = "`admin_logs`";
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1>Admin Log</h1></td>
  </tr>
</table>

<br />


	     <?php
		 $s_q = mysql_query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
		 while($k = mysql_Fetch_array($s_q)){
			 
             $time = time_ago($k['time']);
			 $type = $k['type'];
			 
			 if($type == "1"){
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_res_graph] $k[var2] <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "2"){
				  $server = mysql_Fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_zamrznut_rank] <a href='/admin/server_info/$server[ip]'>$server[hostname]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "3"){
				  $server = mysql_Fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_odmrznut_rank] <a href='/admin/server_info/$server[ip]'>$server[hostname]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "4"){
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_obrisao_server] <b>$k[var2]</b> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
				 
			 } else if($type == "5"){
				  $server = mysql_Fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_obrisan_shoutbox] <a href='/admin/server_info/$server[ip]'>$server[hostname]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "6"){
				  $server = mysql_Fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_editovan_srv] <a href='/admin/server_info/$server[ip]'>$server[hostname]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 }  else if($type == "7"){
				  $server = mysql_Fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_editovan_glavno] <a href='/admin/server_info/$server[ip]'>$server[hostname]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "8"){
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_banovan_ip] <b>$k[var1]</b> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
				 
			 } else if($type == "9"){
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_obrisan_ban] <b>$k[var1]</b> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
				 
			 }  else if($type == "10"){
				  $user = mysql_Fetch_array(mysql_query("SELECT * FROM users WHERE userid='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_banovan_korisnik] <a href='/admin/member/$user[username]'>$user[username]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 }  else if($type == "11"){
				  $user = mysql_Fetch_array(mysql_query("SELECT * FROM users WHERE userid='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_unbanovan_korisnik] <a href='/admin/member/$user[username]'>$user[username]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "12"){
				  $user = mysql_Fetch_array(mysql_query("SELECT * FROM users WHERE userid='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_obrisan_avatar] <a href='/admin/member/$user[username]'>$user[username]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "13"){
				  $user = mysql_Fetch_array(mysql_query("SELECT * FROM users WHERE userid='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_editovan_profil] <a href='/admin/member/$user[username]'>$user[username]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "14"){
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_obrisan_korisnik] <b>$k[var2]</b> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
				 
			 } else if($type == "15"){
				  $comm = mysql_Fetch_array(mysql_query("SELECT * FROM community WHERE id='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_editovan_comm] <a href='/admin/community_info/$comm[id]'>$comm[naziv]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 }  else if($type == "16"){
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_obrisan_comm] <b>$k[var2]</b> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
				 
			 } else if($type == "17"){
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_obrisane_poruke] <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
				 
			 } else if($type == "18"){
				  $poruka = mysql_Fetch_array(mysql_query("SELECT * FROM poruke WHERE id='$k[var1]'"));
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_obrisana_poruka] <b>$k[var2]</b> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "19"){
                  echo "<div style='padding:10px;' class='data'> <a href='/member/$k[author]'>$k[author]</a> $lang[pr_obrisani_logovi] <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
				 
			 }
			 
		 }
		 ?>
	   
<?php 
echo pagination($statement,$limit,$p_id); 
?>