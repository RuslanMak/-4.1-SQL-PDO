<?php

$servername = 'localhost';
$username = 'root';
$password = 'mysql';
$db = 'netology_sql';

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $pdo -> exec("SET CHARACTER SET utf8");
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo 'Connected successfully';
} catch(PDOException $e)
{
    echo 'Connection failed: ' . $e->getMessage();
}

$where = '';
if (!empty($_POST['isbn']) || !empty($_POST['name']) || !empty($_POST['author'])) {
    print_r($_POST);
    $where = 'WHERE ';
    if (!empty($_POST['isbn'])) {
        $where = $where . "isbn LIKE '%".$_POST['isbn']."%' AND ";
    }
    if (!empty($_POST['name'])) {
        $where = $where .  "name LIKE '%".$_POST['name']."%' AND ";
    }
    if (!empty($_POST['author'])) {
        $where = $where .  "author LIKE '%".$_POST['author']."%' AND ";
    }

    $where = substr($where, 0, -4);
}

//$sth = $pdo->prepare("SELECT * FROM books");
$sth = $pdo->prepare("SELECT * FROM `books` $where");
$sth->execute();
/* Извлечение всех оставшихся строк результирующего набора */
//print("Извлечение всех оставшихся строк результирующего набора:\n");
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
//print_r($result);

?>

<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Books</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;
        }
    </style>
</head>
<body>

<table style="width:100%">
    <caption>Books</caption>
    <tr>
        <th>ID</th>
        <th>NAME</th>
        <th>AUTHOR</th>
        <th>YEAR</th>
        <th>ISBN</th>
        <th>GENRE</th>
    </tr>
    <?php foreach ($result as $row) : ?>
        <tr>
            <td><?php echo $row['id'] ?></td>
            <td><?php echo $row['name'] ?></td>
            <td><?php echo $row['author'] ?></td>
            <td><?php echo $row['year'] ?></td>
            <td><?php echo $row['isbn'] ?></td>
            <td><?php echo $row['genre'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Фильтр</h2>
<form action="" method="post">
    <input id="isbn" type="text" name="isbn" placeholder="ISBN">
    <input type="text" name="name" placeholder="Name">
    <input type="text" name="author" placeholder="Author">
    <input type="submit" name="submit" value="Фильтр">
</form>

<script>
    const InputIsbn = document.querySelector('#isbn');

    InputIsbn.addEventListener(onkeyup, e =>
        e.preventDefault();

    )
</script>

</body>
</html>


