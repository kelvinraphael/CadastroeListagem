<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_nome'])) {
    header("Location: index.html");
    exit;
}

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $conn->prepare("DELETE FROM funcionarios WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

header("Location: listagem.php");
exit;
?>