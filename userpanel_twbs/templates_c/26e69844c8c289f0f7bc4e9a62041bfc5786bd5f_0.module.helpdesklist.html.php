<?php /* Smarty version 3.1.27, created on 2015-07-20 10:39:58
         compiled from "module:helpdesklist.html" */ ?>
<?php
/*%%SmartyHeaderCode:99210971555acb3decf3b81_33185786%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '26e69844c8c289f0f7bc4e9a62041bfc5786bd5f' => 
    array (
      0 => 'module:helpdesklist.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '99210971555acb3decf3b81_33185786',
  'variables' => 
  array (
    'helpdesklist' => 0,
    'limit' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb3ded4c9c6_87928896',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb3ded4c9c6_87928896')) {
function content_55acb3ded4c9c6_87928896 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '99210971555acb3decf3b81_33185786';
?>
<!--// $Id$ //-->
<?php $_smarty_tpl->smarty->_tag_stack[] = array('box', array('title'=>"Request history")); $_block_repeat=true; echo _smarty_block_box(array('title'=>"Request history"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<table class="table table-bordered">
	<tr>
		<td><?php echo trans("Number:");?>
</td>
		<td><?php echo trans("Date:");?>
</td>
		<td><?php echo trans("Subject:");?>
</td>
		<td><?php echo trans("Last modified:");?>
</td>
		<td><?php echo trans("Status:");?>
</td>
	</tr>
	<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['name'] = 'helpdesklist';
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['helpdesklist']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['start'] = (int) $_smarty_tpl->tpl_vars['limit']->value;
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['helpdesklist']['total']);
?>
	<tr <?php echo _smarty_function_userpaneltip(array('text'=>"Click icon on the left to see request details"),$_smarty_tpl);?>
>
		<td><a href="?m=helpdesk&amp;op=view&amp;id=<?php echo $_smarty_tpl->tpl_vars['helpdesklist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['helpdesklist']['index']]['id'];?>
"><b><?php echo sprintf("%06d",$_smarty_tpl->tpl_vars['helpdesklist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['helpdesklist']['index']]['id']);?>
</b></a></td>
		<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['helpdesklist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['helpdesklist']['index']]['createtime'],"%Y/%m/%d %H:%M");?>
</td>
		<td><b><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['helpdesklist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['helpdesklist']['index']]['subject'], ENT_QUOTES, 'UTF-8', true);?>
</b></td>
		<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['helpdesklist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['helpdesklist']['index']]['lastmod'],"%Y/%m/%d %H:%M");?>
</td>
    		<td><b>
			<?php if ($_smarty_tpl->tpl_vars['helpdesklist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['helpdesklist']['index']]['state'] == 0) {
echo trans("new");?>

			<?php } elseif ($_smarty_tpl->tpl_vars['helpdesklist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['helpdesklist']['index']]['state'] == 1) {
echo trans("open");?>

			<?php } elseif ($_smarty_tpl->tpl_vars['helpdesklist']->value[$_smarty_tpl->getVariable('smarty')->value['section']['helpdesklist']['index']]['state'] == 2) {
echo trans("resolved");?>

			<?php } else {
echo trans("dead");?>

			<?php }?></b>
		</td>
	<?php endfor; else: ?>
	<tr>
		<td colspan="5">
			<p>&nbsp;</p>
			<p><b><?php echo trans("No such requests in database.");?>
</b></p>
			<p>&nbsp;</p>
		</td>
	</tr>
	<?php endif; ?>
</table>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo _smarty_block_box(array('title'=>"Request history"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);

}
}
?>