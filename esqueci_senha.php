<?php
require 'conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Verifica se o e-mail existe
    $sql = "SELECT * FROM funcionarios WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Gera token temporário (em produção enviar por e-mail)
        $token = bin2hex(random_bytes(16));

        // Salva token no banco (aqui vamos criar coluna "reset_token")
        $sql2 = "ALTER TABLE funcionarios ADD COLUMN IF NOT EXISTS reset_token VARCHAR(255)";
        $conn->exec($sql2);

        $sql3 = "UPDATE funcionarios SET reset_token = :token WHERE email = :email";
        $stmt2 = $conn->prepare($sql3);
        $stmt2->bindParam(':token', $token);
        $stmt2->bindParam(':email', $email);
        $stmt2->execute();

        echo "<p>Token de redefinição gerado: <strong>$token</strong></p>";
        echo "<p>Acesse <a href='nova_senha.php?token=$token'>aqui</a> para definir nova senha.</p>";

    } else {
        echo "<p>E-mail não encontrado.</p>";
    }
} else {
?>
<form action="esqueci_senha.php" method="POST">
    <label>Digite seu e-mail:</label>
    <input type="email" name="email" required>
    <button type="submit">Enviar</button>
</form>
<?php
}
?>