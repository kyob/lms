<?php /* Smarty version 3.1.27, created on 2015-07-20 10:36:01
         compiled from "module:userdocsbox.html" */ ?>
<?php
/*%%SmartyHeaderCode:123268486755acb2f12ff4c9_59522137%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '658fd8faa8d4d770111ed9b37196ea621c7e6fb6' => 
    array (
      0 => 'module:userdocsbox.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '123268486755acb2f12ff4c9_59522137',
  'variables' => 
  array (
    'documents' => 0,
    'doc' => 0,
    'type' => 0,
    '_DOCTYPES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb2f1367c50_93635876',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb2f1367c50_93635876')) {
function content_55acb2f1367c50_93635876 ($_smarty_tpl) {
if (!is_callable('smarty_function_cycle')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/function.cycle.php';
if (!is_callable('smarty_function_number')) require_once '/var/www/lms2.alfa-system.pl/lib//SmartyPlugins/function.number.php';
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '123268486755acb2f12ff4c9_59522137';
?>
<table class="table table-bordered">
	<?php if ($_smarty_tpl->tpl_vars['documents']->value) {?>
	<tr>
		<td><b><?php echo trans("Number:");?>
</b></td>
		<td><b><?php echo trans("Type:");?>
</b></td>
		<td><b><?php echo trans("Created:");?>
</b></td>
		<td><b><?php echo trans("Period:");?>
</b></td>
		<td>&nbsp;</td>
	</tr>
	<?php }?>
	<?php echo smarty_function_cycle(array('values'=>"light,lucid",'print'=>false,'name'=>'doc'),$_smarty_tpl);?>

	<?php
$_from = $_smarty_tpl->tpl_vars['documents']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['doc'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['doc']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['doc']->value) {
$_smarty_tpl->tpl_vars['doc']->_loop = true;
$foreach_doc_Sav = $_smarty_tpl->tpl_vars['doc'];
?>
	<tr class="<?php echo smarty_function_cycle(array('name'=>'doc'),$_smarty_tpl);
if (!$_smarty_tpl->tpl_vars['doc']->value['closed']) {?> blend<?php }?>" onmouseover="addClass(this, 'highlight')" onmouseout="removeClass(this, 'highlight')">
		<td><b><?php echo smarty_function_number(array('number'=>$_smarty_tpl->tpl_vars['doc']->value['number'],'template'=>$_smarty_tpl->tpl_vars['doc']->value['template'],'time'=>$_smarty_tpl->tpl_vars['doc']->value['cdate']),$_smarty_tpl);?>
</b></td>
		<td><?php $_smarty_tpl->tpl_vars['type'] = new Smarty_Variable($_smarty_tpl->tpl_vars['doc']->value['type'], null, 0);
echo $_smarty_tpl->tpl_vars['_DOCTYPES']->value[$_smarty_tpl->tpl_vars['type']->value];?>
</td>
		<td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['doc']->value['cdate'],"%d.%m.%Y");?>
</td>
		<td>
		<?php if (($_smarty_tpl->tpl_vars['doc']->value['type'] == @constant('DOC_CONTRACT')) || ($_smarty_tpl->tpl_vars['doc']->value['type'] == @constant('DOC_ANNEX'))) {?>
			<?php if ($_smarty_tpl->tpl_vars['doc']->value['fromdate']) {
echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['doc']->value['fromdate'],"%d.%m.%Y");
}?>
			<?php if ($_smarty_tpl->tpl_vars['doc']->value['todate']) {?> - <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['doc']->value['todate'],"%d.%m.%Y");
} else {
if ($_smarty_tpl->tpl_vars['doc']->value['fromdate']) {?> - <?php }
echo trans("indefinitely");
}?>
		<?php }?>
		</td>
		<td>
		<?php if ($_smarty_tpl->tpl_vars['doc']->value['closed']) {?>
			<a href="?m=info&amp;f=docview&amp;id=<?php echo $_smarty_tpl->tpl_vars['doc']->value['docid'];?>
" target="_blank"><?php echo trans("View");?>
 <?php echo _smarty_function_img(array('src'=>"view.gif",'alt'=>"[ View ]"),$_smarty_tpl);?>
</a>
		<?php } else { ?>
			<?php echo trans("not approved");?>

		<?php }?>
		</td>
	</tr>
	<?php
$_smarty_tpl->tpl_vars['doc'] = $foreach_doc_Sav;
}
if (!$_smarty_tpl->tpl_vars['doc']->_loop) {
?>
	<tr>
		<td>
			<p>&nbsp;</p>
			<p><b><?php echo trans("No such documents on your account.");?>
</b></p>
			<p>&nbsp;</p>
		</td>
	</tr>
	<?php
}
?>
</table>
<?php }
}
?>