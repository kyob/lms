<?php /* Smarty version 3.1.27, created on 2015-07-20 10:34:05
         compiled from "/var/www/lms2.alfa-system.pl/userpanel/templates/header.html" */ ?>
<?php
/*%%SmartyHeaderCode:140857002555acb27dde0342_57994650%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd77f3a31bfc71ab7e81b1f2aac9169f876809711' => 
    array (
      0 => '/var/www/lms2.alfa-system.pl/userpanel/templates/header.html',
      1 => 1434528972,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '140857002555acb27dde0342_57994650',
  'variables' => 
  array (
    '_ui_language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb27ddf0e02_87297992',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb27ddf0e02_87297992')) {
function content_55acb27ddf0e02_87297992 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '140857002555acb27dde0342_57994650';
?>
<!DOCTYPE html>
<html lang="<?php echo $_smarty_tpl->tpl_vars['_ui_language']->value;?>
">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="content-type">
    <meta http-equiv="refresh" content="<?php echo get_conf('phpui.timeout')+5;?>
">
    <title><?php echo trans("Virtual Customer Service");?>
</title>
    <!-- TWITTER BOOTSTRAP RESPONSIVE -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- TWITTER BOOTSTRAP CSS -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <!-- OWN CSS -->
    <link href="assets/alfa-system/alfa.css" rel="stylesheet">    

</head>
<body>
       <div class="container">
<?php echo _smarty_function_body(array(),$_smarty_tpl);?>

<?php }
}
?>