{literal}
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
{/literal}
<center>
<!-- 検索条件 -->

<form name = user_search_form  method=post>
<table  width=95% border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4>
<tr><th colspan=2 align=left>検索条件選択</th></tr>
<tr>
<td align=left>
ユーザーID&nbsp;<input name = user_id type = text size = 10 value = "{$search.user_id}">&nbsp;&nbsp;&nbsp;
ユーザー名&nbsp;<input name = user_name type = text size = 10 value = "{$search.user_name}">&nbsp;&nbsp;&nbsp;
許可状態&nbsp;{html_options name = permission options=$search_permission_options selected = $search.permission}&nbsp;&nbsp;&nbsp;
アクティブ状態&nbsp;{html_options name = active options=$search_active_options selected = $search.active}&nbsp;&nbsp;&nbsp;
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
件数：{$search.count_of_user_list}件
</td>
</tr>
</table>
<!--リスト-->
{popup_init src='overlib421/overlib.js'}
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
{if $lines != ""}
{foreach from=$lines item=line name=loopname}
<tr id = "{$line.user_id}">
	<td nowrap align=center>{$line.user_id|default:'&nbsp;'}</td>
	<td nowrap align=center>{$line.user_name|default:'&nbsp;'}</td>
	{if $line.company|mb_count_characters:true > 15}
		<td nowrap align=center {popup caption='' text=$line.company}>{$line.company|mb_truncate:15}</td>
	{else}
		<td nowrap align=center>{$line.company|default:'&nbsp;'}</td>
	{/if}

	<td nowrap align=center><a href="mailto:{$line.email}">{$line.email}</a></td>
	<td nowrap align=center>
	{if $line.permission == "Y"}
	許可
	{elseif $line.permission == "N"}
	未処理
	{elseif $line.permission == "R"}
	禁止
	{else}
	NG
	{/if}
	</td>
	<td nowrap align=center>
	{if $line.active == "Y"}
	アクティブ
	{elseif $line.active == "N"}
	未アクティブ
	{else}
	NG
	{/if}
	</td>
	<td nowrap align=center>{$line.reg_day|date_format:"%Y/%m/%d"}</td>
</tr>
{/foreach}
{/if}
</table>
<!--クリックで選択処理-->
{literal}
<script language="javascript">
mouse_select("user_list","#eeeeee","#d0d0d0","#0066CC");
</script>
{/literal}
</form>

<!-- クリックで選択したユーザーＩＤ  -->
<!-- 照会、変更、削除buttonの為  -->
<form name = selected_form method=post>
<input name = "selected_id" type = hidden>
</form>


{include file='paging.tpl'}
<br>
{include file='option.tpl'}
</center>
<br>
