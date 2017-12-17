<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <h1>Book-O-Rama Search Results</h1>

<?php
    $searchType = $_POST['searchType'];
    $searchTerm = trim($_POST['searchTerm']);

    // echo '$searchType: '.$searchType.'<br/>';
    // echo '$searchTerm: '.$searchTerm.'<br/>';

    if (!$searchType || !$searchTerm) {
        echo 'You have not entered search details. Please go back and try again.';
        exit;
    }

    if (!get_magic_quotes_gpc()) {
        $searchType = addslashes($searchType);
        $searchTerm = addslashes($searchTerm);
    }

    $db = new mysqli('localhost', 'root', '', 'books');

    if (mysqli_connect_errno()) {
        echo 'Error: Could not connect to database. Please try again later.';
        exit;
    }

    $query = "select * from books where ".$searchType." like '%".$searchTerm."%'";
    $result = $db->query($query);

    $num_results = $result->num_rows;

    echo '<p>Number of books found: '.$num_results.'</p>';

    for ($i = 0; $i < $num_results; $i++) { 
        $row = $result->fetch_assoc();
        // var_dump($row);

        echo '<p><strong>'.($i+1).'. isbn: </strong>'.$row['isbn'].'</p>';
        echo '<p><strong>author: </strong>'.$row['author'].'</p>';
        echo '<p><strong>title: </strong>'.$row['title'].'</p>';
        echo '<p><strong>price: </strong>'.$row['price'].'</p><br />';
    }

    $result->free();
    $db->close();
?>
</body>
</html>