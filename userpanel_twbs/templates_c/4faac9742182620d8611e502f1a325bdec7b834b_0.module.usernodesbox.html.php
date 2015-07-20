<?php /* Smarty version 3.1.27, created on 2015-07-20 10:36:01
         compiled from "module:usernodesbox.html" */ ?>
<?php
/*%%SmartyHeaderCode:70662597755acb2f12c7173_08614011%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4faac9742182620d8611e502f1a325bdec7b834b' => 
    array (
      0 => 'module:usernodesbox.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '70662597755acb2f12c7173_08614011',
  'variables' => 
  array (
    'usernodes' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb2f12eed70_47038019',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb2f12eed70_47038019')) {
function content_55acb2f12eed70_47038019 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_replace')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/modifier.replace.php';

$_smarty_tpl->properties['nocache_hash'] = '70662597755acb2f12c7173_08614011';
?>
<table class="table table-bordered">
    <tr class="info"><td colspan="3"><strong>Przypisane urządzenia:</strong></td></tr>


        <tr class="warning">
            <td><strong>Opis urządzenia:</strong></td>
            <td><strong>MAC adres:</strong></td>
            <td><strong>Publiczne IP:</strong></td>
        </tr>

<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['name'] = 'usernodes';
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['usernodes']->value) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['usernodes']['total']);
?>
<?php if ($_smarty_tpl->tpl_vars['usernodes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['usernodes']['index']]['id']) {?>
    <tr>
        <td><strong>
            <?php if ($_smarty_tpl->tpl_vars['usernodes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['usernodes']['index']]['access']) {?>
                <span class="positive"><?php echo $_smarty_tpl->tpl_vars['usernodes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['usernodes']['index']]['name'];?>
</span>
            <?php } else { ?>
                <span class="negative"><?php echo $_smarty_tpl->tpl_vars['usernodes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['usernodes']['index']]['name'];?>
</span>
            <?php }?></strong>                
        </td>
        <td><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['usernodes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['usernodes']['index']]['mac'],",","<br/>");?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['usernodes']->value[$_smarty_tpl->getVariable('smarty')->value['section']['usernodes']['index']]['ip'];?>
</td>        
    </tr>
<?php }?>
<?php endfor; else: ?>
    <tr><td colspan="4"><?php echo trans("You don't have any computers.");?>
</td></tr>
<?php endif; ?>
</table>
<?php }
}
?>