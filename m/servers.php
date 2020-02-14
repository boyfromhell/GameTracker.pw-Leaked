 <?php
defined("access") or die("Nedozvoljen pristup");

$g_name = addslashes($_GET['g_name']);
$vreme = time() + 60;

// vazno
			include_once ('function.php');

        	$p_id = (int) (!isset($_GET["p"]) ? 1 : $_GET["p"]);
    	    $limit = 20;
    	    $startpoint = ($p_id * $limit) - $limit;
			
            //to make pagination
		    if($_GET['hostname'] OR $_GET['ip'] OR $_GET['game'] OR $_GET['location'] OR $_GET['mod']){
	        $statement = "`servers` WHERE hostname LIKE '%$_GET[hostname]%' AND ip LIKE '%$_GET[ip]%' AND game LIKE '%$_GET[game]%' AND location LIKE '%$_GET[location]%' AND gamemod LIKE '%$_GET[mod]%' AND last_update > '".date("Y-m-d", $vreme)."'";
	        } else if($_GET['addedby']){
			$addedby = addslashes($_GET['addedby']);
	        $statement = "`servers` WHERE added='$addedby' AND last_update > '".date("Y-m-d", $vreme)."'";
            } else if($_GET['ownedby']){
			$ownedby = addslashes($_GET['ownedby']);
	        $statement = "`servers` WHERE owner='$ownedby' AND last_update > '".date("Y-m-d", $vreme)."'";
            } else if($g_name == ""){
	        $statement = "`servers` WHERE last_update > '".date("Y-m-d", $vreme)."'";
            } else if($g_name == "cs16" OR $g_name == "css" OR $g_name == "csgo" OR $g_name == "minecraft" OR $g_name == "samp" OR $g_name == "cod2" OR $g_name == "cod4" OR $g_name == "tf2" OR $g_name == "teamspeak3"){
	           $statement = "`servers` WHERE game='$g_name' AND last_update > '".date("Y-m-d", $vreme)."'";
            } else {
	              die("<script> alert('Error'); document.location.href='/servers/'; </script>");
            }
?>

<div class="inner">

<form method="POST" action="/process.php?task=m_search">
    Naziv:
	<input type="search" class="form-control" value="<?php echo $_GET['hostname']; ?>" size="20" results="5" name="hostname">

    IP:
	<input type="search" class="form-control" value="<?php echo $_GET['ip']; ?>" size="20" name="ip">

	Igra:
	<select class="form-control" name="game" style="width:100px;" id="game">
	<option value="" > Sve </option>
						<?php foreach ($gt_allowed_games as $gamefull => $gamesafe): ?>
						<option <?php if($gamesafe == $_GET['game'] OR $gamesafe == $g_name){ echo "selected"; } ?> value="<?php echo $gamesafe; ?>"><?php echo $gamefull; ?></option>
						<?php endforeach; ?>
	</select>
	
Lokacija:
					<select class="form-control" name="location" style="width:100px;" id="location">
					<option value="" > Sve </option>
						<?php foreach ($gt_allowed_countries as $locationfull => $locationsafe): ?>
						<option <?php if($locationsafe == $_GET['location']){ echo "selected"; } ?> value="<?php echo $locationsafe; ?>"><?php echo $locationfull; ?></option>
						<?php endforeach; ?>
					</select>

Mod:
                 <select class="form-control" style="width:100px;" name="mod">
				 <option value="" > Sve </option>
						  <optgroup label="Counter Strike 1.6">
                                    <option <?php if($_GET['mod'] == "PUB"){ echo "selected"; } ?> value="PUB" >Public</option>
                                    <option <?php if($_GET['mod'] == "DM"){ echo "selected"; } ?> value="DM" >DeathMatch</option>
                                    <option <?php if($_GET['mod'] == "DR"){ echo "selected"; } ?> value="DR" >DeathRun</option>
                                    <option <?php if($_GET['mod'] == "GG"){ echo "selected"; } ?> value="GG" >GunGame</option>
                                    <option <?php if($_GET['mod'] == "HNS"){ echo "selected"; } ?> value="HNS" >Hide 'n Seek</option>
                                    <option <?php if($_GET['mod'] == "KZ"){ echo "selected"; } ?> value="KZ" >KreedZ</option>
                                    <option <?php if($_GET['mod'] == "SJ"){ echo "selected"; } ?> value="SJ" >SoccerJam</option>
                                    <option <?php if($_GET['mod'] == "KA"){ echo "selected"; } ?> value="KA" >Knife Arena</option>
                                    <option <?php if($_GET['mod'] == "SH"){ echo "selected"; } ?> value="SH" >Super Hero</option>
                                    <option <?php if($_GET['mod'] == "SURF"){ echo "selected"; } ?> value="SURF" >Surf</option>
                                    <option <?php if($_GET['mod'] == "WC3"){ echo "selected"; } ?> value="WC3" >Warcraft3</option>
                                    <option <?php if($_GET['mod'] == "PB"){ echo "selected"; } ?> value="PB" >PaintBall</option>
                                    <option <?php if($_GET['mod'] == "ZM"){ echo "selected"; } ?> value="ZM" >Zombie mod</option>
                                    <option <?php if($_GET['mod'] == "ZMRK"){ echo "selected"; } ?> value="ZMRK" >Zmurka</option>
                                    <option <?php if($_GET['mod'] == "CTF"){ echo "selected"; } ?> value="CTF" >Capture the flag</option>
                                    <option <?php if($_GET['mod'] == "CW"){ echo "selected"; } ?> value="CW" >ClanWar</option>
                                    <option <?php if($_GET['mod'] == "OSTALO"){ echo "selected"; } ?> value="OSTALO" >Ostalo</option>
                                    <option <?php if($_GET['mod'] == "AWP"){ echo "selected"; } ?> value="AWP" >AWP</option>
                                    <option <?php if($_GET['mod'] == "DD2"){ echo "selected"; } ?> value="DD2" >de_dust2 only</option>
                                    <option <?php if($_GET['mod'] == "FUN"){ echo "selected"; } ?> value="FUN" >Fun, Fy, Aim</option>
                                    <option <?php if($_GET['mod'] == "COD"){ echo "selected"; } ?> value="COD" >CoD</option>
                                    <option <?php if($_GET['mod'] == "BB"){ echo "selected"; } ?> value="BB" >BaseBuilder</option>
                                    <option <?php if($_GET['mod'] == "JB"){ echo "selected"; } ?> value="JB" >JailBreak</option>
                                    <option <?php if($_GET['mod'] == "BF2"){ echo "selected"; } ?> value="BF2" >Battlefield2</option>
                            </optgroup>
                        <optgroup label="Counter Strike Source">
                                    <option <?php if($_GET['mod'] == "PUB"){ echo "selected"; } ?> value="PUB" >Public</option>
                                    <option <?php if($_GET['mod'] == "DM"){ echo "selected"; } ?> value="DM" >DeathMatch</option>
                                    <option <?php if($_GET['mod'] == "DR"){ echo "selected"; } ?> value="DR" >DeathRun</option>
                                    <option <?php if($_GET['mod'] == "GG"){ echo "selected"; } ?> value="GG" >GunGame</option>
                                    <option <?php if($_GET['mod'] == "ZM"){ echo "selected"; } ?> value="ZM" >Zombie Mod</option>
                                    <option <?php if($_GET['mod'] == "CW"){ echo "selected"; } ?> value="CW" >Clan War</option>
                            </optgroup>
                        <optgroup label="Call of Duty 2">
                                    <option <?php if($_GET['mod'] == "PAM"){ echo "selected"; } ?> value="PAM" >Pam mod</option>
                                    <option <?php if($_GET['mod'] == "PM4"){ echo "selected"; } ?> value="PM4" >Promod 4</option>
                                    <option <?php if($_GET['mod'] == "AWE"){ echo "selected"; } ?> value="AWE" >Additional War Effects</option>
                            </optgroup>
                        <optgroup label="Call of Duty 4">
                                    <option <?php if($_GET['mod'] == "PAM"){ echo "selected"; } ?> value="PAM" >Pam mod</option>
                                    <option <?php if($_GET['mod'] == "PM4"){ echo "selected"; } ?> value="PM4" >Promod 4</option>
                                    <option <?php if($_GET['mod'] == "BSF"){ echo "selected"; } ?> value="BSF" >Balkan Special Forces</option>
                                    <option <?php if($_GET['mod'] == "PROMODLIVE204"){ echo "selected"; } ?> value="PROMODLIVE204" >Promodlive204</option>
                                    <option <?php if($_GET['mod'] == "EXTREME2.6"){ echo "selected"; } ?> value="EXTREME2.6" >Extreme 2.6</option>
                                    <option <?php if($_GET['mod'] == "ROTU"){ echo "selected"; } ?> value="ROTU" >Reign of the undeath</option>
                         </optgroup>
						 <optgroup label="Ostalo">
						           <option <?php if($_GET['mod'] == "DEFAULT"){ echo "selected"; } ?> value="DEFAULT" >DEFAULT</option>
						 </optgroup>
					</select>

	<button type="submit" class="btn btn-warning">Trazi</button>
</form>

</div>

<br />

	  <table class="table">
	  <tr>
	  <th>Rank</th>
	  <th>Igra</th>
	  <th>Naziv</th>
	  <th>Igraci</th>
	  <th>IP</th>
	  <th>Mod</th>
	  <th>Lokacija</th>
	  <th>Mapa</th>
	  </tr>
	     <?php
		 $s_q = mysql_query("SELECT * FROM {$statement} ORDER BY rank ASC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
		 while($k = mysql_Fetch_array($s_q)){
			
	$naziv = $k['hostname'];
    if(strlen($naziv) > 40){ 
          $naziv = substr($naziv,0,40); 
          $naziv .= "..."; 
     }
	 			
			
		   echo "<tr> <td>$k[rank].</td> <td><img style='width:16px;height:16px;' src='/ime/games/game-$k[game].png'></td> <td style='text-align:left;'><a href='/m/server_info/$k[ip]'>$naziv</a></td> <td>$k[num_players]/$k[max_players]</td> <td>$k[ip]</td> <td>$k[gamemod]</td> <td><img style='width:22px;height:16px;' src='/ime/flags/$k[location].png'></td> <td>$k[mapname]</td> </tr>";
		 }
		 ?>
	   </table>
	   
<?php 
echo pagination($statement,$limit,$p_id); 
?>