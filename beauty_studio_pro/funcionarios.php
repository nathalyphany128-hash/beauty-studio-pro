<?php
include "conexao.php";

$funcionario_editar = null;

if (isset($_GET["excluir"])) {
    $id = $_GET["excluir"];
    $conexao->query("DELETE FROM funcionarios WHERE id_funcionario = $id");
    header("Location: funcionarios.php");
    exit;
}

if (isset($_GET["editar"])) {
    $id = $_GET["editar"];
    $resultado_editar = $conexao->query("SELECT * FROM funcionarios WHERE id_funcionario = $id");
    $funcionario_editar = $resultado_editar->fetch_assoc();
}

if (isset($_POST["atualizar"])) {
    $id = $_POST["id_funcionario"];
    $nome = $_POST["nome"];
    $cargo = $_POST["cargo"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    $conexao->query("UPDATE funcionarios SET
        nome='$nome',
        cargo='$cargo',
        telefone='$telefone',
        email='$email'
        WHERE id_funcionario=$id");

    header("Location: funcionarios.php");
    exit;
}

if (isset($_POST["cadastrar"])) {
    $nome = $_POST["nome"];
    $cargo = $_POST["cargo"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    $conexao->query("INSERT INTO funcionarios (nome, cargo, telefone, email)
    VALUES ('$nome', '$cargo', '$telefone', '$email')");

    header("Location: funcionarios.php");
    exit;
}

$sql = "SELECT * FROM funcionarios";
$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Funcionários</title>

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

h1,h2{
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

.voltar,
.novo{
    display:inline-block;
    margin-top:20px;
    background:#d63384;
    color:white;
    padding:10px 15px;
    border-radius:5px;
    text-decoration:none;
}

.novo{
    margin-left:10px;
}
</style>

</head>
<body>

<header>
    <h1>Beauty Studio Pro</h1>
    <p>Gerenciamento de Funcionários</p>
</header>

<div class="container">

<h1>Cadastro de Funcionários</h1>

<form method="POST">

<?php if ($funcionario_editar) { ?>
<input type="hidden" name="id_funcionario" value="<?php echo $funcionario_editar['id_funcionario']; ?>">
<?php } ?>

<label>Nome:</label><br>
<input type="text" name="nome" required value="<?php echo $funcionario_editar['nome'] ?? ''; ?>"><br><br>

<label>Cargo:</label><br>
<input type="text" name="cargo" required value="<?php echo $funcionario_editar['cargo'] ?? ''; ?>"><br><br>

<label>Telefone:</label><br>
<input type="text" name="telefone" required value="<?php echo $funcionario_editar['telefone'] ?? ''; ?>"><br><br>

<label>Email:</label><br>
<input type="email" name="email" required value="<?php echo $funcionario_editar['email'] ?? ''; ?>"><br><br>

<?php if ($funcionario_editar) { ?>
<button type="submit" name="atualizar">Atualizar Funcionário</button>
<a class="novo" href="funcionarios.php">Novo Cadastro</a>
<?php } else { ?>
<button type="submit" name="cadastrar">Cadastrar Funcionário</button>
<?php } ?>

</form>

<h2>Funcionários Cadastrados</h2>

<table>
<tr>
<th>ID</th>
<th>Nome</th>
<th>Cargo</th>
<th>Telefone</th>
<th>Email</th>
<th>Ações</th>
</tr>

<?php while($funcionario = $resultado->fetch_assoc()) { ?>
<tr>
<td><?php echo $funcionario['id_funcionario']; ?></td>
<td><?php echo $funcionario['nome']; ?></td>
<td><?php echo $funcionario['cargo']; ?></td>
<td><?php echo $funcionario['telefone']; ?></td>
<td><?php echo $funcionario['email']; ?></td>
<td>
<a href="funcionarios.php?editar=<?php echo $funcionario['id_funcionario']; ?>">Editar</a>
|
<a href="funcionarios.php?excluir=<?php echo $funcionario['id_funcionario']; ?>" onclick="return confirm('Tem certeza que deseja excluir este funcionário?')">Excluir</a>
</td>
</tr>
<?php } ?>

</table>

<a class="voltar" href="index.php">Voltar ao Menu</a>

</div>

</body>
</html>