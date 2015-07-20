<?php

ini_set('error_reporting', E_ALL & ~E_NOTICE);

// REPLACE THIS WITH PATH TO YOU CONFIG FILE

$CONFIG_FILE = '/etc/lms/lms.ini';

// PLEASE DO NOT MODIFY ANYTHING BELOW THIS LINE UNLESS YOU KNOW
// *EXACTLY* WHAT ARE YOU DOING!!!
// *******************************************************************
// Parse configuration file
define('CONFIG_FILE', $CONFIG_FILE);
$CONFIG = (array) parse_ini_file($CONFIG_FILE, true);

// Check for configuration vars and set default values
$CONFIG['directories']['sys_dir'] = (!isset($CONFIG['directories']['sys_dir']) ? getcwd() : $CONFIG['directories']['sys_dir']);
$CONFIG['directories']['lib_dir'] = (!isset($CONFIG['directories']['lib_dir']) ? $CONFIG['directories']['sys_dir'] . DIRECTORY_SEPARATOR . 'lib' : $CONFIG['directories']['lib_dir']);
$CONFIG['directories']['userpanel_dir'] = (!isset($CONFIG['directories']['userpanel_dir']) ? getcwd() : $CONFIG['directories']['userpanel_dir']);
$CONFIG['directories']['modules_dir'] = (!isset($CONFIG['directories']['modules_dir']) ? $CONFIG['directories']['sys_dir'] . DIRECTORY_SEPARATOR . 'modules' : $CONFIG['directories']['modules_dir']);
$CONFIG['directories']['smarty_compile_dir'] = $CONFIG['directories']['userpanel_dir'] . DIRECTORY_SEPARATOR . 'templates_c';
$CONFIG['directories']['plugin_dir'] = (!isset($CONFIG['directories']['plugin_dir']) ? $CONFIG['directories']['sys_dir'] . DIRECTORY_SEPARATOR . 'plugins' : $CONFIG['directories']['plugin_dir']);
$CONFIG['directories']['plugins_dir'] = $CONFIG['directories']['plugin_dir'];
$CONFIG['directories']['doc_dir'] = (!isset($CONFIG['directories']['doc_dir']) ? $CONFIG['directories']['sys_dir'] . DIRECTORY_SEPARATOR . 'documents' : $CONFIG['directories']['doc_dir']);

define('USERPANEL_DIR', $CONFIG['directories']['userpanel_dir']);
define('USERPANEL_LIB_DIR', USERPANEL_DIR . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR);
define('USERPANEL_MODULES_DIR', USERPANEL_DIR . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR);

define('SYS_DIR', $CONFIG['directories']['sys_dir']);
define('LIB_DIR', $CONFIG['directories']['lib_dir']);
define('DOC_DIR', $CONFIG['directories']['doc_dir']);
define('MODULES_DIR', $CONFIG['directories']['modules_dir']);
define('SMARTY_COMPILE_DIR', $CONFIG['directories']['smarty_compile_dir']);
define('PLUGIN_DIR', $CONFIG['directories']['plugin_dir']);
define('PLUGINS_DIR', $CONFIG['directories']['plugin_dir']);

// Load autoloader
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'autoloader.php');

require_once(USERPANEL_LIB_DIR . DIRECTORY_SEPARATOR . 'checkdirs.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'config.php');

// Initialize database

$DB = null;

try {
    $DB = LMSDB::getInstance();
} catch (Exception $ex) {
    trigger_error($ex->getMessage(), E_USER_WARNING);
    // can't working without database
    die("Fatal error: cannot connect to database!<BR>");
}

$_TIMEOUT = ConfigHelper::getConfig('phpui.timeout');

// Include required files (including sequence is important)

require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'language.php');
include_once(LIB_DIR . DIRECTORY_SEPARATOR . 'definitions.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'unstrip.php');
require_once(LIB_DIR . DIRECTORY_SEPARATOR . 'common.php');

$SYSLOG = null;

// Initialize templates engine
$SMARTY = new Smarty;
$SESSION = NULL;

// Initialize Session, Auth and LMS classes

$AUTH = NULL;
$LMS = new LMS($DB, $AUTH, $SYSLOG);

require_once(USERPANEL_LIB_DIR . DIRECTORY_SEPARATOR . 'Session.class.php');
require_once(USERPANEL_LIB_DIR . DIRECTORY_SEPARATOR . 'Userpanel.class.php');
require_once(USERPANEL_LIB_DIR . DIRECTORY_SEPARATOR . 'ULMS.class.php');
@include(USERPANEL_DIR . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'locale' . DIRECTORY_SEPARATOR . $_ui_language . DIRECTORY_SEPARATOR . 'strings.php');

unset($LMS); // reset LMS class to enable wrappers for LMS older versions

$LMS = new ULMS($DB, $AUTH, $SYSLOG);

$plugin_manager = new LMSPluginManager();
$LMS->setPluginManager($plugin_manager);

// Load plugin files and register hook callbacks
$plugins = preg_split('/[;,\s\t\n]+/', ConfigHelper::getConfig('phpui.plugins', ''), -1, PREG_SPLIT_NO_EMPTY);
if (!empty($plugins))
    foreach ($plugins as $plugin_name)
        if (is_readable(LIB_DIR . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $plugin_name . '.php'))
            require LIB_DIR . DIRECTORY_SEPARATOR . 'plugins' . DIRECTORY_SEPARATOR . $plugin_name . '.php';

$SESSION = new Session($DB, $_TIMEOUT);
$USERPANEL = new USERPANEL($DB, $SESSION);
$LMS->ui_lang = $_ui_language;
$LMS->lang = $_language;

// set some template and layout variables

$SMARTY->assignByRef('LANGDEFS', $LANGDEFS);
$SMARTY->assignByRef('_ui_language', $LMS->ui_lang);
$SMARTY->assignByRef('_language', $LMS->lang);
$SMARTY->setTemplateDir(null);
$style = ConfigHelper::getConfig('userpanel.style', 'default');
$SMARTY->addTemplateDir(array(
    USERPANEL_DIR . DIRECTORY_SEPARATOR . 'style' . DIRECTORY_SEPARATOR . $style . DIRECTORY_SEPARATOR . 'templates',
    USERPANEL_DIR . DIRECTORY_SEPARATOR . 'templates',
));
$SMARTY->setCompileDir(SMARTY_COMPILE_DIR);
$SMARTY->debugging = ConfigHelper::checkConfig('phpui.smarty_debug');
require_once(USERPANEL_LIB_DIR . DIRECTORY_SEPARATOR . 'smarty_addons.php');

$layout['upv'] = $USERPANEL->_version . ' (' . $USERPANEL->_revision . '/' . $SESSION->_revision . ')';
$layout['lmsdbv'] = $DB->GetVersion();
$layout['lmsv'] = $LMS->_version;
$layout['smarty_version'] = SMARTY_VERSION;
$layout['hostname'] = hostname();
$layout['dberrors'] = & $DB->GetErrors();

$SMARTY->assignByRef('modules', $USERPANEL->MODULES);
$SMARTY->assignByRef('layout', $layout);

$plugin_manager->executeHook('userpanel_lms_initialized', $LMS);

$plugin_manager->executeHook('userpanel_smarty_initialized', $SMARTY);


if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $forwarded_ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
    $nodeid = $LMS->GetNodeIDByIP($forwarded_ip['0']);
} elseif ($_SERVER['REMOTE_ADDR'] == '') {
    $nodeid = $LMS->GetNodeIDByIP(str_replace('::ffff:', '', '127.0.0.1'));
} else {
    $nodeid = $LMS->GetNodeIDByIP(str_replace('::ffff:', '', $_SERVER['REMOTE_ADDR']));
}

$customerid = $LMS->GetNodeOwner($nodeid);
$nodeinfo = $LMS->GetNode($nodeid);

$mac = strtolower($nodeinfo['macs'][0]['mac']);

if (isset($_POST['submit'])) {
    $DB->Execute('UPDATE nodes SET warning = 0 WHERE id = ?', array($nodeid));
    $cmd = 'echo "User-Name=' . $mac . ',Forward-Policy=in:CLIPS-DEFAULT,HTTP-Redirect-Profile-Name=\'\',Context-Name=CLIPS" | radclient -r 1 -x ' . $CONFIG['redback']['clipsip'] . ':3799 coa ' . $CONFIG['redback']['radiuspass'];
    if (!exec($cmd)) {
        return "COA: cmd not executed";
    }
    header('Location: http://alfa-system.pl');
} else {
    $customerinfo = $LMS->GetCustomer($customerid);
    $SMARTY->assign('customerinfo', $customerinfo);
    $SMARTY->assign('nodeinfo', $nodeinfo);
    $SMARTY->assign('layout', $layout);
    $SMARTY->display('message.html');
}
?>