<?php

function conectar(){
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";

    $con = new mysqli($servidor, $usuario, $senha, "mydb");

    if($con->connect_error){
        die("erro :".$con->connect_error);
    }

    return $con;

}


function incluir($nome, $email){
    $con = conectar ();
    $sql = "insert into pessoa(nome, email) values('$nome','$email')";
    if($con->query($sql) === true){
        return "Ok ao gravar";

    }else{
            return "Erro: $sql".$con->error;
    }
}



function listar(){
    $con = conectar();
    $sql = "select id, nome, email from pessoa";
    $resultado = $con->query($sql);
    return $resultado;
}

function buscar($id){
    $con = conectar();
    $sql = "select id, nome, email from pessoa where id = $id";
    $resultado = $con->query($sql);
    $resultado = $resultado->fetch_assoc();
    return $resultado;
}

function alterar($id, $nome, $email){
    $con = conectar();
    $sql = "update pessoa set nome = '$nome', email = '$email' where id = $id";
    if($con->query($sql) === true){
        return "Ok ao Atualizar";
    }else{
        return "Erro: $sql".$con->error;
    }
}

function apagar($id){
    $con = conectar();
    $sql = "delete from pessoa where id = $id";
    if($con->query($sql) === true){
        return "Ok ao Apagar";
    }else{
        return "Erro: $sql".$con->error;
    }
}

<title>Form Pessoa</title>
</head>
<body>
<?php
include 'conectar.php';
$id = $nome = $email = "";
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (array_key_exists('id',$_GET)){
        $id = $_GET['id'];
        $pessoa = buscar($id);
        $nome = $pessoa['nome'];
        $email = $pessoa['email'];
    }
    if (array_key_exists('apagar',$_GET)){
        $apagar = $_GET['apagar'];
        $msg = apagar($apagar);
        echo $msg;
    }
}

?>

<form action="form-pessoa.php" method="post">
    <input type="hidden" name="id"  value="<?php echo $id; ?>">
    <h1>Formulário de Pessoa</h1>
    Nome: <br>
    <input type="text" name="nome"><br>
    <input type="text" name="nome" value="<?php echo $nome; ?>"><br>
    E-mail: <br>
    <input type="text" name="email"><br>
    <input type="text" name="email" value="<?php echo $email; ?>"><br>
    <br>
    <input type="submit" value="Gravar">
    <a href="form-pessoa.php">
    <input type="button" value="Novo">
    </a>
    <input type="button" value="Apagar" 
    <?php echo 'onclick="window.location.replace(\'form-pessoa.php?apagar="';
    echo '$id\')"'; ?>
    >
</form>

<?php 

include 'conectar.php';
//  onclick="window.location.replace('form-pessoa.php');"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $msg = incluir($nome, $email);

    $id = $_POST['id'];
    if($id == ''){
        $msg = incluir($nome, $email);
    } else {
        $msg = alterar($id, $nome, $email);
    }

    echo $msg;
}

?>
<br>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Email</th>
    </tr>
    <?php
    $dados = listar();
    while ($linha = $dados->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$linha['id']."</td>";
        echo "<td>".$linha['nome']."</td>";
        echo "<td>".$linha['email']."</td>";
        echo "<td><a href='form-pessoa.php?id=".$linha['id']."'>Editar</a></td>";
        echo "<td><a href='form-pessoa.php?apagar=".$linha['id']."'>Apagar</a></td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>

function listar(){
    $con = conectar();
    $sql = "select id, nome, email from pessoa";
    $resultado = $con->query($sql);
    return $resultado;
}

function buscar($id){
    $con = conectar();
    $sql = "select id, nome, email from pessoa where id = $id";
    $resultado = $con->query($sql);
    $resultado = $resultado->fetch_assoc();
    return $resultado;
}

function alterar($id, $nome, $email){
    $con = conectar();
    $sql = "update pessoa set nome = '$nome', email = '$email' where id = $id";
    if($con->query($sql) === true){
        return "Ok ao Atualizar";
    }else{
        return "Erro: $sql".$con->error;
    }
}

function apagar($id){
    $con = conectar();
    $sql = "delete from pessoa where id = $id";
    if($con->query($sql) === true){
        return "Ok ao Apagar";
    }else{
        return "Erro: $sql".$con->error;
    }
}

?>
  61  
exemplos-php/crud-mysql/form-pessoa.php
@@ -5,23 +5,76 @@
    <title>Form Pessoa</title>
</head>
<body>
<?php
include 'conectar.php';
$id = $nome = $email = "";
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if (array_key_exists('id',$_GET)){
        $id = $_GET['id'];
        $pessoa = buscar($id);
        $nome = $pessoa['nome'];
        $email = $pessoa['email'];
    }
    if (array_key_exists('apagar',$_GET)){
        $apagar = $_GET['apagar'];
        $msg = apagar($apagar);
        echo $msg;
    }
}
?>
<form action="form-pessoa.php" method="post">
    <input type="hidden" name="id"  value="<?php echo $id; ?>">
    <h1>Formulário de Pessoa</h1>
    Nome: <br>
    <input type="text" name="nome"><br>
    <input type="text" name="nome" value="<?php echo $nome; ?>"><br>
    E-mail: <br>
    <input type="text" name="email"><br>
    <input type="text" name="email" value="<?php echo $email; ?>"><br>
    <br>
    <input type="submit" value="Gravar">
    <a href="form-pessoa.php">
    <input type="button" value="Novo">
    </a>
    <input type="button" value="Apagar" 
    <?php echo 'onclick="window.location.replace(\'form-pessoa.php?apagar="';
    echo '$id\')"'; ?>
    >
</form>
<?php
include 'conectar.php';
//  onclick="window.location.replace('form-pessoa.php');"
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $msg = incluir($nome, $email);

    $id = $_POST['id'];
    if($id == ''){
        $msg = incluir($nome, $email);
    } else {
        $msg = alterar($id, $nome, $email);
    }

    echo $msg;
}

?>
<br>
<table border="1">
    <tr>
        <th>Id</th>
        <th>Nome</th>
        <th>Email</th>
    </tr>
    <?php
    $dados = listar();
    while ($linha = $dados->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$linha['id']."</td>";
        echo "<td>".$linha['nome']."</td>";
        echo "<td>".$linha['email']."</td>";
        echo "<td><a href='form-pessoa.php?id=".$linha['id']."'>Editar</a></td>";
        echo "<td><a href='form-pessoa.php?apagar=".$linha['id']."'>Apagar</a></td>";
        echo "</tr>";
    }
    ?>
</table>
</body>
</html>
