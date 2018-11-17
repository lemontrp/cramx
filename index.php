<!doctype html>
<?php 
	header("Content-Type: text/html; charst=utf-8");
	session_start();
	require_once("vocabPHPfn.php");

	$uId = getUsrId();

	if( isset($uId) && $uId != "" ){
		header("Location: userCenter.php");
	}

?>


<html lang="zh-Hant">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<meta HTTP-EQUIV="EXPIRES" CONTENT="Thu, 1 Jan 2018 01:01:01 GMT">
<title>VocabX™</title>

<link rel="icon" href="" type="image/x-icon">

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<!--<link rel="stylesheet" href="ref/reset.css">-->


<style>
@media only screen and (max-width: 768px) {
	/* For mobile phones: */
	[class*="col-"] {
    	width: 100%;
	}
	.chkBxSize{width:25px; height:25px;}

	.btn {width:100%; height: 75px;}
	.mbHidden{display: none;}
	.mbHeightFull{height: 100vh;}

	input[type="email"] {
		height:3em;
		padding:2px;
		font-size: 1em; 
	}
	input[type="password"] {
		height:3em;
		padding:2px;
		font-size: 1em; 
	}
}

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<!--<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>-->
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>

<script src="vocabJSfn.js?<?php echo time();?>"></script>

</head>

<body>



	
<div class="container-fluid mbHeightFull" style="background:#000; color:#FFF" >
	
	<div class="container">
		<div class="row" style="display: flex; justify-content: center; align-items: center;">
			<div class="col-lg" style="">
				<h1>VocabX</h1>
			</div>
			
			<div class="col-lg-10" style="">
				<form class="form-inline">
					<label class="sr-only" for="frLgin0">username</label>
				  	<input type="email" class="form-control mb-2 mr-sm-2" id="frLgin0" name = "username" placeholder="username" autocomplete="on" autocorrect="off">

				  	<label class="sr-only" for="frLgin1">password</label>
				  	<div class="input-group mb-2 mr-sm-2">				    	
				    	<input type="password" class="form-control" id="frLgin1" name = "password" placeholder="password" autocorrect="off">
				  	</div>

				  	<div class="form-check mb-2 mr-sm-2">
				    	<input class="form-check-input chkBxSize" type="checkbox" id="inlineFormCheck">
				    	<label class="form-check-label" for="inlineFormCheck">
				      		Remember me
				    	</label>
				  	</div>				  	
					<button type="button" class="btn btn-primary mb-2" onclick="login();">Login</button>
				</form>
			</div>
		</div>
	</div>
	




</div>
<div class="container-fluid mbHidden" style="background:blue; height:auto; color:red"><!--background:#f2f2f2;-->
	
	<div class="container">
		<div class="row">
			<h1>Index</h1>	
		</div>
	</div>
</div>
<div class="container-fluid mbHidden" style="background:#000; height:10vh; color:#FFF; display:none;">
	
	<div class="container">
		<div class="row">
			<h1>Footer</h1>	
		</div>
	</div>
</div>






	
	
	
		


</body>
</html>