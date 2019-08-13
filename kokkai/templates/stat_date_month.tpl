{literal}
	<script type="text/javascript">		
		function open_list(key, item){
			//url作成に無理やりチェック入れるしかなし
			str = "?mode=report&row=" + encodeURI(key) + "&col=" + encodeURI(item);
			w = window.open("list.php" + str, "発言リスト");
			w.focus();
		}
//		function open_down(){
			//url作成に無理やりチェック入れるしかなし
//			str = "?mode=report&row=" + encodeURI(key) + "&col=" + encodeURI(item);
//			w = window.open("down.php", "download");
//				"width=1024px,height=700px,help=false,minimize=false,maximize=false,scrollbars=yes,dependent=yes,alwaysRaised=yes,location=no,left=0,top=0");
//				"dialogWidth:1024px;dialogHeight:720px;help:false;minimize:false;maximize:false;edge:sunken;");
//		}

	</script>
{/literal}
<center>
{if $search.maxpage != 0}
{include file='report.tpl'}
<table  border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4>
<tr>
<th rowspan=2 onclick="change_order('{$search.order}')">&nbsp;</th>
{foreach from=$label.year key=key item=item}
	<th colspan={$item}>{$key}</th>	
{/foreach}
	<th rowspan=2>合計</th>
</tr>
<tr>
{foreach from=$label.month key=key item=item}
	<th>{$item|cat:"/01"|date_format:"%m　"}</th>
{/foreach}
</tr>

{foreach from=$lines key=key item=line}
<tr style="background-color: {cycle values="#eeeeee,#d0d0d0"};">
	<td nowrap>{$key}</td>
	{foreach from=$label.month item=item}
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