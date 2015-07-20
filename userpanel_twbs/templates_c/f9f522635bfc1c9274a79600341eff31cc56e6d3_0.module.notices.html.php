<?php /* Smarty version 3.1.27, created on 2015-07-20 10:39:58
         compiled from "module:notices.html" */ ?>
<?php
/*%%SmartyHeaderCode:17791418355acb3de215c74_09778574%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f9f522635bfc1c9274a79600341eff31cc56e6d3' => 
    array (
      0 => 'module:notices.html',
      1 => 1436880634,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '17791418355acb3de215c74_09778574',
  'variables' => 
  array (
    'xajax' => 0,
    'warning' => 0,
    'notice' => 0,
    'items' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb3de3078b4_97160225',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb3de3078b4_97160225')) {
function content_55acb3de3078b4_97160225 ($_smarty_tpl) {
if (!is_callable('smarty_function_cycle')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/function.cycle.php';
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '17791418355acb3de215c74_09778574';
?>
<!-- $Id$ -->
<?php echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php echo $_smarty_tpl->tpl_vars['xajax']->value;?>

<?php if ($_smarty_tpl->tpl_vars['warning']->value) {?>
<table width="100%" cellpadding="10">
    <tr>
       <td>
						<?php $_smarty_tpl->smarty->_tag_stack[] = array('box', array('title'=>"Warning to you")); $_block_repeat=true; echo _smarty_block_box(array('title'=>"Warning to you"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

						
						<table width="100%">
						 <tr>
				      <td align="center">
									<?php echo $_smarty_tpl->tpl_vars['warning']->value;?>

				      </td>
						 </tr>
						 <tr>
						   <td align="right">
										<a href="?m=notices&amp;confirm_old=1"><?php echo trans("I confirm reading");?>
 <?php echo _smarty_function_img(array('src'=>"save.gif",'alt'=>''),$_smarty_tpl);?>
</a>
						   </td>
						 </tr>
						</table>
						<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo _smarty_block_box(array('title'=>"Warning to you"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

       </td>
    </tr>
</table>
<?php }?>
<table width="100%" cellpadding="10">
    <tr>
       <td>
						<?php $_smarty_tpl->smarty->_tag_stack[] = array('box', array('title'=>"Notice to you")); $_block_repeat=true; echo _smarty_block_box(array('title'=>"Notice to you"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

						<?php if ($_smarty_tpl->tpl_vars['notice']->value) {?>
						<table style="width: 100%;" cellpadding="3" class="light">
								<tr class="darkest bold">
									<td width="2%"><?php echo trans("Date:");?>
</td>
									<td width="8%"><?php echo trans("Status:");?>
</td>
									<td width="80%"><?php echo trans("Subject:");?>
</td>
									<td width="10%"><?php echo trans("Read status:");?>
</td>
								</tr>
								<?php echo smarty_function_cycle(array('values'=>"light,lucid",'print'=>false,'name'=>'messages'),$_smarty_tpl);?>

								<?php
$_from = $_smarty_tpl->tpl_vars['notice']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['items'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['items']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['items']->value) {
$_smarty_tpl->tpl_vars['items']->_loop = true;
$foreach_items_Sav = $_smarty_tpl->tpl_vars['items'];
?>
								<tr class="dark hand <?php echo smarty_function_cycle(array('name'=>'messages'),$_smarty_tpl);
if ($_smarty_tpl->tpl_vars['items']->value['status'] == @constant('MSG_ERROR')) {?> alert<?php } elseif ($_smarty_tpl->tpl_vars['items']->value['status'] == @constant('MSG_SENT')) {?> blend<?php }?>" onCLick="ReadNotice('<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
');">
									<td width="2%" class="nobr"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['items']->value['cdate'],"%Y/%m/%d %H:%M");?>
</td>
									<td width="8%" ><?php if ($_smarty_tpl->tpl_vars['items']->value['type'] == 6) {?><b><?php echo trans("Urgent");?>
</b><?php } else {
echo trans("Casual");
}?></td>
									<td width="80%" style="word-break:break-all;"><?php echo $_smarty_tpl->tpl_vars['items']->value['subject'];?>
</td>
									<td width="10%" style="border: 0px solid;"><?php if ($_smarty_tpl->tpl_vars['items']->value['type'] == 6 && $_smarty_tpl->tpl_vars['items']->value['status'] == 1) {
echo trans("Unread");
} elseif ($_smarty_tpl->tpl_vars['items']->value['type'] == 6 && $_smarty_tpl->tpl_vars['items']->value['status'] == 2) {
echo trans("Was read on:");?>
<br /><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['items']->value['lastdate'],"%Y/%m/%d %H:%M");
} elseif ($_smarty_tpl->tpl_vars['items']->value['type'] == 5 && $_smarty_tpl->tpl_vars['items']->value['status'] == 1) {
echo trans("Unread");
} elseif ($_smarty_tpl->tpl_vars['items']->value['type'] == 5 && $_smarty_tpl->tpl_vars['items']->value['status'] == 2) {
echo trans("Was read on:");?>
<br /><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['items']->value['lastdate'],"%Y/%m/%d %H:%M");
} else { ?>&nbsp;<?php }?></td>
								</tr>
								<tr id="<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
"  style="display:none;">
										<td width="10%" align="center" colspan="4" >
										<b><?php echo trans("Body:");?>
</b><br />
										<?php echo $_smarty_tpl->tpl_vars['items']->value['body'];?>
<br /><br />
										<?php if ($_smarty_tpl->tpl_vars['items']->value['status'] != 2) {?><a href="?m=notices&amp;confirm=<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
"><?php echo trans("I confirm reading");?>
 <?php echo _smarty_function_img(array('src'=>"save.gif",'alt'=>''),$_smarty_tpl);?>
</a><?php } else { ?>&nbsp;<?php }?></td>
								</tr>
								<SCRIPT type="text/javascript">
								<!--
								function ReadNotice(elem){
								xajax_setNoticeRead(elem);
								showOrHide(elem);
								}
								if (getCookie('<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
') == '1')
								document.getElementById('<?php echo $_smarty_tpl->tpl_vars['items']->value['id'];?>
').style.display = '';
								//-->
								</SCRIPT>
							 <?php
$_smarty_tpl->tpl_vars['items'] = $foreach_items_Sav;
}
?>
						</table>
						<?php } else { ?>
			       <p>&nbsp;</p>
			       <p align="center"><b><?php echo trans("We don't have any notices to you.");?>
</b></p>
			       <p>&nbsp;</p>
						<?php }?>
						<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo _smarty_block_box(array('title'=>"Notice to you"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

					</td>
    </tr>
</table>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>