<?php

	define('SMARTY_DIR', './Smarty-2.6.22/libs/');
	require_once(SMARTY_DIR . 'Smarty.class.php');

	class mysmarty extends Smarty {

		function __construct() {
			parent::__construct();
			$this->template_dir = './templates/';
			$this->compile_dir  = './templates_c/';
			$this->config_dir   = './configs/';
			$this->cache_dir    = './cache/';
		}
	
		function display($template, $title='', $id=''){
			parent::assign('title', $title);
			parent::display('header.tpl');
			parent::display($template);
			parent::display('footer.tpl');
		}

		function display_dialog($template, $title=''){
			parent::assign('title', $title);
			parent::display('header_dialog.tpl');
			parent::display($template);
			parent::display('footer_dialog.tpl');
		}
	}

?>
