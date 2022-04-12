<?php
/* Smarty version 3.1.30, created on 2022-04-12 06:24:22
  from "C:\xampp\htdocs\php_07_routing\app\views\CalcView.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_6254fef6c42ef0_72560867',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f3cf26c09d30360a056e0aaa32f121a7c251f925' => 
    array (
      0 => 'C:\\xampp\\htdocs\\php_07_routing\\app\\views\\CalcView.tpl',
      1 => 1649737459,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:main.tpl' => 1,
    'file:messages.tpl' => 1,
  ),
),false)) {
function content_6254fef6c42ef0_72560867 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8450839386254fef6c42742_28801503', 'content');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender("file:main.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, false);
}
/* {block 'content'} */
class Block_8450839386254fef6c42742_28801503 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="pure-menu pure-menu-horizontal bottom-margin">
	<a href="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
logout"  class="pure-menu-heading pure-menu-link">wyloguj</a>
	<span style="float:right;">użytkownik: <?php echo $_smarty_tpl->tpl_vars['user']->value->login;?>
, rola: <?php echo $_smarty_tpl->tpl_vars['user']->value->role;?>
</span>
</div>

<form action="<?php echo $_smarty_tpl->tpl_vars['conf']->value->action_url;?>
calcCompute" method="post" class="pure-form pure-form-aligned bottom-margin">
	<legend>Kalkulator</legend>
	<fieldset>

		<div style="position: relative;left: 5%;">
			<label for="s">Kwota kredytu: </label>
			<input id="s" type="text" name="sum" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->sum;?>
"/><br/><br/>
		</div>
		<div style="position: relative;left: 40%; top:-55px;">
			<label for="p">Okres spłaty: </label>
			<input id="p" type="text" name="period" placeholder="Ile lat" value="<?php echo $_smarty_tpl->tpl_vars['form']->value->period;?>
"/><br/><br/>
		</div>
		<div style="position: relative;left: 75%; top:-108px;">
			<label for="per">Oprocentowanie: </label>
			<input id="per" type="text" name="percent" placeholder="6.5"
				   title="Używaj tylko kropki. Maksymalnie dwie liczby po kropce.  " value="<?php echo $_smarty_tpl->tpl_vars['form']->value->percent;?>
"/><br/>
		</div>
	</fieldset>
	<?php if ($_smarty_tpl->tpl_vars['user']->value->role == "admin") {?>
	<button style="position: relative;left: 47%; top:-20px;font-size: 175%;" type="submit"
			class="button-xlarge pure-button "><i class="fa-solid fa-calculator fa-lg fa-beat"></i> Oblicz
	</button>
	<?php }?>
</form>	

<?php $_smarty_tpl->_subTemplateRender("file:messages.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php if (isset($_smarty_tpl->tpl_vars['res']->value->result)) {?>
<div class="messages info">
	Wynik: <?php echo $_smarty_tpl->tpl_vars['res']->value->result;?>

</div>
<?php }?>

<?php
}
}
/* {/block 'content'} */
}
