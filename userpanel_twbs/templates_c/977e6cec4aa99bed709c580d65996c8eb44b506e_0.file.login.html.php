<?php /* Smarty version 3.1.27, created on 2015-07-20 10:37:02
         compiled from "/var/www/lms2.alfa-system.pl/userpanel/templates/login.html" */ ?>
<?php
/*%%SmartyHeaderCode:190358692855acb32ed578c0_26599186%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '977e6cec4aa99bed709c580d65996c8eb44b506e' => 
    array (
      0 => '/var/www/lms2.alfa-system.pl/userpanel/templates/login.html',
      1 => 1434528972,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '190358692855acb32ed578c0_26599186',
  'variables' => 
  array (
    'target' => 0,
    'error' => 0,
    'recovery' => 0,
    'recovery_errors' => 0,
    'bilans' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_55acb32ede6831_89515117',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_55acb32ede6831_89515117')) {
function content_55acb32ede6831_89515117 ($_smarty_tpl) {
if (!is_callable('smarty_block_t')) require_once '/var/www/lms2.alfa-system.pl/lib//SmartyPlugins/block.t.php';

$_smarty_tpl->properties['nocache_hash'] = '190358692855acb32ed578c0_26599186';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type" />
        <title><?php echo trans("Virtual Customer Service");?>
</title>
        <!-- TWITTER BOOTSTRAP RESPONSIVE -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- TWITTER BOOTSTRAP CSS -->
        <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header"><a href="http://alfa-system.pl"><img src="media/logo.png" alt="Alfa-System" /></a></div>

                    <div class="row">
                        <div class="col-md-4">
                            <fieldset>
                                <legend><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Virtual Customer Service<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</legend>
                                <form id="login" method="post" action="<?php echo $_smarty_tpl->tpl_vars['target']->value;?>
" class="well" role="form">
                                    <div class="form-group">
				    <label><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Customer ID:<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                                    <input class="form-control" type="text" name="loginform[login]" />
				    </div>
				    <div class="form-group">
                                    <label><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
PIN:<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                                    <input class="form-control" type="password" name="loginform[pwd]" />
				    </div>
                                                                        <button type="submit" name="loginform[submit]" class="btn btn-default" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Login<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
">Zaloguj się!</button>
                                </form>
                            </fieldset>
                            <div class="alert alert-info">Dane do logowania ID oraz PIN są na pierwszej stronie umowy.</div>
                            <?php if ($_smarty_tpl->tpl_vars['error']->value) {?><div class="alert alert-error"><b><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</b></div><?php } else { ?>&nbsp;<?php }?>
                        </div>

                        <div class="col-md-4">
                            <fieldset>
                                <legend>Przypomnienie ID i PIN</legend>
                                <form role="form" id="recovery" method="post" action="<?php echo $_smarty_tpl->tpl_vars['target']->value;?>
" class="well">
                                    <div class="form-group">
				    <label><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
E-mail:<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
                                    <input class="form-control" type="text" name="recovery_email" />
                                    </div>
				    <div class="form-group">
				    <label>PESEL:</label>
                                    <input class="form-control" type="text" name="recovery_pesel" />        
                                    </div>
                                    <button type="submit" name="recovery_submit" class="btn btn-default" value="Wyślij przypomnienie">Wyślij przypomnienie!</button>
                                </form>
                            </fieldset>
                            <?php if ($_smarty_tpl->tpl_vars['recovery']->value == 'OK') {?>
                            <div class="alert alert-success"><b>Dane do logowania zostały wysłane.</b></div>
                            <?php }?>
                            <?php if (isset($_smarty_tpl->tpl_vars['recovery_errors']->value['email'])) {?>
                            <div class="alert alert-error"><?php echo trans("E-Mail is invalid.");?>
</div>
                            <?php }?>
                            <?php if (isset($_smarty_tpl->tpl_vars['recovery_errors']->value['pesel'])) {?>
                            <div class="alert alert-error"><?php echo trans("PESEL is invalid.");?>
</div>
                            <?php }?> 
                            <div class="alert alert-warning">Przypomnienie zadziała pod warunkiem, gdy Abonent ma uzupełniony profil z adresem email oraz numerem PESEL.</div>
                        </div>

                        <div class="col-md-4">
                            <fieldset>
                                <legend>Informacje:</legend>
                                <?php if ($_smarty_tpl->tpl_vars['bilans']->value < 0) {?><!-- NEGATIVE BALANCE ALERT --><div class="alert alert-error"><h1>UWAGA! Twój bilans jest ujemny.</h1></div><?php }?>
                                <div class="alert alert-info">Dopisz swój adres e-mail, aby co miesiąc otrzymywać faktury VAT.</div>
                                <div class="alert alert-success">Faktury VAT do rozlicznia podatkowego oraz druki do wpłat dostępne są po zalogowaniu do BOK.</div>
                                <div class="alert alert-block">
                                    <strong>Sesje przychodzące - godziny księgowania przelewów przychodzących:</strong>
                                    <ul>
                                        <li>10:30</li>
                                        <li>14:30</li>
                                        <li>17:00</li>
                                    </ul>
                                </div> 
                            </fieldset>                        
                        </div>   
                    </div>        

                    <div class="row">
                        <div class="col-md-12">
			    <div class="alert alert-success">
			    Zapraszamy do serwisu <a href="http://pomoc.alfa-system.pl">POMOC: pytania i odpowiedzi</a>, w którym możesz zadawać pytania innym użytkownikom i ekspertom, dzielić się wiedzą z innymi i zdobywać wiedzę na liczne tematy.
			    </div>
			</div>
		    </div>

                </div>
            </div>
        </div>

        <?php echo '<script'; ?>
 type="text/javascript">
            <!--
            document.forms['login'].elements['loginform[login]'].focus();
            //-->
        <?php echo '</script'; ?>
>
        <!-- TWITTER BOOTSTRAP JS -->
    </body>
</html><?php }
}
?>