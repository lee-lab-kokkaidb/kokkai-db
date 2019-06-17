<center>
<br>
<table border=1 cellspacing=0 cellpadding=2 bordercolor=#B4B4B4 width=90%>
<tr>
	<th nowrap>発言者名</th>
	<th>データベース</th>
	<th>国会種類</th>
	<th>会議種類</th>
	<th>会議名</th>
	<th>開会日付</th>
</tr>
<tr>
	<td nowrap>{$info.talker_name|default:'&nbsp;'}</td>
	<td nowrap>{$info.sys_tp|default:'&nbsp;'}</td>
	<td nowrap>{$info.diet_tp|default:'&nbsp;'}</td>
	<td nowrap>{$info.conf_tp|default:'&nbsp;'}</td>
	<td nowrap>{$info.conf_title|default:'&nbsp;'}</td>
	<td nowrap>{$info.conf_dt|date_format:"%Y/%m/%d"|default:'&nbsp;'}</td>
</tr>
<tr>
	<th>発言内容</th>
	<td colspan=5>{$info.content|replace:"\n":"<br>"|default:'&nbsp;'}</td>
</tr>
</table>
<br>
<br>
<input class="close" type=button value="" onclick="window.opener.focus();window.close();">
</center>