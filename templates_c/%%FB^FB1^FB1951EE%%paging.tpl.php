<?php /* Smarty version 2.6.22, created on 2019-03-20 10:16:57
         compiled from paging.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'string_format', 'paging.tpl', 46, false),array('modifier', 'replace', 'paging.tpl', 46, false),)), $this); ?>
<!-- paging -->
<div class=page>
	<br>
	<form method=post name=page >
		<input type=hidden name=page value="<?php echo $this->_tpl_vars['search']['page']; ?>
">
		<input type=hidden name=order value="<?php echo $this->_tpl_vars['search']['order']; ?>
">
		<input type=hidden name=direction value="<?php echo $this->_tpl_vars['search']['direction']; ?>
">
		<input type=hidden name='mode' value='page'>
	</form>
<?php if ($this->_tpl_vars['search']['page'] > 1): ?>
	<img src="images/btn_top.gif" onclick='change_page(1)'>&nbsp;
	<?php if ($this->_tpl_vars['search']['page'] - 10 >= 1): ?>
		<img src="images/btn_before10.gif" onclick='change_page(<?php echo $this->_tpl_vars['search']['page']-10; ?>
)'>&nbsp;
	<?php else: ?>
		<img src="images/btn_before102.gif">&nbsp;
	<?php endif; ?>
	<img src="images/btn_before.gif" onclick='change_page(<?php echo $this->_tpl_vars['search']['page']-1; ?>
)'>
<?php else: ?>
	<img src="images/btn_top2.gif">&nbsp;
	<img src="images/btn_before102.gif">&nbsp;
	<img src="images/btn_before2.gif">
<?php endif; ?>

<?php 
	$search = $this->get_template_vars("search");
	$start = $search['page'];
	$end = $search['maxpage'];
	if($end - $start < 9){
		$start = $end - 9;
		if($start<1)$start=1;
	}
//	echo "$start:$end";
	$this->assign('start',$start);
	$this->assign('end',$end);
 ?>
　
<?php unset($this->_sections['cnt']);
$this->_sections['cnt']['name'] = 'cnt';
$this->_sections['cnt']['start'] = (int)$this->_tpl_vars['start'];
$this->_sections['cnt']['loop'] = is_array($_loop=$this->_tpl_vars['end']+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['cnt']['max'] = (int)10;
$this->_sections['cnt']['show'] = true;
if ($this->_sections['cnt']['max'] < 0)
    $this->_sections['cnt']['max'] = $this->_sections['cnt']['loop'];
$this->_sections['cnt']['step'] = 1;
if ($this->_sections['cnt']['start'] < 0)
    $this->_sections['cnt']['start'] = max($this->_sections['cnt']['step'] > 0 ? 0 : -1, $this->_sections['cnt']['loop'] + $this->_sections['cnt']['start']);
else
    $this->_sections['cnt']['start'] = min($this->_sections['cnt']['start'], $this->_sections['cnt']['step'] > 0 ? $this->_sections['cnt']['loop'] : $this->_sections['cnt']['loop']-1);
if ($this->_sections['cnt']['show']) {
    $this->_sections['cnt']['total'] = min(ceil(($this->_sections['cnt']['step'] > 0 ? $this->_sections['cnt']['loop'] - $this->_sections['cnt']['start'] : $this->_sections['cnt']['start']+1)/abs($this->_sections['cnt']['step'])), $this->_sections['cnt']['max']);
    if ($this->_sections['cnt']['total'] == 0)
        $this->_sections['cnt']['show'] = false;
} else
    $this->_sections['cnt']['total'] = 0;
if ($this->_sections['cnt']['show']):

            for ($this->_sections['cnt']['index'] = $this->_sections['cnt']['start'], $this->_sections['cnt']['iteration'] = 1;
                 $this->_sections['cnt']['iteration'] <= $this->_sections['cnt']['total'];
                 $this->_sections['cnt']['index'] += $this->_sections['cnt']['step'], $this->_sections['cnt']['iteration']++):
$this->_sections['cnt']['rownum'] = $this->_sections['cnt']['iteration'];
$this->_sections['cnt']['index_prev'] = $this->_sections['cnt']['index'] - $this->_sections['cnt']['step'];
$this->_sections['cnt']['index_next'] = $this->_sections['cnt']['index'] + $this->_sections['cnt']['step'];
$this->_sections['cnt']['first']      = ($this->_sections['cnt']['iteration'] == 1);
$this->_sections['cnt']['last']       = ($this->_sections['cnt']['iteration'] == $this->_sections['cnt']['total']);
?>
	<?php if ($this->_sections['cnt']['index'] == $this->_tpl_vars['search']['page']): ?>
		<?php echo $this->_sections['cnt']['index']; ?>

	<?php else: ?>
		<a onclick='change_page(<?php echo $this->_sections['cnt']['index']; ?>
)'><?php echo $this->_sections['cnt']['index']; ?>
</a>
	<?php endif; ?>
<?php endfor; endif; ?>
　
<?php if ($this->_tpl_vars['search']['maxpage'] != 0 && false): ?>
<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['search']['page'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%6s") : smarty_modifier_string_format($_tmp, "%6s")))) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '&nbsp;') : smarty_modifier_replace($_tmp, ' ', '&nbsp;')); ?>
&nbsp;/&nbsp;<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['search']['maxpage'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%-6s") : smarty_modifier_string_format($_tmp, "%-6s")))) ? $this->_run_mod_handler('replace', true, $_tmp, ' ', '&nbsp;') : smarty_modifier_replace($_tmp, ' ', '&nbsp;')); ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['search']['maxpage'] != $this->_tpl_vars['search']['page'] && $this->_tpl_vars['search']['maxpage'] != 0): ?>
	<img src="images/btn_after.gif" onclick='change_page(<?php echo $this->_tpl_vars['search']['page']+1; ?>
)'>&nbsp;
	<?php if ($this->_tpl_vars['search']['maxpage'] >= $this->_tpl_vars['search']['page'] + 10): ?>
		<img src="images/btn_after10.gif" onclick='change_page(<?php echo $this->_tpl_vars['search']['page']+10; ?>
)'>&nbsp;
	<?php else: ?>
		<img src="images/btn_after102.gif">&nbsp;
	<?php endif; ?>
	<img src="images/btn_last.gif" onclick='change_page(<?php echo $this->_tpl_vars['search']['maxpage']; ?>
)'>
<?php else: ?>
	<img src="images/btn_after2.gif">&nbsp;
	<img src="images/btn_after102.gif">&nbsp;
	<img src="images/btn_last2.gif">
<?php endif; ?>

</div>
<!-- paging end -->