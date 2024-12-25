<?php
require 'src/db.php';
$stmt = $pdo->prepare('DELETE FROM books WHERE book_id = ?');
$stmt->execute([$_GET['id']]);
header('Location: admin.php');
?>