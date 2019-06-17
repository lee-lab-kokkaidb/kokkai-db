<?php /* Smarty version 2.6.22, created on 2012-12-30 18:27:34
         compiled from update.tpl */ ?>
<?php echo '
	<script type="text/javascript">
	
 		function user_update_check(){
			user_name = document.form.user_name.value;
			password = document.form.password.value;
			password_chk = document.form.password_chk.value;
			company = document.form.company.value;
			reason = document.form.reason.value;

			/*入力名前検査*/
			if(user_name == ""){
				alert("ユーザー名を入力してください。");
				return false;
  			}
  
			/*パスワード検査(半角検査は必要がない)*/
			if(password != ""){
				if(password.length <6 || password.length>12){
				alert("パスワードは6文字から12文字で入力してください。");
				return false;
				}
			}
  
			if( password != password_chk){
				alert("パスワードを確認してください。");
				return false;
			}
  
			/*所属検査*/
			if(company == ""){
				alert("所属を入力してください。");
				return false;
			}
  
			/*使用目的検査*/
			if(reason == ""){
				alert("使用目的を入力してください。");
				return false;
			}
			document.form.submit();
		}
		
	</script>
'; ?>


<?php if ($this->_tpl_vars['error'] != ""): ?>
<center><div class="alert"><?php echo $this->_tpl_vars['error']; ?>
</div><br></center>
<?php endif; ?>
<br><br>
<form name=form action=update.php method=POST>
<table border=1 cellpadding=4 cellspacing=0 align=center>
<tr>
	<td align=center nowrap>ユーザーID</td>
	<td colspan = 1><input type= text readonly style="background-color: #CCCCCC " name=user_id size=20 value = <?php echo $this->_tpl_vars['user_id']; ?>
></td>

	<td align=center nowrap>ユーザー名</td>
	<td><input type=text name=user_name size=20 value = <?php echo $this->_tpl_vars['user_name']; ?>
></td>

</tr>

<tr>
	<td align=center nowrap>パスワード</td>
	<td><input type="password" name="password" size=21></td>
	<td rowspan=2 colspan = 2><font size=2>※6文字～12文字の半角英数字、記号。<br>パスワードを変更しない場合、入力しないでください。</font></td>	
</tr>
<tr>
	<td align=center nowrap>パスワード確認</td>
	<td colspan = 1><input type="password" name="password_chk" size=21></td>
</tr>
	
<tr>
	<td align=center nowrap>所属</td>
	<td colspan=3><input type=text name=company size=50 value = <?php echo $this->_tpl_vars['company']; ?>
></td>
</tr>
	
<tr>
	<td align=center nowrap>E-MAIL</td>
	<td colspan=3><input type=text readonly style="background-color: #CCCCCC " name=email size=50 value = <?php echo $this->_tpl_vars['email']; ?>
></td>
</tr>
	
<tr>
	<td align=center nowrap>使用目的</td>
	<td colspan=3><textarea name = reason rows = 20 cols=55><?php echo $this->_tpl_vars['reason']; ?>
</textarea></td>
</tr>
	
</table><br>
<center>
<input class="update" type=button value='' onClick = user_update_check()>
<input class="reset" type=reset value=''>
<input class="close" type=button value='' onClick = "javascript:window.close();">
</center>
</form>