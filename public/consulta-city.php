<?php
session_start();
require '../vendor/autoload.php';
use app\functions\database\Connect;

$pdo = Connect::conect(); // Conexão através da classe Connect

$sql = "SELECT * FROM tb_cidades";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$cidades = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Lista de Cidades</title>
    <link rel="stylesheet" href="./assets/css/crudstyle.css">
    <link rel="shortcut icon" href="./assets/icon/logoamazonia.ico" type="image/x-icon">
    <!-- jQuery -->
    <script src="./assets/js/jquery-3.6.0.min.js"></script>
</head>

<body>

<header>
    <div class="menubar"></div>
    <img src="./assets/image/bandaglogo.png" alt="" class="circleyellow">
</header>

<!-- Barra de Pesquisa -->
<div class="search-container">
    <input type="text" id="search" placeholder="Pesquisar cidades..." class="search-bar" />
    <div class="no-results">Nenhum resultado encontrado.</div> <!-- Mensagem de nenhum resultado -->
</div>

<!-- Botões de navegação -->
<button class="containerconsultavoltar">
    <a href="./pages/inicio.php"><img src="./assets/icon/seta-pequena-esquerda.png" class="mais-buttom"></a>
</button>

<button class="containerconsultavoltar2">
    <a href="cadastro-city.php"><img src="./assets/icon/mais.png" class="mais-buttom2"></a>
</button>

<div class="containerconsulta">
    <h2>Tabela de Cidades</h2>
    <table class="table table-striped" id="categoriasTable">
        <thead>
            <tr class="trgreen">
                <th>ID</th>
                <th>Estado</th>
                <th>Nome</th>
                <th>Ações</th> <!-- Coluna para ações -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cidades as $row) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['codcidade']) ?></td>
                    <td><?= htmlspecialchars($row['estado']) ?></td>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td>
                        <a href="alter-city.php?codcidade=<?= htmlspecialchars($row['codcidade']) ?>" class="btn btn-primary">Alterar</a>
                        <a href="exclusao-city.php?codcidade=<?= htmlspecialchars($row['codcidade']) ?>" class="btn btn-danger">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Script de Pesquisa -->
<script>
$(document).ready(function() {
    $('.no-results').hide(); // Ocultar a mensagem ao carregar

    $('#search').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();
        var hasResults = false;

        $('#categoriasTable tbody tr').each(function() {
            var row = $(this);
            var rowData = row.text().toLowerCase();

            if (rowData.includes(searchTerm)) {
                row.fadeIn(100);
                hasResults = true;
            } else {
                row.fadeOut(100);
            }
        });

        if (!hasResults && searchTerm !== "") {
            $('.no-results').fadeIn(100);
        } else {
            $('.no-results').fadeOut(100);
        }
    });
});
</script>

</body>
</html>
