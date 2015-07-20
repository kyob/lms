<?php /* Smarty version 3.1.27, created on 2015-07-20 10:36:01
         compiled from "module:userinfobox.html" */ ?>
<?php
/*%%SmartyHeaderCode:64375204555acb2f120aae5_02132431%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7be7f55727ad6b31890b5fe7d275a638b0fa9d63' => 
    array (
      0 => 'module:userinfobox.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '64375204555acb2f120aae5_02132431',
  'variables' => 
  array (
    'fields_changed' => 0,
    'userinfo' => 0,
    'item' => 0,
    'bankaccount' => 0,
    'rights' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb2f12b7532_23471679',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb2f12b7532_23471679')) {
function content_55acb2f12b7532_23471679 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_money_format')) require_once '/var/www/lms2.alfa-system.pl/lib//SmartyPlugins/modifier.money_format.php';
if (!is_callable('smarty_modifier_replace')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/modifier.replace.php';

$_smarty_tpl->properties['nocache_hash'] = '64375204555acb2f120aae5_02132431';
if ($_smarty_tpl->tpl_vars['fields_changed']->value) {?>
<div class="alert alert-warning"><?php echo trans("WARNING! Some fields have been changed and changes must become accepted by admin");?>
.</div>
<?php }?>

<table class="table table-bordered table-striped">
        <tr class="info">
            <td colspan="2"><strong>Dane osobowe:</strong></td>
        </tr>
        <tr>
            <td><strong>Imię i nazwisko / Nazwa firmy</strong></td>
            <td><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['customername'];?>
 (<?php echo sprintf("%04d",$_smarty_tpl->tpl_vars['userinfo']->value['id']);?>
)</td>
	</tr>
        <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['email']) {?>
	<tr>
            <td><strong>E-mail:</strong></td>
            <td><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['email'];?>
</td>
	</tr>
        <?php }?>
	<tr>
            <td><strong>Adres instalacji:</strong></td>
            <td><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['address'];?>
<br/><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['zip'];?>
 <?php echo $_smarty_tpl->tpl_vars['userinfo']->value['city'];?>
</td>
	</tr>
        <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['contacts']) {?>
	<tr>
            <td><strong>Telefony kontaktowe:</strong></td>
            <td><?php
$_from = $_smarty_tpl->tpl_vars['userinfo']->value['contacts'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['phone']) {
echo $_smarty_tpl->tpl_vars['item']->value['phone'];?>
<BR /><?php }?>
                <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
            </td>
	</tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['im'] != '' && $_smarty_tpl->tpl_vars['userinfo']->value['im'] != 0) {?>
	<tr>
            <td><strong>Gadu-Gadu:</strong></td>
            <td><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['im'];?>
</td>
	</tr>
        <?php }?>
        <?php
$_from = $_smarty_tpl->tpl_vars['userinfo']->value['messengers'];
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['item'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
$foreach_item_Sav = $_smarty_tpl->tpl_vars['item'];
?>
	<tr>
            <td>
                <?php if ($_smarty_tpl->tpl_vars['item']->value['type'] == @constant('IM_GG')) {?>
                    <?php echo _smarty_function_img(array('src'=>"gg.gif",'alt'=>''),$_smarty_tpl);?>

                <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type'] == @constant('IM_YAHOO')) {?>
                    <?php echo _smarty_function_img(array('src'=>"yahoo.gif",'alt'=>''),$_smarty_tpl);?>

                <?php } elseif ($_smarty_tpl->tpl_vars['item']->value['type'] == @constant('IM_SKYPE')) {?>
                    <?php echo _smarty_function_img(array('src'=>"skype.gif",'alt'=>''),$_smarty_tpl);?>

                <?php }?>
            </td>
            <td><?php echo $_smarty_tpl->tpl_vars['item']->value['uid'];?>
</td>
	</tr>
        <?php
$_smarty_tpl->tpl_vars['item'] = $foreach_item_Sav;
}
?>
        <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['ten'] != '') {?>
	<tr>
            <td><strong><?php echo trans("TEN");?>
</strong></td>
            <td><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['ten'];?>
</td>
	</tr>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['userinfo']->value['ssn'] != '') {?>
	<tr>
            <td><strong><?php echo trans("SSN");?>
</strong></td>
            <td><?php echo $_smarty_tpl->tpl_vars['userinfo']->value['ssn'];?>
</td>
	</tr>
        <?php }?>
	<tr>
            <td><strong><?php echo trans("Balance:");?>
</strong></td>
            <td><?php if ($_smarty_tpl->tpl_vars['userinfo']->value['balance'] < 0) {?><span class="text-danger"><strong><?php echo smarty_modifier_money_format($_smarty_tpl->tpl_vars['userinfo']->value['balance']);?>
</strong></span><?php } else {
echo smarty_modifier_money_format($_smarty_tpl->tpl_vars['userinfo']->value['balance']);
}?></td>
	</tr>
        <?php $_smarty_tpl->tpl_vars['bankaccount'] = new Smarty_Variable(bankaccount($_smarty_tpl->tpl_vars['userinfo']->value['id'],$_smarty_tpl->tpl_vars['userinfo']->value['account']), null, 0);?>
        <?php if ($_smarty_tpl->tpl_vars['bankaccount']->value) {?>
	<tr>
            <td><strong><?php echo trans("Bank account:");?>
</strong></td>
            <td><?php echo smarty_modifier_replace(format_bankaccount($_smarty_tpl->tpl_vars['bankaccount']->value)," ","&nbsp;");?>
	</td>
	</tr>
        <?php }?>
	<?php if ($_smarty_tpl->tpl_vars['rights']->value['info']['edit_addr'] || $_smarty_tpl->tpl_vars['rights']->value['info']['edit_addr_ack'] || $_smarty_tpl->tpl_vars['rights']->value['info']['edit_contact'] || $_smarty_tpl->tpl_vars['rights']->value['info']['edit_contact_ack']) {?>
        <tr class="warning">
            <td colspan="2"><a class="btn btn-info" href="?m=info&amp;f=updateuserform" accesskey="A"><?php echo trans("Actualize data");?>
</a></td>
	</tr>
	<?php }?>
</table><?php }
}
?>