<?php /* Smarty version 3.1.27, created on 2015-07-20 10:57:12
         compiled from "/var/www/lms2.alfa-system.pl/userpanel/assets/default/box.html" */ ?>
<?php
/*%%SmartyHeaderCode:195466622555acb7e83c36e0_53938646%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a3b9922bd40e513ad9ea405ff0d414dfc40d3af0' => 
    array (
      0 => '/var/www/lms2.alfa-system.pl/userpanel/assets/default/box.html',
      1 => 1434528968,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '195466622555acb7e83c36e0_53938646',
  'variables' => 
  array (
    'boxtitle' => 0,
    'boxcontent' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb7e8417ef5_16234843',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb7e8417ef5_16234843')) {
function content_55acb7e8417ef5_16234843 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '195466622555acb7e83c36e0_53938646';
?>
<h3><?php echo $_smarty_tpl->tpl_vars['boxtitle']->value;?>
</h3>
<?php echo $_smarty_tpl->tpl_vars['boxcontent']->value;?>

<?php }
}
?>