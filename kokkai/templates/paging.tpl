<!-- paging -->
<div class=page>
	<br>
	<form method=post name=page >
		<input type=hidden name=page value="{$search.page}">
		<input type=hidden name=order value="{$search.order}">
		<input type=hidden name=direction value="{$search.direction}">
		<input type=hidden name='mode' value='page'>
	</form>
{if $search.page > 1}
	<img src="images/btn_top.gif" onclick='change_page(1)'>&nbsp;
	{if $search.page - 10 >= 1}
		<img src="images/btn_before10.gif" onclick='change_page({$search.page-10})'>&nbsp;
	{else}
		<img src="images/btn_before102.gif">&nbsp;
	{/if}
	<img src="images/btn_before.gif" onclick='change_page({$search.page-1})'>
{else}
	<img src="images/btn_top2.gif">&nbsp;
	<img src="images/btn_before102.gif">&nbsp;
	<img src="images/btn_before2.gif">
{/if}

{php}
	$search = $this->get_template_vars("search");
	$start = $search['page'];
	$end = $search['maxpage'];
	if($end - $start < 9){
		$start = $end - 9;
		if($start<1)$start=1;
	}
//	echo "$start:$end";
	$this->assign('start',$start);
	$this->assign('end',$end);
{/php}
　
{section name=cnt start=$start loop=$end+1 max=10}
	{if $smarty.section.cnt.index == $search.page}
		{$smarty.section.cnt.index}
	{else}
		<a onclick='change_page({$smarty.section.cnt.index})'>{$smarty.section.cnt.index}</a>
	{/if}
{/section}
　
{if $search.maxpage != 0 && false}
{$search.page|string_format:"%6s"|replace:' ':'&nbsp;'}&nbsp;/&nbsp;{$search.maxpage|string_format:"%-6s"|replace:' ':'&nbsp;'}
{/if}

{if $search.maxpage != $search.page && $search.maxpage != 0}
	<img src="images/btn_after.gif" onclick='change_page({$search.page+1})'>&nbsp;
	{if $search.maxpage >= $search.page + 10}
		<img src="images/btn_after10.gif" onclick='change_page({$search.page+10})'>&nbsp;
	{else}
		<img src="images/btn_after102.gif">&nbsp;
	{/if}
	<img src="images/btn_last.gif" onclick='change_page({$search.maxpage})'>
{else}
	<img src="images/btn_after2.gif">&nbsp;
	<img src="images/btn_after102.gif">&nbsp;
	<img src="images/btn_last2.gif">
{/if}

</div>
<!-- paging end -->
