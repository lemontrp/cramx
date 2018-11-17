<!doctype html>
<?php	
	header("Content-Type: text/html; charst=utf-8");
	session_start();
	require_once("vocabPHPfn.php");

	$uId = getUsrId();	
	
	if( !$uId ){
		header("Location: index.php");
	}else{
		require_once("ref/vocabConn.php");//PDO connect
		require_once("ref/pdoDBclass.php");//PDO連線用

		$dbh	= 	new Database();
		$id			=	intval($uId);
		$reloadTime = 	time();//date('Y-m-d H:i:s');
		$ipAddr		=	get_client_ip();
		$sql 		= 	"UPDATE vocabje1_admin.userInfo001 SET `reloadTime` = :reloadTime, `ipAddr` = :ipAddr WHERE `id` = :id";
		$dbh->query($sql);//*****紀錄會員登入IP、時間******
		$dbh->bind(':reloadTime'	,	$reloadTime);
		$dbh->bind(':ipAddr'		,	$ipAddr);
		$dbh->bind(':id'			, 	$id, PDO::PARAM_INT);
		$dbh->execute();
	}
?>
<html lang="zh-Hant">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php //<!--控制瀏覽器cache期限-->?>
<meta HTTP-EQUIV="EXPIRES" CONTENT="Thu, 1 Jan 2018 01:01:01 GMT">
<title>VocabX™</title>
<link rel="icon" href="img/VJ.png" type="image/x-icon">	

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<script rel="subresource"  src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script rel="subresource"  src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>

<script rel="subresource"  src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<script rel="subresource"  src="vocabJSfn.js?<?php echo time();?>"></script>


<script>

/*$(document).ready(function(){	});*/
/*document.ready().then(function(){ });*/


</script>

<style>
@media only screen and (max-width: 768px) {
	/* For mobile phones: */
	[class*="col-"] {
    	width: 100%;
	}
	.btn {width:100%; height: 75px;}
	.btnC1{color: #FFF;}
	.btnBg1{background: #007bff;}
	.btnBg2{background: #dc3545;}

	.btnPadTop{margin-top: 10px;}

	.mbHidden{display: none;}
	.mbHeightFull{height: 100vh;}
}
</style>



</head>
<body>

<div class="container-fluid mbHeightFull" style="background:#000; color:#FFF;">
	<!--
	<div class="row" style="display: flex; justify-content: center; align-items: center;"></div>

	-->
	<nav class="navbar navbar-expand-lg navbar-light bg-light">			
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<a class="navbar-brand" href="#">VocabX</a>
		
		<div class="collapse navbar-collapse" id="navbarToggler">
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
		    	<li class="nav-item active">
		        	<a class="btn btnC1 btnBg1" href="#tgt0" role="button" aria-expanded="false" aria-controls="tgt0">Button1 <span class="sr-only">(current)</span></a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="btn btnC1 btnBg1 btnPadTop" href="#tgt1">Button2</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="btn btnC1 btnBg1 btnPadTop" href="#tgt2">Button3</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="btn btnC1 btnBg1 btnPadTop" onclick="test();">TEST</a>
		      	</li>
		      	<li class="nav-item">
		        	<a class="btn btnC1 btnBg2 btnPadTop" onclick="logout();">logout</a>
		      	</li>
		    </ul>				
		</div>


		<div class="collapse" id="tgt0" style="height:30vh; background: #112233; color:#FFF; border: solid 1px red;">
			<h1>Cool-tgt0</h1>
		</div>

		<div class="collapse" id="tgt1" style="color:#FFF; border: solid 1px red;">
			<h1>Cool-tgt1</h1>
		</div>

		<div class="collapse" id="tgt2" style="color:#FFF; border: solid 1px red;">
			<h1>Cool-tgt2</h1>
		</div>


	</nav>

	


</div>
<div class="container-fluid mbHidden" style="background:#f2f2f2; height:80vh; color:red">
	
	<div class="container">
		<div class="row">
			<h1>User Center</h1>	
		</div>
	</div>
</div>
<div class="container-fluid mbHidden" style="background:#000; height:10vh; color:#FFF">
	
	<div class="container">
		<div class="row">
			<h1>Footer</h1>	
		</div>
	</div>
</div>


</body>
</html>

