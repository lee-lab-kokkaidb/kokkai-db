<form method=post name=report >
<div class=report>
<iframe src="" name = "down" frameborder=0 width=0 height=0></iframe>
<input type=hidden name='mode' value='report'>
<input type=hidden name='page' value='1'>
{if $rpt!=""}
表示形式&nbsp;{html_options options=$rpt name="rpt" selected=$search.rpt|default:'06' onchange="disp_executing();submit();"}
&nbsp;&nbsp;&nbsp;&nbsp;
{/if}
件数&nbsp;{$search.rows}
&nbsp;&nbsp;&nbsp;&nbsp;
表示件数&nbsp;{html_options options=$disp_rows name="disp_rows" selected=$search.disp_rows onchange="disp_executing();submit();"}
{if $search.rows >=10000}
&nbsp;&nbsp;&nbsp;&nbsp;<input class="down" type=button value="" onclick="javascript:alert('検索記録が10000件超える場合、ダウンロードができないです。');">
{elseif $rpt!=""}
&nbsp;&nbsp;&nbsp;&nbsp;<input class="down" type=button value="" onclick="window.frames['down'].location = 'down.php?d_mode=search';">
{else}
&nbsp;&nbsp;&nbsp;&nbsp;<input class="down" type=button value="" onclick="window.frames['down'].location = 'down.php?d_mode=list';">
{/if}
</div></form>
<br>
