<?php	
	if(isset($_POST["fnName"])){
		$fnName	=	$_POST["fnName"];		
		if(isset($_POST["fnPar"])){
			$fnPar	=	$_POST["fnPar"];
			call_user_func($fnName, $fnPar);
		}else{
			call_user_func($fnName);
		}	
	}
	//$_COOKIE['vjPass'];//這個cookie是指userId
	//setcookie(name, value, expire, path, domain, secure, httponly);
?>


<?php function logout($fnPar){ 			//登出
		killCookies();
		
		session_start();
	    session_unset();
	    session_destroy();
	    session_write_close();
	    setcookie(session_name(),'',0,'/');
	    session_regenerate_id(true);		
}?>	

<?php function login($fnPar){			//登入
	session_start();
	$usrInfo	= getUsrInfoByAcctPwd($fnPar);

	if( isset($usrInfo['sPwd']) &&  $usrInfo['sPwd'] != "" ){//表示有拿到密碼，登入成功
		setcookie("vjNickName"	, $usrInfo['nickname']	, time() + (86400 * 30)	, "/", NULL , NULL, TRUE);		
		$_SESSION["vjNickName"] = $usrInfo['nickname'];
		$_SESSION["vjUsrId"] = $usrInfo['id'];
		$token="";
		if($fnPar[2]=='1'){//保持登入有勾選
			//*****產生token*****//						
			$salt 	= 	"vJ@579!CaT_912";
			$token	=	sha1( $salt.$usrInfo['id'].time() );
			//*****產生cookie**************//
			setcookie("vjtoken"		, $token			, time() + (86400 * 30)	, "/", NULL , TRUE, TRUE);
			$_SESSION["vjtoken"] = $token;		
		}

		require_once("ref/vocabConn2.php");
		$id        = intval($usrInfo['id']);
		$log_count = ++$usrInfo['log_count'];
		$ipAddr    = get_client_ip();	
		
		$sql = "UPDATE vocabje1_admin.userInfo001 SET `log_count` = '".$log_count."', `ipAddr` = '".$ipAddr."', `loginToken` = '".$token."', `location` = '".$_COOKIE['userCountry']."', `ssid` = '' WHERE `id` = '".$id."'";
		mysql_query($sql);
		//echo "uid: ".$id;		
	}else{
		echo "fail";
	}	
}?>	
<?php function getUsrInfoByAcctPwd($fnPar){		//驗證帳號/密碼，通過就回傳用戶資訊陣列---$fnPar=['帳號','密碼']
	require_once("ref/vocabConn.php");//PDO connect
	$acctTmp= escapeStr($fnPar[0]);
	$pwTmp  = $fnPar[1];		
	$account= $acctTmp;
	$stmt 	= $dbh->prepare('SELECT `fbStr`, `sPwd`, `id`, `mem_level`, `nickname`, `log_count`, `actvAcct`, `ssid`, `hourDiff` FROM vocabje1_admin.userInfo001 WHERE `account` = :account');
	$stmt->bindParam(':account', $account);
	$stmt->execute();		
	$row   		= $stmt->fetch();
	$vId  	 	= $row["id"];
	$pwReal		= $row["sPwd"];
	$actvAcct	= $row["actvAcct"];
	$ssid		= $row["ssid"];
	
	$infoAry=[];
	if(isset($vId) && $vId!=''){
		if(password_verify($pwTmp,$pwReal) || $pwTmp == $pwReal){
			if($actvAcct=='1'){						
				$infoAry=$row;
			}else if($actvAcct=='0'){
				$infoAry = array('NeedActvAcct','');
			}				
		}else{
			$infoAry = array('AcctExist','');
		}
	}else{
		$infoAry = array('NoAcctRec','');
	}

	return $infoAry;		
}?>

<?php function escapeStr($_str){		//替換怪符號，正規式未完成待補充
	$str	=	str_replace("'"	, "╪"	, $_str);//替換單引號
	$str	=	str_replace("ˈ"	, "╪"	, $str);//替換單引號
	$str	=	str_replace("."	, "⊙"	, $str);//替換「.」	
	$str	=	str_replace('"'	, "┴"	, $str);//替換雙引號		
	$str	=	preg_replace("/[+\/]/"	, "♂"	, $str);
	$str	=	preg_replace("/[+:]/"	, "⊕"	, $str);
	$str	=	preg_replace("/[\n]/"	, "╨"	, $str);
	$str	=	preg_replace("/[<]/"	, "ω"	, $str);
	$str	=	preg_replace("/[>]/"	, "Ψ"	, $str);		
	return $str;
}?>

<?php function get_client_ip(){			//取得用戶IP位址
		//$ipaddress = "127.0.0.1";//'';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = '127.0.0.1';//'UNKNOWN';
		return $ipaddress;
}?>

<?php function getUsrInfoByTokenOrSession($fnPar){				
		session_start();

		require_once("ref/vocabConn.php");//PDO connect
		require_once("ref/pdoDBclass.php");//PDO連線用	
	
		$dbh	= 	new Database();		

		if( isset($_SESSION["vjUsrId"]) && $_SESSION["vjUsrId"] !="" ){
			
			if( $fnPar == 0 ){
				$sql = "SELECT * from vocabje1_admin.userInfo001 WHERE `id` = :id";
			}else{				
				$sql = "SELECT `id`, `nickname`, `mem_level`, `orgList`, `lang`, `reg_time`, `vocInfo`, `realName`, `ttlWords`, `hourDiff` from vocabje1_admin.userInfo001 WHERE `id` = :id";
				//$sql = "SELECT `id`, `nickname`, `mem_level`, `orgList`, `lang`, `reg_time`, `vocInfo`, `realName`, `ttlWords`, `hourDiff` from vocabje1_admin.userInfo001 WHERE `id` = :id";		
			}			
			
			$dbh->query($sql);
			$dbh->bind(':id', $_SESSION["vjUsrId"] );
			$dbh->execute();			
			$numOfRlt =	$dbh->rowCount();//回傳query結果筆數		
			$row = $dbh->single();//resultset();//搜尋結果陣列用欄位名取出	
			
			if( $numOfRlt ){					
				setcookie("vjNickName"	, $row['nickname']	, time() + (86400 * 30)	, "/", NULL , NULL, TRUE);			
				return $row;
			}else{
				killCookies();				
				return false;
			}
			
		}elseif( isset( $_COOKIE["vjtoken"] ) && $_COOKIE["vjtoken"] != '' ){		
			$sql = "SELECT `id`, `nickname`, `mem_level`, `orgList`, `lang`, `reg_time`, `vocInfo`, `realName`, `ttlWords`, `hourDiff` from vocabje1_admin.userInfo001 WHERE `loginToken` = :loginToken";
			$dbh->query($sql);
			$dbh->bind(':loginToken', $_COOKIE["vjtoken"] );
			$dbh->execute();			
			$numOfRlt =	$dbh->rowCount();//回傳query結果筆數		
			$row = $dbh->single();//resultset();//搜尋結果陣列用欄位名取出	
			
			if( $numOfRlt ){					
				setcookie("vjNickName"	, $row['nickname']	, time() + (86400 * 30)	, "/", NULL , NULL, TRUE);			
				return $row;
			}else{
				killCookies();				
				return false;
			}					
		}else{
			killCookies();
			return false;
		}
				
}?>

<?php function killCookies(){			//清除cookie
		$cookiesName =  array("vjtoken", "vjNickName");

		for($i=0; $i < count($cookiesName); $i++){
			setcookie($cookiesName[$i], "", time()-3600, "/", NULL , TRUE, TRUE);
		}
}?>

<?php function getUsrId(){			//清除cookie
		$infoAry = getUsrInfoByTokenOrSession(1);

		if( isset($infoAry['id']) && $infoAry['id'] != ""){
			return $infoAry['id'];
		}else{
			return false;
		}
}?>









<?php function echoCWD(){				
		$cwd = getcwd();
		echo $cwd;	
}?>