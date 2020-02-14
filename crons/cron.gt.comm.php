<?php
include($_SERVER['DOCUMENT_ROOT'].'/connect_db.php');
 
$chars = array();
$start = date("H")+2;
for($i = 0; $i < 12; $i++){$chars[] = str_pad( ($start+2*$i)%24, 2, '0', STR_PAD_LEFT);}
$chart_updates = '|' . implode( '|', $chars);
 
 
 $test = mysql_query("SELECT * FROM community");
 while($t = mysql_fetch_array($test)){
 $id = $t['id'];
 
 $sql = "SELECT sum( num_players ) as `suma_igraca`, sum( max_players ) as `max_igraca`
 FROM `servers`
 WHERE
 `id` IN (SELECT `srvid` FROM `community_servers` WHERE `comid` = '{$id}')";
 
 $tmp = mysql_fetch_assoc( mysql_query( $sql ) );
 
 
 $rank_pts = $t['rank_pts'] + $tmp['suma_igraca'] / $tmp['max_igraca'];
 $igraci = $tmp['suma_igraca'];
 
        if($igraci == "0")       {$igraci = "000";}
                if($igraci == "1")       {$igraci = "001";}
                if($igraci == "2")       {$igraci = "002";}
                if($igraci == "3")       {$igraci = "003";}
                if($igraci == "4")       {$igraci = "004";}
                if($igraci == "5")       {$igraci = "005";}
                if($igraci == "6")       {$igraci = "006";}
                if($igraci == "7")       {$igraci = "007";}
                if($igraci == "8")       {$igraci = "008";}
                if($igraci == "9")       {$igraci = "009";}
                if($igraci == "10")      {$igraci = "010";}
                if($igraci == "11")      {$igraci = "011";}
                if($igraci == "12")      {$igraci = "012";}
                if($igraci == "13")      {$igraci = "013";}
                if($igraci == "14")      {$igraci = "014";}
                if($igraci == "15")      {$igraci = "015";}
                if($igraci == "16")      {$igraci = "016";}
                if($igraci == "17")      {$igraci = "017";}
                if($igraci == "18")      {$igraci = "018";}
                if($igraci == "19")      {$igraci = "019";}
                if($igraci == "20")      {$igraci = "020";}
                if($igraci == "21")      {$igraci = "021";}
                if($igraci == "22")      {$igraci = "022";}
                if($igraci == "23")      {$igraci = "023";}
                if($igraci == "24")      {$igraci = "024";}
                if($igraci == "25")      {$igraci = "025";}
                if($igraci == "26")      {$igraci = "026";}
                if($igraci == "27")      {$igraci = "027";}
                if($igraci == "28")      {$igraci = "028";}
                if($igraci == "29")      {$igraci = "029";}
                if($igraci == "30")      {$igraci = "030";}
                if($igraci == "31")      {$igraci = "031";}
                if($igraci == "32")      {$igraci = "032";}
                if($igraci == "33")      {$igraci = "033";}
                if($igraci == "34")      {$igraci = "034";}
                if($igraci == "35")      {$igraci = "035";}
                if($igraci == "36")      {$igraci = "036";}
                if($igraci == "37")      {$igraci = "037";}
                if($igraci == "38")      {$igraci = "038";}
                if($igraci == "39")      {$igraci = "039";}
                if($igraci == "40")      {$igraci = "040";}
                if($igraci == "41")      {$igraci = "041";}
                if($igraci == "42")      {$igraci = "042";}
                if($igraci == "43")      {$igraci = "043";}
                if($igraci == "44")      {$igraci = "044";}
                if($igraci == "45")      {$igraci = "045";}
                if($igraci == "46")      {$igraci = "046";}
                if($igraci == "47")      {$igraci = "047";}
                if($igraci == "48")      {$igraci = "048";}
                if($igraci == "49")      {$igraci = "049";}
                if($igraci == "50")      {$igraci = "050";}
                if($igraci == "51")      {$igraci = "051";}
                if($igraci == "52")      {$igraci = "052";}
                if($igraci == "53")      {$igraci = "053";}
                if($igraci == "54")      {$igraci = "054";}
                if($igraci == "55")      {$igraci = "055";}
                if($igraci == "56")      {$igraci = "056";}
                if($igraci == "57")      {$igraci = "057";}
                if($igraci == "58")      {$igraci = "058";}
                if($igraci == "59")      {$igraci = "059";}
                if($igraci == "60")      {$igraci = "060";}
                if($igraci == "61")      {$igraci = "061";}
                if($igraci == "62")      {$igraci = "062";}
                if($igraci == "63")      {$igraci = "063";}
                if($igraci == "64")      {$igraci = "064";}
                if($igraci == "65")      {$igraci = "065";}
                if($igraci == "66")      {$igraci = "066";}
                if($igraci == "67")      {$igraci = "067";}
                if($igraci == "68")      {$igraci = "068";}
                if($igraci == "69")      {$igraci = "069";}
                if($igraci == "70")      {$igraci = "070";}
                if($igraci == "71")      {$igraci = "071";}
                if($igraci == "72")      {$igraci = "072";}
                if($igraci == "73")      {$igraci = "073";}
                if($igraci == "74")      {$igraci = "074";}
                if($igraci == "75")      {$igraci = "075";}
                if($igraci == "76")      {$igraci = "076";}
                if($igraci == "77")      {$igraci = "077";}
                if($igraci == "78")      {$igraci = "078";}
                if($igraci == "79")      {$igraci = "079";}
                if($igraci == "80")      {$igraci = "080";}
                if($igraci == "81")      {$igraci = "081";}
                if($igraci == "82")      {$igraci = "082";}
                if($igraci == "83")      {$igraci = "083";}
                if($igraci == "84")      {$igraci = "084";}
                if($igraci == "85")      {$igraci = "085";}
                if($igraci == "86")      {$igraci = "086";}
                if($igraci == "87")      {$igraci = "087";}
                if($igraci == "88")      {$igraci = "088";}
                if($igraci == "89")      {$igraci = "089";}
                if($igraci == "90")      {$igraci = "090";}
                if($igraci == "91")      {$igraci = "091";}
                if($igraci == "92")      {$igraci = "092";}
                if($igraci == "93")      {$igraci = "093";}
                if($igraci == "94")      {$igraci = "094";}
                if($igraci == "95")      {$igraci = "095";}
                if($igraci == "96")      {$igraci = "096";}
                if($igraci == "97")      {$igraci = "097";}
                if($igraci == "98")      {$igraci = "098";}
                if($igraci == "99")      {$igraci = "099";}
                if($igraci == "100")      {$igraci = "100";}
               
                $comm_playercount                       = $t['playercount'];
               
                $comm_playercount       = substr($comm_playercount, 4);
                $comm_playercount       = $comm_playercount.",".$igraci;
                
		if($t['maxslots'] == ""){} else {
                $update_query           = mysql_query("UPDATE community SET playercount='$comm_playercount',maxslots='$tmp[max_igraca]', chart_updates='$chart_updates', rank_pts='$rank_pts' WHERE id='{$id}'");
		}
 
 }
?>