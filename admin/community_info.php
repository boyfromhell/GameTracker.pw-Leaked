<?php
$id = addslashes($_GET['id']);

$info = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));

$br_srv = mysql_query("SELECT * FROM community_servers WHERE comid='$id'");
$broj_servera = mysql_num_rows($br_srv);

// Prosek
$players = $info['playercount'];
  
$niz24 = explode(',' , $players);

$suma = array_sum( $niz24 );

$prosek = round($suma / count( $niz24 ), 2);

if($info['id'] == ""){
    die("<script> alert('$lang[zajednicanepostoji].'); document.location.href='/'; </script>");
} else {

?>
<style>
.brand_morph {
	font-weight:bold;
}
</style>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $info['naziv']; ?></h1></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">
	  <a  data-toggle="modal" href="#community_edit"><input type="button" value="Izmeni Informacije" class="button blue restart" /></a>
	  <?php if($user['rank'] == "1"){ ?> <input type="button" value="Obrisi zajednicu" onclick="window.location='/admin/adminprocess.php?task=obrisi_zajednicu&id=<?php echo $info['id']; ?>'" class="button red stop" /> <?php } ?>
    </td>
  </tr>
</table>

<br />

<!-- desno -->
<div style="float:right;width:330px;">
   <div class="data" style="padding:10px 20px 10px 20px; height:150px;">
	   <?php
	   
$sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `servers`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$id}')";

$tmp = mysql_fetch_assoc( mysql_query( $sql ) );
 if(empty($info['maxslots'])){
	 $numtest = $tmp['max_igraca'];
 } else {
	 $numtest = $info['maxslots'];
 }

	   ?>
	   <img src="http://chart.apis.google.com/chart?chf=bg,s,ffffff,18&chxl=0:<?php echo $info['chart_updates']; ?>&chxr=0,0,7|1,0,<?php echo $numtest; ?>&chxs=0,FF7300,9,0,lt|1,FF7300,9,1,lt&chxt=x,y&chs=300x150&cht=lc&chco=FF7300&chds=0,<?php echo $numtest; ?>&chd=t:<?php echo $info['playercount']; ?>&chdlp=l&chg=0,-1,0,0&chls=2&chma=10,10,10,10">
   </div>
</div>

<!-- kraj desno -->

<div class="data" style="width:650px; text-align: left;padding:10px;"> 

  <div style="width:350px;">
  <div class="brand_morph"><?php echo $lang['opste_i']; ?></div>
  <div class="brand_text"><span><?php echo $lang['ime_zajednice']; ?>: </span> <?php echo $info['naziv']; ?></div>
  <div class="brand_text"><span><?php echo $lang['sajt_forum']; ?>: </span> <a target="_blank" href="http://<?php echo $info['forum']; ?>"><?php echo $info['forum']; ?></a></div>
  <div class="brand_text"><span><?php echo $lang['vlasnik']; ?>: </span> <?php echo "<a href='/member/$info[owner]'>$info[owner]</a>"; ?></div>
  <div class="brand_text"><span><?php echo $lang['br_servera_z']; ?>: </span> <?php echo $broj_servera; ?></div>
  <div class="brand_text"><span><?php echo $lang['ukupno_igraca_z']; ?>: </span> <?php
 $sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `servers`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$id}')";

 $tmp = mysql_fetch_assoc( mysql_query( $sql ) );
 if(empty($info['maxslots'])){
	 $numtest = $tmp['max_igraca'];
 } else {
	 $numtest = $info['maxslots'];
 }
 echo "$tmp[suma_igraca]/$numtest";
 ?> 
 </div>
  
  <br />
  
  <div class="brand_morph"><?php echo $lang['info_igraci']; ?></div>
  <div class="brand_text"><span><?php echo $lang['prosek_24']; ?>:</span> <?php echo $prosek; ?></div>  
  <br />
  
  <div class="brand_morph"><?php echo $lang['o_zajednici']; ?></div>
  <div class="brand_text"> <?php echo nl2br($info['opis']); ?> </div>

  <br />
  
	  <table style="width:645px;" class="gt_s">
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
$kte2 = mysql_query("SELECT * FROM community_servers WHERE comid='$id'");
$br_kt = mysql_num_rows($kte2);
 
 if($br_kt < 1){ 
   echo "<tr> <td>$lang[nema_servera_z]</td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> <td></td> </tr>";
 } else {

$kte = mysql_query("SELECT * FROM community_servers WHERE comid='$id'");
while($te = mysql_fetch_array($kte)){
$res = mysql_query("SELECT * FROM servers WHERE id='$te[srvid]' ORDER BY rank_pts DESC");
while($srv = mysql_fetch_array($res)){
	  $naziv = $srv['hostname'];
      if(strlen($naziv) > 20){ 
          $naziv = substr($naziv,0,20); 
          $naziv .= "..."; 
	  }
   echo "<tr> <td>$srv[rank].</td> <td><img style='width:16px;height:16px;' src='/ime/games/game-$srv[game].png'></td>  <td><a href='/admin/server_info/$srv[ip]'>$naziv<a></td> <td><span id='broj_igraca'>$srv[num_players]</span>/$srv[max_players]</td> <td>$srv[ip]</td> <td>$srv[gamemod]</td> <td><img src='/ime/flags/$srv[location].png'></td> <td>$srv[mapname]</td></tr>";
}
}
 
 }
  ?>
  </table>
  
</div>

</div>
<?php } ?>


<!-- Modals -->	
<div id="community_edit" class="modal hide fade in" style="display: none; ">
            <div class="modal-header">
              <a class="close" style="float:right;cursor:pointer;" data-dismiss="modal">x</a>
              <?php echo $lang['izmeni_z']; ?>
            </div>
			<div class="block-title-hr"></div>
			
			<form action="/admin/adminprocess.php?task=edit_community" method="POST">
			
            <div class="modal-body">
    <input type="text" name="naziv" style="width:90%;" value="<?php echo $info['naziv']; ?>" required="required"> <div style="height:10px;"></div>
	<input type="text" name="forum" style="width:90%;" value="<?php echo $info['forum']; ?>" required="required"> <div style="height:10px;"></div>
	<textarea name="opis" style="width:90%;max-width:90%;height:70px;max-height:100px;" required="required"><?php echo $info['opis']; ?></textarea> <div style="height:10px;"></div>
	<input type="hidden" name="id" value="<?php echo $id; ?>">
            </div>
            <div class="modal-footer">
             <button class="btn_orange"><?php echo $lang['posalji']; ?></button>
            </div>
			
			</form>
</div>	