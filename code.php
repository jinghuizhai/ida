<?php 
	require('./engine/validatecode.php');
	session_start();
	$vcode = new ValidateCode('./font/LHANDW.TTF');
	$vcode->doimg();
	$_SESSION['validatecode'] = $vcode->getCode();
?>