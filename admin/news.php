<?php
defined("access") or die("Nedozvoljen pristup");
?>


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="title">
  <tr>
    <td align="left"><h1>Obavestenja</h1></td>
  </tr>
</table>

<table width="100%" align="center" cellpadding="1" cellspacing="1" class="data">
	  <tr>
	  <th>ID</th>
	  <th>Naslov</th>
	  <th>Text</th>
	  <th><?php echo $lang['dodao']; ?></th>
	  <th>Datum</th>
	  <th></th>
	  </tr>
	  
	  	  <?php
		 $s_q = mysql_query("SELECT * FROM acp_obavestenja ORDER BY id DESC LIMIT 3") or die(mysql_error());
		 if(mysql_num_rows($s_q) < 1){
		   echo "<tr> <td></td> <td></td> <td>$lang[nema]</td> <td></td> <td></td>  <Td></td> </tr>"; 
		 } else {
			 
		   while($k = mysql_Fetch_array($s_q)){
	       $time = time_ago($k['time']);
		   echo "<tr> <td>#$k[id]</td> <td>$k[title]</td> <td>$k[text]</td> <td><a href='/admin/member/$k[author]'>$k[author]</a></td> <td>$time</td>  <Td><a href='/admin/adminprocess.php?task=obrisi_obv&id=$k[id]'><img src='/admin/images/buttons/delete24.png'></a></td> </tr>";
		   }
		 
		 }
		 ?>	  

</table>

<div style="height:10px;"></div>

<form action="/admin/adminprocess.php?task=dodaj_vest" method="POST">
  <input type="text" class="text" name="title" required="required" placeholder="Naslov"> <div style="height:5px;"></div>
  <textarea class="textarea" name="text" required="required" style="min-width:300px;max-width:400px;min-height:50px;max-height:100px;" placeholder="Text"></textarea> <div style="height:5px;"></div>

  <div style="height:5px;"></div>
  <input type="submit" value="<?php echo $lang['posalji']; ?>" class="button green" />
</form>