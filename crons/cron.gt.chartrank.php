<?php 
include($_SERVER['DOCUMENT_ROOT'].'/connect_db.php'); 

$i = $_GET['i'];

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

$chars = array();
$start = date("d")+2;
for($i = 0; $i < 15; $i++){$chars[] = str_pad( ($start+2*$i)%30, 2, '0', STR_PAD_LEFT);}
$chart_updates = '|' . implode( '|', $chars);

// rank_pts+0 = order fix
$server_query	= mysql_query("SELECT * FROM servers WHERE game='$g' ORDER BY rank_pts DESC");
while($server_row = mysql_fetch_assoc($server_query)){
	$server_id		= $server_row['id'];
	$rank           = $server_row['rank'];
	$best_rank      = $server_row['best_rank'];
	$worst_rank     = $server_row['worst_rank'];
	$rank_chart_count = $server_row['rank_chart_count'];
	
    if($rank < 10)       {$rank_mysql = "0000$rank";} else if($rank > 9){$rank_mysql = "000$rank"; } else if($rank > 99){$rank_mysql = "00$rank";} else if($rank > 999){$rank_mysql = "0$rank";}
	
	$rank_chart_count	= substr($rank_chart_count, 6);
	$rank_chart_count	= $rank_chart_count.",".$rank_mysql;
	
	print_r($rank_chart_count);
	
	$update_query	= mysql_query("UPDATE servers SET rank_chart_count='$rank_chart_count',rank_chart_updates='$chart_updates' WHERE id='$server_id'");	
	}
?>