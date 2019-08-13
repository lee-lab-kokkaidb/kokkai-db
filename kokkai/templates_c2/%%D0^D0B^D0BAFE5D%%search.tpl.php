<?php /* Smarty version 2.6.22, created on 2013-01-29 11:55:35
         compiled from search.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_radios', 'search.tpl', 66, false),array('function', 'html_select_date', 'search.tpl', 75, false),array('function', 'html_checkboxes', 'search.tpl', 102, false),array('function', 'html_options', 'search.tpl', 145, false),array('modifier', 'default', 'search.tpl', 66, false),array('modifier', 'replace', 'search.tpl', 124, false),)), $this); ?>
<?php echo '
	<script type="text/javascript">		
		function reset_input(){
			location.href = "./search.php?mode=reset";
		}
		
		function change_all(p){
			var obj = document.main.elements["select_all[]"];
			//alert(obj[p]);

			if(obj[p-1].checked){
				switch(p){
				case 1:
					var ele = document.main.elements["diet_tp[]"];
					for (var i = 0; i < ele.length; i ++) {
						ele[i].checked = false;
						ele[i].disabled = true;
					}
					break;
				case 2:
					var ele = document.main.elements["sys_tp[]"];
					for (var i = 0; i < ele.length; i ++) {
						ele[i].checked = false;
						ele[i].disabled = true;
					}
					break;
				}
			}else{
				switch(p){
				case 1:
					var ele = document.main.elements["diet_tp[]"];
					for (var i = 0; i < ele.length; i ++) {
						ele[i].disabled = false;
					}
					break;
				case 2:
					var ele = document.main.elements["sys_tp[]"];
					for (var i = 0; i < ele.length; i ++) {
						ele[i].disabled = false;
					}
					break;
				}
			
			}	
		}

	</script>
'; ?>

<center>
<?php 
	$option = array('発言内容'=>'発言内容', '発言者'=>'発言者','政党'=>'政党','肩書き'=>'肩書き','会議情報'=>'会議情報','会議名'=>'会議名');
	$andor = array('AND'=>'AND','OR'=>'OR','AND NOT'=>'NOT');
	$period = array('1'=>'1年','2'=>'2年','3'=>'3年','0'=>'全期間');
 	$this->assign('andor',$andor);
 	$this->assign('option',$option);
 	$this->assign('period',$period);

 ?>
<form method=post name=main action=stat.php onsubmit="disp_executing()">
<table width=95%>
<tr><th colspan=2 align=left>期間選択</th></tr>
<tr>
	<td nowrap width=15% class=title>検索期間</td>
	<td nowrap width=80%>
		<input type=radio name=time value=0 <?php if ($this->_tpl_vars['search']['time'] == 0 || $this->_tpl_vars['search']['time'] == ''): ?>checked<?php endif; ?>>期間指定
		<?php echo smarty_function_html_radios(array('options' => $this->_tpl_vars['period'],'name' => 'period','selected' => ((is_array($_tmp=@$this->_tpl_vars['search']['period'])) ? $this->_run_mod_handler('default', true, $_tmp, '1') : smarty_modifier_default($_tmp, '1')),'onclick' => "document.main.time[0].checked= true"), $this);?>

		<br>
		<input type=radio name=time value=1 <?php if ($this->_tpl_vars['search']['time'] == 1): ?>checked<?php endif; ?>>日付指定&nbsp;
		<?php 
			if(isset($_SESSION['search']['date_s'])){
			 	$this->assign('date_s',implode("/", $_SESSION['search']['date_s']));
			 	$this->assign('date_e',implode("/", $_SESSION['search']['date_e']));
			}
		 ?>
		<?php echo smarty_function_html_select_date(array('time' => ((is_array($_tmp=@$this->_tpl_vars['date_s'])) ? $this->_run_mod_handler('default', true, $_tmp, '2011/01/01') : smarty_modifier_default($_tmp, '2011/01/01')),'start_year' => '1947','end_year' => '2020','field_array' => 'date_s','month_format' => "%m",'field_order' => 'YMD','field_separator' => "/",'onclick' => "document.main.time[1].checked= true"), $this);?>

		<span>～</spaan>
		<?php echo smarty_function_html_select_date(array('time' => ((is_array($_tmp=@$this->_tpl_vars['date_e'])) ? $this->_run_mod_handler('default', true, $_tmp, '2011/12/31') : smarty_modifier_default($_tmp, '2011/12/31')),'start_year' => '1947','end_year' => '2020','field_array' => 'date_e','month_format' => "%m",'field_order' => 'YMD','field_separator' => "/",'onclick' => "document.main.time[1].checked= true"), $this);?>

 	</td>
</tr>

<tr><th colspan=2 align=left>議事録選択</th></tr>
<tr>
	<td nowrap class=title>議会</td>
	<td nowrap>
	<?php 
		if($_SESSION['search']=='') $this->assign('check_diet',true);
		if(count($_SESSION['search']['select_all'])>0){
			foreach($_SESSION['search']['select_all'] as $all){
				switch($all){
				case "1";
				 	$this->assign('check_diet',true);
					break;
				case "2";
				 	$this->assign('check_sys',true);
				}
			}
		}
	 ?>
			<input type=checkbox name="select_all[]" value='1' onclick="change_all(1)" <?php if ($this->_tpl_vars['check_diet']): ?>checked<?php endif; ?>>国会全て<br>
			<div class=paddingbox>
			<?php if ($this->_tpl_vars['check_diet']): ?>
				<?php echo smarty_function_html_checkboxes(array('name' => 'diet_tp','options' => $this->_tpl_vars['diet'],'selected' => $this->_tpl_vars['search']['diet_tp'],'separator' => '','disabled' => true), $this);?>

			<?php else: ?>
				<?php echo smarty_function_html_checkboxes(array('name' => 'diet_tp','options' => $this->_tpl_vars['diet'],'selected' => $this->_tpl_vars['search']['diet_tp'],'separator' => ''), $this);?>

			<?php endif; ?>
			</div>
			<input type=checkbox name="select_all[]" value='2' onclick="change_all(2)" <?php if ($this->_tpl_vars['check_sys']): ?>checked<?php endif; ?>>地方議会全て<br>
			<div class=paddingbox>
			<?php if ($this->_tpl_vars['check_sys']): ?>
				<?php echo smarty_function_html_checkboxes(array('name' => 'sys_tp','options' => $this->_tpl_vars['system'],'selected' => $this->_tpl_vars['search']['sys_tp'],'disabled' => true), $this);?>

			<?php else: ?>
				<?php echo smarty_function_html_checkboxes(array('name' => 'sys_tp','options' => $this->_tpl_vars['system'],'selected' => $this->_tpl_vars['search']['sys_tp']), $this);?>

			<?php endif; ?>
			</div>
	</td>
</tr>
<tr>
	<td nowrap class=title>会議種類</td>
	<td nowrap>
	<div class=paddingbox>
		<?php ob_start(); ?>
			<?php echo smarty_function_html_checkboxes(array('name' => 'conf_tp','options' => $this->_tpl_vars['kind'],'selected' => $this->_tpl_vars['search']['conf_tp'],'separator' => ''), $this);?>

		<?php $this->_smarty_vars['capture']['conf'] = ob_get_contents(); ob_end_clean(); ?>
		国会　　：<?php echo ((is_array($_tmp=$this->_smarty_vars['capture']['conf'])) ? $this->_run_mod_handler('replace', true, $_tmp, '委員会</label>', '委員会</label>&nbsp;<br>地方議会：') : smarty_modifier_replace($_tmp, '委員会</label>', '委員会</label>&nbsp;<br>地方議会：')); ?>

	</div>
	</td>
</tr>
<!--
<tr>
	<td nowrap>会議号数</td>
	<td nowrap>
		<input type="text" name="number_s" value="<?php echo $this->_tpl_vars['search']['number_s']; ?>
" style="width: 20px;">～<input type="text" name="number_e"  value="<?php echo $this->_tpl_vars['search']['number_e']; ?>
" style="width: 20px;">
	</td>
</tr>
<tr>
	<td nowrap>発言者名</td>
	<td nowrap>
		<input type="text" name="talker_name"  style="width: 100px;" value="<?php echo $this->_tpl_vars['search']['talker_name']; ?>
" ><input type=button value="選択" onclick="talker()">
	</td>
</tr>
-->

<tr><th colspan=2 align=left>検索語指定　　　※A「AND」B→AかつB　　A「OR」B→AまたはB　　A「NOT」B→AのうちBは含まない</th></tr>
<tr>
	<td nowrap class=title><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['option'],'name' => "option[0]",'selected' => $this->_tpl_vars['search']['option'][0]), $this);?>
</td>
	<td nowrap>
		<input type="text" name="option_value[0]" style="width: 300px;" value="<?php echo $this->_tpl_vars['search']['option_value'][0]; ?>
">
		<?php echo smarty_function_html_radios(array('options' => $this->_tpl_vars['andor'],'name' => "andor[1]",'selected' => ((is_array($_tmp=@$this->_tpl_vars['search']['andor'][1])) ? $this->_run_mod_handler('default', true, $_tmp, 'AND') : smarty_modifier_default($_tmp, 'AND'))), $this);?>

		<input type="hidden" name="andor[0]" value="AND">
	</td>
</tr>
<tr>
	<td nowrap class=title><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['option'],'name' => "option[1]",'selected' => $this->_tpl_vars['search']['option'][1],'style' => "z-index:2"), $this);?>
</td>
	<td nowrap>
		<input type="text" name="option_value[1]" style="width: 300px;" value="<?php echo $this->_tpl_vars['search']['option_value'][1]; ?>
">
		<?php echo smarty_function_html_radios(array('options' => $this->_tpl_vars['andor'],'name' => "andor[2]",'selected' => ((is_array($_tmp=@$this->_tpl_vars['search']['andor'][2])) ? $this->_run_mod_handler('default', true, $_tmp, 'AND') : smarty_modifier_default($_tmp, 'AND'))), $this);?>

	</td>
</tr>
<tr>
	<td nowrap class=title><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['option'],'name' => "option[2]",'selected' => $this->_tpl_vars['search']['option'][2]), $this);?>
</td>
	<td nowrap>
		<input type="text" name="option_value[2]" style="width: 300px;" value="<?php echo $this->_tpl_vars['search']['option_value'][2]; ?>
">
		<?php echo smarty_function_html_radios(array('options' => $this->_tpl_vars['andor'],'name' => "andor[3]",'selected' => ((is_array($_tmp=@$this->_tpl_vars['search']['andor'][3])) ? $this->_run_mod_handler('default', true, $_tmp, 'AND') : smarty_modifier_default($_tmp, 'AND'))), $this);?>

	</td>
</tr>
<tr>
	<td nowrap class=title><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['option'],'name' => "option[3]",'selected' => $this->_tpl_vars['search']['option'][3]), $this);?>
</td>
	<td nowrap>
		<input type="text" name="option_value[3]" style="width: 300px;" value="<?php echo $this->_tpl_vars['search']['option_value'][3]; ?>
">
		<?php echo smarty_function_html_radios(array('options' => $this->_tpl_vars['andor'],'name' => "andor[4]",'selected' => ((is_array($_tmp=@$this->_tpl_vars['search']['andor'][4])) ? $this->_run_mod_handler('default', true, $_tmp, 'AND') : smarty_modifier_default($_tmp, 'AND'))), $this);?>

	</td>
</tr>
<tr>
	<td nowrap class=title><?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['option'],'name' => "option[4]",'selected' => $this->_tpl_vars['search']['option'][4]), $this);?>
</td>
	<td nowrap><input type="text" name="option_value[4]" style="width: 300px;" value="<?php echo $this->_tpl_vars['search']['option_value'][4]; ?>
"></td>
</tr>
</table>
<input type=hidden name='page' value='1'>
<input type=hidden name='order' value='name'>
<input type=hidden name='direction' value='ASC'>
<input type=hidden name='mode' value='search'>

<br>
表示形式&nbsp;<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['rpt'],'name' => 'rpt','selected' => ((is_array($_tmp=@$this->_tpl_vars['search']['rpt'])) ? $this->_run_mod_handler('default', true, $_tmp, '02') : smarty_modifier_default($_tmp, '02'))), $this);?>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
表示件数&nbsp;<?php echo smarty_function_html_options(array('options' => $this->_tpl_vars['disp_rows'],'name' => 'disp_rows','selected' => $this->_tpl_vars['search']['disp_rows']), $this);?>

<br><br>
<input type="submit" value="" name=button1 class="search">&nbsp;
<input type="button" onclick="reset_input();" class="clear" >
<br>
</form>
</center>