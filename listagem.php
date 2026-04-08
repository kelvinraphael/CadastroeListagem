<?php
session_start();
require 'conexao.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_nome'])) {
    header("Location: index.html");
    exit;
}

// Paginação
$pagina = isset($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$limite = 5;
$offset = ($pagina - 1) * $limite;

// Busca
$buscar = $_GET['buscar'] ?? '';
$buscar_param = "%$buscar%";

// Total de registros filtrados
$sql_count = "SELECT COUNT(*) FROM funcionarios WHERE nome ILIKE :buscar OR email ILIKE :buscar";
$stmt_total = $conn->prepare($sql_count);
$stmt_total->bindValue(':buscar', $buscar_param, PDO::PARAM_STR);
$stmt_total->execute();
$total_funcionarios = $stmt_total->fetchColumn();

$total_paginas = ceil($total_funcionarios / $limite);

// Buscar funcionários
$sql = "SELECT f.id, f.nome, c.nome AS cargo, f.email, f.situacao
        FROM funcionarios f
        LEFT JOIN cargos c ON f.cargo_id = c.id
        WHERE f.nome ILIKE :buscar OR f.email ILIKE :buscar
        ORDER BY f.id
        LIMIT :limite OFFSET :offset";

$stmt = $conn->prepare($sql);
$stmt->bindValue(':buscar', $buscar_param, PDO::PARAM_STR);
$stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

$funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Listagem de Funcionários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div class="container">
    <div class="card">
        <h3>Listagem de Funcionários</h3>

        <!-- Formulário de busca -->
        <form method="GET" action="listagem.php" class="mb-3 d-flex">
            <input type="text" name="buscar" class="form-control me-2" placeholder="Buscar funcionário..." value="<?= htmlspecialchars($buscar) ?>">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
            <a href="home.php" class="btn btn-success ms-2">Cadastrar Novo Funcionário</a>
        </form>

        <!-- Tabela -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Cargo</th>
                    <th>E-mail</th>
                    <th>Situação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($funcionarios) === 0): ?>
                    <tr><td colspan="6" class="text-center">Nenhum funcionário encontrado</td></tr>
                <?php else: ?>
                    <?php foreach ($funcionarios as $func): ?>
                        <tr>
                            <td><?= $func['id'] ?></td>
                            <td><?= htmlspecialchars($func['nome']) ?></td>
                            <td><?= htmlspecialchars($func['cargo']) ?></td>
                            <td><?= htmlspecialchars($func['email']) ?></td>
                            <td>
                                <?php if ($func['situacao']): ?>
                                    <span class="badge bg-success">Ativo</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Inativo</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="home.php?id=<?= $func['id'] ?>" class="btn btn-sm btn-primary">✏️ Editar</a>
                                <a href="excluir_funcionario.php?id=<?= $func['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Deseja realmente excluir?')">🗑️ Excluir</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Paginação -->
        <nav>
            <ul class="pagination">
                <?php for ($p = 1; $p <= $total_paginas; $p++): ?>
                    <li class="page-item <?= $p == $pagina ? 'active' : '' ?>">
                        <a class="page-link" href="?pagina=<?= $p ?>&buscar=<?= urlencode($buscar) ?>"><?= $p ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>

    </div>
</div>

</body>
</html>