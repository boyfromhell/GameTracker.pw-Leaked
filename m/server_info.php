<?php
defined("access") or die("Nedozvoljen pristup");

$ip			= addslashes($_GET['ip']);

$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));

if($info['id'] == ""){
die("<script> alert('$lang[servernepostoji]'); document.location.href='/servers/'; </script>");
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
  $owner = "Nema <a href='/process/ownership/$ip'>[ Potvrdi vlasnistvo ]</a>";
} else {
  $owner = "<a href='/member/$info[owner]'>$info[owner]</a> <a href='/process/ownership/$ip'>[ Potvrdi vlasnistvo ]</a>";
}

// Forum
$forum = $info['forum'];

if($forum == "Nema"){
  $forum = "Nema";
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
	 if (file_exists("/ime/maps/".$info['mapname'].".jpg")){ 
	 $mapimg = "<img style='width:145px;height:108px;' src='/ime/maps/$info[mapname].jpg'>"; 
	 } else {
	 $mapimg = "<img src='/ime/mapbg.png'>";	 
	 } 
	 
?>

<div style="font-size:18px;" class="tab-content">
<img style='width:15px;height:15px;' src='/ime/games/game-<?php echo $info['game']; ?>.png'> <img style='width:15px;height:15px;' src='/ime/flags/<?php echo $info['location']; ?>.png'> <?php echo $info['hostname']; ?>
<span style="float:right;margin-top:3px;"><small>Poslednji update: <em><?php echo time_ago($info['last_update']); ?></em></small></span>
</div>

<br />

<!-- desno -->
<div style="float:right;width:300px;">
        <div id="dnevni_graph" class="tab-content">
               <img width="270" src="/chart/<?php echo $ip; ?>">
        </div>
        <div id="nedeljni_graph" class="tab-content">
               <img width="270" src="/chart_week/<?php echo $ip; ?>">
        </div>
        <div id="mesecni_graph" class="tab-content">
               <img width="270" src="/chart_month/<?php echo $ip; ?>">
        </div>
		<div id="rank" class="tab-content">
		       <img width="270" src="/chart_rank/<?php echo $ip; ?>">
		</div>



<div style="height:100px;"></div>
</div>

<!-- kraj desno -->

<div class="tab-content" style="width:550px; text-align: left;"> 


<div style="width:230px; text-align: left;float:right;"> 
<div class="brand_morph"><?php echo $lang['mapa']; ?></div> <br />
  <center>
  <div id="mapc">
  <?php echo $mapimg; ?>
  </div>
   <b><?php echo $info['mapname']; ?></b>
  </center>
  
  <br />
  </div>

  <div style="width:350px;">
  <div class="brand_morph">Opste Informacije</div>
  <div class="brand_text"><span>Igra: </span> <?php echo $igra; ?></div>
  <div class="brand_text"><span>Naziv: </span> <?php echo $naziv; ?></div>
  <div class="brand_text"><span>Mod: </span> <?php echo $info['gamemod']; ?></div>
  <div class="brand_text"><span>Status: </span> <?php echo $online; ?></div>
  <div class="brand_text"><span>IP: </span> <?php echo $info['ip']; ?></div>
  <div class="brand_text"><span>Dodao: </span> <a href="/member/<?php echo $info['added']; ?>"><?php echo $info['added']; ?></a></div>
  <div class="brand_text"><span>Vlasnik: </span> <?php echo $owner; ?></div>
  <div class="brand_text"><span>Forum: </span> <?php echo $forum; ?></div>
  
  <br />
  
  <div class="brand_morph">Igraci</div>
  <div class="brand_text"><span>Igraci</span> <?php echo "$info[num_players]/$info[max_players]"; ?></div>
  <div class="brand_text"><span>Prosecan broj igraca (12 sati):</span> <?php echo $prosek12; ?></div>
  <div class="brand_text"><span>Prosecan broj igraca (24 sata):</span> <?php echo $prosek; ?></div>
  
  <br />
  
  <div class="brand_morph">Rank servera</div>
  <?php
  if($info['rank'] == "99999"){
  ?>
  <div class="brand_text"><span>Rank:</span> <?php echo $lang['rank_zamrznut']; ?></div>
  <?php
  } else {
  ?>
  <div class="brand_text"><span>Rank:</span> <?php echo $info['rank']; ?></div>
  <div class="brand_text"><span>Najbolji rank:</span> <?php echo $info['best_rank']; ?></div>
  <div class="brand_text"><span>Najgori:</span> <?php echo $info['worst_rank']; ?></div>
  <?php } ?>
  
  <br />
  </div>
    
  <br />
  
  	  <table style="width:100%;" class="table">
	  <tr>
	  <th>ID</th>
	  <th>Nick</th>
	  <th>Vreme</th>
	  <th>Ubistva</th>
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
  
</div>