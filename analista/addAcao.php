<?php
    require_once "../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    if( (!empty($_POST['cnpj'])) and (!empty($_POST['nome'])) and (!empty($_POST['atividade'])) and (!empty($_POST['setor'])) and (!empty($_POST['preco'])) ) {
        $r = $db->prepare("SELECT id FROM acao WHERE cnpj=?");
        $r->execute(array($_POST['cnpj']));;

        if($r->rowCount()==0) {
            $pregao = number_format($_POST['preco'],2);
            $r = $db->prepare("INSERT INTO acao(cnpj,nome,atividade,setor,preco) VALUES (?,?,?,?,?)");
            $r->execute(array($_POST['cnpj'],$_POST['nome'],$_POST['atividade'],$_POST['setor'],$pregao));
            $_SESSION['msg'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Ação Cnpj ".$_POST['cnpj']." adicionada!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            header("location: acoes.php");
        } else {$_SESSION['msg'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Ação já existente!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; header("location: acoes.php");}
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
                            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="acoes.php">Ações</a></li>
                            <li class="nav-item"><a class="nav-link" href="../logout.php" id="logout">An. <?=$_SESSION['nome']?>-logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h1>Nova ação</h1>
            <form action="addAcao.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="cnpj (somente números)" required name="cnpj" pattern="\d{12}">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="nome" required name="nome" maxlength="60" style="text-transform:lowercase;">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="atividade" required name="atividade" maxlength="60" style="text-transform:lowercase;">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="setor" required name="setor" maxlength="60" style="text-transform:lowercase;">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" required name="preco" pattern="\d{1,3}\.\d{2}" placeholder="pregão">
                    <div class="form-text">Use ponto ao invés de vírgula</div>
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='acoes.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Confirmar</button>
            </form>
        </div>
    </div>


</div>
</body>
</html>