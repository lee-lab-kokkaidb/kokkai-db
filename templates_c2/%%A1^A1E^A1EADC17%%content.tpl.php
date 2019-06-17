<?php /* Smarty version 2.6.22, created on 2012-12-30 14:43:56
         compiled from content.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'content.tpl', 13, false),array('modifier', 'date_format', 'content.tpl', 18, false),array('modifier', 'replace', 'content.tpl', 22, false),)), $this); ?>
<center>
<br>
<table border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4 width=90%>
<tr>
	<th nowrap>発言者名</th>
	<th>データベース</th>
	<th>国会種類</th>
	<th>会議種類</th>
	<th>会議名</th>
	<th>開会日付</th>
</tr>
<tr>
	<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['info']['talker_name'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['info']['sys_tp'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['info']['diet_tp'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['info']['conf_tp'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['info']['conf_title'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<td nowrap><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['info']['conf_dt'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")))) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
</tr>
<tr>
	<th>発言内容</th>
	<td colspan=5><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['info']['content'])) ? $this->_run_mod_handler('replace', true, $_tmp, "\n", "<br>") : smarty_modifier_replace($_tmp, "\n", "<br>")))) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
</tr>
</table>
<br>
<br>
<input class="close" type=button value="" onclick="window.opener.focus();window.close();">
</center>