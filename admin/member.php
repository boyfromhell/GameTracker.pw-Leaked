<?php
defined("access") or die("Nedozvoljen pristup");

$username			=  htmlspecialchars($_GET['username'], ENT_QUOTES);

$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$username'"));
$status = (time() - $info['activity']) < 300 ? '<font color="#27a600">Online</font>' : '<font color="red">Offline</font>';

$dodatih_s = mysql_num_rows(mysql_query("SELECT * FROM servers WHERE addedid='$info[userid]'"));
$vlasnik_s = mysql_num_rows(mysql_query("SELECT * FROM servers WHERE ownerid='$info[userid]'"));
$posete = mysql_num_rows(mysql_query("SELECT * FROM profile_visits WHERE userid='$info[userid]'"));
$zajednice = mysql_num_rows(mysql_query("SELECT * FROM community WHERE ownerid='$info[userid]'"));

$poslednja_aktivnost = time_ago($info['activity']);
if($poslednja_aktivnost == "45 years ago"){
	$poslednja_aktivnost = "$lang[nema]";
}

if($info['hidemail'] == "on"){
	$email = "$lang[skriven_e]";
} else {
	$email = "$info[email]";
}

if($info['username'] == ""){
die("<script> alert('$lang[korisniknepostoji]'); document.location.href='/admin/memberlist'; </script>");
} else {

?>



<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $info['username']; ?></h1></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">
	  <?php if($user['rank'] == "1"){ ?><a  data-toggle="modal" href="#informacije"><input type="button" value="Izmeni Informacije" class="button blue restart" /></a><?php } ?>
	  <?php if($user['rank'] == "1"){ ?> <input type="button" value="Obrisi korisnika" onclick="window.location='/admin/adminprocess.php?task=obrisi_korisnika&id=<?php echo $info['userid']; ?>'" class="button red stop" /> <?php } ?>
	  </td>
    <td align="right">
	<?php if($user['rank'] == "1"){ ?> <?php if($info['ban'] == "0"){ ?> <input type="button" value="Banuj korisnika" onclick="window.location='/admin/adminprocess.php?task=banuj_korisnika&id=<?php echo $info['userid']; ?>'" class="button blue" /> <?php } else { ?> <input type="button" value="Unbanuj korisnika" onclick="window.location='/admin/adminprocess.php?task=unbanuj_korisnika&id=<?php echo $info['userid']; ?>'" class="button blue" /> <?php } } ?>
    <?php if($info['avatar'] == "nopic.png"){} else { ?> <input type="button" value="Obrisi avatar" onclick="window.location='/admin/adminprocess.php?task=obrisi_avatar&id=<?php echo $info['userid']; ?>'" class="button blue" /> <?php } ?>
  </tr>
</table>

<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="33%" valign="top"><fieldset>
      <table width="100%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" class="fieldheader">USER INFO</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;width:110px;">User ID:</td>
          <td class="fieldarea">#<?php echo $info['userid']; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['username']; ?>:</td>
          <td class="fieldarea"><b><?php echo $info['username']; ?></b></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['email']; ?>:</td>
          <td class="fieldarea"><?php echo $info['email']; ?></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo "$lang[ime] $lang[prezime]"; ?>:</td>
          <td class="fieldarea"><b><?php echo "$info[ime] $info[prezime]"; ?></b></td>
        </tr>
		<tr>
		  <td class="fieldname" style="height:20px;"><?php echo $lang['registrovan']; ?>:</td>
		  <td class="fieldarea"><?php echo $info['register_time']; ?></td>
		</tr>
		<tr>
		  <td class="fieldname" style="height:20px;"><?php echo $lang['poslednja_aktivnost']; ?>:</td>
		  <td class="fieldarea"><?php echo $poslednja_aktivnost ?></td>
		</tr>
      </table>
      </fieldset>
	  </td>
	  
	  <td width="33%" valign="top"><fieldset>
      <table width="100%" style="height:205px;" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" style="height:22px;" class="fieldheader">COMMUNITY</td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;width:110px;"><?php echo $lang['dodatih_s']; ?>:</td>
          <td class="fieldarea"><?php echo $dodatih_s; ?> <a href="/admin/?page=servers&addedby=<?php echo $info['username']; ?>">[ <?php echo $lang['lista_m']; ?> ]</a></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['vlasnik_s']; ?>:</td>
          <td class="fieldarea"><?php echo $vlasnik_s; ?> <a href="/admin/?page=servers&ownedby=<?php echo $info['username']; ?>">[ <?php echo $lang['lista_m']; ?> ]</a></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;"><?php echo $lang['zajednica_p']; ?>:</td>
          <td class="fieldarea"><?php echo $zajednice; ?> <a href="/?page=communities&author=<?php echo $info['username']; ?>">[ <?php echo $lang['lista_m']; ?> ]</a></td>
        </tr>
        <tr>
          <td class="fieldname" style="height:20px;">Status</td>
          <td class="fieldarea"><b><?php echo $status; ?></b></td>
        </tr>
		<tr>
		  <td class="fieldname" style="height:20px;"><?php echo $lang['p_posete']; ?>:</td>
		  <td class="fieldarea"><?php echo $posete; ?></td>
		</tr>
		<tr>
		    <td class="fieldname" style="height:20px;">Rank:</td>
			<?php
			if($info['rank'] == "1"){
			    $rank = "<span style='color:red;'>Administrator</span>";
			} else if($info['rank'] == "2"){
				$rank = "<span style='color:yellow;'>Moderator</span>";
			} else if($info['rank'] == "4"){
				$rank = "<span style='color:black;text-decoration: line-through;'>Banned</span>";
			} else {
				$rank = "Member";
			}
			?>
			<td class="fieldarea"><b><?php echo $rank; ?></b></td>
		</tr>
      </table>
      </fieldset>
	  </td>
	  
	 <td width="33%" height="200" valign="top"><fieldset>
      <table width="100%" style="height:200px;" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td colspan="2" class="fieldheader"><?php echo $lang['p_slika']; ?></td>
        </tr>
        <tr>
          <td class="fieldarea">
		  <img style="width:150px;height:150px;margin-left:60px;" src="/avatars/<?php echo $info['avatar']; ?>">
		  </td>
        </tr>
      </table>
      </fieldset>
	  </td>
	  
	  </tr>
	  </table>

	
<table width="100%">
  <tr>
    <td width="30%" valign="top"><table width="100%" cellpadding="0" cellspacing="1" class="data">
        <tr>
          <td valign="top" style="padding:10px;height:200px;">
	 <?php
	 $l_p = mysql_query("SELECT * FROM zahtevi WHERE status='1' AND od='$info[userid]' OR status='1' AND za='$info[userid]'");
	 ?>
	 <b><?php echo $lang['prijatelji']; ?> <span style="float:right;"><?php echo mysql_num_rows($l_p); ?></span></b> <div style="height:5px;"></div>
	 <?php
	 if(mysql_num_rows($l_p) < 1){
		 echo "$lang[nema]";
	 } else {
	 $l_pp = mysql_query("SELECT * FROM zahtevi WHERE status='1' AND od='$info[userid]' OR status='1' AND za='$info[userid]' ORDER BY id DESC LIMIT 24");
	 while($l = mysql_fetch_array($l_pp)){
		 if($l['od'] == $info['userid']){
		 $ui = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$l[za]'"));
		 } else if($l['za'] == $info['userid']){
		 $ui = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$l[od]'"));	 
		 }
		 		 
		 echo " <a href='/admin/member/$ui[username]'><img title='$ui[username]' style='width:50px;height:50px;' src='/avatars/$ui[avatar]'></a>";
	 }	 
		 
	 }
	 ?>
	 <br />
		  </td>
        </tr>
      </table></td>
    <td width="60%" valign="top"><table width="100%" cellpadding="0" cellspacing="1" class="data">
        <tr>
          <td valign="top" style="padding:10px;height:200px;">
		  <?php
		 $p_l = mysql_query("SELECT * FROM profile_log WHERE userid='$info[userid]' ORDER BY time DESC LIMIT 6");
		 if(mysql_num_rows($p_l) < 1){
			 
			 echo "<div class='profile_feed_l'>$lang[nema]</div>";
			 
		 } else {
		 while($pl = mysql_fetch_array($p_l)){
			 $time = time_ago($pl['time']);
			 $type = $pl['type'];
			 
			 if($type == "1"){
				 echo "<div class='profile_feed_l'>$lang[korisnik] <a href='/member/$pl[var2]'>$pl[var2]</a> $lang[pl_profil] <a href='/member/$pl[var3]'>$pl[var3]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div> <hr />";
			 } else if($type == "2"){
				  $server = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$pl[var3]'"));
				  	
		  $naziv = $server['hostname'];
          if(strlen($naziv) > 30){ 
          $naziv = substr($naziv,0,30); 
          $naziv .= "..."; 
          }
				  echo "<div class='profile_feed_l'>$lang[korisnik] <a href='/member/$pl[var2]'>$pl[var2]</a> $lang[pl_server] <a href='/server_info/$server[ip]'> <img style='height:10px;' src='/ime/games/game-$server[game].png'> $naziv</a>  <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div> <hr />";
			 }
			 
		   }			 
		 }
		 ?>
		  </td>
        </tr>
      </table></td>

  </tr>
</table>
	
	<div style="clear: both;"></div> <br />
   <div class="mh left" style="margin: 0px; width: 900px;">
		 <h3 style="margin-bottom: 15px;">GUESTBOOK <span style="float:right;"><a style='font-size:12px;text-shadow:none;' class="press" href="/guestbook/<?php echo $info['username']; ?>"><?php echo $lang['pogledaj_vise']; ?></a></span> </h3>
		 
		 <?php
		 $p_f = mysql_query("SELECT * FROM profile_feed WHERE userid='$info[userid]' ORDER BY id DESC LIMIT 5");
		 if(mysql_num_rows($p_f) < 1){
			 
			 echo "<div style='padding:5px;' class='data'>$lang[nema]</div>";
			 
		 } else {
		 while($p = mysql_fetch_array($p_f)){
			 $ainf = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$p[authorid]'"));
			 $before = time_ago($p['time']);
			 
			 echo "
			 <div style='padding:5px;' class='data'>
			 <img style='width:40px;height:40px;' src='/avatars/$ainf[avatar]'>
			 <div style='margin-left:45px;margin-top:-40px;'>
			 <a href='/member/$p[author]'>$p[author]</a> <div style='height:10px;'></div>
			 $p[message]  <span style='float:right'> <small>$before</small> </span>
			 </div>
			 </div> <div style='height:5px;'></div>";
		 }
			 
		 }
		 ?>
		 		 
	</div>

	<div style="clear: both;"></div>
	
	</div>
	
<?php } ?>


<!-- Modal -->

<?php if($user['rank'] == "1"){ ?>
<div id="informacije" class="modal hide fade in" style="display: none; ">
            <div class="modal-header">
              <a class="close" style="float:right;cursor:pointer;" data-dismiss="modal">x</a>
              <?php echo $lang['izmeni_profil']; ?>
            </div>
			<div class="block-title-hr"></div>
						
            <div class="modal-body">
			<?php
			$user_infot = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$info[userid]' "));
			?>
				 <form action="/admin/adminprocess.php?task=profil" class="objavi_form" method="POST">
	 
	 <input class="text" type="text" name="ime" value="<?php echo $user_infot['ime']; ?>" required="required"> <div style="height:5px;"></div>
	 <input class="text" type="text" name="prezime" value="<?php echo $user_infot['prezime']; ?>" required="required"> <div style="height:5px;"></div>
	 <input class="text" type="text" name="email" value="<?php echo $user_infot['email']; ?>" required="required"> <div style="height:5px;"></div>
	 
	 <select class="select" required="required" name="rank">
	   <option <?php if($info['rank'] == "0"){ echo "selected"; } ?> value="0">Member</option>
	   <option <?php if($info['rank'] == "2"){ echo "selected"; } ?> value="2">Moderator</option>
	   <option <?php if($info['rank'] == "1"){ echo "selected"; } ?> value="1">Administrator</option>
	 </select>
     <div style="height:5px;"></div>
	 
	 <input class="text" type="password" name="oldpass" placeholder="<?php echo $lang['stara_lozinka']; ?>"> <div style="height:5px;"></div>
	 <input class="text" type="password" name="password" placeholder="<?php echo $lang['nova_lozinka']; ?>"> <div style="height:5px;"></div>
	 
	 <input type="hidden" name="userid" value="<?php echo $info['userid']; ?>">
			
            </div>
            <div class="modal-footer">
			<input type="submit" value="<?php echo $lang['posalji']; ?>" class="button blue" />
            </div>
			</form>
			
</div>
<?php } else {} ?>