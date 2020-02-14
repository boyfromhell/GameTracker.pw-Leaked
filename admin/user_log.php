<?php
defined("access") or die("Nedozvoljen pristup");

// vazno
			include_once ('function.php');

        	$p_id = (int) (!isset($_GET["p"]) ? 1 : $_GET["p"]);
    	    $limit = 20;
    	    $startpoint = ($p_id * $limit) - $limit;
			
            //to make pagination
	        $statement = "`profile_log`";
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1>User Log</h1></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">
	  <?php if($user['rank'] == "1"){ ?> <input type="button" value="Obrisi sve logove" onclick="window.location='/admin/adminprocess.php?task=obrisi_logove'" class="button red stop" /> <?php } ?>
	  </td>
  </tr>
</table>


<br />


	     <?php
		 $s_q = mysql_query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
		 while($k = mysql_Fetch_array($s_q)){
			 
             $time = time_ago($k['time']);
			 $type = $k['type'];
			 
			 if($type == "1"){
				 echo "<div style='padding:10px;' class='data'>$lang[korisnik] <a href='/member/$k[var2]'>$k[var2]</a> $lang[pl_profil] <a href='/member/$k[var3]'>$k[var3]</a> <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 } else if($type == "2"){
				  $server = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$k[var3]'"));
				  	
		  $naziv = $server['hostname'];
          if(strlen($naziv) > 30){ 
          $naziv = substr($naziv,0,30); 
          $naziv .= "..."; 
          }
				  echo "<div style='padding:10px;' class='data'>$lang[korisnik] <a href='/member/$k[var2]'>$k[var2]</a> $lang[pl_server] <a href='/server_info/$server[ip]'> <img style='height:10px;' src='/ime/games/game-$server[game].png'> $naziv</a>  <span style='float:right;'><small>$time</small></span></div> <div style='height:3px;'></div>";
			 }
		 }
		 ?>
	   
<?php 
echo pagination($statement,$limit,$p_id); 
?>