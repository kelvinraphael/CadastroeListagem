<?php
session_start();
require 'conexao.php';

if (!isset($_SESSION['usuario_nome'])) {
    header("Location: index.html");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: home.php");
    exit;
}

$id = (int)$_GET['id'];

// Buscar dados do funcionário
$stmt = $conn->prepare("SELECT * FROM funcionarios WHERE id = :id");
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    echo "Funcionário não encontrado.";
    exit;
}

// Buscar cargos para o select
$cargos_stmt = $conn->query("SELECT id, nome FROM cargos ORDER BY nome");
$cargos = $cargos_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h3>Editar Funcionário</h3>

    <form method="POST" action="salvar_funcionario.php">
        <input type="hidden" name="id" value="<?= $funcionario['id'] ?>">

        <div class="row mb-3">
            <div class="col">
                <label>Nome</label>
                <input type="text" name="nome" class="form-control" required value="<?= htmlspecialchars($funcionario['nome']) ?>">
            </div>
            <div class="col">
                <label>Cargo</label>
                <select name="cargo_id" class="form-control" required>
                    <option value="">Selecione</option>
                    <?php foreach ($cargos as $cargo): ?>
                        <option value="<?= $cargo['id'] ?>" <?= $cargo['id'] == $funcionario['cargo_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cargo['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>E-mail</label>
                <input type="email" name="email" class="form-control" required value="<?= htmlspecialchars($funcionario['email']) ?>">
            </div>
            <div class="col">
                <label>Telefone</label>
                <input type="text" name="telefone" class="form-control" value="<?= htmlspecialchars($funcionario['telefone']) ?>">
            </div>
        </div>

        <div class="mb-3">
            <label>Situação</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="situacao" id="ativo" value="true" <?= $funcionario['situacao'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="ativo">Ativo</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="situacao" id="inativo" value="false" <?= !$funcionario['situacao'] ? 'checked' : '' ?>>
                <label class="form-check-label" for="inativo">Inativo</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="home.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>