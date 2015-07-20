<?php /* Smarty version 3.1.27, created on 2015-07-20 10:39:58
         compiled from "module:helpdesk.html" */ ?>
<?php
/*%%SmartyHeaderCode:201674752255acb3dec67514_81029067%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9151b2be06a51821656874909ce7de90fba1cb1e' => 
    array (
      0 => 'module:helpdesk.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '201674752255acb3dec67514_81029067',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb3decb9992_31893593',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb3decb9992_31893593')) {
function content_55acb3decb9992_31893593 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '201674752255acb3dec67514_81029067';
echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


			<?php echo $_smarty_tpl->getSubTemplate ("module:helpdesknew.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


			<?php echo $_smarty_tpl->getSubTemplate ("module:helpdesklist.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>