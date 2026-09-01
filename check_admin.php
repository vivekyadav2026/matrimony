<?php
require_once __DIR__ . '/config.php';
$stmt = $pdo->query("DESCRIBE admin_users");
print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
