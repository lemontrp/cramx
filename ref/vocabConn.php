<?php
	//connect code
	$db_DSN	=	"mysql:host=localhost;charset=utf8";
	$db_user=	"vocabje1_user";//"vocabje1_admin";
	$db_pwd	=	"mysqlvocabjet#2";//"mkj942804#1";	
	try {
		$dbh = new PDO($db_DSN, $db_user, $db_pwd, array(PDO::ATTR_EMULATE_PREPARES => false, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));		
		$dbh->exec("SET NAMES utf8");		
	} catch (PDOException $e) {
		error_reporting(E_ALL);						
		die();
	}
	//end connect code		
?>