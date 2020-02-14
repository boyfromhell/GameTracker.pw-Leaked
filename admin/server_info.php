<?php
defined("access") or die("Nedozvoljen pristup");

$ip			= addslashes($_GET['ip']);

$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));

if($info['id'] == ""){
die("<script> alert('$lang[servernepostoji]'); document.location.href='/admin/servers/'; </script>");
}

// igra
$igra = $info['game'];
if($igra == "cs16"){
	$igra = "Counter Strike 1.6";
} else if($igra == "css"){
	$igra = "Counter Strike Source";
} else if($igra == "csgo"){
	$igra = "Counter Strike Global Offensive";
} else if($igra == "cod2"){
	$igra = "Call Of Duty 2";
} else if($igra == "cod4"){
	$igra = "Call Of Duty 4";
} else if($igra == "minecraft"){
	$igra = "MineCraft";
} else if($igra == "samp"){
	$igra = "San Andreas Multiplayer";
} else if($igra == "tf2"){
	$igra = "Team Fortress 2";
} else if($igra == "teamspeak3"){
	$igra = "TeamSpeak 3";
}

// online
$online = $info['online'];
if($online == "1"){
	$online = "<span style='color:green'>Online</span>";
} else {
	$online = "<span style='color:red'>Offline</span>";
}

// Vlasnik
$owner = $info['owner'];
if($owner == ""){
  $owner = "$lang[nema] <a href='/process/ownership/$ip'>[ $lang[potvrdi_v] ]</a>";
} else {
  $owner = "<a href='/member/$info[owner]'>$info[owner]</a> <a href='/process/ownership/$ip'>[ $lang[potvrdi_v] ]</a>";
}

// Forum
$forum = $info['forum'];

if($forum == "Nema"){
  $forum = "$lang[nema]";
} else {
  $forum = "<a href='http://$forum' target='_blank'>$info[forum]</a>";
}

// Prosek
$players = $info['playercount'];
  
$niz24 = explode(',' , $players);

$niz1 = substr($players , 12);
$niz12 = explode(',' , $niz1);

$suma = array_sum( $niz24 );
$suma1 = array_sum( $niz12 );

$prosek = round($suma / count( $niz24 ), 2);
$prosek12 = round($suma1 / count( $niz12 ), 2);

// Naziv
$naziv = $info['hostname'];
  if(strlen($naziv) > 50){ 
          $naziv = substr($naziv,0,50); 
          $naziv .= "..."; 
     }
	 
	 
// mapimg
	 if (file_exists("ime/maps/".$info['mapname'].".jpg")){ 
	 $mapimg = "<img style='width:145px;height:108px;' src='/ime/maps/$info[mapname].jpg'>"; 
	 } else {
	 $mapimg = "<img src='/ime/mapbg.png'>";	 
	 } 
	 
	 
	 $ph = substr($info['playercount_hour'], 0, 1);
     if($ph == ","){
		 $bug = "<img title='$info[playercount_hour]'  src='/admin/images/buttons/yellow.png'> ";
	 } else {
		 $bug = "<img title='$info[playercount_hour]'  src='/admin/images/buttons/green.png'> ";
	 }	
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1> <img style='width:15px;height:15px;' src='/ime/games/game-<?php echo $info['game']; ?>.png'> <img style='width:15px;height:15px;' src='/ime/flags/<?php echo $info['location']; ?>.png'> <?php echo $info['hostname']; ?>  <span style="float:right;"><?php echo $bug; ?></span></h1></td>
  </tr>
</table>


<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">
	  <a  data-toggle="modal" href="#informacije-opste"><input type="button" value="Izmeni Informacije" class="button blue restart" /></a>
	  <?php if($user['rank'] == "1"){ ?> <input type="button" value="Obrisi server" onclick="window.location='/admin/adminprocess.php?task=obrisi_server&id=<?php echo $info['id']; ?>'" class="button red stop" /> <?php } ?>
	  </td>
    <td align="right">
	<?php if($user['rank'] == "1"){ if($info['rank'] == "99999"){ ?> <input type="button" value="Odmrzni Rank" onclick="window.location='/admin/adminprocess.php?task=odmrzni_rank&id=<?php echo $info['id']; ?>'" class="button blue" /> <?php } else { ?> <input type="button" value="Zamrzni Rank" onclick="window.location='/admin/adminprocess.php?task=zamrzni_rank&id=<?php echo $info['id']; ?>'" class="button blue" /> <?php } } ?>
	<?php if($user['rank'] == "1"){ ?> <input type="button" value="Restartuj grafik" onclick="window.location='/admin/adminprocess.php?task=restartuj_grafik&id=<?php echo $info['id']; ?>'" class="button blue" /> <?php } ?>
	<?php if($user['rank'] == "1"){ ?> <a data-toggle="modal" href="#informacije-admin"> <input type="button" value="Ostale Informacije" class="button blue"> </a> <?php } ?>
	<input type="button" value="Obrisi ceo Shoutbox" onclick="window.location='/admin/adminprocess.php?task=obrisi_shoutbox&id=<?php echo $info['id']; ?>'" class="button blue" /></td>
  </tr>
</table>

<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="50%" valign="top"><fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" class="fieldheader"><?php echo $lang['opste_i']; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;width:110px;"><?php echo $lang['igra']; ?></td>
          <td class="fieldarea"><?php echo $igra; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['ime_s']; ?></td>
          <td class="fieldarea"><?php echo $naziv; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['mod']; ?></td>
          <td class="fieldarea"><?php echo $info['gamemod']; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;">Status</td>
          <td class="fieldarea"><b><?php echo $online; ?></b></td>
        </tr>
		<tr>
		  <td class="fieldname" style="height:20px;">IP</td>
		  <td class="fieldarea"><?php echo $info['ip']; ?></td>
		</tr>
		<tr>
		  <td class="fieldname" style="height:20px;"><?php echo $lang['dodao']; ?></td>
		  <td class="fieldarea"><a href="/member/<?php echo $info['added']; ?>"><?php echo $info['added']; ?></a></td>
		</tr>
		<tr>
		  <td class="fieldname" style="height:20px;"><?php echo $lang['vlasnik']; ?></td>
		  <td class="fieldarea"><?php echo $owner; ?></td>
		</tr>
		<tr>
		  <td class="fieldname" style="height:20px;"><?php echo $lang['forum']; ?></td>
		  <td class="fieldarea"><?php echo $forum; ?></td>
		</tr>
      </table>
      </fieldset>
      <fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
         <tr>
          <td colspan="2" class="fieldheader"><?php echo $lang['info_igraci']; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;width:150px;"><?php echo $lang['igraci_s']; ?></td>
          <td class="fieldarea"><?php echo "$info[num_players]/$info[max_players]"; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['prosek_12']; ?></td>
          <td class="fieldarea"><?php echo $prosek12; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['prosek_24']; ?></td>
          <td class="fieldarea"><?php echo $prosek; ?></td>
        </tr>
      </table>
      </fieldset>
      <fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
         <tr>
          <td colspan="2" class="fieldheader"><?php echo $lang['rank_servera_t']; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;width:150px;">Rank</td>
          <td class="fieldarea"><?php if($info['rank'] == "99999"){ echo "<span style='color:red;'><b>$lang[rank_zamrznut]</b><span>"; } else { echo $info['rank']; } ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['best_rank']; ?></td>
          <td class="fieldarea"><?php echo $info['best_rank']; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['worst_rank']; ?></td>
          <td class="fieldarea"><?php echo $info['worst_rank']; ?></td>
        </tr>
      </table>
      </fieldset>
      </td>
    <td width="50%" valign="top">
      <fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
         <tr>
          <td colspan="2" class="fieldheader">
		  <?php echo $lang['igraci_s']; ?>
		  
		<ul style="float:right;" class="tabs-menu">
        <li class="current"><a href="#dnevni_graph"><?php echo $lang['dnevni']; ?></a></li>
        <li><a href="#nedeljni_graph"><?php echo $lang['nedeljni']; ?></a></li>
        <li><a href="#mesecni_graph"><?php echo $lang['mesecni']; ?></a></li>
        </ul>
		  </td>
        </tr>
        <tr>
          <td class="fieldarea">
		   <div class="tab">
           <div id="dnevni_graph" class="tab-content">
               <img src="http://chart.apis.google.com/chart?chf=bg,s,ffffff,18&chxl=0:<?php echo $info['chart_updates']; ?>&chxr=0,0,24|1,0,<?php echo $info['max_players']; ?>&chxs=0,FF7300,9,0,lt|1,FF7300,9,1,lt&chxt=x,y&chs=410x170&cht=lc&chco=FF7300&chds=0,<?php echo $info['max_players']; ?>&chd=t:<?php echo $info['playercount']; ?>&chdlp=l&chg=0,-1,0,0&chls=2&chma=10,10,10,10">
           </div>
           <div id="nedeljni_graph" class="tab-content">
               <img src="http://chart.apis.google.com/chart?chf=bg,s,ffffff,18&chxl=0:<?php echo $info['chart_week']; ?>&chxr=0,0,7|1,0,<?php echo $info['max_players']; ?>&chxs=0,FF7300,9,0,lt|1,FF7300,9,1,lt&chxt=x,y&chs=410x170&cht=lc&chco=FF7300&chds=0,<?php echo $info['max_players']; ?>&chd=t:<?php echo $info['playercount_week']; ?>&chdlp=l&chg=0,-1,0,0&chls=2&chma=10,10,10,10">
           </div>
           <div id="mesecni_graph" class="tab-content">
               <img src="http://chart.apis.google.com/chart?chf=bg,s,ffffff,18&chxl=0:<?php echo $info['chart_month']; ?>&chxr=0,0,7|1,0,<?php echo $info['max_players']; ?>&chxs=0,FF7300,9,0,lt|1,FF7300,9,1,lt&chxt=x,y&chs=410x170&cht=lc&chco=FF7300&chds=0,<?php echo $info['max_players']; ?>&chd=t:<?php echo $info['playercount_month']; ?>&chdlp=l&chg=0,-1,0,0&chls=2&chma=10,10,10,10">
           </div>
           </div>   
		  </td>
        </tr>
      </table>
      </fieldset>
      <fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
         <tr>
          <td colspan="2" class="fieldheader">
		  ShoutBox
		  </td>
        </tr>
        <tr>
          <td class="fieldarea">
		   <?php
  $sm = mysql_query("SELECT * FROM shoutbox_s WHERE sid='$info[id]' ORDER BY id DESC LIMIT 7");
  if(mysql_num_rows($sm) < 1){
	  echo "<div class='message_shout'><span>$lang[nemarezultata]</span><br /></div>";
  } else {
	 while($s = mysql_fetch_array($sm)){
     $time = time_ago($s['time']);
	 $s_user = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$s[author]'"));
	 
	  echo " 
	  <a href='/member/$s[author]'>$s[author]</a> 
	  <small>$s[message]</small>
      <div style='height:4px;'></div>";	 
	 } 
	  
  }
  ?>
		  </td>
        </tr>
      </table>
      </fieldset>
      <fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
         <tr>
          <td colspan="2" class="fieldheader">
		  <?php echo $lang['prijave_servera']; ?>
		  </td>
        </tr>
        <tr>
          <td class="fieldarea">
		   <?php
  $sme = mysql_query("SELECT * FROM prijave_s WHERE sid='$info[id]' ORDER BY id DESC LIMIT 7");
  if(mysql_num_rows($sme) < 1){
	  echo "<div class='message_shout'><span>$lang[nemarezultata]</span><br /></div>";
  } else {
	 while($se = mysql_fetch_array($sme)){
     $time = time_ago($se['time']);
	 
	  echo " 
	  <a href='/member/$se[author]'>$se[author]</a> -  
	  <small>$se[razlog]</small> - <small>$se[napomena]</small>  <span style='float:right;'><small>$time</small></span>
      <div style='height:4px;'></div>";	 
	 } 
	  
  }
  ?>
		  </td>
        </tr>
      </table>
      </fieldset>
     </td>

  </tr>
</table>

  <br />
  
  	  <table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th>ID</th>
	  <th><?php echo $lang['nick']; ?></th>
	  <th><?php echo $lang['vreme']; ?></th>
	  <th><?php echo $lang['ubistva']; ?></th>
	  </tr>
<?php
 $nk = mysql_query("SELECT * FROM players WHERE sid='$info[id]'");
 $pbr = mysql_num_rows($nk);
 
 if($pbr < 1){ 
   echo "<tr> <td>$lang[nema_igraca]</td> <td></td> <td></td> <td></td> </tr>";
 } else {

 $rand_id = 0;
 $p_q = mysql_query("SELECT * FROM players WHERE sid='$info[id]'");
 while($p = mysql_fetch_array($p_q)){ 
   $playertime = gmdate("H:i:s", $p[time_online]%86400);
   $rand_id++;
   
   echo "<tr> <td>$rand_id.</td> <td>$p[nickname]</td>   <td>$playertime</td> <td>$p[score]</td></span> </tr>";
 }
 
 }
  ?>
  </table>
  
  <div id="informacije-opste" class="modal hide fade in" style="display: none;width:760px;left:45%;">
            <div class="modal-header">
              <a class="close" style="float:right;cursor:pointer;" data-dismiss="modal">x</a>
              <?php echo $lang['izmeni_info']; ?>       </div>
			<div class="block-title-hr"></div>
						
			<form action="/admin/adminprocess.php?task=edit_server" method="POST">			
						
            <div class="modal-body">
			
 <div style="width:100px;"><?php echo $lang['forum']; ?>:</div>
	<input type="text" class="text" value="<?php echo $info['forum']; ?>" placeholder="www.link.com" size="20" name="forum">
	
	<br /><br />

	<div style="width:100px;"><?php echo $lang['igra']; ?>:</div>
	<select name="game" class="select" style="width:180px;" id="game">
	<option value="" > <?php echo $lang['sve']; ?> </option>
						<?php foreach ($gt_allowed_games as $gamefull => $gamesafe): ?>
						<option <?php if($gamesafe == $info['game']){ echo "selected"; } ?> value="<?php echo $gamesafe; ?>"><?php echo $gamefull; ?></option>
						<?php endforeach; ?>
	</select>
	
	<br /><br />
	
                    <div style="width:100px;"><?php echo $lang['lokacija']; ?>:</div>
					<select class="select" name="location" style="width:180px;" id="location">
					<option value="" > <?php echo $lang['sve']; ?> </option>
						<?php foreach ($gt_allowed_countries as $locationfull => $locationsafe): ?>
						<option <?php if($locationsafe == $info['location']){ echo "selected"; } ?> value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
						<?php endforeach; ?>
					</select>
					
					<br /><br />

                 <div style="width:100px;"><?php echo $lang['mod']; ?>:</div>
                 <select class="select" style="width:180px;" name="mod">
				 <option value="" > <?php echo $lang['sve']; ?> </option>
				 <?php if($info['game'] == "cs16"){ ?>
						  <optgroup label="Counter Strike 1.6">
                                    <option <?php if($info['gamemod'] == "PUB"){ echo "selected"; } ?> value="PUB" >Public</option>
                                    <option <?php if($info['gamemod'] == "DM"){ echo "selected"; } ?> value="DM" >DeathMatch</option>
                                    <option <?php if($info['gamemod'] == "DR"){ echo "selected"; } ?> value="DR" >DeathRun</option>
                                    <option <?php if($info['gamemod'] == "GG"){ echo "selected"; } ?> value="GG" >GunGame</option>
                                    <option <?php if($info['gamemod'] == "HNS"){ echo "selected"; } ?> value="HNS" >Hide 'n Seek</option>
                                    <option <?php if($info['gamemod'] == "KZ"){ echo "selected"; } ?> value="KZ" >KreedZ</option>
                                    <option <?php if($info['gamemod'] == "SJ"){ echo "selected"; } ?> value="SJ" >SoccerJam</option>
                                    <option <?php if($info['gamemod'] == "KA"){ echo "selected"; } ?> value="KA" >Knife Arena</option>
                                    <option <?php if($info['gamemod'] == "SH"){ echo "selected"; } ?> value="SH" >Super Hero</option>
                                    <option <?php if($info['gamemod'] == "SURF"){ echo "selected"; } ?> value="SURF" >Surf</option>
                                    <option <?php if($info['gamemod'] == "WC3"){ echo "selected"; } ?> value="WC3" >Warcraft3</option>
                                    <option <?php if($info['gamemod'] == "PB"){ echo "selected"; } ?> value="PB" >PaintBall</option>
                                    <option <?php if($info['gamemod'] == "ZM"){ echo "selected"; } ?> value="ZM" >Zombie mod</option>
                                    <option <?php if($info['gamemod'] == "ZMRK"){ echo "selected"; } ?> value="ZMRK" >Zmurka</option>
                                    <option <?php if($info['gamemod'] == "CTF"){ echo "selected"; } ?> value="CTF" >Capture the flag</option>
                                    <option <?php if($info['gamemod'] == "CW"){ echo "selected"; } ?> value="CW" >ClanWar</option>
                                    <option <?php if($info['gamemod'] == "OSTALO"){ echo "selected"; } ?> value="OSTALO" >Ostalo</option>
                                    <option <?php if($info['gamemod'] == "AWP"){ echo "selected"; } ?> value="AWP" >AWP</option>
                                    <option <?php if($info['gamemod'] == "DD2"){ echo "selected"; } ?> value="DD2" >de_dust2 only</option>
                                    <option <?php if($info['gamemod'] == "FUN"){ echo "selected"; } ?> value="FUN" >Fun, Fy, Aim</option>
                                    <option <?php if($info['gamemod'] == "COD"){ echo "selected"; } ?> value="COD" >CoD</option>
                                    <option <?php if($info['gamemod'] == "BB"){ echo "selected"; } ?> value="BB" >BaseBuilder</option>
                                    <option <?php if($info['gamemod'] == "JB"){ echo "selected"; } ?> value="JB" >JailBreak</option>
                                    <option <?php if($info['gamemod'] == "BF2"){ echo "selected"; } ?> value="BF2" >Battlefield2</option>
                            </optgroup>
				 <?php } else if($info['game'] == "css"){ ?>
                        <optgroup label="Counter Strike Source">
                                    <option <?php if($info['gamemod'] == "PUB"){ echo "selected"; } ?> value="PUB" >Public</option>
                                    <option <?php if($info['gamemod'] == "DM"){ echo "selected"; } ?> value="DM" >DeathMatch</option>
                                    <option <?php if($info['gamemod'] == "DR"){ echo "selected"; } ?> value="DR" >DeathRun</option>
                                    <option <?php if($info['gamemod'] == "GG"){ echo "selected"; } ?> value="GG" >GunGame</option>
                                    <option <?php if($info['gamemod'] == "ZM"){ echo "selected"; } ?> value="ZM" >Zombie Mod</option>
                                    <option <?php if($info['gamemod'] == "CW"){ echo "selected"; } ?> value="CW" >Clan War</option>
                            </optgroup>
				  <?php } else if($info['game'] == "cod2"){ ?>
                        <optgroup label="Call of Duty 2">
                                    <option <?php if($info['gamemod'] == "PAM"){ echo "selected"; } ?> value="PAM" >Pam mod</option>
                                    <option <?php if($info['gamemod'] == "PM4"){ echo "selected"; } ?> value="PM4" >Promod 4</option>
                                    <option <?php if($info['gamemod'] == "AWE"){ echo "selected"; } ?> value="AWE" >Additional War Effects</option>
                            </optgroup>
					 <?php } else if($info['game'] == "cod4"){ ?>
                        <optgroup label="Call of Duty 4">
                                    <option <?php if($info['gamemod'] == "PAM"){ echo "selected"; } ?> value="PAM" >Pam mod</option>
                                    <option <?php if($info['gamemod'] == "PM4"){ echo "selected"; } ?> value="PM4" >Promod 4</option>
                                    <option <?php if($info['gamemod'] == "BSF"){ echo "selected"; } ?> value="BSF" >Balkan Special Forces</option>
                                    <option <?php if($info['gamemod'] == "PROMODLIVE204"){ echo "selected"; } ?> value="PROMODLIVE204" >Promodlive204</option>
                                    <option <?php if($info['gamemod'] == "EXTREME2.6"){ echo "selected"; } ?> value="EXTREME2.6" >Extreme 2.6</option>
                                    <option <?php if($info['gamemod'] == "ROTU"){ echo "selected"; } ?> value="ROTU" >Reign of the undeath</option>
                         </optgroup>
					 <?php } else if($info['game'] == "samp" OR $info['game'] == "tf2" OR $info['game'] == "csgo" OR $info['game'] == "minecraft" OR $info['game'] == "teamspeak3"){ ?>
						 <optgroup label="Ostalo">
						           <option <?php if($info['gamemod'] == "DEFAULT"){ echo "selected"; } ?> value="DEFAULT" >DEFAULT</option>
						 </optgroup>
					 <?php } ?>
					</select>         

                    <input type="hidden" name="sid" value="<?php echo $info['id']; ?>">		
					
            </div>
			
			<input style="margin-left:10px;" type="submit" value="<?php echo $lang['posalji']; ?>" class="button green" />
			<div style="height:10px;"></div>
			
			</form>
			
            <div class="modal-footer">
            </div>
			
</div>

<?php
if($user['rank'] == "1"){
?>
 <div id="informacije-admin" class="modal hide fade in" style="display: none;width:760px;left:45%;">
            <div class="modal-header">
              <a class="close" style="float:right;cursor:pointer;" data-dismiss="modal">x</a>
              <?php echo $lang['izmeni_info']; ?>       </div>
			<div class="block-title-hr"></div>
						
						
            <div class="modal-body">
			
            <form action="/admin/adminprocess.php?task=server-admin-edit" class="objavi_form" method="POST">
			
			<div style="float:right;width:350px;">
	                 <input type="text" style="width:90%;" class="text" name="playercount_6h" required="required" title="playercount_6h" value="<?php echo $info['playercount_6h']; ?>"> <div style="height:10px;"></div>
					 <input type="text" style="width:90%;" class="text" name="playercount_month" required="required" title="playercount_month" value="<?php echo $info['playercount_month']; ?>"> <div style="height:10px;"></div>
					 <input type="text" style="width:90%;" class="text" name="playercount_hour" required="required" title="playercount_hour" value="<?php echo $info['playercount_hour']; ?>"> <div style="height:10px;"></div>
	        </div>
			
			<div style="width:350px;text-align:left;">
				     <input type="text" style="width:90%;" class="text" name="rank_pts" required="required" title="rank_pts" value="<?php echo $info['rank_pts']; ?>"> <div style="height:10px;"></div>
					 <input type="text" style="width:90%;" class="text" name="playercount" required="required" title="playercount"  value="<?php echo $info['playercount']; ?>"> <div style="height:10px;"></div>
		             <input type="text" style="width:90%;" class="text" name="playercount_week" required="required" title="playercount_week" value="<?php echo $info['playercount_week']; ?>"> <div style="height:10px;"></div>
					 <input type="hidden" name="id" value="<?php echo $info['id']; ?>">
					 
		             <input type="submit" value="<?php echo $lang['posalji']; ?>" class="button green" />
			</div>
			</form>
			</div>
			
            <div class="modal-footer">
            </div>
<?php
}
?>