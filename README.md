# Code Explanation for Book Addition Form in PHP

This PHP script is designed to facilitate the addition of new books into a database through a web form. Below, we will break down the key components and functions of the code to better understand its functionality.

## Required Files and Initialization

```php
require 'src/db.php';
require_once __DIR__ . "/vendor/autoload.php";

$get = new App\Get;
```

The script begins by including necessary files. The `db.php` file likely contains the database connection setup, while `vendor/autoload.php` is used for loading dependencies managed by Composer. An instance of the `App\Get` class is created, which presumably contains methods for retrieving authors and categories from the database.

## Fetching Authors and Categories

```php
$authors = $get->getAuthors($pdo);
$categories = $get->getCategories($pdo);
```

Here, the script fetches a list of authors and categories from the database using methods from the `Get` class. The `$pdo` variable represents the PDO database connection object, allowing for secure interaction with the database. The retrieved authors and categories are stored in the `$authors` and `$categories` arrays, respectively.

## Handling Form Submission

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('INSERT INTO books (title, description, price, author_id, category_id) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute([$_POST['title'], $_POST['description'], $_POST['price'], $_POST['author_id'], $_POST['category_id']]);
    header('Location: admin.php');
    exit;
}
```

This section checks if the form has been submitted via a POST request. If so, it prepares an SQL statement to insert a new book into the `books` table. The values for title, description, price, author ID, and category ID are taken from the submitted form data (`$_POST`). After executing the statement to insert the new book record, the script redirects the user to `admin.php`, effectively ending the current script execution with `exit`.

## HTML Form Structure

```html
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
```

The HTML portion of the code constructs a form that allows users to input details about a new book. Key elements include:

- **Title Input**: A required text field for entering the book's title.
- **Description Textarea**: An optional field for providing a description of the book.
- **Price Input**: A required numeric input for specifying the book's price.
- **Author Selection**: A dropdown menu populated with authors fetched from the database.
- **Category Selection**: Another dropdown menu populated with categories.

Finally, there is a submit button labeled "Добавить книгу" (Add Book) and a link to return to the admin page.

## Conclusion

This PHP script effectively combines backend logic with frontend form handling to allow administrators to add new books to a database. By utilizing prepared statements for database interactions, it ensures security against SQL injection attacks while providing a user-friendly interface for data entry. This structure can serve as a solid foundation for further enhancements in a library or bookstore management system.
