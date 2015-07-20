<?php /* Smarty version 3.1.27, created on 2015-07-20 10:57:05
         compiled from "/var/www/lms2.alfa-system.pl/userpanel/assets/default/body.html" */ ?>
<?php
/*%%SmartyHeaderCode:18915879555acb7e17e95c4_23614209%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b8f9960e697ac1986c72961d9018c0d28b640a54' => 
    array (
      0 => '/var/www/lms2.alfa-system.pl/userpanel/assets/default/body.html',
      1 => 1434528968,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18915879555acb7e17e95c4_23614209',
  'variables' => 
  array (
    'modules' => 0,
    'menuitem' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb7e186a328_59905531',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb7e186a328_59905531')) {
function content_55acb7e186a328_59905531 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/modifier.replace.php';

$_smarty_tpl->properties['nocache_hash'] = '18915879555acb7e17e95c4_23614209';
?>
<div class="row">
    <div class="col-md-12">
        <div class="page-header"><img src="media/logo.png" alt="Alfa-System" /></div>
        <ul class="nav nav-tabs">
        <?php
$_from = $_smarty_tpl->tpl_vars['modules']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['menuitem'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['menuitem']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['menuitem']->value) {
$_smarty_tpl->tpl_vars['menuitem']->_loop = true;
$foreach_menuitem_Sav = $_smarty_tpl->tpl_vars['menuitem'];
?>
            <li <?php if (strpos($_GET['m'],$_smarty_tpl->tpl_vars['menuitem']->value['module']) !== false && strlen($_GET['m']) == strlen($_smarty_tpl->tpl_vars['menuitem']->value['module'])) {?> class="active" <?php }?>><a href="?m=<?php echo $_smarty_tpl->tpl_vars['menuitem']->value['module'];?>
" <?php echo _smarty_function_userpaneltip(array('text'=>$_smarty_tpl->tpl_vars['menuitem']->value['tip']),$_smarty_tpl);?>
><b><?php echo $_GET['page'];?>
 <?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['menuitem']->value['name']," ","&nbsp;");?>
</b></a></li>
        <?php
$_smarty_tpl->tpl_vars['menuitem'] = $foreach_menuitem_Sav;
}
?>
        </ul>       
</div>
</div>
<hr/><?php }
}
?>