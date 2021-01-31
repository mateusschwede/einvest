<?php
    require_once "../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    $r = $db->prepare("SELECT * FROM cliente WHERE nome=? AND senha=?");
    $r->execute(array($_SESSION['nome'],$_SESSION['senha']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {
        $cpf = $l['cpf'];
        $email = $l['email'];
        $telefone = $l['telefone'];
    }

    if( (!empty($_GET['cpf'])) and (!empty($_POST['nNome'])) and (!empty($_POST['nEmail'])) and (!empty($_POST['nTelefone'])) and (!empty($_POST['nSenha'])) ) {
        $r = $db->prepare("SELECT cpf FROM cliente WHERE nome=? AND senha=? AND cpf!=?");
        $r->execute(array($_POST['nNome'],$_POST['nSenha'],$cpf));
        if($r->rowCount()==0) {
            $r = $db->prepare("UPDATE cliente SET nome=?,email=?,telefone=?,senha=? WHERE cpf=?");
            $r->execute(array($_POST['nNome']),$_POST['nEmail'],$_POST['nTelefone'],$_POST['nSenha'],$cpf);
            $_SESSION['nome'] = $_POST['nNome'];
            $_SESSION['senha'] = $_POST['nSenha'];
            $_SESSION['msg'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Cliente ".$nome." atualizado!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            header("location: index.php");
        } else {$_SESSION['msg'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Nome e senha já existentes!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; header("location: index.php");}
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
        <div class="col-sm-12" id="menu">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">EInvest</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link"href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link active" aria-current="page"  href="cliente.php">Perfil</a></li>
                            <li class="nav-item"><a class="nav-link" href="../logout.php" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h1>Editar <?=$_SESSION['nome']?></h1>
            <form action="edCliente.php?cpf=<?=$cpf?>" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="nome" required name="nNome" maxlength="60" style="text-transform:lowercase;" value="<?=$_SESSION['nome']?>">
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="email" required name="nEmail" maxlength="60" style="text-transform:lowercase;" value="<?=$email?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="telefone (51)99999-2828" required name="nTelefone" pattern="\([0-9]{2}\)[0-9]{4,5}-[0-9]{4}" value="<?=$telefone?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="senha" required name="nSenha" maxlength="5" style="text-transform:lowercase;" value="<?=$_SESSION['senha']?>">
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='index.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Atualizar</button>
            </form>
        </div>
    </div>


</div>
</body>
</html>