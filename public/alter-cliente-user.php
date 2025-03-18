<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados do Cliente</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <header>
        <div class="menubar">
            <!-- Adicione um menu se necessário -->
        </div>
        <img src="./assets/icon/logoamazonia.ico" alt="" class="circleyellow">
    </header>

    <div class="containeralter">
        <h2>Alterar Dados do Cliente</h2>

        <form method="post" action="">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" value="" required>
            </div>

            <div class="form-group">
                <label for="fone">Telefone:</label>
                <input type="text" class="form-control" id="fone" name="fone" value="" required>
            </div>

            <div class="form-group">
                <label for="rua">Rua:</label>
                <input type="text" class="form-control" id="rua" name="rua" value="" required>
            </div>

            <div class="form-group">
                <label for="bairro">Bairro:</label>
                <input type="text" class="form-control" id="bairro" name="bairro" value="" required>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Atualizar</button>
        </form>
    </div>

</body>

</html>
