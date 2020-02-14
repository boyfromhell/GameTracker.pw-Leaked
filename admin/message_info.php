    <?php
	defined("access") or die("Nedozvoljen pristup");

		$id = addslashes($_GET['id']);
		
		$info = mysql_fetch_array(mysql_query("SELECT * FROM poruke WHERE id='$id'"));
		
		if($info['id'] == ""){
			die("<script> alert('$lang[poruka_nepostoji]'); document.location.href='/admin/poruke'; </script>");
		}
		
			     $od = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$info[od]'"));
				 $za = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$info[za]'"));
				 $time = time_ago($info['time']);
				 
					 echo "
					 <a href='/admin/poruke'><button class='button blue'>$lang[nazad_na_poruke]</button></a> 
					 <a href='/admin/adminprocess.php?task=obrisi_poruku&id=$info[id]'><button style='float:right;' class='button stop red'>Obrisi Poruku</button></a> <div style='height:10px;'></div>
					 
					 <div style='padding:10px;' class='data'>
					 <img style='width:50px;height:50px;' src='/avatars/$od[avatar]'>
				     <div style='margin-left:55px;margin-top:-50px;'>
				     <a href='/member/$od[username]'>$od[username]</a> > <a href='/member/$za[username]'>$za[username]</a>  <span style='float:right;'><small>$time</small></span> <div style='height:5px;'></div> <em>$info[title]</em> <div style='height:5px;'></div> <small>$info[message]</small> <div style='height:3px;'></div>
				     </div>
					 </div>
					 
					 <div style='height:5px;'></div>
					 ";
					 
	  $mc = mysql_query("SELECT * FROM messages_answers WHERE mid='$id' ORDER BY time ASC");
	  while($c = mysql_fetch_array($mc)){
	  
			$user = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE userid='$c[authorid]'"));
			
	        $message = nl2br($c['message']);
			
			$time = time_ago($c['time']);
			
	    echo "
			  <div style='padding:10px;' class='data'>
			  <img style='width:50px;height:50px;' src='/avatars/$user[avatar]'>
			  <div style='margin-left:55px;margin-top:-50px;'>
			    <a href='/member/$user[username]'>$user[username]</a> <div style='height:10px;'></div> $message  <div style='height:10px;'></div> <small>$time.</small></span>
			  </div>
              </div> <div style='height:5px;'></div>
		";
	    }

            ?>					