<?php /* Smarty version 3.1.27, created on 2015-07-20 10:34:06
         compiled from "/var/www/lms2.alfa-system.pl/userpanel/templates/footer.html" */ ?>
<?php
/*%%SmartyHeaderCode:19006185055acb27e0b9899_78126824%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '93f13e5d46a6ec62056b09c979b09b60b70c39e1' => 
    array (
      0 => '/var/www/lms2.alfa-system.pl/userpanel/templates/footer.html',
      1 => 1434528972,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19006185055acb27e0b9899_78126824',
  'variables' => 
  array (
    'layout' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb27e0c7cc0_13718050',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb27e0c7cc0_13718050')) {
function content_55acb27e0c7cc0_13718050 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '19006185055acb27e0b9899_78126824';
?>
<!--// $Id$ //-->
<?php if ($_smarty_tpl->tpl_vars['layout']->value['dberrors']) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("dberrors.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>

<?php }?>
       </div>
    <?php echo '<script'; ?>
 type="text/javascript" src="assets/default/common.js"><?php echo '</script'; ?>
>
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:100;"></div>
<?php echo '<script'; ?>
 type="text/javascript" src="assets/default/overlib.js"><?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 type="text/javascript" src="assets/jquery-1.11.1.min.js"><?php echo '</script'; ?>
>

<!-- DataTables CSS -->
<link rel="stylesheet" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">

<!-- DataTables -->
<?php echo '<script'; ?>
 type="text/javascript" charset="utf-8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type="text/javascript" charset="utf-8" src="//cdn.datatables.net/plug-ins/be7019ee387/integration/bootstrap/3/dataTables.bootstrap.js"><?php echo '</script'; ?>
>


        <?php echo '<script'; ?>
 type="text/javascript">
            $(document).ready(function() {
    $('#table_id').DataTable({
        "order": [[ 0, "desc" ]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/be7019ee387/i18n/Polish.json"
            }
	});
            });
        <?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
?>