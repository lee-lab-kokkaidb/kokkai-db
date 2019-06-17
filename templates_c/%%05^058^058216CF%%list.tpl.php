<?php /* Smarty version 2.6.22, created on 2019-03-20 10:16:59
         compiled from list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'popup_init', 'list.tpl', 19, false),array('function', 'counter', 'list.tpl', 41, false),array('function', 'cycle', 'list.tpl', 43, false),array('function', 'popup', 'list.tpl', 48, false),array('modifier', 'default', 'list.tpl', 45, false),array('modifier', 'mb_count_characters', 'list.tpl', 47, false),array('modifier', 'mb_truncate', 'list.tpl', 48, false),array('modifier', 'date_format', 'list.tpl', 53, false),array('modifier', 'replace', 'list.tpl', 74, false),)), $this); ?>
<?php echo '
	<script type="text/javascript">		
		function open_content(id, item){
			//url作成に無理やりチェック入れるしかなし
			str = "?mode=report&conf_id=" + id + "&conf_item_id=" + item;

			w = window.open("content.php" + str, "詳細内容");
//				"help=false,minimize=false,maximize=false,scrollbars=yes");

/*
			w = window.showModalDialog("content.php" + str, "発言リスト", 
							"status:false;dialogWidth:1024px;dialogHeight:720px;help:false;minimize:false;maximize:false;edge:sunken;");
*/
		}
	</script>
'; ?>

<center>
<?php if ($this->_tpl_vars['search']['maxpage'] != 0): ?>
	<?php echo smarty_function_popup_init(array('src' => 'overlib421/overlib.js'), $this);?>

	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'report.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<table  border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4>
	<tr>
		<th>No</th>
		<th onclick="change_order('talker_name')">発言者名</th>
		<th onclick="change_order('parties')">政党</th>
		<th onclick="change_order('position')">肩書き</th>
		<th onclick="change_order('roles')">役割</th>
		<th onclick="change_order('conf_dt')">開会日付</th>
		<th onclick="change_order('sys_tp')">議会</th>
		<th onclick="change_order('diet_tp')">国会<br>種類</th>
		<th onclick="change_order('conf_tp')">会議<br>種類</th>
		<th onclick="change_order('conf_title')">会議名</th>
		<th onclick="change_order('conf_no')">会議<br>回数</th>
		<th onclick="change_order('conf_seq')">会議<br>号数</th>
		<th onclick="change_order('item_cnt')">総発<br>言数</th>
		<th onclick="change_order('conf_len')">会議<br>文字数</th>
		<th onclick="change_order('conf_item_id')">発言<br>順番</th>
		<th onclick="change_order('cont_len')">発言<br>文字数</th>
		<th >発言内容</th>
	</tr>
	<?php echo smarty_function_counter(array('start' => $this->_tpl_vars['offset'],'skip' => 1,'print' => false), $this);?>

	<?php $_from = $this->_tpl_vars['lines']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['line']):
?>
	<tr style="background-color: <?php echo smarty_function_cycle(array('values' => "#eeeeee,#d0d0d0"), $this);?>
;">
		<td nowrap><?php echo smarty_function_counter(array(), $this);?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['talker_name'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['parties'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<?php if (((is_array($_tmp=$this->_tpl_vars['line']['position'])) ? $this->_run_mod_handler('mb_count_characters', true, $_tmp, true) : smarty_modifier_mb_count_characters($_tmp, true)) > 15): ?>
		<td nowrap <?php echo smarty_function_popup(array('caption' => '','text' => "<nobr>".($this->_tpl_vars['line']['position'])."</nobr>"), $this);?>
><?php echo ((is_array($_tmp=$this->_tpl_vars['line']['position'])) ? $this->_run_mod_handler('mb_truncate', true, $_tmp, 15) : smarty_modifier_mb_truncate($_tmp, 15)); ?>
</td>
	<?php else: ?>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['position'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<?php endif; ?>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['roles'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['line']['conf_dt'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")))) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['sys_tp'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['diet_tp'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['conf_tp'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<?php if (((is_array($_tmp=$this->_tpl_vars['line']['conf_title'])) ? $this->_run_mod_handler('mb_count_characters', true, $_tmp, true) : smarty_modifier_mb_count_characters($_tmp, true)) > 15): ?>
		<td nowrap <?php echo smarty_function_popup(array('caption' => '','width' => 300,'text' => ($this->_tpl_vars['line']['conf_title'])), $this);?>
><?php echo ((is_array($_tmp=$this->_tpl_vars['line']['conf_title'])) ? $this->_run_mod_handler('mb_truncate', true, $_tmp, 15) : smarty_modifier_mb_truncate($_tmp, 15)); ?>
</td>
	<?php else: ?>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['conf_title'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<?php endif; ?>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['conf_no'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['conf_seq'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['item_cnt'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['conf_len'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['conf_item_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['cont_len'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
			<?php if ($this->_tpl_vars['down'] != ""): ?>
		<td nowrap><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['content'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<?php else: ?>
		<td nowrap><a  <?php echo smarty_function_popup(array('textsize' => '3','width' => 800,'hauto' => true,'vauto' => true,'text' => ((is_array($_tmp=$this->_tpl_vars['line']['content'])) ? $this->_run_mod_handler('replace', true, $_tmp, "\n", "<br>") : smarty_modifier_replace($_tmp, "\n", "<br>"))), $this);?>
 onclick="open_content(<?php echo $this->_tpl_vars['line']['conf_id']; ?>
, <?php echo $this->_tpl_vars['line']['conf_item_id']; ?>
)">詳細内容</a></td>
	<?php endif; ?>
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
<?php if ($this->_tpl_vars['search']['rpt'] == '00'): ?>
<input class="back" type=button value="" onclick="window.location.replace('search.php')">
<?php else: ?>
<input class="close" type=button value="" onclick="window.opener.focus();window.close()">
<?php endif; ?>
</center>