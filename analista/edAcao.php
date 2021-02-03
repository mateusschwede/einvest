<?php
    require_once "../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    $r = $db->prepare("SELECT * FROM acao WHERE id=?");
    $r->execute(array(base64_decode($_GET['id'])));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {
        $cnpj = $l['cnpj'];
        $nome = $l['nome'];
        $atividade = $l['atividade'];
        $setor = $l['setor'];
        $preco = number_format($l['preco'],2);
    }

    if ( (!empty($_GET['idVelho'])) and (!empty($_POST['nCnpj'])) and (!empty($_POST['nNome'])) and (!empty($_POST['nAtividade'])) and (!empty($_POST['nSetor'])) and (!empty($_POST['nPreco'])) ) {
        $r = $db->prepare("SELECT idAcao FROM carteira_acao WHERE idAcao=?");
        $r->execute(array($_GET['idVelho']));

        if ($r->rowCount()==0) {
            $pregao = number_format($_POST['nPreco'],2);
            $r = $db->prepare("UPDATE acao SET cnpj=?,nome=?,atividade=?,setor=?,preco=? WHERE id=?");
            $r->execute(array($_POST['nCnpj'],$_POST['nNome'],$_POST['nAtividade'],$_POST['nSetor'],$pregao,$_GET['idVelho']));
            $_SESSION['msg'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Ação ".$_GET['idVelho']." atualizada!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            header("location: acoes.php");
        } else {$_SESSION['msg'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Ação cadastrada em carteira!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; header("location: acoes.php");}

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
            <h1>Editar ação <?=base64_decode($_GET['id'])?></h1>
            <form action="edAcao.php?idVelho=<?=base64_decode($_GET['id'])?>" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="cnpj (somente números)" required name="nCnpj" pattern="\d{12}" value="<?=$cnpj?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="nome" required name="nNome" maxlength="60" style="text-transform:lowercase;" value="<?=$nome?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="atividade" required name="nAtividade" maxlength="60" style="text-transform:lowercase;" value="<?=$atividade?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="setor" required name="nSetor" maxlength="60" style="text-transform:lowercase;" value="<?=$setor?>">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" required name="nPreco" pattern="\d{1,3}\.\d{2}" placeholder="pregão" value="<?=$preco?>">
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