<?php /* Smarty version 3.1.27, created on 2015-07-20 10:39:58
         compiled from "module:stats.html" */ ?>
<?php
/*%%SmartyHeaderCode:121783431855acb3de3d4043_45265520%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad35088bdd1f65b65e987bccb830d1f3fd33f800' => 
    array (
      0 => 'module:stats.html',
      1 => 1436880634,
      2 => 'module',
    ),
  ),
  'nocache_hash' => '121783431855acb3de3d4043_45265520',
  'variables' => 
  array (
    'bar' => 0,
    'download' => 0,
    'upload' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb3de4cf922_40764450',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb3de4cf922_40764450')) {
function content_55acb3de4cf922_40764450 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/var/www/lms2.alfa-system.pl/lib/Smarty/plugins/modifier.truncate.php';

$_smarty_tpl->properties['nocache_hash'] = '121783431855acb3de3d4043_45265520';
echo $_smarty_tpl->getSubTemplate ("header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<table width="100%" cellpadding="10" align="center">
    <tr>
        <td align="center">
	    <?php $_smarty_tpl->smarty->_tag_stack[] = array('box', array('title'=>"Filter")); $_block_repeat=true; echo _smarty_block_box(array('title'=>"Filter"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

	    <p style="white-space: nowrap; text-align: center;">
		<a href="?m=stats&amp;bar=hour"><?php if ($_smarty_tpl->tpl_vars['bar']->value == 'hour') {?><b><?php }
echo trans("Last hour");
if ($_smarty_tpl->tpl_vars['bar']->value == 'hour') {?></b><?php }?></a> /
		<a href="?m=stats&amp;bar=day"><?php if ($_smarty_tpl->tpl_vars['bar']->value == 'day') {?><b><?php }
echo trans("Last day");
if ($_smarty_tpl->tpl_vars['bar']->value == 'day') {?></b><?php }?></a> /
		<a href="?m=stats&amp;bar=month"><?php if ($_smarty_tpl->tpl_vars['bar']->value == 'month') {?><b><?php }
echo trans("Last 30 days");
if ($_smarty_tpl->tpl_vars['bar']->value == 'month') {?></b><?php }?></a> /
		<a href="?m=stats&amp;bar=year"><?php if ($_smarty_tpl->tpl_vars['bar']->value == 'year') {?><b><?php }
echo trans("Last year");
if ($_smarty_tpl->tpl_vars['bar']->value == 'year') {?></b><?php }?></a> /
		<a href="?m=stats&amp;bar=all"><?php if ($_smarty_tpl->tpl_vars['bar']->value == 'all') {?><b><?php }
echo trans("All");
if ($_smarty_tpl->tpl_vars['bar']->value == 'all') {?></b><?php }?></a>
	    </p>
	    <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo _smarty_block_box(array('title'=>"Filter"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

	</td>
    </tr>
    <tr>
	<td align="center">
<?php if ($_smarty_tpl->tpl_vars['download']->value || $_smarty_tpl->tpl_vars['upload']->value) {?>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<td width="49%">
			<?php $_smarty_tpl->smarty->_tag_stack[] = array('box', array('title'=>"Download")); $_block_repeat=true; echo _smarty_block_box(array('title'=>"Download"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

			<table width="100%" cellpadding="0">
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['download'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['download']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['name'] = 'download';
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['download']->value['name']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['download']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['download']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['download']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['download']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['download']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['download']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['download']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['download']['total']);
?>
				<tr>
					<td class="nobr" width="1%" align="left">
						<b><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['download']->value['name'][$_smarty_tpl->getVariable('smarty')->value['section']['download']['index']],32,"...");?>
</b>
					</td>
					<td class="nobr" width="99%" align="left">
						<?php echo _smarty_function_img(array('src'=>"redpx.gif",'height'=>"16",'width'=>$_smarty_tpl->tpl_vars['download']->value['bar'][$_smarty_tpl->getVariable('smarty')->value['section']['download']['index']],'style'=>"border-width: 1pt; border-color: #000000;"),$_smarty_tpl);?>
 <?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['download']->value['data'][$_smarty_tpl->getVariable('smarty')->value['section']['download']['index']]);?>
 <?php echo $_smarty_tpl->tpl_vars['download']->value['unit'][$_smarty_tpl->getVariable('smarty')->value['section']['download']['index']];?>
 (<?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['download']->value['avg'][$_smarty_tpl->getVariable('smarty')->value['section']['download']['index']]);?>
 kbit/s) 
					</td>
				</tr>
				<?php endfor; endif; ?>
				<tr>
					<td align="center" colspan="2">
						<p><b><?php echo trans("Total:");?>
 <?php echo sprintf("%.2f ",$_smarty_tpl->tpl_vars['download']->value['sum']['data']);
echo $_smarty_tpl->tpl_vars['download']->value['sum']['unit'];?>
 (<?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['download']->value['avgsum']);?>
&nbsp;kbit/s)</b></p>
					</td>
				</tr>
			</table>
			<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo _smarty_block_box(array('title'=>"Download"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

		</td>
		<td width="2%">&nbsp;</td>
		<td width="49%">
			<?php $_smarty_tpl->smarty->_tag_stack[] = array('box', array('title'=>"Upload")); $_block_repeat=true; echo _smarty_block_box(array('title'=>"Upload"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

			<table width="100%" cellpadding="0">
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['upload'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['upload']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['name'] = 'upload';
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['upload']->value['name']) ? count($_loop) : max(0, (int) $_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['upload']['total']);
?>
				<tr>
					<td class="nobr" width="1%" align="left">
						<b><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['upload']->value['name'][$_smarty_tpl->getVariable('smarty')->value['section']['upload']['index']],32,"...");?>
</b>
					</td>
					<td class="nobr" width="99%" align="left">
						<?php echo _smarty_function_img(array('src'=>"bluepx.gif",'height'=>"16",'width'=>$_smarty_tpl->tpl_vars['upload']->value['bar'][$_smarty_tpl->getVariable('smarty')->value['section']['upload']['index']],'border'=>"1"),$_smarty_tpl);?>
 <?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['upload']->value['data'][$_smarty_tpl->getVariable('smarty')->value['section']['upload']['index']]);?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['upload']->value['unit'][$_smarty_tpl->getVariable('smarty')->value['section']['upload']['index']];?>
&nbsp;(<?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['upload']->value['avg'][$_smarty_tpl->getVariable('smarty')->value['section']['upload']['index']]);?>
&nbsp;kbit/s) 
					</td>
				</tr>
				<?php endfor; endif; ?>
				<tr>
					<td align="center" colspan="2">
						<p><b><?php echo trans("Total:");?>
 <?php echo sprintf("%.2f ",$_smarty_tpl->tpl_vars['upload']->value['sum']['data']);
echo $_smarty_tpl->tpl_vars['upload']->value['sum']['unit'];?>
 (<?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['upload']->value['avgsum']);?>
&nbsp;kbit/s)</b></p>
					</td>
				</tr>
			</table>
			<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo _smarty_block_box(array('title'=>"Upload"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

		</td>
	</tr>
</table>
<?php } else { ?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('box', array('title'=>"Network Statistics")); $_block_repeat=true; echo _smarty_block_box(array('title'=>"Network Statistics"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<p>&nbsp;</p>
<p style="text-align: center;"><b><?php echo trans("No such data for selected period.");?>
</b></p>
<p>&nbsp;</p>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo _smarty_block_box(array('title'=>"Network Statistics"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }?>
        </td>
    </tr>
</table>
<?php echo $_smarty_tpl->getSubTemplate ("footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }
}
?>