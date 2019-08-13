<?php /* Smarty version 2.6.22, created on 2012-12-30 14:43:31
         compiled from header_dialog.tpl */ ?>
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
<div class=main>
<?php if ($this->_tpl_vars['title'] != ''): ?>
<h2><?php echo $this->_tpl_vars['title']; ?>
</h2>
<?php endif; ?>
<?php if ($this->_tpl_vars['alert'] != ""): ?>
<div class="alert"><?php echo $this->_tpl_vars['alert']; ?>
</div><br>
<?php endif; ?>