<?php
// Time ago function
function time_ago($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}
					
// DB
// DB
define('DB_HOST', 'localhost');
define('DB_USER', 'westbalk_gtscript');
define('DB_PASS', 'newgenerationgt2017');
define('DB_NAME', 'westbalk_gtscript');

if (!$db=@mysql_connect(DB_HOST, DB_USER, DB_PASS))
{
	die ("<b>Doslo je do greske prilikom spajanja na MySQL...</b>");
}

if (!mysql_select_db(DB_NAME, $db))
{
	die ("<b>Greska prilikom biranja baze!</b>");
}

// gametracker config
$gt_allowed_countries	= array(
						'Serbia'			=> 'RS',
						'Bulgaria'       => 'BG',
						'Bosnia and Herzegovina' => 'BA',
						'Croatia'			=> 'HR',
						'Macedonia'			=> 'MK',
						'Montenegro'        => 'ME',
						'Albania'     => 'AL',
						'Romania'   => 'RO',
						'United States' => 'US',
						'Russia'   => 'RU',
						'Germany'  => 'DE',
						'Poland'  => 'PL',
						'Lithuania'  => 'LT',
						'Turkey'  => 'TR',
						'France'  => 'FR',
						'Australia'  => 'AU',
						'Brazil'  => 'BR',
						);


$gt_allowed_games		= array(
						'Counter-Strike'			=> 'cs16',
						'Counter-Strike: Source'    => 'css',
						'Counter-Strike: Global Offensive' => 'csgo',
						'Call Of Duty 2'            => 'cod2',
						'Call Of Duty 4'            => 'cod4',
						'MineCraft'                 => 'minecraft',
						'San Andreas Multiplayer'   => 'samp',
						'Team Fortress 2'           => 'tf2',
						'TeamSpeak 3'               => 'teamspeak3',
						);

// title
if($page == "")  {$title = "Pocetna"; }
if($_GET['page'] == "servers") {$title = "Serveri"; }
if($_GET['page'] == "server_info") {
	$ip = addslashes($_GET['ip']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM servers WHERE ip='$ip'"));
	
	$title = "$info[hostname]";
}
if($_GET['page'] == "banned_s") {$title = "Banovani serveri"; }
if($_GET['page'] == "memberlist") {$title = "Korisnici"; }
if($_GET['page'] == "member") {
	$username = addslashes($_GET['username']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username='$username'"));
	
	$title = "$info[username]";
}
if($_GET['page'] == "communities") {$title = "Zajednice"; }
if($_GET['page'] == "community_info") {
	$id = addslashes($_GET['id']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM community WHERE id='$id'"));
	
	$title = "$info[naziv]";
}
if($_GET['page'] == "messages") {$title = "Poruke"; }
if($_GET['page'] == "message_info") {
	$id = addslashes($_GET['id']);
	$info = mysql_fetch_array(mysql_query("SELECT * FROM poruke WHERE id='$id'"));
	
	$title = "$info[title]";
}
if($_GET['page'] == "user_log") {$title = "User Logs"; }

?>