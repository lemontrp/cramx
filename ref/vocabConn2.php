<?php
	//****connect code start****
	$db_host	="localhost";
	$db_account	="vocabje1_user";
	$db_password="mysqlvocabjet#2";
	
	$connect_id = mysqli_connect($db_host, $db_account, $db_password);	
	if (!@mysql_connect($db_host, $db_account, $db_password)) die("Database connection failed.");
	
	mysql_query("SET NAMES 'utf8'");
	mysql_query("SET CHARACTER_SET_CLIENT='utf8'");
	mysql_query("SET CHARACTER_SET_RESULTS='utf8'");
	//****end connect code****		
?>