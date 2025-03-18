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
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="./assets/css/crudstyle.css">
    <link rel="shortcut icon" href="./assets/icon/logoamazonia.ico" type="image/x-icon">
</head>

<body>
<header>
    <div class="menubar"></div>
    <img src="./assets/image/bandaglogo.png" alt="" class="circleyellow">
</header>

<!-- Barra de Pesquisa -->
<div class="search-container">
    <input type="text" id="search" placeholder="Pesquisar usuários..." class="search-bar" />
    <div class="no-results">Nenhum resultado encontrado.</div>
</div>

<!-- Restante do código -->
<div class="containerconsulta">
    <h2>Tabela de Usuários</h2>
    <table class="table table-striped" id="categoriasTable">
        <thead>
            <tr class="trgreen">
                <th>ID</th>
                <th>Nome</th>
                <th>Rua</th>
                <th>CPF</th>
                <th>Telefone</th>
                <th>E-mail</th>
                <th>Data de Nascimento</th>
                <th>N° Casa</th>
                <th>Bairro</th>
                <th>Complemento</th>
                <th>Tipo</th>
                <th>Ativo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $sql = "SELECT * FROM tb_clientes";
                $stmt = $pdo->query($sql);

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $inativoClass = $row['ativo'] === 'N' ? 'inativo' : '';
                    echo "<tr>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['codcliente']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['nome']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['rua']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['cpf']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['fone']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['email']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['datanasc']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['ncasa']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['bairro']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['complemento']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['tipo']) . "</td>";
                    echo "<td class='{$inativoClass}'>" . htmlspecialchars($row['ativo']) . "</td>";
                    echo "<td>
                            <a href='alter-user.php?codcliente=" . htmlspecialchars($row['codcliente']) . "' class='btn btn-danger'>Alterar</a>
                            <a href='exclusao-user.php?codcliente=" . htmlspecialchars($row['codcliente']) . "' class='btn btn-danger'>Desativar</a>
                          </td>";
                    echo "</tr>";
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
        <a href="cadastro-user-do-consulta.php"><img src="./assets/icon/mais.png" class="mais-buttom2"></a>
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
