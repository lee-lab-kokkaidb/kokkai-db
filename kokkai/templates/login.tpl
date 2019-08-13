{literal}
	<script type="text/javascript">		
	//クリアButtonを押すと、入力したユーザーIDとパスワードをクリアする
		function clear_up(){
			document.main.user_id.value = '';
			document.main.password.value = '';
		}
	</script>
{/literal}


<center>
<h2>ログイン</h2>

{if $error!= ""}
<div class="alert">{$error}</div>
{/if}

<!--入力テーブル-->
<form name = main method=post action=index.php>
<table width=98%>
<tr class="login">
	<td width=49% style = "text-align: right">ユーザーID</td><td width=49% align=left><input style="width:130px;" name=user_id type=text value = {$user_id} ></td>
</tr>
<tr class="login">
	<td style = "text-align: right">パスワード</td><td align=left><input style="width:130px;" name=password type=password></td>
</tr>
</table>
<br>

<div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
<input class="login" type="submit" value="" >&nbsp;&nbsp;
<input class="clear" type="button" value="" onclick = clear_up() >
</div>

<br>
<br>
<br>

<p>
ユーザーの申し込みは<a href = "terms.php">こちら</a>へ。
</p>
<p>本ホームページは、Internet Explore 7.0(IE7)あるいはFirefox 3.0以上でご覧ください。</p>
<input type=hidden name=login value=true>

</form>
</center>