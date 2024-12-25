<?php

require 'src/db.php';
require_once __DIR__ . "/vendor/autoload.php";

$get= new App\Get;

                                
$authors = $get->getAuthors($pdo);
$categories = $get->getCategories($pdo);

// Обработка отправки формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO books (title, description, price, author_id, category_id) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['price'], $_POST['author_id'], $_POST['category_id']]);
    header('Location: admin.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить книгу</title>
</head>
<body>
    <form method="POST">
        <label for="title">Название книги:</label>
        <input type="text" name="title" required><br>
        
        <label for="description">Описание:</label>
        <textarea name="description"></textarea><br>
        
        <label for="price">Цена:</label>
        <input type="number" step="0.01" name="price" required><br>
        
        <label for="author_id">Автор:</label>
        <select name="author_id">
            <?php foreach ($authors as $author): ?>
                <option value="<?= $author['author_id'] ?>">
                    <?= $author['first_name'] . ' ' . $author['last_name'] ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        
        <label for="category_id">Категория:</label>
        <select name="category_id">
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
            <?php endforeach; ?>
        </select><br>
        
        <button type="submit">Добавить книгу</button>
    </form>

    <a href="admin.php">Назад</a>
</body>
</html>
