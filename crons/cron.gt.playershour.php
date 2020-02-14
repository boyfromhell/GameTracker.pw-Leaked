<?php 
include($_SERVER['DOCUMENT_ROOT'].'/connect_db.php'); 

$server_query	= mysql_query("SELECT id,ip,game,rank_pts,playercount,playercount_hour FROM servers ORDER BY rank_pts DESC");
while($server_row = mysql_fetch_assoc($server_query)){
	$server_id					= $server_row['id'];
	$server_ip					= $server_row['ip'];
	$server_game				= $server_row['game'];
	$server_rank_pts			= $server_row['rank_pts'];
	$server_playercount			= $server_row['playercount'];
	$playercount_hour           = $server_row['playercount_hour'];
	
require_once($_SERVER['DOCUMENT_ROOT'].'/GameQ.php'); 
$servers = array(
	array(
		'id' => $server_id,
		'type' => $server_game,
		'host' => $server_ip,
	)
);
$gq = new GameQ();
$gq->addServers($servers);
$gq->setOption('timeout', 4); // Seconds
$gq->setFilter('normalise');
$results = $gq->requestData();

foreach($results as $data){
	

    if($data['gq_online'] == "1"){
		$num_players		= mysql_real_escape_string($data['gq_numplayers']);
		$max_players		= mysql_real_escape_string($data['gq_maxplayers']);	

		if($server_game == "cs16" OR $server_game == "css" OR $server_game == "csgo" OR $server_game == "cod2" OR $server_game == "cod4" OR $server_game == "tf2"){
		$igraci = mysql_real_escape_string($data['gq_numplayers']);
        if($igraci == "0")       {$igraci = "00";}
		if($igraci == "1")       {$igraci = "01";}
		if($igraci == "2")       {$igraci = "02";}
		if($igraci == "3")       {$igraci = "03";}
		if($igraci == "4")       {$igraci = "04";}
		if($igraci == "5")       {$igraci = "05";}
		if($igraci == "6")       {$igraci = "06";}
		if($igraci == "7")       {$igraci = "07";}
		if($igraci == "8")       {$igraci = "08";}
		if($igraci == "9")       {$igraci = "09";}
		
		$playercount_hour	= substr($playercount_hour, 3);
		$playercount_hour	= $playercount_hour.",".$igraci;
        } else if($server_game == "minecraft" OR $server_game == "samp" OR $server_game == "teamspeak3"){
		$igraci = mysql_real_escape_string($data['gq_numplayers']);
		if($igraci < 10){
	          $igraci = "000$igraci";
        } else if($igraci == "10" OR $igraci > 10 && $igraci < 100){
	          $igraci = "00$igraci";
        } else if($igraci == "100" OR $igraci > 100 && $igraci < 1000){
	          $igraci = "0$igraci";
        } else if($igraci == "1000" OR $igraci > 1000 && $igraci < 10000){
	          $igraci = "$igraci";
        }

		$playercount_hour	= substr($playercount_hour, 5);
		$playercount_hour	= $playercount_hour.",".$igraci;		
		}
		
		if($igraci == ""){} else {
		$update_query		= mysql_query("UPDATE servers SET playercount_hour='$playercount_hour' WHERE id='$server_id'");
		echo "$server_ip <b>$igraci</b> <br />";
		}
	} else {
		if($server_game == "cs16" OR $server_game == "css" OR $server_game == "csgo" OR $server_game == "cod2" OR $server_game == "cod4" OR $server_game == "tf2"){
		$playercount_hour		= substr($playercount_hour,3);
		$playercount_hour		= $playercount_hour.",00";
		} else if($server_game == "minecraft" OR $server_game == "samp" OR $server_game == "teamspeak3"){
		$playercount_hour		= substr($playercount_hour,5);
		$playercount_hour		= $playercount_hour.",0000";			
		}
		
		$update_query			= mysql_query("UPDATE servers SET online='0', playercount_hour='$playercount_hour' WHERE id='$server_id'");
	}
	
}
}
?>