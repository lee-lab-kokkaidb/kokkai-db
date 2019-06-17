{literal}
	<script type="text/javascript">
			function input_check(){

			user_id = document.form.user_id.value;
			user_name = document.form.user_name.value;
			password = document.form.password.value;
			password_chk = document.form.password_chk.value;
			company = document.form.company.value;
			email = document.form.email.value;
			reason = document.form.reason.value;
  			/*入力ID検査*/

			if(user_id == ""){
			    alert("ユーザーIDを入力してください。");
			    return false;
			}else if(user_id.length <5 || user_id.length>12){
			    alert("ユーザーIDは5文字から12文字で入力してください。");
			    return false;
			}//else if(!user_id.match(/^(\w| |'|,|&)+$/)){
			  //	alert('ユーザーIDは半角英数字、アンダーライン以外の文字は使用できません。');
				//return false;
  			//}
  			else if(user_id.match(/[^a-zA-Z_0-9]/)){	//(/^[^0-9_a-zA-Z]$/)){
  				alert('ユーザーIDは半角英数字、アンダーライン以外の文字は使用できません。');
				return false;
			}

			/*入力名前検査*/
			if(user_name == ""){
			alert("ユーザー名を入力してください。");
			return false;
			}

			/*パスワード検査(半角検査は必要がない)*/
			if(password == ""){
				alert("パスワードを入力してください。");
				return false;
			}else if(password.length <6 || password.length>12){
				alert("パスワードは6文字から12文字で入力してください。");
				return false;
			}
  
			if(password != password_chk){
				alert("パスワードを確認してください。");
				return false;
			}
  
			/*所属検査*/
			if(company == ""){
				alert("所属を入力してください。");
				return false;
			}
  
			/*Email検査*/  
			if(!/^[a-zA-Z0-9._\-]{1,}@[a-zA-Z0-9_\-]{1,}\.[a-zA-Z0-9_\-.]{1,}$/.test(email))   {   
				alert("E-MAILを正しく入力してください。");
				return false;
			}
  
			/*使用目的検査*/
			if(reason == ""){
				alert("使用目的を入力してください。");
				return false;
			}
			document.form.submit();
  		}
		
		function input_reset(){
			document.form.user_id.value ="";
			document.form.user_name.value ="";
			document.form.password.value="";
			document.form.password_chk.value="";
			document.form.company.value="";
			document.form.email.value="";
			document.form.reason.value="";
		}
	</script>
{/literal}

{if $error!= ""}
<center><div class="alert">{$error}</div><br></center>
{/if}
<form name=form action="register.php" method="POST">
<table border=1 cellpadding=4 cellspacing=0 align=center>
<tr>
	<td align=center nowrap>ユーザーID</td>
	<td colspan = 1><input type="text" name="user_id" size=20 value = {$user_id}><font size=2>※5文字～12文字の半角英数字、アンダーライン。</font></td>
</tr>
<tr>
	<td align=center nowrap>ユーザー名</td>
	<td colspan = 1><input type="text" name="user_name" size=20 value = {$user_name}></td>
</tr>
<tr>
	<td align=center nowrap>パスワード</td>
	<td colspan = 3><input type="password" name="password" size=21><font size=2>※6文字～12文字の半角英数字、記号。</font></td>
	
</tr>
<tr>
	<td align=center nowrap>パスワード確認</td>
	<td colspan = 3><input type="password" name="password_chk" size=21><font size=2>※パスワードを再度入力してください。</font></td>
</tr>
<tr>
	<td align=center nowrap>所属</td>
	<td colspan=3><input type="text" name="company" size=50 value = {$company}></td>
</tr>

<tr>
	<td align=center nowrap>E-MAIL</td>
	<td colspan=3><input type="text" name="email" size=50 style=ime-mode:disabled  value = {$email}></td>
</tr>

<tr>
	<td align=center nowrap>使用目的</td>
	<td colspan=3><textarea name = "reason" rows = "15" cols="55">{$reason}</textarea></td>
</tr>
<tr>
    <td class = help colspan = 4>※全ての項目を入力してください。</td>
</tr>

</table>
<br>
<center>
<input type=button class=regist value=''  onClick = input_check()>&nbsp
<input type=button class=clear value=''	onClick = input_reset()>
</center>
</form>