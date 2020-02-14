<?php
defined("access") or die("Nedozvoljen pristup");

// vazno
			include_once ('function.php');

        	$p_id = (int) (!isset($_GET["p"]) ? 1 : $_GET["p"]);
    	    $limit = 20;
    	    $startpoint = ($p_id * $limit) - $limit;
			
            //to make pagination
		    if($_GET['name']){
	        $statement = "`community` WHERE naziv LIKE '%$_GET[name]%'";
	        } else if($_GET['author']){
			$statement = "`community` WHERE owner='$_GET[author]' ";	
			} else {
	        $statement = "`community`";
			}
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_comm']; ?></h1></td>
  </tr>
</table>

<form method="post" action="/admin/adminprocess.php?task=search_c">
    <?php echo $lang['ime_zajednice']; ?>:
	<input type="search" value="<?php echo $_GET['name']; ?>" size="20" results="5" name="name">

	<input type="submit" name="pretrazi" value="<?php echo $lang['pretrazi']; ?>">
</form>

<br />

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
		 $s_q = mysql_query("SELECT * FROM {$statement} ORDER BY rank_pts DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
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
	   
<?php 
echo pagination($statement,$limit,$p_id); 
?>