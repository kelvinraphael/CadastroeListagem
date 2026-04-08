<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_nome'])) {
    header("Location: index.html");
    exit;
}

$id = $_GET['id'] ?? null;
$funcionario = null;

if ($id) {
    $stmt = $conn->prepare("SELECT * FROM funcionarios WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
}

$cargos_stmt = $conn->query("SELECT id, nome FROM cargos ORDER BY nome");
$cargos = $cargos_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="card">
        <h3>Cadastro de Funcionário</h3>
        <div class="mb-3 text-end">
            <a href="listagem.php" class="btn btn-secondary">Ver Listagem</a>
        </div>

        <form method="POST" action="salvar_funcionario.php">
            <input type="hidden" name="id" value="<?= $funcionario['id'] ?? '' ?>">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Nome</label>
                    <input type="text" name="nome" class="form-control" required value="<?= htmlspecialchars($funcionario['nome'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label>Cargo</label>
                    <select name="cargo_id" class="form-control" required>
                        <option value="">Selecione</option>
                        <?php foreach ($cargos as $cargo): ?>
                            <option value="<?= $cargo['id'] ?>" <?= (isset($funcionario['cargo_id']) && $cargo['id'] == $funcionario['cargo_id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cargo['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label>E-mail</label>
                    <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($funcionario['email'] ?? '') ?>">
                </div>
                <div class="col-md-6">
                    <label>Telefone</label>
                    <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($funcionario['telefone'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label>Situação</label><br>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="situacao" id="ativo" value="true" <?= (isset($funcionario['situacao']) && $funcionario['situacao']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="ativo">Ativo</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="situacao" id="inativo" value="false" <?= (isset($funcionario['situacao']) && !$funcionario['situacao']) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="inativo">Inativo</label>
                </div>
            </div>

            <div class="mb-3">
                <label>Senha</label>
                <input type="password" name="senha" class="form-control" <?= $id ? '' : 'required' ?> placeholder="<?= $id ? 'Deixe em branco para manter a senha' : '' ?>">
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>

</body>
</html>