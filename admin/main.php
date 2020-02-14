    <?php
	defined("access") or die("Nedozvoljen pristup");
	
	//stats
	$stats_users = mysql_num_rows(mysql_query("SELECT * FROM users"));
	$stats_servers = mysql_num_rows(mysql_query("SELECT * FROM servers"));
	$stats_players = mysql_num_rows(mysql_query("SELECT * FROM players"));
	$ukupno_z = mysql_num_rows(mysql_query("SELECT * FROM community"));

	?>
    
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_pocetna']; ?> <input style="float:right;" type="button" value="Obavestenja" onclick="window.location='/admin/news'" class="button blue" /></h1></td>
  </tr>
</table>


<table width="100%">
  <tr>
    <td width="25%" valign="top"><table width="100%" cellpadding="0" cellspacing="1" class="data">
        <tr>
          <td align="center" style="padding:10px;"><?php echo $lang['s_users']; ?> <br /> <strong><?php echo $stats_users; ?></strong></td>
        </tr>
      </table></td>
    <td width="25%" valign="top"><table width="100%" cellpadding="0" cellspacing="1" class="data">
        <tr>
          <td align="center" style="padding:10px;"><?php echo $lang['s_servers']; ?> <br /> <strong><?php echo $stats_servers; ?></strong></td>
        </tr>
      </table></td>
    <td width="25%" valign="top"><table width="100%" cellpadding="0" cellspacing="1" class="data">
        <tr>
          <td align="center" style="padding:10px;"><?php echo $lang['s_players']; ?> <br /> <strong><?php echo $stats_players; ?></strong></td>
        </tr>
      </table></td>
    <td width="25%" valign="top"><table width="100%" cellpadding="0" cellspacing="1" class="data">
        <tr>
          <td align="center" style="padding:10px;"><?php echo $lang['s_comm']; ?> <br /> <strong><?php echo $ukupno_z; ?></strong></td>
        </tr>
      </table></td>
  </tr>
</table>

<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_online_staff']; ?></h1></td>
  </tr>
</table>

<table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th></th>
	  <th><?php echo $lang['username']; ?></th>
	  <th><?php echo $lang['informacije']; ?></th>
	  <th><?php echo $lang['email']; ?></th>
	  <th>Status</th>
	  <th>Rank</th>
	  <th><?php echo $lang['poslednja_aktivnost']; ?></th>
	  </tr>
	  
	  	     <?php
		 $s_q = mysql_query("SELECT * FROM users WHERE rank='1' AND `activity` >= unix_timestamp(CURRENT_TIMESTAMP - INTERVAL 5 MINUTE) OR rank='2' AND `activity` >= unix_timestamp(CURRENT_TIMESTAMP - INTERVAL 5 MINUTE)") or die(mysql_error());
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
			} else {
				$rank = "Member";
			}
		   
		   echo "<tr> <td>#$k[userid]</td> <td><a href='/admin/member/$k[username]'>$k[username]</a></td> <td>$k[ime] $k[prezime]</td> <td>$email</td> <td>$border</td> <td>$rank</td> <td>$last_activity</td> </tr>";
		 }
		 ?>
</table>

<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_poslednji_kor']; ?></h1></td>
  </tr>
</table>

<table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th></th>
	  <th><?php echo $lang['username']; ?></th>
	  <th><?php echo $lang['informacije']; ?></th>
	  <th><?php echo $lang['email']; ?></th>
	  <th>Status</th>
	  <th>Rank</th>
	  <th><?php echo $lang['poslednja_aktivnost']; ?></th>
	  </tr>
	  
	  	     <?php
		 $s_q = mysql_query("SELECT * FROM users ORDER BY userid DESC LIMIT 5") or die(mysql_error());
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
			} else {
				$rank = "Member";
			}
		   
		   echo "<tr> <td>#$k[userid]</td> <td><a href='/admin/member/$k[username]'>$k[username]</a></td> <td>$k[ime] $k[prezime]</td> <td>$email</td> <td>$border</td> <td>$rank</td> <td>$last_activity</td> </tr>";
		 }
		 ?>
</table>

<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_poslednji_srv']; ?></h1></td>
  </tr>
</table>

<table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th>Rank</th>
	  <th><?php echo $lang['igra']; ?></th>
	  <th><?php echo $lang['ime_s']; ?></th>
	  <th><?php echo $lang['igraci_s']; ?></th>
	  <th>IP</th>
	  <th><?php echo $lang['mod']; ?></th>
	  <th><?php echo $lang['lokacija']; ?></th>
	  <th><?php echo $lang['mapa']; ?></th>
	  </tr>
	  
	  <?php
	  $s_q = mysql_query("SELECT * FROM servers ORDER BY id DESC LIMIT 5") or die(mysql_error());
	  while($k = mysql_Fetch_array($s_q)){
			
	  $naziv = $k['hostname'];
      if(strlen($naziv) > 50){ 
          $naziv = substr($naziv,0,50); 
          $naziv .= "..."; 
      }
	 			
			
		   echo "<tr> <td>$k[rank].</td> <td><img style='width:16px;height:16px;' src='/ime/games/game-$k[game].png'></td> <td style='text-align:left;'><a href='/admin/server_info/$k[ip]'>$naziv</a></td> <td>$k[num_players]/$k[max_players]</td> <td>$k[ip]</td> <td>$k[gamemod]</td> <td><img style='width:22px;height:16px;' src='/ime/flags/$k[location].png'></td> <td>$k[mapname]</td> </tr>";
		 }
	  ?>
</table>

<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_poslednji_zaj']; ?></h1></td>
  </tr>
</table>

<table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th></th>
	  <th><?php echo $lang['ime_zajednice']; ?></th>
	  <th><?php echo $lang['br_servera_z']; ?></th>
	  <th><?php echo $lang['igraci_s']; ?></th>
	  <th><?php echo $lang['sajt_forum']; ?></th>
	  <th><?php echo $lang['vlasnik']; ?></th>
	  </tr>
	  
	   <?php
		 $i = 0;
		 $s_q = mysql_query("SELECT * FROM community ORDER BY id DESC LIMIT 5") or die(mysql_error());
		 while($k = mysql_Fetch_array($s_q)){
		
         $i++;
		 
	$naziv = $k['naziv'];
    if(strlen($naziv) > 50){ 
          $naziv = substr($naziv,0,50); 
          $naziv .= "..."; 
     }
	 
 $sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `servers`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$k[id]}')";

 $tmp = mysql_fetch_assoc( mysql_query( $sql ) );
 
 $sql_new = mysql_query("SELECT * FROM community_servers WHERE comid='{$k[id]}'");
 $sql_num = mysql_num_rows($sql_new);
 $broj_igraca = $tmp['suma_igraca'];
 $max_igraca = $tmp['max_igraca'];
 if($broj_igraca == ""){ $broj_igraca = "0"; } else {} 
 if($max_igraca == ""){ $max_igraca = "0"; } else {} 

	 	
 echo "<tr> <td>$i.</td> <td><a href='/admin/community_info/$k[id]'>$naziv</a></td> <td>$sql_num</td> <td>$broj_igraca/$max_igraca</td> <td><a target='_blank' href='http://$k[forum]'>$k[forum]</a></td> <td><a href='/admin/member/$k[owner]'>$k[owner]</a></td></tr>";
		 }
		 ?>
	   </table>
	  
</table>