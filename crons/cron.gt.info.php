<?php 
include($_SERVER['DOCUMENT_ROOT'].'/connect_db.php'); 

$server_query	= mysql_query("SELECT id,ip,game FROM servers WHERE UNIX_TIMESTAMP()-last_update>180 ORDER BY rank_pts DESC");
while($server_row = mysql_fetch_assoc($server_query)){
	$server_id					= $server_row['id'];
	$server_ip					= $server_row['ip'];
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
		$hostname			= mysql_real_escape_string($data['gq_hostname']);
		$mapname			= mysql_real_escape_string($data['gq_mapname']);
		$num_players		= mysql_real_escape_string($data['gq_numplayers']);
		$max_players		= mysql_real_escape_string($data['gq_maxplayers']);
		$players			= $data['players'];
		
        $hostname		= (!empty($hostname)) ? $hostname : '---';
        $mapname		= (!empty($mapname)) ? $mapname : '---';
        $max_players		= (!empty($max_players)) ? $max_players : '---';
		
		if($hostname == "---" OR $mapname == "---" OR $max_players == "---"){
		$update_query		= mysql_query("UPDATE servers SET online='1', num_players='$num_players', last_update='$last_update' WHERE id='$server_id'");
		} else {
		$update_query		= mysql_query("UPDATE servers SET online='1', hostname='$hostname', mapname='$mapname', num_players='$num_players', max_players='$max_players', last_update='$last_update' WHERE id='$server_id'");
		}
		
		
		$del_player_query	= mysql_query("DELETE FROM players WHERE sid='$server_id'");
		foreach ($players as $player) {
			$player_nickname		= mysql_real_escape_string($player['gq_name']);
			$player_score			= mysql_real_escape_string($player['gq_score']);
			$player_time			= mysql_real_escape_string($player['time']);
			$player_nickname		= (!empty($player_nickname)) ? $player_nickname : 'anonymous';
			$insert_player_query	= mysql_query("INSERT INTO players (id,nickname,score,time_online,mapname,sid) VALUES ('','$player_nickname','$player_score','$player_time','$mapname','$server_id')");
		}
	} else {
		$update_query		= mysql_query("UPDATE servers SET online='0',num_players='0' WHERE id='$server_id'");
		$del_player_query	= mysql_query("DELETE FROM players WHERE sid='$server_id'");
	}
	
}

}
?>