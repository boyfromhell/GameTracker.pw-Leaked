<?php
defined("access") or die("Nedozvoljen pristup");

// vazno
			include_once ('function.php');

        	$p_id = (int) (!isset($_GET["p"]) ? 1 : $_GET["p"]);
    	    $limit = 20;
    	    $startpoint = ($p_id * $limit) - $limit;
			
            //to make pagination
	        $statement = "`poruke`";
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_poruke']; ?></h1></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left">
	  <?php if($user['rank'] == "1"){ ?> <input type="button" value="Obrisi sve poruke" onclick="window.location='/admin/adminprocess.php?task=obrisi_poruke'" class="button red stop" /> <?php } ?>
	  </td>
  </tr>
</table>


<br />

	  <table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th></th>
	  <th><?php echo $lang['p_title']; ?></th>
	  <th><?php echo $lang['p_od']; ?></th>
	  <th><?php echo $lang['p_za']; ?></th>
	  <th><?php echo $lang['p_time']; ?></th>
	  <th><?php echo $lang['p_odgovora']; ?></th>
	  </tr>
	     <?php
		 $s_q = mysql_query("SELECT * FROM {$statement} ORDER BY id DESC LIMIT {$startpoint} , {$limit}") or die(mysql_error());
		 while($k = mysql_Fetch_array($s_q)){
		 $odgovora = mysql_num_rows(mysql_query("SELECT * FROM messages_answers WHERE mid='$k[id]'"));
		 $time = time_ago($k['time']);
		 
		 $od = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$k[od]'"));
		 $za = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$k[za]'"));
		 
         echo "<tr> <td>$k[id]</td> <td><a href='/admin/message_info/$k[id]'>$k[title]</a></td> <td><a href='/admin/member/$od[username]'>$od[username]</a></td> <td><a href='/admin/member/$za[username]'>$za[username]</a></td> <td>$time</td> <td>$odgovora</td> </tr>"; 
		 }
		 ?>
	   </table>
	   
<?php 
echo pagination($statement,$limit,$p_id); 
?>