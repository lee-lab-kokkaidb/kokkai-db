<?php /* Smarty version 2.6.22, created on 2019-04-24 09:04:07
         compiled from manage.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'html_options', 'manage.tpl', 58, false),array('function', 'popup_init', 'manage.tpl', 81, false),array('function', 'popup', 'manage.tpl', 99, false),array('modifier', 'default', 'manage.tpl', 96, false),array('modifier', 'mb_count_characters', 'manage.tpl', 98, false),array('modifier', 'mb_truncate', 'manage.tpl', 99, false),array('modifier', 'date_format', 'manage.tpl', 125, false),)), $this); ?>
<?php echo '
	<script type="text/javascript">

		/* 照会、変更buttonの為 */
		function user_edit(URL) {
			if(document.selected_form.selected_id.value == ""){
				alert("対象ユーザーを選択してください。");
				return;
			}

			URL += "?user_id=";
			URL += document.selected_form.selected_id.value;
			document.location = URL;
		}
		
		/* 削除buttonの為 */
		function user_delete() {
			if(document.selected_form.selected_id.value == ""){
				alert("対象ユーザーを選択してください。");
				return;
			}
			
			var conf="ユーザー:"+document.selected_form.selected_id.value+"を削除してよろしいですか？";
			if (window.confirm(conf)) {
				document.selected_form.submit();
			}
		}

		/* クリックでユーザーIDを選択する為 */
		function mouse_select(id,color_odd,color_even,color_selected){
			var t=document.getElementById(id).getElementsByTagName("tr");
			for(var i=1;i<t.length;i++){
				t[i].style.backgroundColor=(t[i].sectionRowIndex%2==0)?color_odd:color_even;
				t[i].onclick=function(){
					var tt=document.getElementById(id).getElementsByTagName("tr");
					for(var j=1;j<tt.length;j++){
							tt[j].style.backgroundColor=(tt[j].sectionRowIndex%2==0)?color_odd:color_even;
					}
					this.style.backgroundColor=color_selected;
					// 選択したユーザーIDを保存
					document.selected_form.selected_id.value = this.id;
				}
			}
		}

	</script>
'; ?>

<center>
<!-- 検索条件 -->

<form name = user_search_form  method=post>
<table  width=95% border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4>
<tr><th colspan=2 align=left>検索条件選択</th></tr>
<tr>
<td align=left>
ユーザーID&nbsp;<input name = user_id type = text size = 10 value = "<?php echo $this->_tpl_vars['search']['user_id']; ?>
">&nbsp;&nbsp;&nbsp;
ユーザー名&nbsp;<input name = user_name type = text size = 10 value = "<?php echo $this->_tpl_vars['search']['user_name']; ?>
">&nbsp;&nbsp;&nbsp;
許可状態&nbsp;<?php echo smarty_function_html_options(array('name' => 'permission','options' => $this->_tpl_vars['search_permission_options'],'selected' => $this->_tpl_vars['search']['permission']), $this);?>
&nbsp;&nbsp;&nbsp;
アクティブ状態&nbsp;<?php echo smarty_function_html_options(array('name' => 'active','options' => $this->_tpl_vars['search_active_options'],'selected' => $this->_tpl_vars['search']['active']), $this);?>
&nbsp;&nbsp;&nbsp;
<input type=hidden name='mode' value='search'>
</td>
<td align = right>
<input type="submit" value="" class="search")>
</td>
</tr>
</table>
</form>
<br>

<!--検索結果リスト-->
<form name = user_list_form>
<!--件数-->
<table width=95% border=0 >
<tr class = login>
<td align = left>
件数：<?php echo $this->_tpl_vars['search']['count_of_user_list']; ?>
件
</td>
</tr>
</table>
<!--リスト-->
<?php echo smarty_function_popup_init(array('src' => 'overlib421/overlib.js'), $this);?>

<table width=95% border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4 id = "user_list">
<tr id = "title">
	<th><a onclick="change_order('user_id')">ユーザーID</a></th>
	<th><a onclick="change_order('user_name')">ユーザー名</a></th>
	<th>所属</th>
	<th>Email</th>
	<th>許可状態</th>
	<th>アクティブ状態</th>
	<th><a onclick="change_order('reg_dt')">登録日付</a></th>
</tr>
<!--検索したレコードが無い場合に、何も表示しないように-->
<?php if ($this->_tpl_vars['lines'] != ""): ?>
<?php $_from = $this->_tpl_vars['lines']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loopname'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loopname']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['line']):
        $this->_foreach['loopname']['iteration']++;
?>
<tr id = "<?php echo $this->_tpl_vars['line']['user_id']; ?>
">
	<td nowrap align=center><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['user_id'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<td nowrap align=center><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['user_name'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<?php if (((is_array($_tmp=$this->_tpl_vars['line']['company'])) ? $this->_run_mod_handler('mb_count_characters', true, $_tmp, true) : smarty_modifier_mb_count_characters($_tmp, true)) > 15): ?>
		<td nowrap align=center <?php echo smarty_function_popup(array('caption' => '','text' => $this->_tpl_vars['line']['company']), $this);?>
><?php echo ((is_array($_tmp=$this->_tpl_vars['line']['company'])) ? $this->_run_mod_handler('mb_truncate', true, $_tmp, 15) : smarty_modifier_mb_truncate($_tmp, 15)); ?>
</td>
	<?php else: ?>
		<td nowrap align=center><?php echo ((is_array($_tmp=@$this->_tpl_vars['line']['company'])) ? $this->_run_mod_handler('default', true, $_tmp, '&nbsp;') : smarty_modifier_default($_tmp, '&nbsp;')); ?>
</td>
	<?php endif; ?>

	<td nowrap align=center><a href="mailto:<?php echo $this->_tpl_vars['line']['email']; ?>
"><?php echo $this->_tpl_vars['line']['email']; ?>
</a></td>
	<td nowrap align=center>
	<?php if ($this->_tpl_vars['line']['permission'] == 'Y'): ?>
	許可
	<?php elseif ($this->_tpl_vars['line']['permission'] == 'N'): ?>
	未処理
	<?php elseif ($this->_tpl_vars['line']['permission'] == 'R'): ?>
	禁止
	<?php else: ?>
	NG
	<?php endif; ?>
	</td>
	<td nowrap align=center>
	<?php if ($this->_tpl_vars['line']['active'] == 'Y'): ?>
	アクティブ
	<?php elseif ($this->_tpl_vars['line']['active'] == 'N'): ?>
	未アクティブ
	<?php else: ?>
	NG
	<?php endif; ?>
	</td>
	<td nowrap align=center><?php echo ((is_array($_tmp=$this->_tpl_vars['line']['reg_day'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y/%m/%d") : smarty_modifier_date_format($_tmp, "%Y/%m/%d")); ?>
</td>
</tr>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
</table>
<!--クリックで選択処理-->
<?php echo '
<script language="javascript">
mouse_select("user_list","#eeeeee","#d0d0d0","#0066CC");
</script>
'; ?>

</form>

<!-- クリックで選択したユーザーＩＤ  -->
<!-- 照会、変更、削除buttonの為  -->
<form name = selected_form method=post>
<input name = "selected_id" type = hidden>
</form>


<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'paging.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<br>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'option.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</center>
<br>