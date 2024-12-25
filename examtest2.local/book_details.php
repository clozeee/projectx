<?php
require 'src/db.php';
require_once __DIR__ . "/vendor/autoload.php";

$get= new App\Get;

                                
$authors = $get->getAuthors($pdo);
$categories = $get->getCategories($pdo);

// Проверка параметра id
if (!isset($_GET['id'])) {
    die('Книга не найдена.');
}

$book_id = $_GET['id'];

// Получение данных о книге
$stmt = $pdo->prepare('SELECT * FROM books WHERE book_id = ?');
$stmt->execute([$book_id]);
$book = $stmt->fetch();

if (!$book) {
    die('Книга не найдена.');
}
?>





<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($book['title']) ?></title>
</head>
<body>
    <h1><?= htmlspecialchars($book['title']) ?></h1>
    <p><strong>Описание:</strong> <?= htmlspecialchars($book['description']) ?></p>
    <p><strong>Цена:</strong> <?= htmlspecialchars($book['price']) ?> руб.</p>
    <p><strong>Автор:</strong> <?php
    foreach ($authors as $author) {
        if ($author['author_id']==$book['author_id']) {
            echo  $author['first_name']." ".$author['last_name'];
        }
    } ?></p>
    <p><strong>Категория:</strong> <?php
    foreach ($categories as $category) {
        if ($category['category_id']==$book['category_id']) {
            echo  $category['name'] ?? 'Неизвестный автор';
        }
    } ?></p>
    <a href="index.php">Вернуться к списку книг</a>
</body>
</html>
