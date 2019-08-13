<?php /* Smarty version 2.6.22, created on 2012-12-30 14:24:22
         compiled from header.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>会議録検索 <?php echo $this->_tpl_vars['title']; ?>
</title>
	<style type="text/css" media="all">
	@import url("site.css");
	</style>
	<script type="text/javascript" src="common.js"></script>
</head>
<body>
<div style="background: url(images/banner2.png) repeat-x;width:100%;margin-bottom:-5px;"><img src=images/banner.png></div>
<br>
<div style="padding:0px;border-bottom: 1px solid gray; width:100%;">
<!--ユーザー申し込み画面、個人情報変更画面、ユーザー新規画面、ユーザー照会画面、ユーザー変更画面において、以下のTABを表示しない-->
<?php if ($this->_tpl_vars['no_tab'] == ""): ?>
<?php if ($_SESSION['user_id'] != ''): ?>
<!-- <a href=index.php><img class=tab src="images/tab_home.gif"></a>-->
 <a href=search.php><img class=tab src="images/tab_search.gif"></a>
 <a href=update.php onClick="return popitup('update.php')"><img class=tab src="images/tab_selfinfo.gif"></a>
<?php if ($_SESSION['authority'] == 'A'): ?>
 <a href=manage.php><img class=tab src="images/tab_usermanage.gif"></a>
<?php endif; ?>
 <a href="index.php?logout=true"><img class=tab src="images/tab_logout.gif"></a>
 <!--<span style="text-align:right;width:100%"><?php echo $_SESSION['user_name']; ?>
</span>-->
<?php endif; ?>
<?php endif; ?>
</div>
<div class=main>
<?php if ($this->_tpl_vars['title'] != ''): ?>
<h2><?php echo $this->_tpl_vars['title']; ?>
</h2>
<?php endif; ?>
<?php if ($this->_tpl_vars['alert'] != ""): ?>
<div class="alert"><?php echo $this->_tpl_vars['alert']; ?>
</div>
<?php endif; ?>