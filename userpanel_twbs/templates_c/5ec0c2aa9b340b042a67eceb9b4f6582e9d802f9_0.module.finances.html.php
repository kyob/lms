<?php /* Smarty version 3.1.27, created on 2015-07-20 10:35:56
         compiled from "module:finances.html" */ ?>
<?php
/*%%SmartyHeaderCode:146535409855acb2ecd56236_83366180%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ec0c2aa9b340b042a67eceb9b4f6582e9d802f9' => 
    array (
      0 => 'module:finances.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '146535409855acb2ecd56236_83366180',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb2ecdb5718_60380701',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb2ecdb5718_60380701')) {
function content_55acb2ecdb5718_60380701 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '146535409855acb2ecd56236_83366180';
echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php echo $_smarty_tpl->getSubTemplate ("module:balance.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php echo $_smarty_tpl->getSubTemplate ("module:userbalancebox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>