<?php

	class common {

		function __autoload($class_name) {
		    include_once $class_name . '.php';
		}

		function __construct(){
		}
/*************************************************************************/
/**		����	���O�C�����Ă��Ȃ��ꍇ�ɁA���O�C����ʂֈړ����� 		**/
/**		����	SESSION�ɂ̃��[�U�[ID									**/
/**		�o��															**/
/**		���L�̊֐����g�p�ɂȂ�ΏۃT�C�g�F		�S�T�C�g				**/
/*************************************************************************/
		function user_login_check(){
			if (!isset($_SESSION['user_id'])){
				header("Location: index.php");
				return;
			}
		}
/*************************************************************************/
/**		����	�Ǘ��҂ł͂Ȃ��ꍇ�ɁA���O�C����ʂֈړ����� 			**/
/**		����	SESSION�ɂ̌���											**/
/**		�o��															**/
/**		���L�̊֐����g�p�ɂȂ�ΏۃT�C�g�F		�Ǘ��Ґ�p�T�C�g		**/
/*************************************************************************/
		function user_authority_check(){
			if($_SESSION['authority'] != "A"){
				header("Location: index.php");
				return;
			}
		}
	}
?>