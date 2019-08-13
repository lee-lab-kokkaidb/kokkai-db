<?php /* Smarty version 2.6.22, created on 2012-12-31 15:21:01
         compiled from stat_talker_month.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'cat', 'stat_talker_month.tpl', 30, false),array('modifier', 'date_format', 'stat_talker_month.tpl', 30, false),array('function', 'cycle', 'stat_talker_month.tpl', 35, false),)), $this); ?>
<?php echo '
	<script type="text/javascript">		
		function open_list(key, item){
			//url作成に無理やりチェック入れるしかなし
			str = "?mode=report&row=" + encodeURI(key) + "&col=" + encodeURI(item);
			w = window.open("list.php" + str, "発言リスト");
		}
//		function open_down(){
			//url作成に無理やりチェック入れるしかなし
//			w = window.open("down.php", "download");
//		}

	</script>
'; ?>

<center>
<?php if ($this->_tpl_vars['search']['maxpage'] != 0): ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'report.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<table border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4>
<tr>
<th rowspan=2 onclick="change_order('parties')">政党</th>
<th rowspan=2 onclick="change_order('talker_name')">発言者名</th>
<?php $_from = $this->_tpl_vars['label']['year']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<th colspan=<?php echo $this->_tpl_vars['item']; ?>
><?php echo $this->_tpl_vars['key']; ?>
</th>	
<?php endforeach; endif; unset($_from); ?>

	<th rowspan=2>合計</th>
</tr>
<tr>
<?php $_from = $this->_tpl_vars['label']['month']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
	<th><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item'])) ? $this->_run_mod_handler('cat', true, $_tmp, "/01") : smarty_modifier_cat($_tmp, "/01")))) ? $this->_run_mod_handler('date_format', true, $_tmp, "%m　") : smarty_modifier_date_format($_tmp, "%m　")); ?>
</th>
<?php endforeach; endif; unset($_from); ?>
</tr>

<?php $_from = $this->_tpl_vars['lines']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['line']):
?>
<tr style="background-color: <?php echo smarty_function_cycle(array('values' => "#eeeeee,#d0d0d0"), $this);?>
;">
	<td nowrap><?php echo $this->_tpl_vars['line']['parties']; ?>
</td>
	<td nowrap><?php echo $this->_tpl_vars['line']['name']; ?>
</td>
	<?php $_from = $this->_tpl_vars['label']['month']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
		<td nowrap>
		<?php if ($this->_tpl_vars['line'][$this->_tpl_vars['item']] != ''): ?>
			<a onclick="open_list('<?php echo $this->_tpl_vars['key']; ?>
', '<?php echo $this->_tpl_vars['item']; ?>
')"><?php echo $this->_tpl_vars['line'][$this->_tpl_vars['item']]; ?>
</a>
		<?php else: ?>
			&nbsp;
		<?php endif; ?>
		</td>
	<?php endforeach; endif; unset($_from); ?>
	
	<td nowrap><a onclick="open_list('<?php echo $this->_tpl_vars['key']; ?>
', 'all')"><?php echo $this->_tpl_vars['line']['sum']; ?>
</a></td>
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