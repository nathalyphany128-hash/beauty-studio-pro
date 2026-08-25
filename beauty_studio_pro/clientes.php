<?php
include "conexao.php";

$cliente_editar = null;

if (isset($_GET["excluir"])) {
    $id = $_GET["excluir"];
    $conexao->query("DELETE FROM clientes WHERE id_cliente = $id");
}

if (isset($_GET["editar"])) {
    $id = $_GET["editar"];
    $resultado_editar = $conexao->query("SELECT * FROM clientes WHERE id_cliente = $id");
    $cliente_editar = $resultado_editar->fetch_assoc();
}

if (isset($_POST["atualizar"])) {
    $id = $_POST["id_cliente"];
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $endereco = $_POST["endereco"];

    $conexao->query("UPDATE clientes SET 
        nome='$nome',
        telefone='$telefone',
        email='$email',
        endereco='$endereco'
        WHERE id_cliente=$id");

    header("Location: clientes.php");
    exit;
}

if (isset($_POST["cadastrar"])) {
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];
    $endereco = $_POST["endereco"];

    $conexao->query("INSERT INTO clientes (nome, telefone, email, endereco)
    VALUES ('$nome', '$telefone', '$email', '$endereco')");

    header("Location: clientes.php");
    exit;
}

$sql = "SELECT * FROM clientes";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>

<style>
body{
    font-family: Arial, sans-serif;
    background:#f8e8ef;
    margin:0;
    padding:0;
}

header{
    background:#d63384;
    color:white;
    text-align:center;
    padding:20px;
}

.container{
    width:85%;
    margin:auto;
    margin-top:30px;
}

h1, h2{
    color:#d63384;
}

form{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

input{
    width:300px;
    padding:8px;
    border:1px solid #ccc;
    border-radius:5px;
}

button{
    background:#d63384;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:5px;
    cursor:pointer;
}

button:hover{
    background:#b82c70;
}

table{
    width:100%;
    background:white;
    border-collapse:collapse;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

th{
    background:#d63384;
    color:white;
    padding:10px;
}

td{
    padding:10px;
    border:1px solid #ddd;
}

a{
    color:#d63384;
    font-weight:bold;
    text-decoration:none;
}

a:hover{
    text-decoration:underline;
}

.voltar, .novo{
    display:inline-block;
    margin-top:20px;
    background:#d63384;
    color:white;
    padding:10px 15px;
    border-radius:5px;
}

.novo{
    margin-left:10px;
}
</style>

</head>
<body>

<header>
    <h1>Beauty Studio Pro</h1>
    <p>Gerenciamento de Clientes</p>
</header>

<div class="container">

<h1>Cadastro de Clientes</h1>

<form method="POST">

    <?php if ($cliente_editar) { ?>
        <input type="hidden" name="id_cliente" value="<?php echo $cliente_editar['id_cliente']; ?>">
    <?php } ?>

    <label>Nome:</label><br>
    <input type="text" name="nome" required value="<?php echo $cliente_editar['nome'] ?? ''; ?>"><br><br>

    <label>Telefone:</label><br>
    <input type="text" name="telefone" required value="<?php echo $cliente_editar['telefone'] ?? ''; ?>"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email" required value="<?php echo $cliente_editar['email'] ?? ''; ?>"><br><br>

    <label>Endereço:</label><br>
    <input type="text" name="endereco" required value="<?php echo $cliente_editar['endereco'] ?? ''; ?>"><br><br>

    <?php if ($cliente_editar) { ?>
        <button type="submit" name="atualizar">Atualizar Cliente</button>
        <a class="novo" href="clientes.php">Novo Cadastro</a>
    <?php } else { ?>
        <button type="submit" name="cadastrar">Cadastrar Cliente</button>
    <?php } ?>

</form>

<h2>Clientes Cadastrados</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Telefone</th>
        <th>Email</th>
        <th>Endereço</th>
        <th>Ações</th>
    </tr>

    <?php while($cliente = $resultado->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $cliente['id_cliente']; ?></td>
        <td><?php echo $cliente['nome']; ?></td>
        <td><?php echo $cliente['telefone']; ?></td>
        <td><?php echo $cliente['email']; ?></td>
        <td><?php echo $cliente['endereco']; ?></td>
        <td>
            <a href="clientes.php?editar=<?php echo $cliente['id_cliente']; ?>">Editar</a>
            |
            <a href="clientes.php?excluir=<?php echo $cliente['id_cliente']; ?>" onclick="return confirm('Tem certeza que deseja excluir este cliente?')">Excluir</a>
        </td>
    </tr>
    <?php } ?>

</table>

<a class="voltar" href="index.php">Voltar ao Menu</a>

</div>

</body>
</html>