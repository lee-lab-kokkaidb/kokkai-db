{literal}
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
{/literal}
<center>
{if $search.maxpage != 0}
{include file='report.tpl'}
<table  border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4>
<tr>
<th onclick="change_order('parties')">政党</th>
<th onclick="change_order('talker_name')">発言者名</th>
{foreach from=$label key=key item=item}
	<th>{$item|default:'&nbsp;'}</th>
{/foreach}
	<th>合計</th>
</tr>
{foreach from=$lines key=key item=line}
<tr style="background-color: {cycle values="#eeeeee,#d0d0d0"};">
	<td nowrap>{$line.parties}</td>
	<td nowrap>{$line.name}</td>
	{foreach from=$label item=item}
		<td nowrap>
		{if $line[$item]!=''}
			<a onclick="open_list('{$key}', '{$item}')">{$line[$item]}</a>
		{else}
			&nbsp;
		{/if}
		</td>
	{/foreach}
	
	<td nowrap><a onclick="open_list('{$key}', 'all')">{$line.sum}</a></td>
</tr>
{/foreach}
</table>
{include file='paging.tpl'}
{/if}

<br>
<!--<input type=button value="download" id=button1 name=button1>-->
<input class="back" type=button value="" onclick="window.location.replace('search.php')">
</center>