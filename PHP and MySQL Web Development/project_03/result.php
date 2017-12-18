<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>查询结果</h1>

<?php
	$personalNo = trim($_POST['personalNo']);

	if (!get_magic_quotes_gpc()) {
		$personalNo = addslashes($personalNo);
	}

	if (!$personalNo) {
		echo '未输入个人编号！';
		exit;
	}

	@ $db = new mysqli('localhost', 'test', '888888', 'edb');

	if (mysqli_connect_errno()) {
		echo '无法连接数据库！请联系管理员！';
		exit;
	}

	$query = "select * from ea01 where a01001 = '".$personalNo."'";

	$result = $db->query($query);

	if (!$result) {
		echo '未查询到相关信息！';
		exit;
	}

	$num_results = $result->num_rows;

	// echo '$num_results = '.$num_results.'<br/>';

	for ($i = 0; $i < $num_results; $i++) {
		$row = $result->fetch_assoc();

		echo '<table>';
		echo '<tr><td>姓名 '.$row['a01002'].'</td>'.'<td>编号 '.$row['a01001'].'</td>'.'</tr>';
		echo '<tr><td>性别 '.$row['a01003'].'</td>'.'<td>日期 '.$row['a01005'].'</td>'.'</tr>';
		echo '</table>';
		// var_dump($row);
	}

	$db->close();

?>
</body>
</html>