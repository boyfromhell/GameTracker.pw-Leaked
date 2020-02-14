<?php
defined("access") or die("Nedozvoljen pristup");

// vazno
			include_once ('function.php');

        	$p_id = (int) (!isset($_GET["p"]) ? 1 : $_GET["p"]);
    	    $limit = 20;
    	    $startpoint = ($p_id * $limit) - $limit;
			
            //to make pagination
			if($_GET['name']){
	        $statement = "`users` WHERE username LIKE '%$_GET[name]%'";
	        } else {
	        $statement = "`users`";
			}
			
	$br_clanova = mysql_num_rows(mysql_query("SELECT * FROM users"));
	$br_online = mysql_num_rows(mysql_query("SELECT * FROM users WHERE `activity` >= unix_timestamp(CURRENT_TIMESTAMP - INTERVAL 5 MINUTE)"));
	$pos_clan = mysql_fetch_array(mysql_query("SELECT * FROM users ORDER BY userid DESC LIMIT 1"));
	$br_online_danas = mysql_num_rows(mysql_query("SELECT * FROM users WHERE `activity` >= unix_timestamp(CURRENT_TIMESTAMP - INTERVAL 1 DAY)"));
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_users']; ?></h1></td>
  </tr>
</table>

<form method="post" action="/admin/adminprocess.php?task=search_u">
    <?php echo $lang['username']; ?>:
	<input type="search" value="<?php echo $_GET['name']; ?>" size="20" results="5" name="name">

	<input type="submit" name="pretrazi" value="<?php echo $lang['pretrazi']; ?>">
</form>

<br />

      <table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th></th>
	  <th></th>
	  <th><?php echo $lang['username']; ?></th>
	  <th><?php echo $lang['informacije']; ?></th>
	  <th><?php echo $lang['email']; ?></th>
	  <th>Status</th>
	  <th>Rank</th>
	  <th><?php echo $lang['poslednja_aktivnost']; ?></th>
          <th>UserIP</th>
	  </tr>
	     <?php
		 $s_q = mysql_query("SELECT * FROM {$statement} ORDER BY activity DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
		 while($k = mysql_Fetch_array($s_q)){
			 
		   $last_activity = time_ago($k['activity']);
		   if($last_activity == "45 years ago"){
			   $last_activity = "$lang[nema]";
		   }
		   
	$status = $k['activity'];
	$diff =  time() - $status;
	if($diff < 300){
	   $border = "<span style='color:green;'>Online</span>";
	} else { 
	   $border = "<span style='color:red;'>Offline</span>";
	}	

if($k['hidemail'] == "on"){
	$email = "$lang[skriven_e]";
} else {
	$email = "$k[email]";
}	

			if($k['rank'] == "1"){
			    $rank = "<span style='color:red;'>Administrator</span>";
			} else if($k['rank'] == "2"){
				$rank = "<span style='color:yellow;'>Moderator</span>";
			} else if($k['rank'] == "4"){
				$rank = "<span style='color:black;text-decoration: line-through;'>Banned</span>";
			} else {
				$rank = "Member";
			}
		   
		   echo "<tr> <td><img style='width:15px;height:15px;' src='/avatars/$k[avatar]'></td> <td>#$k[userid]</td> <td><a href='/admin/member/$k[username]'>$k[username]</a></td> <td>$k[ime] $k[prezime]</td> <td>$email</td> <td>$border</td> <td>$rank</td> <td>$last_activity</td> <td>$k[ip]</td> </tr>";
		 }
		 ?>
	   </table>
	   
<?php 
echo pagination($statement,$limit,$p_id); 
?>

<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_statistika']; ?></h1></td>
  </tr>
</table>

    <table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	<tr>
	
	<td width="30%" style="text-align:left;padding:5px;">
	<?php echo $lang['ukupno_clanova']; ?>: <b><?php echo $br_clanova; ?></b> <hr />
	<span><?php echo $lang['online_clanova']; ?>: <b><?php echo $br_online; ?></b></span> <hr />
	<span><?php echo $lang['poslednji_clan']; ?>: <b><a href="/admin/member/<?php echo $pos_clan['username']; ?>"> <?php echo $pos_clan['username']; ?></a></b></span> <hr />
	<span><?php echo $lang['danas_online']; ?>: <b><?php echo $br_online_danas; ?></b></span>
	</td>
	
	<td width="70%" valign="top" style="text-align:left;padding:5px;">
	<?php echo $lang['ukupno_je']; ?> <b><?php echo $br_online; ?></b> <?php echo $lang['online_text_2']; ?>.
   
    <div style="height:5px;"></div>
   
	<?php
	$on_lista = mysql_query("SELECT * FROM users WHERE `activity` >= unix_timestamp(CURRENT_TIMESTAMP - INTERVAL 5 MINUTE)");
	while($on = mysql_fetch_array($on_lista)){
	
	
	$rank = $on['rank'];
	if($rank == "0"){
	  $us_er = "<a title='Obican korisnik' style='font-weight:normal;' href='/admin/member/$on[username]'>#$on[username]</a>";
	} else if($rank == "1"){
      $us_er = "<a title='Administrator' style='color:red;' href='/admin/member/$on[username]'>#$on[username]</a>";
	} else if($rank == "2"){
	  $us_er = "<a title='Moderator' style='color:yellow;' href='/admin/member/$on[username]'>#$on[username]</a>";
	} else {}
	
	  echo "$us_er &nbsp;";
	}
	?>
	
	<div style="height:10px;"></div>
	
	<?php echo $lang['danas_je_posetilo']; ?> <b><?php echo $br_online_danas; ?></b> <?php echo $lang['adm_korisnika']; ?>.
	
	<div style="height:5px;"></div>
	
	<?php
	$on1_lista = mysql_query("SELECT * FROM users WHERE `activity` >= unix_timestamp(CURRENT_TIMESTAMP - INTERVAL 1 DAY)");
	while($on1 = mysql_fetch_array($on1_lista)){
	
	$rank = $on1['rank'];
	if($rank == "0"){
	  $us_er1 = "<a title='Obican korisnik' style='font-weight:normal;' href='/admin/member/$on1[username]'>#$on1[username]</a>";
	} else if($rank == "1"){
      $us_er1 = "<a title='Administrator' style='color:red;' href='/admin/member/$on1[username]'>#$on1[username]</a>";
	} else if($rank == "2"){
	  $us_er1 = "<a title='Moderator' style='color:yellow;' href='/admin/member/$on1[username]'>#$on1[username]</a>";
	} else {}
	
	  echo "$us_er1 &nbsp;";
	}
	?>
	
	</td>
	
	</tr>
	</table>