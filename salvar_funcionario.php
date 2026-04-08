<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_nome'])) {
    header("Location: index.html");
    exit;
}

$id = $_POST['id'] ?? null;
$nome = $_POST['nome'];
$cargo_id = $_POST['cargo_id'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$situacao = $_POST['situacao'] === 'true';
$senha = $_POST['senha'] ?? null;

if ($id) {
    // Atualizar
    if ($senha) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "UPDATE funcionarios SET nome=:nome, cargo_id=:cargo_id, email=:email, telefone=:telefone, situacao=:situacao, senha=:senha WHERE id=:id";
    } else {
        $sql = "UPDATE funcionarios SET nome=:nome, cargo_id=:cargo_id, email=:email, telefone=:telefone, situacao=:situacao WHERE id=:id";
    }
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cargo_id', $cargo_id);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':situacao', $situacao, PDO::PARAM_BOOL);
    if ($senha) $stmt->bindParam(':senha', $senha_hash);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
} else {
    // Inserir
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
    $sql = "INSERT INTO funcionarios (nome, cargo_id, email, telefone, situacao, senha) VALUES (:nome, :cargo_id, :email, :telefone, :situacao, :senha)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cargo_id', $cargo_id);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':telefone', $telefone);
    $stmt->bindParam(':situacao', $situacao, PDO::PARAM_BOOL);
    $stmt->bindParam(':senha', $senha_hash);
    $stmt->execute();
}

header("Location: home.php");
exit;
?>