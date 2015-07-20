<?php /* Smarty version 3.1.27, created on 2015-07-20 10:39:58
         compiled from "/var/www/lms2.alfa-system.pl/userpanel/style/default/box.html" */ ?>
<?php
/*%%SmartyHeaderCode:109542668355acb3de31f2d6_29882719%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '299d24b6971b5b3f2d4f173820d21e7c2f2a1dc0' => 
    array (
      0 => '/var/www/lms2.alfa-system.pl/userpanel/style/default/box.html',
      1 => 1434528972,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109542668355acb3de31f2d6_29882719',
  'variables' => 
  array (
    'boxtitle' => 0,
    'boxcontent' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb3de3244d2_84936789',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb3de3244d2_84936789')) {
function content_55acb3de3244d2_84936789 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '109542668355acb3de31f2d6_29882719';
?>
<table width="100%" cellpadding="0" cellspacing="0" class="light">
    <tr>
	<td style="text-align:left; color: white; white-space: nowrap; background-color: #940000; padding-left: 5px; padding-top:2px;">
	    <b><?php echo $_smarty_tpl->tpl_vars['boxtitle']->value;?>
</b>
	</td>
    </tr>
</table>
<table width="100%" cellpadding="3" class="light" style="border:solid; border-color: #940000; border-width: 2px;">
    <tr>
	<td>
	    <?php echo $_smarty_tpl->tpl_vars['boxcontent']->value;?>

	</td>
    </tr>
</table>
<?php }
}
?>