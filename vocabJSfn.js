

function callPhpFn(fnName, fnPar, fnIfSuccess) {//執行指定的Ajax Fn

	var myUrl = 'vocabPHPfn.php';	
	//alert(fnName + ' & ' + myUrl);	
	$.ajax({
		type	:	"POST",
		url		:	myUrl,
		async 	:	true,
		data 	:	{
			fnName	: 	fnName,
			fnPar 	: 	fnPar
		},
		error: function(jqXHR, textStatus, errorThrown) {
			if(textStatus == 'timeout'){
				alert('作業逾時，請按F5更新頁面: ' + textStatus);
			}
			console.log(jqXHR);
		},		
		success : function (data) {
			fnIfSuccess(data);
		}
	});
}

function login() {
	//alert('login click');
	var vloginAry = [];
	var fnIfSuccess = function (data) {
		//alert(data);
		if(data.trim() != "fail"){
			window.location.href = "userCenter.php";
		}else{
			alert("Incorrect username/password combination.");
		}					
	}

	for (i=0; i<2; i++){
		vloginAry[i] = $('#frLgin' + i).val();
	}
	
	if ($('#inlineFormCheck').is(":checked")) {
		vloginAry[2] = '1';//保持登入
	} else {
		vloginAry[2] = '0';//臨時登入
	}
	if (vloginAry[0] != '' && vloginAry[1] != '') {
		//alert(vloginAry[0]+"\n"+vloginAry[1]+"\n"+vloginAry[2]);
		callPhpFn('login', vloginAry, fnIfSuccess);		
	} else {
		alert('請輸入電子郵件及密碼。');
	}
}

function logout(){
	//localStorage.clear();//清除localStorage		
	var fnIfSuccess = function (data) {
		//alert(data);
		window.location.href = "index.php";
	}
	callPhpFn('logout', '', fnIfSuccess);
}






function test(){
	/*var fnIfSuccess = function (data) {
		alert(data);		
	}
	callPhpFn('echoCWD', '', fnIfSuccess);*/
}