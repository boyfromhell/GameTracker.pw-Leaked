<?php 
include($_SERVER['DOCUMENT_ROOT'].'/connect_db.php'); 

$i = addslashes($_GET['i']);

if($i == "1"){
$server_query	= mysql_query("SELECT * FROM servers ORDER BY rank_pts DESC");
while($server_row = mysql_fetch_assoc($server_query)){
	$server_id					= $server_row['id'];
	$server_ip					= $server_row['ip'];
	$server_port				= $server_row['port'];
	$server_game				= $server_row['game'];
	$server_rank_pts			= $server_row['rank_pts'];
	$server_playercount			= $server_row['playercount_6h'];
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
		
		$rank_pts			= $server_rank_pts + ($num_players/$max_players);

		$players = $playercount_hour;
  
        $niz = explode(',' , $players);

        $suma = array_sum( $niz );

		$igraci = round($suma / count( $niz ), 0);
        if($server_game == "cs16" OR $server_game == "css" OR $server_game == "csgo" OR $server_game == "cod2" OR $server_game == "cod4" OR $server_game == "tf2"){
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
		
		$server_playercount	= substr($server_playercount, 3);
		$server_playercount	= $server_playercount.",".$igraci;
		} else if($server_game == "minecraft" OR $server_game == "samp" OR $server_game == "teamspeak3"){
			
		if($igraci < 10){
	          $igraci = "000$igraci";
        } else if($igraci == "10" OR $igraci > 10 && $igraci < 100){
	          $igraci = "00$igraci";
        } else if($igraci == "100" OR $igraci > 100 && $igraci < 1000){
	          $igraci = "0$igraci";
        } else if($igraci == "1000" OR $igraci > 1000 && $igraci < 10000){
	          $igraci = "$igraci";
        }

		$server_playercount	= substr($server_playercount, 5);
		$server_playercount	= $server_playercount.",".$igraci;		
		}
			

		$update_query		= mysql_query("UPDATE servers SET  playercount_6h='$server_playercount' WHERE id='$server_id'");
	} else {
        if($server_game == "cs16" OR $server_game == "css" OR $server_game == "csgo" OR $server_game == "cod2" OR $server_game == "cod4" OR $server_game == "tf2"){
		$server_playercount		= substr($server_playercount,3);
		$server_playercount		= $server_playercount.",00";
		} else if($server_game == "minecraft" OR $server_game == "samp" OR $server_game == "teamspeak3"){
		$server_playercount		= substr($server_playercount,5);
		$server_playercount		= $server_playercount.",0000";			
		}
		$update_query			= mysql_query("UPDATE servers SET online='0', playercount_6h='$server_playercount', last_chart_update='$timestamp' WHERE id='$server_id'");
	}
}
}


} else if($i == "2"){
$server_query	= mysql_query("SELECT * FROM servers ORDER BY rank_pts DESC");
while($server_row = mysql_fetch_assoc($server_query)){
	$server_id					= $server_row['id'];
	$server_ip					= $server_row['ip'];
	$server_port				= $server_row['port'];
	$server_game				= $server_row['game'];
	$last_update                = time();
	
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
				
		$mapname			= mysql_real_escape_string($data['gq_mapname']);
		
        $mapname		= (!empty($mapname)) ? $mapname : '---';
		
        if($mapname == "---"){} else {
		
		$q = mysql_query("SELECT * FROM maps WHERE sid='$server_id' AND name='$mapname'");
		$check = mysql_num_rows($q);
		if($check < 1){
			mysql_query("INSERT INTO maps (sid,name,num) VALUES ('$server_id','$mapname','1')");
		} else {
		
		$srv = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE id='$server_id'"));
				
		if($srv['last_map'] == "$data[gq_mapname]"){} else {
			$in = mysql_fetch_array($q);
			$br = $in['num'];
			$novi_br = $br + 1;
			mysql_query("UPDATE maps SET num='$novi_br' WHERE sid='$server_id' AND name='$mapname'");
		}
		
		if($srv['last_map'] == "$data[gq_mapname]"){} else {
				$update_map = mysql_query("UPDATE servers SET last_map='$data[gq_mapname]' WHERE id='$server_id'");
        }
		
		}
		
		}
		
		
	}
		
		
	
}

}

}
?>