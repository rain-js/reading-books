<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<h1>Book-O-Rama Book Entry Results</h1>

<?php
	$isbn = trim($_POST['isbn']);
	$author = trim($_POST['author']);
	$title = trim($_POST['title']);
	$price = trim($_POST['price']);

	if (!$isbn || !$author || !$title || !$price) {
		echo '请输入图书的详细信息';
		exit;
	}

	if (!get_magic_quotes_gpc()) {
		$isbn = addslashes($isbn);
		$author = addslashes($author);
		$title = addslashes($title);
		$price = addslashes($price);
	}

	@ $db = new mysqli('localhost', 'root', '', 'books');

	if (mysqli_connect_errno()) {
		echo '无法连接数据库，请重试！';
		exit;
	}

	$query = "insert into books(isbn,author,title,price) values('".$isbn."','".$author."','".$title."',".$price.")";

	$result = $db->query($query);

	if ($result) {
		echo '成功添加'.$db->affected_rows.'本图书！';		
	} else {
		echo '插入数据库失败！';
	}

	$db->close();
?>
</body>
</html>