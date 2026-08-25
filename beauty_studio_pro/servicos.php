<?php
include "conexao.php";

$servico_editar = null;

if (isset($_GET["excluir"])) {
    $id = $_GET["excluir"];
    $conexao->query("DELETE FROM servicos WHERE id_servico = $id");
}

if (isset($_GET["editar"])) {
    $id = $_GET["editar"];
    $resultado_editar = $conexao->query("SELECT * FROM servicos WHERE id_servico = $id");
    $servico_editar = $resultado_editar->fetch_assoc();
}

if (isset($_POST["atualizar"])) {
    $id = $_POST["id_servico"];
    $nome_servico = $_POST["nome_servico"];
    $descricao = $_POST["descricao"];
    $valor = $_POST["valor"];

    $conexao->query("UPDATE servicos SET 
        nome_servico='$nome_servico',
        descricao='$descricao',
        valor='$valor'
        WHERE id_servico=$id");
}

if (isset($_POST["cadastrar"])) {
    $nome_servico = $_POST["nome_servico"];
    $descricao = $_POST["descricao"];
    $valor = $_POST["valor"];

    $conexao->query("INSERT INTO servicos (nome_servico, descricao, valor)
    VALUES ('$nome_servico', '$descricao', '$valor')");
}

$sql = "SELECT * FROM servicos";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Serviços</title>

<style>
body{
    font-family: Arial, sans-serif;
    background:#f8e8ef;
    padding:20px;
}

h1, h2{
    color:#d63384;
}

form{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

input{
    padding:6px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    background:#d63384;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#b82c70;
}

table{
    background:white;
    border-collapse:collapse;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

th{
    background:#d63384;
    color:white;
    padding:8px;
}

td{
    padding:6px;
}

a{
    color:#d63384;
    font-weight:bold;
}
</style>

</head>
<body>

<h1>Cadastro de Serviços</h1>

<form method="POST">

    <?php if ($servico_editar) { ?>
        <input type="hidden" name="id_servico" value="<?php echo $servico_editar['id_servico']; ?>">
    <?php } ?>

    <label>Nome do Serviço:</label><br>
    <input type="text" name="nome_servico" required value="<?php echo $servico_editar['nome_servico'] ?? ''; ?>"><br><br>

    <label>Descrição:</label><br>
    <input type="text" name="descricao" required value="<?php echo $servico_editar['descricao'] ?? ''; ?>"><br><br>

    <label>Valor:</label><br>
    <input type="text" name="valor" required value="<?php echo $servico_editar['valor'] ?? ''; ?>"><br><br>

    <?php if ($servico_editar) { ?>
        <button type="submit" name="atualizar">Atualizar Serviço</button>
    <?php } else { ?>
        <button type="submit" name="cadastrar">Cadastrar Serviço</button>
    <?php } ?>

</form>

<hr>

<h2>Serviços Cadastrados</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Serviço</th>
        <th>Descrição</th>
        <th>Valor</th>
        <th>Ações</th>
    </tr>

    <?php while($servico = $resultado->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $servico['id_servico']; ?></td>
        <td><?php echo $servico['nome_servico']; ?></td>
        <td><?php echo $servico['descricao']; ?></td>
        <td>R$ <?php echo $servico['valor']; ?></td>
        <td>
            <a href="servicos.php?editar=<?php echo $servico['id_servico']; ?>">Editar</a>
            |
            <a href="servicos.php?excluir=<?php echo $servico['id_servico']; ?>" onclick="return confirm('Tem certeza que deseja excluir este serviço?')">Excluir</a>
        </td>
    </tr>
    <?php } ?>

</table>

<br>

<a href="index.php">Voltar ao Menu</a>

</body>
</html>