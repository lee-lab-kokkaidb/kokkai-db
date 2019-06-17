<?php /* Smarty version 2.6.22, created on 2012-12-30 14:42:47
         compiled from report.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'report.tpl', 7, false),array('modifier', 'default', 'report.tpl', 7, false),)), $this); ?>
<form method=post name=report >
<div class=report>
<iframe src="" name = "down" frameborder=0 width=0 height=0></iframe>
<input type=hidden name='mode' value='report'>
<input type=hidden name='page' value='1'>
<?php if ($this->_tpl_vars['rpt'] != ""): ?>
表示形式&nbsp;<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['rpt'],'name' => 'rpt','selected' => ((is_array($_tmp=@$this->_tpl_vars['search']['rpt'])) ? $this->_run_mod_handler('default', true, $_tmp, '06') : smarty_modifier_default($_tmp, '06')),'onchange' => "disp_executing();submit();"), $this);?>

&nbsp;&nbsp;&nbsp;&nbsp;
<?php endif; ?>
件数&nbsp;<?php echo $this->_tpl_vars['search']['rows']; ?>

&nbsp;&nbsp;&nbsp;&nbsp;
表示件数&nbsp;<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['disp_rows'],'name' => 'disp_rows','selected' => $this->_tpl_vars['search']['disp_rows'],'onchange' => "disp_executing();submit();"), $this);?>

<?php if ($this->_tpl_vars['search']['rows'] >= 10000): ?>
&nbsp;&nbsp;&nbsp;&nbsp;<input class="down" type=button value="" onclick="javascript:alert('検索記録が10000件超える場合、ダウンロードができないです。');">
<?php elseif ($this->_tpl_vars['rpt'] != ""): ?>
&nbsp;&nbsp;&nbsp;&nbsp;<input class="down" type=button value="" onclick="window.frames['down'].location = 'down.php?d_mode=search';">
<?php else: ?>
&nbsp;&nbsp;&nbsp;&nbsp;<input class="down" type=button value="" onclick="window.frames['down'].location = 'down.php?d_mode=list';">
<?php endif; ?>
</div></form>
<br>