<?php
    require_once "../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}
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
            <h1>Ações</h1>
            <a href="addAcao.php" class="btn btn-primary">Adicionar ação</a>
            <?php
                if($_SESSION['msg']!=null){echo $_SESSION['msg']; $_SESSION['msg']=null;}

                $r = $db->query("SELECT * FROM acao");
                if($r->rowCount()>0) {
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
                        echo "
                            <p><b>Cód:</b> ".$l['id']."</p>
                            <p><b>Cnpj:</b> ".$l['cnpj']."</p>
                            <p><b>Nome:</b> ".$l['nome']."</p>
                            <p><b>Atividade:</b> ".$l['atividade']."</p>
                            <p><b>Setor:</b> ".$l['setor']."</p>
                            <p><b>Pregão:</b> R$ ".number_format($l['preco'],2,',','')."</p>
                            <a href='edAcao.php?id=".base64_encode($l['id'])."' class='btn btn-warning btn-sm'>Editar</a>
                            <a href='canCliente.php?id=".base64_encode($l['id'])."' class='btn btn-danger btn-sm'>Excluir</a>
                            <hr>
                        ";
                    }
                } else {echo "<p class='text-muted'>Não há clientes pendetes</p>";}
            ?>
        </div>
    </div>


</div>
</body>
</html>