<?php
require 'src/db.php';
require_once __DIR__ . "/vendor/autoload.php";

$get= new App\Get;

                                
$authors = $get->getAuthors($pdo);
$categories = $get->getCategories($pdo);

// Получение параметров фильтрации
$search_title = $_GET['title'] ?? '';
$search_author = $_GET['author_id'] ?? '';
$search_category = $_GET['category_id'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';



// Формирование SQL-запроса с фильтрацией
$sql = 'SELECT * FROM books WHERE 1=1';
$params = [];

if ($search_title) {
    $sql .= ' AND title LIKE ?';
    $params[] = '%' . $search_title . '%';
}

if ($search_author) {
    $sql .= ' AND author_id = ?';
    $params[] = $search_author;
}

if ($search_category) {
    $sql .= ' AND category_id = ?';
    $params[] = $search_category;
}

if ($min_price) {
    $sql .= ' AND price >= ?';
    $params[] = $min_price;
}

if ($max_price) {
    $sql .= ' AND price <= ?';
    $params[] = $max_price;
}

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$books = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог книг</title>
</head>
<body>
    <h1>Каталог книг</h1>
    
    <!-- Форма фильтрации -->
    <form method="GET">
        <label for="title">Название:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($search_title) ?>"><br>

        <label for="author_id">Автор:</label>
        <select name="author_id">
            <option value="">-- Все авторы --</option>
            <?php foreach ($authors as $author) {?>
                    <option value="<?$book['author_id']?>"><?echo  $author['first_name']." ".$author['last_name'];?></option>
                <?} ?>
        </select><br>

        <label for="category_id">Категория:</label>
        <select name="category_id">
            <option value="">-- Все категории --</option>
            <?php foreach ($categories as $category) {?>
                    <option value="<?$book['category_id']?>"><?echo  $category['name']?></option>
                <?} ?>
        </select><br>

        <label for="min_price">Цена от:</label>
        <input type="number" name="min_price" step="0.01" value="<?= htmlspecialchars($min_price) ?>"><br>

        <label for="max_price">Цена до:</label>
        <input type="number" name="max_price" step="0.01" value="<?= htmlspecialchars($max_price) ?>"><br>

        <button type="submit">Фильтровать</button>
    </form>
    
    <!-- Список книг -->
    <ul>
        <?php foreach ($books as $book): ?>
            <li>
                <a href="book_details.php?id=<?= $book['book_id'] ?>">
                    <?= htmlspecialchars($book['title']) ?>
                </a>
                - <?= htmlspecialchars(mb_strimwidth($book['description'], 0, 50, '...')) ?>
                ,
                <?php foreach ($authors as $author) {
                    if ($author['author_id']==$book['author_id']) {
                        echo  $author['first_name']." ".$author['last_name'];
                    }
                }  
                ?>
                ,
                <?php foreach ($categories as $category) {
                    if ($category['category_id']==$book['category_id']) {
                        echo  $category['name'] ?? 'Неизвестный автор';
                    }
                } 
                ?>
                , <?= $book['price'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="admin.php">Админ</a>
</body>
</html>
