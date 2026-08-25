<?php
include "conexao.php";

$agendamento_editar = null;

if (isset($_GET["excluir"])) {
    $id = $_GET["excluir"];
    $conexao->query("DELETE FROM agendamentos WHERE id_agendamento = $id");
    header("Location: agendamentos.php");
    exit;
}

if (isset($_GET["editar"])) {
    $id = $_GET["editar"];
    $resultado_editar = $conexao->query("SELECT * FROM agendamentos WHERE id_agendamento = $id");
    $agendamento_editar = $resultado_editar->fetch_assoc();
}

if (isset($_POST["atualizar"])) {
    $id = $_POST["id_agendamento"];
    $id_cliente = $_POST["id_cliente"];
    $id_funcionario = $_POST["id_funcionario"];
    $id_servico = $_POST["id_servico"];
    $desejo_cliente = $_POST["desejo_cliente"];
    $data_agendamento = $_POST["data_agendamento"];
    $horario = $_POST["horario"];

    $conexao->query("UPDATE agendamentos SET
        id_cliente='$id_cliente',
        id_funcionario='$id_funcionario',
        id_servico='$id_servico',
        desejo_cliente='$desejo_cliente',
        data_agendamento='$data_agendamento',
        horario='$horario'
        WHERE id_agendamento=$id");

    header("Location: agendamentos.php");
    exit;
}

if (isset($_POST["cadastrar"])) {
    $id_cliente = $_POST["id_cliente"];
    $id_funcionario = $_POST["id_funcionario"];
    $id_servico = $_POST["id_servico"];
    $desejo_cliente = $_POST["desejo_cliente"];
    $data_agendamento = $_POST["data_agendamento"];
    $horario = $_POST["horario"];

    $conexao->query("INSERT INTO agendamentos
    (id_cliente, id_funcionario, id_servico, desejo_cliente, data_agendamento, horario)
    VALUES ('$id_cliente', '$id_funcionario', '$id_servico', '$desejo_cliente', '$data_agendamento', '$horario')");

    header("Location: agendamentos.php");
    exit;
}

$clientes = $conexao->query("SELECT * FROM clientes");
$funcionarios = $conexao->query("SELECT * FROM funcionarios");
$servicos = $conexao->query("SELECT * FROM servicos");

$sql = "
SELECT
    a.id_agendamento,
    c.nome AS cliente,
    f.nome AS funcionario,
    s.nome_servico,
    a.desejo_cliente,
    a.data_agendamento,
    a.horario
FROM agendamentos a
INNER JOIN clientes c ON a.id_cliente = c.id_cliente
INNER JOIN funcionarios f ON a.id_funcionario = f.id_funcionario
INNER JOIN servicos s ON a.id_servico = s.id_servico
";

$resultado = $conexao->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Agendamentos</title>

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

input, select, textarea{
    width:300px;
    padding:8px;
    border:1px solid #ccc;
    border-radius:5px;
}

textarea{
    height:70px;
    resize:none;
}

.info-funcionario{
    width:500px;
    background:#fff0f6;
    border-left:5px solid #d63384;
    padding:12px;
    border-radius:8px;
    margin-bottom:18px;
    color:#333;
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
}

.novo{
    margin-left:10px;
}
</style>

</head>
<body>

<header>
    <h1>Beauty Studio Pro</h1>
    <p>Gerenciamento de Agendamentos</p>
</header>

<div class="container">

<h1>Cadastro de Agendamentos</h1>

<form method="POST">

<?php if ($agendamento_editar) { ?>
<input type="hidden" name="id_agendamento" value="<?php echo $agendamento_editar['id_agendamento']; ?>">
<?php } ?>

<label>Cliente:</label><br>
<select name="id_cliente" required>
<?php while($cliente = $clientes->fetch_assoc()) { ?>
<option value="<?php echo $cliente['id_cliente']; ?>"
    <?php if ($agendamento_editar && $agendamento_editar['id_cliente'] == $cliente['id_cliente']) echo 'selected'; ?>>
    <?php echo $cliente['nome']; ?>
</option>
<?php } ?>
</select><br><br>

<label>Funcionário:</label><br>
<select name="id_funcionario" id="funcionario" required onchange="mostrarServicosFuncionario()">
<?php while($funcionario = $funcionarios->fetch_assoc()) { ?>
<option value="<?php echo $funcionario['id_funcionario']; ?>"
    <?php if ($agendamento_editar && $agendamento_editar['id_funcionario'] == $funcionario['id_funcionario']) echo 'selected'; ?>>
    <?php echo $funcionario['nome']; ?>
</option>
<?php } ?>
</select><br><br>

<div class="info-funcionario" id="infoFuncionario">
    Selecione uma funcionária para ver o que ela faz.
</div>

<label>Serviço:</label><br>
<select name="id_servico" required>
<?php while($servico = $servicos->fetch_assoc()) { ?>
<option value="<?php echo $servico['id_servico']; ?>"
    <?php if ($agendamento_editar && $agendamento_editar['id_servico'] == $servico['id_servico']) echo 'selected'; ?>>
    <?php echo $servico['nome_servico']; ?>
</option>
<?php } ?>
</select><br><br>

<label>O que deseja fazer?</label><br>
<textarea name="desejo_cliente" required placeholder="Exemplo: Progressiva, luzes, alongamento em gel..."><?php echo $agendamento_editar['desejo_cliente'] ?? ''; ?></textarea><br><br>

<label>Data:</label><br>
<input type="date" name="data_agendamento" required value="<?php echo $agendamento_editar['data_agendamento'] ?? ''; ?>"><br><br>

<label>Horário:</label><br>
<input type="time" name="horario" required value="<?php echo $agendamento_editar['horario'] ?? ''; ?>"><br><br>

<?php if ($agendamento_editar) { ?>
<button type="submit" name="atualizar">Atualizar Agendamento</button>
<a class="novo" href="agendamentos.php">Novo Agendamento</a>
<?php } else { ?>
<button type="submit" name="cadastrar">Cadastrar Agendamento</button>
<?php } ?>

</form>

<h2>Agendamentos Cadastrados</h2>

<table>
<tr>
<th>ID</th>
<th>Cliente</th>
<th>Funcionário</th>
<th>Serviço</th>
<th>Desejo da Cliente</th>
<th>Data</th>
<th>Horário</th>
<th>Ações</th>
</tr>

<?php while($agendamento = $resultado->fetch_assoc()) { ?>
<tr>
<td><?php echo $agendamento['id_agendamento']; ?></td>
<td><?php echo $agendamento['cliente']; ?></td>
<td><?php echo $agendamento['funcionario']; ?></td>
<td><?php echo $agendamento['nome_servico']; ?></td>
<td><?php echo $agendamento['desejo_cliente']; ?></td>
<td><?php echo $agendamento['data_agendamento']; ?></td>
<td><?php echo $agendamento['horario']; ?></td>
<td>
<a href="agendamentos.php?editar=<?php echo $agendamento['id_agendamento']; ?>">Editar</a>
|
<a href="agendamentos.php?excluir=<?php echo $agendamento['id_agendamento']; ?>" onclick="return confirm('Tem certeza que deseja excluir este agendamento?')">Excluir</a>
</td>
</tr>
<?php } ?>

</table>

<a class="voltar" href="index.php">Voltar ao Menu</a>

</div>

<script>
function mostrarServicosFuncionario(){
    var funcionario = document.getElementById("funcionario");
    var nome = funcionario.options[funcionario.selectedIndex].text;
    var info = document.getElementById("infoFuncionario");

    if(nome.includes("Carla Santos")){
        info.innerHTML = "<strong>Carla Santos - Cabeleireira</strong><br>Corte, Escova, Hidratação, Luzes, Coloração, Progressiva e Botox.";
    } else if(nome.includes("Juliana Lima")){
        info.innerHTML = "<strong>Juliana Lima - Manicure</strong><br>Manicure Simples (Mão), Pedicure Simples (Pé), Combo Mão e Pé e Alongamento em Gel.";
    } else if(nome.includes("Mariana Azevedo")){
        info.innerHTML = "<strong>Mariana Azevedo - Lash Designer</strong><br>Extensão de cílios, manutenção e remoção.";
    } else {
        info.innerHTML = "Selecione uma funcionária para ver o que ela faz.";
    }
}

mostrarServicosFuncionario();
</script>

</body>
</html>