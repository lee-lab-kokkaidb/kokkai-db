{literal}
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
{/literal}
<center>
{php}
	$option = array('発言内容'=>'発言内容', '発言者'=>'発言者','政党'=>'政党','肩書き'=>'肩書き','会議情報'=>'会議情報','会議名'=>'会議名');
	$andor = array('AND'=>'AND','OR'=>'OR','AND NOT'=>'NOT');
	$period = array('1'=>'1年','2'=>'2年','3'=>'3年','0'=>'全期間');
 	$this->assign('andor',$andor);
 	$this->assign('option',$option);
 	$this->assign('period',$period);

{/php}
<form method=post name=main action=stat.php onsubmit="disp_executing()">
<table width=95%>
<tr><th colspan=2 align=left>期間選択</th></tr>
<tr>
	<td nowrap width=15% class=title>検索期間</td>
	<td nowrap width=80%>
		<input type=radio name=time value=0 {if $search.time == 0 || $search.time == ''}checked{/if}>期間指定
		{html_radios options=$period name="period" selected=$search.period|default:'1'  onclick="document.main.time[0].checked= true"}
		<br>
		<input type=radio name=time value=1 {if $search.time == 1}checked{/if}>日付指定&nbsp;
		{php}
			if(isset($_SESSION['search']['date_s'])){
			 	$this->assign('date_s',implode("/", $_SESSION['search']['date_s']));
			 	$this->assign('date_e',implode("/", $_SESSION['search']['date_e']));
			}
		{/php}
		{html_select_date time=$date_s|default:'2011/01/01' start_year="1947" end_year="2020" field_array="date_s" month_format="%m" field_order="YMD" field_separator="/" onclick="document.main.time[1].checked= true"}
		<span>～</spaan>
		{html_select_date time=$date_e|default:'2011/12/31' start_year="1947" end_year="2020" field_array="date_e" month_format="%m" field_order="YMD" field_separator="/" onclick="document.main.time[1].checked= true"}
 	</td>
</tr>

<tr><th colspan=2 align=left>議事録選択</th></tr>
<tr>
	<td nowrap class=title>議会</td>
	<td nowrap>
	{php}
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
	{/php}
			<input type=checkbox name="select_all[]" value='1' onclick="change_all(1)" {if $check_diet}checked{/if}>国会全て<br>
			<div class=paddingbox>
			{if $check_diet}
				{html_checkboxes name='diet_tp' options=$diet selected=$search.diet_tp separator='' disabled=true}
			{else}
				{html_checkboxes name='diet_tp' options=$diet selected=$search.diet_tp separator=''}
			{/if}
			</div>
			<input type=checkbox name="select_all[]" value='2' onclick="change_all(2)" {if $check_sys}checked{/if}>地方議会全て<br>
			<div class=paddingbox>
			{if $check_sys}
				{html_checkboxes name='sys_tp' options=$system selected=$search.sys_tp disabled=true}
			{else}
				{html_checkboxes name='sys_tp' options=$system selected=$search.sys_tp}
			{/if}
			</div>
	</td>
</tr>
<tr>
	<td nowrap class=title>会議種類</td>
	<td nowrap>
	<div class=paddingbox>
		{capture name=conf}
			{html_checkboxes name='conf_tp' options=$kind selected=$search.conf_tp separator=''}
		{/capture}
		国会　　：{$smarty.capture.conf|replace:'委員会</label>':'委員会</label>&nbsp;<br>地方議会：'}
	</div>
	</td>
</tr>
<!--
<tr>
	<td nowrap>会議号数</td>
	<td nowrap>
		<input type="text" name="number_s" value="{$search.number_s}" style="width: 20px;">～<input type="text" name="number_e"  value="{$search.number_e}" style="width: 20px;">
	</td>
</tr>
<tr>
	<td nowrap>発言者名</td>
	<td nowrap>
		<input type="text" name="talker_name"  style="width: 100px;" value="{$search.talker_name}" ><input type=button value="選択" onclick="talker()">
	</td>
</tr>
-->

<tr><th colspan=2 align=left>検索語指定　　　※A「AND」B→AかつB　　A「OR」B→AまたはB　　A「NOT」B→AのうちBは含まない</th></tr>
<tr>
	<td nowrap class=title>{html_options options=$option name="option[0]" selected=$search.option[0]}</td>
	<td nowrap>
		<input type="text" name="option_value[0]" style="width: 300px;" value="{$search.option_value[0]}">
		{html_radios options=$andor name="andor[1]" selected=$search.andor[1]|default:'AND'}
		<input type="hidden" name="andor[0]" value="AND">
	</td>
</tr>
<tr>
	<td nowrap class=title>{html_options options=$option name="option[1]" selected=$search.option[1] style="z-index:2"}</td>
	<td nowrap>
		<input type="text" name="option_value[1]" style="width: 300px;" value="{$search.option_value[1]}">
		{html_radios options=$andor name="andor[2]" selected=$search.andor[2]|default:'AND'}
	</td>
</tr>
<tr>
	<td nowrap class=title>{html_options options=$option name="option[2]" selected=$search.option[2]}</td>
	<td nowrap>
		<input type="text" name="option_value[2]" style="width: 300px;" value="{$search.option_value[2]}">
		{html_radios options=$andor name="andor[3]" selected=$search.andor[3]|default:'AND'}
	</td>
</tr>
<tr>
	<td nowrap class=title>{html_options options=$option name="option[3]" selected=$search.option[3]}</td>
	<td nowrap>
		<input type="text" name="option_value[3]" style="width: 300px;" value="{$search.option_value[3]}">
		{html_radios options=$andor name="andor[4]" selected=$search.andor[4]|default:'AND'}
	</td>
</tr>
<tr>
	<td nowrap class=title>{html_options options=$option name="option[4]" selected=$search.option[4]}</td>
	<td nowrap><input type="text" name="option_value[4]" style="width: 300px;" value="{$search.option_value[4]}"></td>
</tr>
</table>
<input type=hidden name='page' value='1'>
<input type=hidden name='order' value='name'>
<input type=hidden name='direction' value='ASC'>
<input type=hidden name='mode' value='search'>

<br>
表示形式&nbsp;{html_options options=$rpt name="rpt" selected=$search.rpt|default:'02'}
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
表示件数&nbsp;{html_options options=$disp_rows name="disp_rows" selected=$search.disp_rows}
<br><br>
<input type="submit" value="" name=button1 class="search">&nbsp;
<input type="button" onclick="reset_input();" class="clear" >
<br>
</form>
</center>
