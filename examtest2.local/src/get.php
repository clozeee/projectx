<?php
namespace App;
require 'src/db.php';

use PDO;

class Get {

    function getAuthors($pdo) {
        $sql = "SELECT * FROM authors";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function getCategories($pdo) {
        $sql = "SELECT * FROM categories";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>