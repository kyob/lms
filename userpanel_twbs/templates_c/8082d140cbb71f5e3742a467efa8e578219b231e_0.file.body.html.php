<?php /* Smarty version 3.1.27, created on 2015-07-20 10:34:05
         compiled from "/var/www/lms2.alfa-system.pl/userpanel/style/default/body.html" */ ?>
<?php
/*%%SmartyHeaderCode:115370845055acb27ddf4a32_56584393%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8082d140cbb71f5e3742a467efa8e578219b231e' => 
    array (
      0 => '/var/www/lms2.alfa-system.pl/userpanel/style/default/body.html',
      1 => 1436880634,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '115370845055acb27ddf4a32_56584393',
  'variables' => 
  array (
    'notice_urgent' => 0,
    'xajax' => 0,
    'layout' => 0,
    'modules' => 0,
    'menuitem' => 0,
    'display_spacer' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb27de687e5_90380049',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb27de687e5_90380049')) {
function content_55acb27de687e5_90380049 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/modifier.date_format.php';
if (!is_callable('smarty_modifier_replace')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/modifier.replace.php';

$_smarty_tpl->properties['nocache_hash'] = '115370845055acb27ddf4a32_56584393';
if ($_smarty_tpl->tpl_vars['notice_urgent']->value) {?>
<?php echo $_smarty_tpl->tpl_vars['xajax']->value;?>

<SCRIPT type="text/javascript">
<!--
xajax_setNoticeRead(<?php echo $_smarty_tpl->tpl_vars['notice_urgent']->value['id'];?>
);
//-->
</SCRIPT>
<div id="dialog">
	<div id="dialog-bg">
		<div id="dialog-title"><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['notice_urgent']->value['cdate'],"%Y/%m/%d %H:%M");?>
<br /><?php echo $_smarty_tpl->tpl_vars['notice_urgent']->value['subject'];?>
</div>
           <div id="dialog-description">
 <?php $_smarty_tpl->smarty->_tag_stack[] = array('box', array()); $_block_repeat=true; echo _smarty_block_box(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<table style="width: 100%;" cellpadding="3" class="light">
<tr >
	<td  style="word-break:break-all;"><?php echo $_smarty_tpl->tpl_vars['notice_urgent']->value['body'];?>
</td>
</tr>
<tr class="darkest">
	<td align="center"><a href="?m=notices&amp;confirm_urgent=<?php echo $_smarty_tpl->tpl_vars['notice_urgent']->value['id'];?>
"><?php echo trans("I confirm reading");?>
</a></td>
	</tr>
</table>
 <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo _smarty_block_box(array(), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

           </div>
	</div>
</div>
<?php }?>
<table width="100%" cellspacing="0" cellpadding="0" style="background-image:url('style/default/keyboard.jpg'); background-repeat:no-repeat; background-color: #ECECEC;">
    <tr style="height:100px;">
	<td align="right" style="padding-right:15px;">
	    <h2>LMS Userpanel <?php echo $_smarty_tpl->tpl_vars['layout']->value['upv'];?>
<br/>
	    @ <?php echo $_smarty_tpl->tpl_vars['layout']->value['hostname'];?>
</h2>
	</td>
    </tr>
<tr><td>
<table style="text-align: left; width: 100%; background-image: url(style/default/tabs_bg.gif); background-repeat: repeat-x;" cellspacing="0" cellpadding="0">
    <tr>
	<?php
$_from = $_smarty_tpl->tpl_vars['modules']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['menuitem'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['menuitem']->_loop = false;
$_smarty_tpl->tpl_vars['menuitem']->total= $_smarty_tpl->_count($_from);
$_smarty_tpl->tpl_vars['menuitem']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['menuitem']->value) {
$_smarty_tpl->tpl_vars['menuitem']->_loop = true;
$_smarty_tpl->tpl_vars['menuitem']->iteration++;
$_smarty_tpl->tpl_vars['menuitem']->first = $_smarty_tpl->tpl_vars['menuitem']->iteration == 1;
$_smarty_tpl->tpl_vars['menuitem']->last = $_smarty_tpl->tpl_vars['menuitem']->iteration == $_smarty_tpl->tpl_vars['menuitem']->total;
$foreach_menuitem_Sav = $_smarty_tpl->tpl_vars['menuitem'];
?>
	<?php if ($_smarty_tpl->tpl_vars['menuitem']->first) {?>
	    <td style="vertical-align: top;" width="1px">
    	    <img src="style/default/<?php if ($_smarty_tpl->tpl_vars['menuitem']->value['selected']) {?>tabs_begin_sel.gif<?php } else { ?>tabs_begin_notsel.gif<?php }?>" alt=""/>
	</td>
	<?php } else { ?>
	    <?php if ($_smarty_tpl->tpl_vars['menuitem']->value['selected']) {?>
	    <td style="vertical-align: top;" width="1px">
    	    <img src="style/default/tabs_begin_tab_sel.gif" alt=""/>
	    </td>
	    <?php } else { ?>
	    <?php if ($_smarty_tpl->tpl_vars['display_spacer']->value) {?>
	    <td style="vertical-align: top;" width="1px">
    	    <img src="style/default/tabs_spacer_notsel.gif" alt=""/>
	    </td>
	    <?php }?>
	    <?php }?>
	<?php }?>
        <td style="vertical-align: top; background-image: url(style/default/<?php if ($_smarty_tpl->tpl_vars['menuitem']->value['selected']) {?>tabs_tab_sel.gif<?php } else { ?>tabs_tab_notsel.gif<?php }?>); background-repeat: repeat-x; padding-top: 2px;" width="1px">
    	    <a href="?m=<?php echo $_smarty_tpl->tpl_vars['menuitem']->value['module'];?>
" <?php echo _smarty_function_userpaneltip(array('text'=>$_smarty_tpl->tpl_vars['menuitem']->value['tip']),$_smarty_tpl);?>
 class="<?php if ($_smarty_tpl->tpl_vars['menuitem']->value['selected']) {?>tabsel<?php } else { ?>tabnotsel<?php }?>"><?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['menuitem']->value['name']," ","&nbsp;");?>
</a>
        </td>
	<?php if ($_smarty_tpl->tpl_vars['menuitem']->last) {?>
	    <td style="vertical-align: top;" width="1px">
	<?php if ($_smarty_tpl->tpl_vars['menuitem']->value['selected']) {?>
    	    <img src="style/default/tabs_end_sel.gif" alt=''/>
	<?php } else { ?>
    	    <img src="style/default/tabs_end_notsel.gif" alt=''/>
	<?php }?>
    	    </td>
	<?php } else { ?>
	<?php if ($_smarty_tpl->tpl_vars['menuitem']->value['selected']) {?>
	    <td style="vertical-align: top;" width="1px">
    	    <img src="style/default/tabs_end_tab_sel.gif" alt=''/>
        </td>
	<?php }?>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['menuitem']->value['selected']) {
$_smarty_tpl->tpl_vars['display_spacer'] = new Smarty_Variable(0, null, 0);
} else {
$_smarty_tpl->tpl_vars['display_spacer'] = new Smarty_Variable(1, null, 0);
}?>
	<?php
$_smarty_tpl->tpl_vars['menuitem'] = $foreach_menuitem_Sav;
}
?>
	<td>&nbsp;</td>
    </tr>
</table>
</tr></td></table>
<div style="margin:0px; background-image: url('style/default/grad.gif'); background-repeat: repeat-x; height: 400px"><?php }
}
?>