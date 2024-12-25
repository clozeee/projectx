<?php

require 'src/db.php';
require_once __DIR__ . "/vendor/autoload.php";

$get= new App\Get;

$authors = $get->getAuthors($pdo);
$categories = $get->getCategories($pdo);

$book = $pdo->prepare('SELECT * FROM books WHERE book_id = ?');
$book->execute([$_GET['id']]);
$book = $book->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE books SET title = ?, description = ?, price = ?, author_id = ?, category_id = ? WHERE book_id = ?');
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['price'], $_POST['author_id'], $_POST['category_id'], $_GET['id']]);
    header('Location: admin.php');
}
?>

<form method="POST">
    <input type="text" name="title" value="<?= $book['title'] ?>" required>
    <textarea name="description"><?= $book['description'] ?></textarea>
    <input type="number" step="0.01" name="price" value="<?= $book['price'] ?>" required>
    <label for="author_id">Автор:</label>
    <select name="author_id">
        <?php foreach ($authors as $author): ?>
            <option value="<?= $author['author_id'] ?>"><?= $author['first_name'] . ' ' . $author['last_name'] ?></option>
        <?php endforeach; ?>
    </select><br>
    
    <label for="category_id">Категория:</label>
    <select name="category_id">
        <?php foreach ($categories as $category): ?>
            <option value="<?= $category['category_id'] ?>"><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select><br>
    <button type="submit">Сохранить</button>
</form>

<a href="izzz.php">Админ</a>