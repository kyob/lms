<?php
function module_main()
{
    global $DB,$LMS,$SESSION,$SMARTY,$CONFIG;

    $link = mysqli_connect($CONFIG['aspa']['host'], $CONFIG['aspa']['user'], $CONFIG['aspa']['password'], $CONFIG['aspa']['database']);


/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
    $usernodes = $LMS->GetCustomerNodes($SESSION->id);
    foreach($usernodes as $un) {
	$ip_arr[]=$un[ip];
    }

    $id=1;
    foreach($ip_arr as $ip) {
### aspa_n6_bots_5 ###
	$sql= 'SELECT time,ip,sport,dip,dport,name FROM aspa_n6_bots_5 WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result = mysqli_query($link, $sql);

	if (!$result) {
	    echo "DB Error, could not query the database\n";	echo 'MySQL Error: ' . mysql_error();	exit;
	}

	while ($row = mysqli_fetch_array($result, MYSQL_NUM)) {
	    $aspa_n6_bots_5[$id][]=$row;
	}
	//mysql_free_result($result);

### aspa_n6_bots_drone_poland ###
	$sql2= 'SELECT timestamp,ip,port,type,infection FROM aspa_n6_bots_drone_poland WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result2 = mysqli_query($link, $sql2);

	if (!$result2) {
	    echo "DB Error, could not query the database\n";	echo 'MySQL Error: ' . mysql_error();	exit;
	}

	while ($row2 = mysqli_fetch_array($result2, MYSQL_NUM)) {
	    $aspa_n6_bots_drone_poland[$id][]=$row2;
	}
	//mysql_free_result($result2);

### aspa_n6_dns_open_resolvers_poland ###
	$sql3= 'SELECT timestamp,ip,port,protocol,dns_version FROM aspa_n6_dns_open_resolvers_poland WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result3 = mysqli_query($link, $sql3);

	if (!$result3) {
	    echo "DB Error, could not query the database\n"; echo 'MySQL Error: ' . mysql_error(); exit;
	}

	while ($row3 = mysqli_fetch_array($result3, MYSQL_NUM)) {
	    $aspa_n6_dns_open_resolvers_poland[$id][]=$row3;
	}
	//mysql_free_result($result3);

### aspa_n6_sinkhole_http_drone_poland ###
	$sql4= 'SELECT timestamp,ip,url,http_agent,dst_port,dst_ip FROM aspa_n6_sinkhole_http_drone_poland WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result4 = mysqli_query($link, $sql4);

	if (!$result4) {
	    echo "DB Error, could not query the database\n"; echo 'MySQL Error: ' . mysql_error(); exit;
	}

	while ($row4 = mysqli_fetch_array($result4, MYSQL_NUM)) {
	    $aspa_n6_sinkhole_http_drone_poland[$id][]=$row4;
	}
	//mysql_free_result($result4);

### aspa_n6_netbios_poland ###
	$sql5= 'SELECT timestamp,ip,port,hostname,tag,workgroup,machine_name,username FROM aspa_n6_netbios_poland WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result5 = mysqli_query($link, $sql5);

	if (!$result5) {
	    echo "DB Error, could not query the database\n"; echo 'MySQL Error: ' . mysql_error(); exit;
	}

	while ($row5 = mysqli_fetch_array($result5, MYSQL_NUM)) {
	    $aspa_n6_netbios_poland[$id][]=$row5;
	}
	//mysql_free_result($result5);

### aspa_n6_ntp_poland ###
	$sql6= 'SELECT timestamp,ip,port,protocol,hostname,version,processor,stratum,system FROM aspa_n6_ntp_poland WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result6 = mysqli_query($link, $sql6);

	if (!$result6) {
	    echo "DB Error, could not query the database\n";	    echo 'MySQL Error: ' . mysql_error();	    exit;
	}

	while ($row6 = mysqli_fetch_array($result6, MYSQL_NUM)) {
	    $aspa_n6_ntp_poland[$id][]=$row6;
	}
//	mysql_free_result($result6);

### aspa_n6_snmp_poland ###
	$sql7= 'SELECT timestamp,ip,protocol,port,hostname,sysdesc,sysname,version FROM aspa_n6_snmp_poland WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result7 = mysqli_query($link, $sql7);

	if (!$result7) {
	    echo "DB Error, could not query the database\n";	    echo 'MySQL Error: ' . mysql_error();	    exit;
	}

	while ($row7 = mysqli_fetch_array($result7, MYSQL_NUM)) {
	    $aspa_n6_snmp_poland[$id][]=$row7;
	}
	//mysql_free_result($result7);
//
### aspa_n6_ssdp_poland ###
	$sql8= 'SELECT timestamp,ip,protocol,port,hostname,systime,location,server FROM aspa_n6_ssdp_poland WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result8 = mysqli_query($link, $sql8);

	if (!$result8) {
	    echo "DB Error, could not query the database\n";	    echo 'MySQL Error: ' . mysql_error();	    exit;
	}

	while ($row8 = mysqli_fetch_array($result8, MYSQL_NUM)) {
	    $aspa_n6_ssdp_poland[$id][]=$row8; 
	}
//	mysql_free_result($result8);

### aspa_n6_bots_6 ###
	$sql9= 'SELECT infected_ip,from_unixtime(lastseen_timestamp, "%Y-%m-%d %h:%i:%s"),bot_name FROM aspa_n6_bots_6 WHERE infected_ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result9 = mysqli_query($link, $sql9);

	if (!$result9) {
	    echo "DB Error, could not query the database\n";	    echo 'MySQL Error: ' . mysql_error();	    exit;
	}

	while ($row9 = mysqli_fetch_array($result9, MYSQL_NUM)) {
	    $aspa_n6_bots_6[$id][]=$row9;
	}
//	mysql_free_result($result9);

### aspa_n6_certpl_sinkhole_2 ###
	$sql10= 'SELECT time,ip,dst_ip,dst_port,proto,name FROM aspa_n6_certpl_sinkhole_2 WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result10 = mysqli_query($link, $sql10);

	if (!$result10) {
	    echo "DB Error, could not query the database\n";	    echo 'MySQL Error: ' . mysql_error();	    exit;
	}

	while ($row10 = mysqli_fetch_array($result10, MYSQL_NUM)) {
	    $arr10[$id][]=$row10;	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
	}
//	mysql_free_result($result10);


### aspa_n6_malurl_11 ###
	$sql11= 'SELECT timestamp,ip,port,hostname,tag,url,http_host,category,system,detected_since FROM aspa_n6_malurl_11 WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result11 = mysqli_query($link, $sql11);

	if (!$result11) {
	    echo "DB Error, could not query the database\n";	    echo 'MySQL Error: ' . mysql_error();	    exit;
	}

	while ($row11 = mysqli_fetch_array($result11, MYSQL_NUM)) {
	    $aspa_n6_malurl_11[$id][]=$row11;	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
	}
//	mysql_free_result($result11);

### aspa_n6_bots_zeroaccess ###
	$sql12= 'SELECT time,ip FROM aspa_n6_bots_zeroaccess WHERE ip="'.$ip.'" ORDER BY id DESC LIMIT 10';
	$result12 = mysqli_query($link, $sql12);

	if (!$result12) {
	    echo "DB Error, could not query the database\n";	    echo 'MySQL Error: ' . mysql_error();	    exit;
	}

	while ($row12 = mysqli_fetch_array($result12, MYSQL_NUM)) {
	    $aspa_n6_bots_zeroaccess[$id][]=$row12;	    //printf("ID: %s  Name: %s", $row[0], $row[1]);  
	}
//	mysql_free_result($result12);





	$id++;
    }


//echo 'Connected successfully';
mysqli_close($link);

//echo '<pre>';print_r($arr);echo '</pre>';

$SMARTY->assign('arr', $aspa_n6_bots_5);
$SMARTY->assign('arr2', $aspa_n6_bots_drone_poland);
$SMARTY->assign('arr3', $aspa_n6_dns_open_resolvers_poland);
$SMARTY->assign('arr4', $aspa_n6_sinkhole_http_drone_poland);
$SMARTY->assign('arr5', $aspa_n6_netbios_poland);
$SMARTY->assign('arr6', $aspa_n6_ntp_poland);
$SMARTY->assign('arr7', $aspa_n6_snmp_poland);
$SMARTY->assign('arr8', $aspa_n6_ssdp_poland);
$SMARTY->assign('arr9', $aspa_n6_bots_6);

$SMARTY->assign('arr10', $aspa_n6_certpl_sinkhole_2);
$SMARTY->assign('arr11', $aspa_n6_malurl_11);
$SMARTY->assign('arr12', $aspa_n6_bots_zeroaccess);
//$SMARTY->assign('usernodes', $usernodes);

$SMARTY->display('module:security.html');
}

?>
