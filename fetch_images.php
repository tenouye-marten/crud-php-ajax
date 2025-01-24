<?php
include 'db.php';

$stmt = $db->query("SELECT * FROM images ORDER BY id DESC");
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($images);
?>
