<?php
    require_once "../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: ../index.php");}
    $_SESSION['msg'] = null;

    $r = $db->prepare("SELECT * FROM cliente WHERE nome=? AND senha=?");
    $r->execute(array($_SESSION['nome'],$_SESSION['senha']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {$cpf = $l['cpf'];}

    if( (!empty($_GET['cpf'])) and (!empty($_POST['email'])) and (!empty($_POST['telefone'])) and (!empty($_POST['novaSenha'])) ) {
        $r = $db->prepare("SELECT cpf FROM cliente WHERE nome=? AND senha=? AND cpf!=?");
        $r->execute(array($_SESSION['nome'],$_POST['novaSenha'],$cpf));
        if($r->rowCount()==0) {
            $r = $db->prepare("UPDATE cliente SET email=?,telefone=?,senha=? WHERE cpf=?");
            $r->execute(array($_POST['email'],$_POST['telefone'],$_POST['novaSenha'],$_GET['cpf']));
            $_SESSION['nome'] = $_POST['nome'];
            $_SESSION['senha'] = $_POST['novaSenha'];
            $_SESSION['msg'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Cliente ".$nome." atualizado!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            header("location: ../index.php");
        } else {$_SESSION['msg'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Senha ".$_POST['novaSenha']." já existente!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>EInvest</title>
    <link rel="stylesheet" href="../estilo.css">
    <link rel="shortcut icon" href="https://img.icons8.com/color/48/000000/technical-support.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container-fluid">


    <div class="row">
        <div class="col-sm-12 text-center">
            <h1>Atualização de dados (<?=$_SESSION['nome']?>)</h1>
            <p>Como esse é seu primeiro acesso ao sistema, atualize seus dados e refaça o login</p>
            <form action="primeiroAcesso.php?cpf=<?=$cpf?>" method="post">
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="email" required name="email" maxlength="60" style="text-transform:lowercase;">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="telefone (51)99999-2828" required name="telefone" pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="nova senha" required name="novaSenha" maxlength="5" style="text-transform:lowercase;" value="<?=$_SESSION['senha']?>">
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='../index.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Atualizar</button>
            </form>
            <?php if($_SESSION['msg']!=null){echo $_SESSION['msg']; $_SESSION['msg']=null;}?>
        </div>
    </div>


</div>
</body>
</html>