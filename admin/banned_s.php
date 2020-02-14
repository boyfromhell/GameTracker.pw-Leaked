<?php
defined("access") or die("Nedozvoljen pristup");
?>

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_banovani_serveri']; ?></h1></td>
  </tr>
</table>

<table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th>ID</th>
	  <th>IP</th>
	  <th><?php echo $lang['adm_razlog']; ?></th>
	  <th><?php echo $lang['dodao']; ?></th>
	  <th></th>
	  <th></th>
	  </tr>
	  
	  	  <?php
		 $s_q = mysql_query("SELECT * FROM b_servers WHERE type='1' ORDER BY id DESC") or die(mysql_error());
		 if(mysql_num_rows($s_q) < 1){
		   echo "<tr> <td></td> <td></td> <td>$lang[nema]</td> <td></td> <td></td>  <Td></td> </tr>"; 
		 } else {
			 
		   while($k = mysql_Fetch_array($s_q)){
	       $time = time_ago($k['time']);
		   echo "<tr> <td>#$k[id]</td> <td>$k[ip]</td> <td>$k[razlog]</td> <td><a href='/admin/member/$k[author]'>$k[author]</a></td> <td>$time</td>  <Td><a href='/admin/adminprocess.php?task=obrisi_ban&id=$k[id]'><img src='/admin/images/buttons/delete24.png'></a></td> </tr>";
		   }
		 
		 }
		 ?>
</table>

<br />

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1><?php echo $lang['adm_banovane_masine']; ?></h1></td>
  </tr>
</table>

<table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th>ID</th>
	  <th>IP</th>
	  <th><?php echo $lang['adm_razlog']; ?></th>
	  <th><?php echo $lang['dodao']; ?></th>
	  <th></th>
	  <th></th>
	  </tr>
	  
	  	  <?php
		 $s_q = mysql_query("SELECT * FROM b_servers WHERE type='2' ORDER BY id DESC") or die(mysql_error());
		 if(mysql_num_rows($s_q) < 1){
		   echo "<tr> <td></td> <td></td> <td>$lang[nema]</td> <td></td> <td></td>  <Td></td> </tr>"; 
		 } else {
			 
		   while($k = mysql_Fetch_array($s_q)){
	       $time = time_ago($k['time']);
		   echo "<tr> <td>#$k[id]</td> <td>$k[ip]</td> <td>$k[razlog]</td> <td><a href='/admin/member/$k[author]'>$k[author]</a></td> <td>$time</td>  <Td><a href='/admin/adminprocess.php?task=obrisi_ban&id=$k[id]'><img src='/admin/images/buttons/delete24.png'></a></td> </tr>";
		   }
		 
		 }
		 ?>
</table>

<div style="height:10px;"></div>

<form action="/admin/adminprocess.php?task=banuj_ip" method="POST">
  <input type="text" class="text" name="ip" required="required" placeholder="IP"> <div style="height:5px;"></div>
  <textarea class="textarea" name="razlog" required="required" style="min-width:300px;max-width:400px;min-height:50px;max-height:100px;" placeholder="<?php echo $lang['adm_razlog']; ?>"></textarea> <div style="height:5px;"></div>
  <select class="select" name="type">
    <option value="1"><?php echo $lang['adm_serveri']; ?></option>
	<option value="2"><?php echo $lang['adm_masine']; ?></option>
  </select>
  <div style="height:5px;"></div>
  <input type="submit" value="<?php echo $lang['posalji']; ?>" class="button green" />
</form>