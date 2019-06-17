{if $error!= ""}
<center><div class="alert">{$error}</div><br></center>
{/if}
<br><br>
<!--<form name=form action = "useralt.php" method = "GET">-->
<form name=form>
<table border=1 cellpadding=4 cellspacing=0 align=center>
<tr>
	<td align=center nowrap>ユーザーID</td>
	<td><input type= text readonly style="background-color: #CCCCCC " name=user_id size=20 value = {$user_id}></td>
	
	<td align=center nowrap>ユーザー名</td>
	<td><input type=text readonly style="background-color: #CCCCCC " name=user_name size=20 value = {$user_name}></td>
</tr>

<tr>
	<td align=center nowrap>許可状態</td>
	<td><input type= text readonly style="background-color: #CCCCCC " name=permission size=20 value = {$permission}></td>
	
	<td align=center nowrap>アクティブ状態</td>
	<td><input type=text readonly style="background-color: #CCCCCC " name=active size=20 value = {$active}></td>
</tr>
	
<tr>
	<td align=center nowrap>所属</td>
	<td colspan=3><input type=text readonly style="background-color: #CCCCCC " name=company size=50 value = {$company}></td>
</tr>
	
<tr>
	<td align=center nowrap>E-MAIL</td>
	<td colspan=3><input type=text readonly style="background-color: #CCCCCC " name=email size=50 value = {$email}></td>
</tr>
	
<tr>
	<td align=center nowrap>使用目的</td>
	<td colspan=3><textarea name = reason style="background-color: #CCCCCC " readonly rows = 20 cols=55>{$reason}</textarea></td>
</tr>

</table>
<br><br>
<center>
<input type=button class=change value=''  onClick = "window.location.href = 'change.php?user_id={$user_id}'">
&nbsp;
<input type=button class=back value='' onClick = "window.location.href = 'manage.php'">
</center>
</form>