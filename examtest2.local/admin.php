<?php
require 'src/db.php';
require_once __DIR__ . "/vendor/autoload.php";

$get= new App\Get;

$authors = $get->getAuthors($pdo);
$categories = $get->getCategories($pdo);


$books = $pdo->query('SELECT * FROM books')->fetchAll();

?>
<a href="create_book.php">Добавить книгу</a>

<table>
    <tr>
        <th>Название</th>
        <th>Описание</th>
        <th>Цена</th>
        <th>Автор</th>
        <th>Категория</th>
        <th>Действия</th>
    </tr>
    <?php foreach ($books as $book): ?>
    <tr>
        <td><?= $book['title'] ?></td>
        <td><?= $book['description'] ?></td>
        <td><?= $book['price'] ?></td>
        <td>
            <?php foreach ($authors as $author) {
                        if ($author['author_id']==$book['author_id']) {
                            echo  $author['first_name']." ".$author['last_name'];
                        }
                    }  
            ?>
        </td>
        <td>
            <?php foreach ($categories as $category) {
                        if ($category['category_id']==$book['category_id']) {
                            echo  $category['name'] ?? 'Неизвестный автор';
                        }
                    } 
            ?>
        </td>
        <td>
            <a href="edit_book.php?id=<?= $book['book_id'] ?>">Редактировать</a>
            <a href="delete_book.php?id=<?= $book['book_id'] ?>">Удалить</a>
        </td>
    </tr>
    <?php endforeach; ?>

    <a href="index.php">Главная страница</a>
    
</table>