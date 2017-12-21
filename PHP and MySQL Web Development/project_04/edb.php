<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="./bootstrap-3.3.7-dist/css/bootstrap.css">
	<style>
		.info {
			width: 460px;
			border: 1px solid #ccc;
			border-radius: 4px;
			margin: 50px auto 0;
			padding: 10px;
			color: red;
			text-align: center;
		}
		u {
			color: blue;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<h1>中医体质报告接口</h1>
				<form action="#" method="post">
					<div class="form-group">
						<label for="personalNo">个人编号</label>
						<input type="text" class="form-control" name="personalNo" id="personalNo" placeholder="请输入个人编号">
					</div>
					<div class="form-group">
						<label for="medicalNo">体检号码</label>
						<input type="text" class="form-control" name="medicalNo" id="medicalNo" placeholder="请输入体检号码">
					</div>
					<button type="submit" class="btn btn-primary" id="submitBtn">确定</button>
				</form>
			</div>
		</div>
	</div>

<script>
	var log = console.log.bind(console);

	var submitBtn = document.getElementById('submitBtn');

	submitBtn.onclick = function() {
		var personalNo = document.getElementById('personalNo').value,
			medicalNo = document.getElementById('medicalNo').value;

		// log(personalNo);
		// log(medicalNo);

		if (!personalNo.trim()) {
			alert('请输入个人编号！');
			return false;
		}

		if (!medicalNo.trim()) {
			alert('请输入体检号码！');
			return false;
		}
		return true;
	}

</script>

<?php
	
	if (!isset($_POST['personalNo']) && !isset($_POST['medicalNo'])) {
		// echo '<p class="info">个人编号未输入!</p>';
		return;
	}

	$personalNo = trim($_POST['personalNo']);
	$medicalNo = trim($_POST['medicalNo']);

	if (!get_magic_quotes_gpc()) {
		$personalNo = addslashes($personalNo);
		$medicalNo = addslashes($medicalNo);
	}

	@ $db = new mysqli('localhost', 'test', '888888', 'edb');

	if (mysqli_connect_errno()) {
		echo '<p class="info">无法连接数据库！请联系管理员！</p>';
		exit;
	}

	$query = "select * from ea01 where a01001 = '".$personalNo."'";
	$personalInfo = $db->query($query);
	$num_results = $personalInfo->num_rows;

	$row = $personalInfo->fetch_assoc();

	if (!$num_results) {
		echo '<p class="info">未查询到对应的记录，请检查个人编号<u>'.$personalNo.'</u>是否正确！</p>';
		exit;
	}
	// var_dump($result);

	// a01027 预留字段，存体检号码
	$query = "update ea01 set a01027 = '".$medicalNo."' where a01001 = '".$personalNo."'"; 
	$result = $db->query($query);

	// var_dump($result);

	// echo '$db->affected_rows = '.$db->affected_rows;

	if ($db->affected_rows == 0) {
		echo '<p class="info">数据更新失败，请稍后再试！</p>';
		exit;
	} else {
		echo '<p class="info">已将个人编号<u>'.$row['a01001'].'</u> 姓名<u>'.$row['a01002'].'</u>的体检号更正为<u>'.$medicalNo.'</u>！';
	}

	$db->close();

?>
</body>
</html>