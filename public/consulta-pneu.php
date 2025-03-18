<?php
session_start();
require '../vendor/autoload.php'; // Autoload para carregar a classe Connect
use app\functions\database\Connect;

$pdo = Connect::conect(); // Conexão via classe Connect
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <title>Lista de Pneus</title>
    <link rel="stylesheet" href="./assets/css/crudstyle.css">
    <link rel="shortcut icon" href="./assets/icon/logoamazonia.ico" type="image/x-icon">
    <style>
        /* Estilo para linhas inativas (quando a classe 'inativo' for aplicada) */
        .inativo {
            background-color: #ffb7bd; /* Cor de fundo vermelha clara */
            color: #721c24; /* Cor do texto */
        }
    </style>
</head>

<body>
<header>
    <div class="menubar"></div>
    <img src="./assets/image/bandaglogo.png" alt="" class="circleyellow">
</header>

<!-- Barra de Pesquisa -->
<div class="search-container">
    <input type="text" id="search" placeholder="Pesquisar pneus..." class="search-bar" />
    <div class="no-results">Nenhum resultado encontrado.</div>
</div>

<!-- Restante do código -->
<div class="containerconsulta">
    <h2>Tabela de Pneus</h2>
    <table class="table table-striped" id="categoriasTable">
        <thead>
            <tr class="trgreen">
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Tipo</th>
                <th>Preço</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $sql = "SELECT * FROM tb_pneus"; // Consulta para obter os pneus
                $stmt = $pdo->query($sql);

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    // Verifica se o pneu está inativo e aplica a classe 'inativo' em todas as células
                    $inativoClass = $row['ativo'] === 'N' ? 'inativo' : ''; 
                    echo "<tr>"; // Começo da linha
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['codpneu']) . "</td>"; // ID do pneu
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['nomepneu']) . "</td>"; // Nome do pneu
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['descricao']) . "</td>"; // Descrição do pneu
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['tipo']) . "</td>"; // Tipo do pneu
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['preco']) . "</td>"; // Preço do pneu
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['ativo']) . "</td>"; // Status Ativo
                    echo "<td class='{$inativoClass}'>
                            <a href='alter-pneu.php?codpneu=" . htmlspecialchars($row['codpneu']) . "' class='btn btn-danger'>Alterar</a>
                            <a href='exclusao-pneu.php?codpneu=" . htmlspecialchars($row['codpneu']) . "' class='btn btn-danger'>Excluir</a>
                          </td>"; // Ações
                    echo "</tr>"; // Fim da linha
                }
            } catch (\PDOException $e) {
                echo "Erro: " . $e->getMessage();
            }
            ?>
        </tbody>
    </table>

    <button class="containerconsultavoltar">
        <a href="./pages/inicio.php"><img src="./assets/icon/seta-pequena-esquerda.png" class="mais-buttom"></a>
    </button>

    <button class="containerconsultavoltar2">
        <a href="cadastro-pneu.php"><img src="./assets/icon/mais.png" class="mais-buttom2"></a>
    </button>
</div>

<script src="./assets/js/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.no-results').hide();

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
