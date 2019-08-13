<?php /* Smarty version 2.6.22, created on 2012-12-31 15:40:15
         compiled from stat_talker_conf.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'stat_talker_conf.tpl', 19, false),array('function', 'cycle', 'stat_talker_conf.tpl', 26, false),)), $this); ?>
<?php echo '
	<script type="text/javascript">		
		function open_list(key, item){
			//url作成に無理やりチェック入れるしかなし
			str = "?mode=report&row=" + encodeURI(key) + "&col=" + encodeURI(item);
			w = window.open("list.php" + str, "発言リスト");
//				"dependent=yes,width=1024px,height=720px,help=false,minimize=false,maximize=false,scrollbars=yes");

		}
	</script>
'; ?>

<center>
<?php if ($this->_tpl_vars['search']['maxpage'] != 0): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'report.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table  border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4>
<tr>
<?php $_from = $this->_tpl_vars['col']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<?php if ($this->_tpl_vars['key'] == 'talker_name' || $this->_tpl_vars['key'] == 'parties'): ?>
		<th onclick="change_order('<?php echo $this->_tpl_vars['key']; ?>
')"><?php echo ((is_array($_tmp=@$this->_tpl_vars['item'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</th>
	<?php else: ?>
		<th><?php echo ((is_array($_tmp=@$this->_tpl_vars['item'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</th>
	<?php endif; ?>
<?php endforeach; endif; unset($_from); ?>
</tr>
<?php $_from = $this->_tpl_vars['lines']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['line']):
?>
<tr style="background-color: <?php echo smarty_function_cycle(array('values' => "#eeeeee,#d0d0d0"), $this);?>
;">
	<?php $_from = $this->_tpl_vars['line']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
		<td nowrap>
		<?php if ($this->_tpl_vars['item'] != ''): ?>
			<?php if ($this->_tpl_vars['key'] != 'talker_name' && $this->_tpl_vars['key'] != 'parties'): ?>
				<a onclick="open_list('<?php echo $this->_tpl_vars['line']['parties']; ?>
,<?php echo $this->_tpl_vars['line']['talker_name']; ?>
', '<?php echo $this->_tpl_vars['key']; ?>
')"><?php echo $this->_tpl_vars['item']; ?>
</a>
			<?php else: ?>
				<?php echo $this->_tpl_vars['item']; ?>

			<?php endif; ?>
		<?php else: ?>
			&nbsp;
		<?php endif; ?>
		</td>
	<?php endforeach; endif; unset($_from); ?>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'paging.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php endif; ?>

<br>
<!--<input type=button value="download" id=button1 name=button1>-->
<input class="back" type=button value="" onclick="window.location.replace('search.php')">
</center>