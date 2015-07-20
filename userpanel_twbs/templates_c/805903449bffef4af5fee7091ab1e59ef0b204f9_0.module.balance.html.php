<?php /* Smarty version 3.1.27, created on 2015-07-20 10:35:56
         compiled from "module:balance.html" */ ?>
<?php
/*%%SmartyHeaderCode:48180284755acb2ecdcedf8_04245163%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '805903449bffef4af5fee7091ab1e59ef0b204f9' => 
    array (
      0 => 'module:balance.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '48180284755acb2ecdcedf8_04245163',
  'variables' => 
  array (
    'userinfo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb2ecdef0f6_43975170',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb2ecdef0f6_43975170')) {
function content_55acb2ecdef0f6_43975170 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_money_format')) require_once '/var/www/lms2.alfa-system.pl/lib//SmartyPlugins/modifier.money_format.php';

$_smarty_tpl->properties['nocache_hash'] = '48180284755acb2ecdcedf8_04245163';
?>
<!--// $Id$ //-->
<div class="row">
<div class="col-md-12">
<?php if ($_smarty_tpl->tpl_vars['userinfo']->value['balance'] < 0) {?>
    <div class="alert alert-danger">
        <h1>Kwota do zapłaty: <?php echo smarty_modifier_money_format($_smarty_tpl->tpl_vars['userinfo']->value['balance']);?>
</h1>
    <?php if (!check_conf('userpanel.disable_transferform')) {?>
	<a href="?m=finances&amp;f=transferform" target="_blank">Wydrukuj formularz zapłaty.</a>
    <?php }?>        
</div>
<?php } else { ?>
    <div class="alert alert-success"><h1><?php echo smarty_modifier_money_format($_smarty_tpl->tpl_vars['userinfo']->value['balance']);?>
</h1>
    <?php echo trans("All your covenants are settled");?>
.
    </div>
<?php }?>
</div>
</div>

<?php }
}
?>