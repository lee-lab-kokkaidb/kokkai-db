{literal}
	<script type="text/javascript">		
		function open_list(key, item){
			//url作成に無理やりチェック入れるしかなし
			str = "?mode=report&row=" + encodeURI(key) + "&col=" + encodeURI(item);
			w = window.open("list.php" + str, "発言リスト");
//				"dependent=yes,width=1024px,height=720px,help=false,minimize=false,maximize=false,scrollbars=yes");

		}
	</script>
{/literal}
<center>
{if $search.maxpage != 0}
{include file='report.tpl'}
<table  border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4>
<tr>
{foreach from=$col key=key item=item}
	{if $key == 'talker_name' or  $key == 'parties'}
		<th onclick="change_order('{$key}')">{$item|default:'&nbsp;'}</th>
	{else}
		<th>{$item|default:'&nbsp;'}</th>
	{/if}
{/foreach}
</tr>
{foreach from=$lines item=line}
<tr style="background-color: {cycle values="#eeeeee,#d0d0d0"};">
	{foreach from=$line key=key item=item}
		<td nowrap>
		{if $item !=''}
			{if $key != 'talker_name' and  $key != 'parties' }
				<a onclick="open_list('{$line.parties},{$line.talker_name}', '{$key}')">{$item}</a>
			{else}
				{$item}
			{/if}
		{else}
			&nbsp;
		{/if}
		</td>
	{/foreach}
</tr>
{/foreach}
</table>
{include file='paging.tpl'}
{/if}

<br>
<!--<input type=button value="download" id=button1 name=button1>-->
<input class="back" type=button value="" onclick="window.location.replace('search.php')">
</center>