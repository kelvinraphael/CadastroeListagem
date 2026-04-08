<?php
require 'conexao.php';

if (!isset($_GET['token'])) {
    die("Token inválido.");
}

$token = $_GET['token'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nova_senha = $_POST['senha'];
    $hash = password_hash($nova_senha, PASSWORD_DEFAULT);

    $sql = "UPDATE funcionarios SET senha = :senha, reset_token = NULL WHERE reset_token = :token";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':senha', $hash);
    $stmt->bindParam(':token', $token);
    $stmt->execute();

    echo "<p>Senha redefinida com sucesso! <a href='index.html'>Login</a></p>";
} else {
?>
<form action="nova_senha.php?token=<?php echo $token; ?>" method="POST">
    <label>Nova senha:</label>
    <input type="password" name="senha" required>
    <button type="submit">Redefinir senha</button>
</form>
<?php
}
?>