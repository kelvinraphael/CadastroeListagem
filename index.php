<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh;">

<div class="card shadow" style="width: 350px;">
    <div class="card-header bg-primary text-white text-center">
        <h5>Login</h5>
    </div>
    <div class="card-body">
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>

        <!-- Link esqueci senha -->
        <div class="text-center mt-3">
            <a href="esqueci_senha.php" class="text-decoration-none">Esqueci minha senha</a>
        </div>
    </div>
</div>

</body>
</html>