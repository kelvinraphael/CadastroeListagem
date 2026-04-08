<?php
session_start();
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM funcionarios WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_nome'] = $user['nome'];
        $_SESSION['usuario_id'] = $user['id'];
        header("Location: listagem.php");
        exit;
    } else {
        echo "<script>alert('E-mail ou senha inválidos'); window.location='index.html';</script>";
    }
}
?>