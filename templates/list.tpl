{literal}
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
{/literal}
<center>
{if $search.maxpage != 0}
	{popup_init src='overlib421/overlib.js'}
	{include file='report.tpl'}
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
	{counter start=$offset skip=1 print=false}
	{foreach from=$lines item=line}
	<tr style="background-color: {cycle values="#eeeeee,#d0d0d0"};">
		<td nowrap>{counter}</td>
		<td nowrap>{$line.talker_name|default:'&nbsp;'}</td>
		<td nowrap>{$line.parties|default:'&nbsp;'}</td>
	{if $line.position|mb_count_characters:true > 15}
		<td nowrap {popup caption='' text="<nobr>`$line.position`</nobr>"}>{$line.position|mb_truncate:15}</td>
	{else}
		<td nowrap>{$line.position|default:'&nbsp;'}</td>
	{/if}
		<td nowrap>{$line.roles|default:'&nbsp;'}</td>
		<td nowrap>{$line.conf_dt|date_format:"%Y/%m/%d"|default:'&nbsp;'}</td>
		<td nowrap>{$line.sys_tp|default:'&nbsp;'}</td>
		<td nowrap>{$line.diet_tp|default:'&nbsp;'}</td>
		<td nowrap>{$line.conf_tp|default:'&nbsp;'}</td>
	{if $line.conf_title|mb_count_characters:true > 15}
		<td nowrap {popup caption='' width=300 text="`$line.conf_title`"}>{$line.conf_title|mb_truncate:15}</td>
	{else}
		<td nowrap>{$line.conf_title|default:'&nbsp;'}</td>
	{/if}
		<td nowrap>{$line.conf_no|default:'&nbsp;'}</td>
		<td nowrap>{$line.conf_seq|default:'&nbsp;'}</td>
		<td nowrap>{$line.item_cnt|default:'&nbsp;'}</td>
		<td nowrap>{$line.conf_len|default:'&nbsp;'}</td>
		<td nowrap>{$line.conf_item_id|default:'&nbsp;'}</td>
		<td nowrap>{$line.cont_len|default:'&nbsp;'}</td>
		{*
		<td {popup caption="`$line.conf_no`回 `$line.conf_title` `$line.conf_seq`号 `$line.conf_item_id`番" bgbackground="/images/banner.png" width=800  hauto=true textsize="3" vauto=true text=$line.content|replace:"\n":"<br>"} nowrap><a onclick="open_content({$line.conf_id}, {$line.conf_item_id})">詳細内容</a></td>
		*}
	{if $down != ""}
		<td nowrap>{$line.content|default:'&nbsp;'}</td>
	{else}
		<td nowrap><a  {popup textsize="3" width=800 hauto=true vauto=true text=$line.content|replace:"\n":"<br>"} onclick="open_content({$line.conf_id}, {$line.conf_item_id})">詳細内容</a></td>
	{/if}
	</tr>
	{/foreach}
	</table>
	{include file='paging.tpl'}
{/if}

<br>
{if $search.rpt == '00'}
<input class="back" type=button value="" onclick="window.location.replace('search.php')">
{else}
<input class="close" type=button value="" onclick="window.opener.focus();window.close()">
{/if}
</center>