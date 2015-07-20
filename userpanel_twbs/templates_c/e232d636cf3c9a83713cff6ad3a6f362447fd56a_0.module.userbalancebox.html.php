<?php /* Smarty version 3.1.27, created on 2015-07-20 10:35:56
         compiled from "module:userbalancebox.html" */ ?>
<?php
/*%%SmartyHeaderCode:63440957155acb2ecdf79e3_49774850%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e232d636cf3c9a83713cff6ad3a6f362447fd56a' => 
    array (
      0 => 'module:userbalancebox.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '63440957155acb2ecdf79e3_49774850',
  'variables' => 
  array (
    'disable_invoices' => 0,
    'balancelist' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb2ece603b3_76658630',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb2ece603b3_76658630')) {
function content_55acb2ece603b3_76658630 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_money_format')) require_once '/var/www/lms2.alfa-system.pl/lib//SmartyPlugins/modifier.money_format.php';

$_smarty_tpl->properties['nocache_hash'] = '63440957155acb2ecdf79e3_49774850';
$_smarty_tpl->tpl_vars['disable_invoices'] = new Smarty_Variable(check_conf('userpanel.disable_invoices'), null, 0);?>
<div class="row">
    <div class="col-md-12">

<form name="invoices" action="?m=finances&amp;f=invoice" method="POST" target="_blank">
<table id="table_id" class="display">
<thead>
    <tr class="warning">
        <th><strong><?php echo trans("Date");?>
</strong></th>
        <th class="positive"><strong>Wpłata</strong></th>
        <th class="negative"><strong>Zobowiązanie</strong></th>
	<!--<th><strong>Saldo</strong></th>-->
	<th><strong>Tytuł przelewu / Opis faktury VAT</strong></th>
	<?php if (!$_smarty_tpl->tpl_vars['disable_invoices']->value) {?>
	<th></th>
	<?php }?>
    </tr>  
</thead>
<tbody>
    <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['name'] = 'balancelist';
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['balancelist']->value['id']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['step'] = ((int) 1) == 0 ? 1 : (int) 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['balancelist']['total']);
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['balancelist']->value['date'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']];?>
</td>
      
        <?php if ($_smarty_tpl->tpl_vars['balancelist']->value['value'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']] > 0) {?>
        <td class="positive center">
            <?php if ($_smarty_tpl->tpl_vars['balancelist']->value['value'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']] > 0 && $_smarty_tpl->tpl_vars['balancelist']->value['type'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']] != 4) {?>
                
            <?php }?>
            <?php echo smarty_modifier_money_format($_smarty_tpl->tpl_vars['balancelist']->value['value'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']]);?>

        </td>
        <td></td>        
        <?php } else { ?>   
        <td></td>
        <td class="negative center">
            <?php if ($_smarty_tpl->tpl_vars['balancelist']->value['type'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']] == 4) {?>
                -
            <?php }?>
            <?php echo smarty_modifier_money_format($_smarty_tpl->tpl_vars['balancelist']->value['value'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']]);?>
          
        </td>
        <?php }?>        
        
<!--        <td><?php if ($_smarty_tpl->tpl_vars['balancelist']->value['after'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']] < 0) {?><strong><?php echo smarty_modifier_money_format($_smarty_tpl->tpl_vars['balancelist']->value['after'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']]);?>
</strong><?php } else {
echo smarty_modifier_money_format($_smarty_tpl->tpl_vars['balancelist']->value['after'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']]);
}?></td>-->
	<td ><?php echo $_smarty_tpl->tpl_vars['balancelist']->value['comment'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']];?>
</td>
	<?php if (!$_smarty_tpl->tpl_vars['disable_invoices']->value) {?>
	<td>
            <?php if ($_smarty_tpl->tpl_vars['balancelist']->value['doctype'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']] == 1 || $_smarty_tpl->tpl_vars['balancelist']->value['doctype'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']] == 3) {?>
                <a href="?m=finances&amp;f=invoice&amp;id=<?php echo $_smarty_tpl->tpl_vars['balancelist']->value['docid'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']];?>
" target="_blank">Wydrukuj</a> <input type="checkbox" name="inv[<?php echo $_smarty_tpl->tpl_vars['balancelist']->value['docid'][$_smarty_tpl->getVariable('smarty')->value['section']['balancelist']['index']];?>
]" value="1" />
            <?php } else { ?>
                &nbsp;
            <?php }?>
	</td>
    <?php }?>
    </tr>
    <?php endfor; else: ?>
    <tr>
        <td colspan="5">
            <p>&nbsp;</p>
            <p><b><?php echo trans("No such transactions on your account.");?>
</b></p>
            <p>&nbsp;</p>
        </td>
    </tr>
    <?php endif; ?>
</tbody>
    <?php if (!$_smarty_tpl->tpl_vars['disable_invoices']->value) {?>
    <tr>
        <td colspan="4">&nbsp;</td>
        <td>
            <?php echo trans("Check all");?>
&nbsp;<input type="checkbox" name="allbox" id="allbox" onchange="CheckAll('invoices', this)" value="1" />
            <br/><br/>            
            <a href="javascript:document.invoices.submit()"><?php echo trans("Print selected");?>
</a>            
        </td>
    </tr>
    <?php }?>

</table>
</form>
</div>
</div><?php }
}
?>