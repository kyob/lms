<?php /* Smarty version 3.1.27, created on 2015-07-20 10:39:58
         compiled from "module:helpdesknew.html" */ ?>
<?php
/*%%SmartyHeaderCode:23235939655acb3deccd3c0_11796749%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0bb4b1622825f91c2dca953dea52c240c673a9a6' => 
    array (
      0 => 'module:helpdesknew.html',
      1 => 1437381307,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '23235939655acb3deccd3c0_11796749',
  'variables' => 
  array (
    'helpdesk' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb3decee7b7_81365753',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb3decee7b7_81365753')) {
function content_55acb3decee7b7_81365753 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '23235939655acb3deccd3c0_11796749';
?>
<!--// $Id$ //-->
<form method="post" action="?m=helpdesk" name="helpdesk">
<?php $_smarty_tpl->smarty->_tag_stack[] = array('box', array('title'=>"New Request")); $_block_repeat=true; echo _smarty_block_box(array('title'=>"New Request"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<table class="table table-bordered">
	<tr>
		<td>
			<b><?php echo trans("Subject:");?>
</b>
		</td>
		<td>
			<input style="width:99%;" type="text" name="helpdesk[subject]" value="<?php echo $_smarty_tpl->tpl_vars['helpdesk']->value['subject'];?>
" <?php echo _smarty_function_userpaneltip(array('text'=>"Enter request subject",'trigger'=>"subject"),$_smarty_tpl);?>
 />
		</td>
	</tr>
	<tr>

		<td>
			<b><?php echo trans("Body:");?>
</b>
		</td>
		<td>
			<textarea style="width:99%;" name="helpdesk[body]" rows="5" <?php echo _smarty_function_userpaneltip(array('text'=>"Enter request contents",'trigger'=>"body"),$_smarty_tpl);?>
><?php echo $_smarty_tpl->tpl_vars['helpdesk']->value['body'];?>
</textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<a class="btn btn-danger" href="javascript:document.helpdesk.submit()" accesskey="S"><?php echo trans("Submit");?>
</a>                   
                        <input type="hidden" name="wyslane" value="1">
		</td>
	</tr>
</table>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo _smarty_block_box(array('title'=>"New Request"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

</form>

<?php }
}
?>