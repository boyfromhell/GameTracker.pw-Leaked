<?php
include($_SERVER['DOCUMENT_ROOT'].'/connect_db.php');
// Send the headers
header('Content-Type: text/xml; charset=utf-8');
header('Pragma: public');
header('Cache-control: private');
header('Expires: -1');
echo "<?xml version=\"1.0\"?>";

$ip = addslashes($_GET['ip']);
$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));

// Prosek
$players = $info['playercount'];
  
$niz24 = explode(',' , $players);

$niz1 = substr($players , 12);
$niz12 = explode(',' , $niz1);

$suma = array_sum( $niz24 );
$suma1 = array_sum( $niz12 );

$prosek = round($suma / count( $niz24 ), 2);
$prosek12 = round($suma1 / count( $niz12 ), 2);

if($info['ip'] == ""){

echo '
<server_info>
    <errorText>Server not found</errorText>
</server_info>
';
	
} else {

echo '
<server_info>
    <id>'.$info['id'].'</id>
    <rank>'.$info['rank'].'</rank>
	<players>'.$info['num_players'].'</players>
	<playersmax>'.$info['max_players'].'</playersmax>
	<name>'.$info['hostname'].'</name>
	<ip>'.$info['ip'].'</ip>
	<map>'.$info['mapname'].'</map>
	<players_day>'.$info['playercount'].'</players_day>
	<players_week>'.$info['playercount_week'].'</players_week>
	<players_month>'.$info['playercount_month'].'</players_month>
	<rank_month>'.$info['rank_chart_count'].'</rank_month>
	<status>'.$info['online'].'</status>
	<last_update>'.$info['last_update'].'</last_update>
	<added>'.$info['added'].'</added>
	<addedid>'.$info['addedid'].'</addedid>
	<owner>'.$info['owner'].'</owner>
	<ownerid>'.$info['ownerid'].'</ownerid>
	<game>'.$info['game'].'</game>
	<location>'.$info['location'].'</location>
	<modname>'.$info['gamemod'].'</modname>
	<rank_min>'.$info['best_rank'].'</rank_min>
	<rank_max>'.$info['worst_rank'].'</rank_max>
	<prosek12>'.$prosek12.'</prosek12>
	<prosek24>'.$prosek.'</prosek24>
	<forum>'.$info['forum'].'</forum>
	
<players_info>
	';
$players = mysql_query("SELECT * FROM players WHERE sid='$info[id]'");
while($p = mysql_fetch_array($players)){	
$playertime = gmdate("H:i:s", $p[time_online]%86400);
$name = $p['nickname'];
$test = str_replace('<', ' ', $name);

echo '
   <player>
   <pid>'.$p['id'].'</pid>
   <nick>'.$test.'</nick>
   <score>'.$p['score'].'</score>
   <time>'.$playertime.'</time>
   </player>
';
}
echo '
</players_info>

</server_info>
';


}

?>