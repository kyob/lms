<?php /* Smarty version 3.1.27, created on 2015-07-20 10:36:01
         compiled from "module:info.html" */ ?>
<?php
/*%%SmartyHeaderCode:155837359455acb2f1177600_52608363%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12813e4aee75519b7a6f89ff2ecf1bd23e4bde66' => 
    array (
      0 => 'module:info.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '155837359455acb2f1177600_52608363',
  'variables' => 
  array (
    'usernodes' => 0,
    'userinfo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb2f11edb72_65356002',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb2f11edb72_65356002')) {
function content_55acb2f11edb72_65356002 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '155837359455acb2f1177600_52608363';
echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<div class="row">
<div class="cold-md-12">
    <?php if (!$_smarty_tpl->tpl_vars['usernodes']->value['total'] && check_conf('userpanel.hide_nodesbox')) {?>
	<?php if (get_conf('userpanel.data_consent_text') && !$_smarty_tpl->tpl_vars['userinfo']->value['consentdate']) {?>
		<?php echo $_smarty_tpl->getSubTemplate ("module:consentbox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

	<?php }?>

        <?php echo $_smarty_tpl->getSubTemplate ("module:userinfobox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

	<?php echo $_smarty_tpl->getSubTemplate ("module:userdocsbox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

    <?php } else { ?>
        <?php if (get_conf('userpanel.data_consent_text') && !$_smarty_tpl->tpl_vars['userinfo']->value['consentdate']) {?>
            <?php echo $_smarty_tpl->getSubTemplate ("module:consentbox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

        <?php }?>
        <div class="row">
        <div class="col-md-6"><?php echo $_smarty_tpl->getSubTemplate ("module:userinfobox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
</div>
        <div class="col-md-6"><?php echo $_smarty_tpl->getSubTemplate ("module:usernodesbox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>
</div>
        </div>
        <?php echo $_smarty_tpl->getSubTemplate ("module:userdocsbox.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }?>
</div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>