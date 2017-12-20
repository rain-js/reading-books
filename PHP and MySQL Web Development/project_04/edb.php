<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<style>
		.container, .info {
			width: 350px;
			border: 1px solid #ccc;
			margin: 50px auto 0;
			padding: 20px;
		}
		.info {
			width: 500px;
			color: red;
			text-align: center;
		}
		.container h1,.container form {
			padding: 0 10px;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>中医体质报告接口</h1>
		<form action="#" method="post">
			<p>请输入个人编号：<input type="text" name="personalNo"></p>
			<p>请输入体检号码：<input type="text" name="medicalNo"></p>
			<p><input type="submit" value="确定"></p>
		</form>
	</div>

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
		echo '<p class="info">未查询到对应的记录，请检查个人编号('.$personalNo.')是否正确！</p>';
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
		echo '<p class="info">已将个人编号：'.$row['a01001'].' 姓名：'.$row['a01002'].'的体检号更正为：'.$medicalNo;
	}

	$db->close();

?>
</body>
</html>