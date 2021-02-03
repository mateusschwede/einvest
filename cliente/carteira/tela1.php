<?php
    require_once "../../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if( (!empty($_POST['nome'])) and (!empty($_POST['precoInvestimento'])) ) {
        $r = $db->query("SELECT id FROM acao");
        
        if($r->rowCount()>0) {            
            $r = $db->prepare("SELECT cpf FROM cliente WHERE nome=? AND senha=?");
            $r->execute(array($_SESSION['nome'],$_SESSION['senha']));
            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
            foreach($linhas as $l) {$cpf = $l['cpf'];}

            $r = $db->prepare("SELECT nome FROM carteira WHERE nome=? AND cpfCliente=?");
            $r->execute(array($_POST['nome'],$cpf));
            
            if($r->rowCount()==0) {
                $r = $db->prepare("INSERT INTO carteira(nome,precoInvestimento,cpfCliente) VALUES (?,?,?)");
                $r->execute(array($_POST['nome'],$_POST['precoInvestimento'],$cpf));

                $r2 = $db->prepare("SELECT id FROM carteira WHERE nome=? AND cpfCliente=?");
                $r2->execute(array($_POST['nome'],$cpf));
                $linhas = $r2->fetchAll(PDO::FETCH_ASSOC);
                $_SESSION['cpfCliente'] = $cpf;
                foreach($linhas as $l) {$_SESSION['idCarteira'] = $l['id'];}
                header("location: tela2.php");
            } else {$_SESSION['msg'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Nome de carteira já existente no sistema!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; header("location: ../index.php");}
        } else {$_SESSION['msg'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Nenhuma ação cadastrada no sistema!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; header("location: ../index.php");}
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>EInvest</title>
    <link rel="stylesheet" href="../../estilo.css">
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
                    <a class="navbar-brand" href="../index.php">EInvest</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="../cliente.php">Perfil</a></li>
                            <li class="nav-item"><a class="nav-link" href="../../logout.php" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h1>Nova carteira</h1>
            <form action="tela1.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="nome" required name="nome" maxlength="60" style="text-transform:lowercase;">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" required name="precoInvestimento" pattern="\d{1,6}\.\d{2}" placeholder="valor investimento">
                    <div class="form-text">Use ponto ao invés de vírgula</div>
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='../index.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Confirmar</button>
            </form>
        </div>
    </div>


</div>
</body>
</html>