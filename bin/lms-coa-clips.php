#!/usr/bin/php
<?php
/* 
 * aktualizacja predkosci, przekierowan dla wszystkich nodes z wykorzystaniem radclient
 * Łukasz Kopiszka
 * lukasz@alfa-system.pl
 */
$time_start = microtime(true);

ini_set('error_reporting', E_ALL&~E_NOTICE);
ini_set("log_errors", 1);
ini_set("error_log", "/var/log/lms-vclips.log");
error_log("LMS-COA.php: START at ".date('Y-m-d H:i:s'));

$CONFIG_FILE = '/etc/lms/lms.ini';

if (!is_readable($CONFIG_FILE))
    die('Unable to read configuration file ['.$CONFIG_FILE.']!'); 

$CONFIG = (array) parse_ini_file($CONFIG_FILE, true);

// Check for configuration vars and set default values
$CONFIG['directories']['sys_dir'] = (!isset($CONFIG['directories']['sys_dir']) ? getcwd() : $CONFIG['directories']['sys_dir']);
$CONFIG['directories']['lib_dir'] = (!isset($CONFIG['directories']['lib_dir']) ? $CONFIG['directories']['sys_dir'].'/lib' : $CONFIG['directories']['lib_dir']);

define('SYS_DIR', $CONFIG['directories']['sys_dir']);
define('LIB_DIR', $CONFIG['directories']['lib_dir']);
// Do some checks and load config defaults

require_once(LIB_DIR.'/autoloader.php');

// Init database
 
$_DBTYPE = $CONFIG['database']['type'];
$_DBHOST = $CONFIG['database']['host'];
$_DBUSER = $CONFIG['database']['user'];
$_DBPASS = $CONFIG['database']['password'];
$_DBNAME = $CONFIG['database']['database'];

$DB = null;

try {
    $DB = LMSDB::getDB($_DBTYPE, $_DBHOST, $_DBUSER, $_DBPASS, $_DBNAME);
} catch (Exception $ex) {
    trigger_error($ex->getMessage(), E_USER_WARNING);
    // can't working without database
    die("Fatal error: cannot connect to database!\n");
}

$arr = $DB->GetAll("SELECT lower(m.mac) AS mac, INET_NTOA(n.ipaddr) AS ip, t.downceil AS dl_ceil, t.upceil AS up_ceil, CASE WHEN n.access = 0 OR n.warning = 1 THEN 1 ELSE 0 END AS redirect FROM nodeassignments na INNER JOIN assignments a ON (na.assignmentid = a.id) AND ((UNIX_TIMESTAMP() >= datefrom AND UNIX_TIMESTAMP() <= dateto) OR (UNIX_TIMESTAMP() >= datefrom AND dateto = 0)) INNER JOIN tariffs t ON (a.tariffid = t.id) INNER JOIN nodes n ON (na.nodeid = n.id) INNER JOIN macs m ON (m.nodeid = n.id);");
$i=0;
foreach($arr as $row)
{
    if($row['redirect']==0)
    {
    $fp='CLIPS-DEFAULT';
    $rpn='';
    }elseif($row['redirect']==1){
    $fp='REDIRECT';
    $rpn='KOMUNIKAT';
    }
    $cmd='echo "User-Name='.$row[mac].',Qos-Rate-Outbound='.$row[dl_ceil].',Qos-Rate-Inbound='.$row[up_ceil].',Forward-Policy=in:'.$fp.',HTTP-Redirect-Profile-Name=\''.$rpn.'\',Context-Name=CLIPS" | radclient -r 1 -x '.$CONFIG['redback']['clipsip'].':3799 coa '.$CONFIG['redback']['radiuspass'];
    exec($cmd);
    echo $i++.' # MAC: '.$row['mac'].' # IP: '.$row['ip'].' # DL: '.$row['dl_ceil'].' # UP: '.$row['up_ceil'].' # R: '.$row['redirect'].PHP_EOL;
}
$time_end = microtime(true);
$time = $time_end - $time_start;
echo "\nTake $time seconds\n";
?>
