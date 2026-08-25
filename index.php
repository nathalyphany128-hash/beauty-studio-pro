<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Beauty Studio Pro</title>

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

header img{
    width:230px;
    margin-bottom:5px;
}

.horario{
    margin-top:10px;
    background:rgba(255,255,255,0.2);
    display:inline-block;
    padding:10px 20px;
    border-radius:8px;
    font-size:16px;
}

.container{
    width:80%;
    margin:auto;
    margin-top:30px;
}

.card{
    background:white;
    padding:20px;
    margin-bottom:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
    color:#d63384;
}

a{
    display:inline-block;
    margin-top:10px;
    padding:10px 15px;
    background:#d63384;
    color:white;
    text-decoration:none;
    border-radius:5px;
}

a:hover{
    background:#b82c70;
}

footer{
    text-align:center;
    background:#d63384;
    color:white;
    padding:15px;
    margin-top:30px;
}
</style>

</head>
<body>

<header>

    <img src="logo.png" alt="Logo Beauty Studio Pro">

    <h1>Beauty Studio Pro</h1>

    <p>Sistema de Agendamento de Salão</p>

    <div class="horario">
        🕒 Horário de Funcionamento<br>
        Terça a Sábado<br>
        Das 07:00 às 19:00
    </div>

</header>

<div class="container">

    <div class="card">
        <h2>Beauty Studio Pro</h2>
        <p>
            Organize seus clientes, profissionais, serviços e agendamentos
            de forma prática e eficiente.
        </p>
    </div>

    <div class="card">
        <h2>Clientes</h2>
        <p>Cadastro e gerenciamento de clientes.</p>
        <a href="clientes.php">Ver Clientes</a>
    </div>

    <div class="card">
        <h2>Funcionários</h2>
        <p>Controle dos profissionais do salão.</p>
        <a href="funcionarios.php">Ver Funcionários</a>
    </div>

    <div class="card">
        <h2>Serviços</h2>
        <p>Cadastro de cortes, escovas, unhas e tratamentos.</p>
        <a href="servicos.php">Ver Serviços</a>
    </div>

    <div class="card">
        <h2>Agendamentos</h2>
        <p>Controle completo dos horários.</p>
        <a href="agendamentos.php">Ver Agendamentos</a>
    </div>

</div>

<footer>
    Beauty Studio Pro © 2026<br>
    Desenvolvido por Nathaly Sthephanie
</footer>

</body>
</html>