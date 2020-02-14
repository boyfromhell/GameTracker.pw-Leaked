<?php 
include($_SERVER['DOCUMENT_ROOT'].'/connect_db.php'); 

$i = addslashes($_GET['i']);

if($i == "1"){
  $g = "cs16";
} else if($i == "2"){
  $g = "css";
} else if($i == "3"){
  $g = "csgo";
} else if($i == "4"){
  $g = "cod2";
} else if($i == "5"){
  $g = "cod4";
} else if($i == "6"){
  $g = "minecraft";
} else if($i == "7"){
  $g = "samp";
} else if($i == "8"){
  $g = "tf2";
} else if($i == "9"){
  $g = "teamspeak3";
} else {}

$server_rank = 1;
// rank_pts+0 = order fix
$server_query	= mysql_query("SELECT * FROM servers WHERE game='$g' ORDER BY rank_pts DESC");
while($server_row = mysql_fetch_assoc($server_query)){
	$server_id		= $server_row['id'];
	$rank           = $server_row['rank'];
	$best_rank      = $server_row['best_rank'];
	$worst_rank     = $server_row['worst_rank'];
	
	if($rank == "99999"){} else {
	
	$update_query	= mysql_query("UPDATE servers SET rank='$server_rank' WHERE id='$server_id'");
	$server_rank++;
	
	$testrank++;
	
	if($best_rank == "" OR $best_rank =="0"){
	  mysql_query("UPDATE servers SET best_rank='$testrank' WHERE id='$server_id'");
	} else if($testrank < $best_rank){
	  mysql_query("UPDATE servers SET best_rank='$testrank' WHERE id='$server_id'");
	}
	
    if($worst_rank == "" OR $worst_rank =="0"){
	  mysql_query("UPDATE servers SET worst_rank='$testrank' WHERE id='$server_id'");
	} else if($testrank > $worst_rank){
	  mysql_query("UPDATE servers SET worst_rank='$testrank' WHERE id='$server_id'");
	}	
	
	}
	
}