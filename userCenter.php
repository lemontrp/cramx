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

		$usrInfoAry = getUsrInfoByTokenOrSession(0);
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

$(document).ready(function(){	
	calVbodyH();
});
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
	
	<div class="row" style="display: flex; justify-content: center; align-items: center;">		
		<span class="navbar-brand h1">VocabX</span>
		<button type="button" class="btn btn-dark">Button1</button>
		<button type="button" class="btn btn-dark" data-toggle="collapse" data-target="#myvoc">我的單字</button>
		<button type="button" class="btn btn-dark">Button3</button>
		<button type="button" class="btn btn-dark" onclick="test();">TEST</button>
		<button type="button" class="btn btn-danger" onclick="logout();">logout</button>
		<span><?php 
			if( !$uId ){
				echo $usrInfoAry["nickname"].", uId: ".$uId;
			}
		?></span> 	
	</div>	
</div>
<div id="vbody" class="container-fluid mbHidden" style="background:#f2f2f2; color:red">
	
	<div class="container">
		<div class="row">
			<h1>User Center</h1>

			<div id="myvoc" class="collapse">
				<table class="table table-hover table-dark">
					<thead>
						<tr>
						  <th scope="col">#</th>
						  <th scope="col">First</th>
						  <th scope="col">Last</th>
						  <th scope="col">Handle</th>
						</tr>
					</thead>
					<tbody>
						<tr>
						  <th scope="row">1</th>
						  <td>Mark</td>
						  <td>Otto</td>
						  <td>@mdo</td>
						</tr>
						<tr>
						  <th scope="row">2</th>
						  <td>Jacob</td>
						  <td>Thornton</td>
						  <td>@fat</td>
						</tr>
						<tr>
						  <th scope="row">3</th>
						  <td colspan="2">Larry the Bird</td>
						  <td>@twitter</td>
						</tr>
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
<div class="container-fluid mbHidden" style="height:70px; background:#000; color:#FFF">
	
	<div class="container">
		<div class="row">
			Copyright©2018 VocabX™ All rights reserved.	
		</div>
	</div>
</div>


</body>
</html>