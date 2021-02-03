<?php
    require_once "../../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}
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
                    <a class="navbar-brand" href="#">EInvest</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Home</a>
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Perfil</a>
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true"><?=$_SESSION['nome']?>-logout</a>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <h2>Carteira <?=$_SESSION['idCarteira']?>:</h2>
            <?php
                if($_SESSION['msg']!=null){echo $_SESSION['msg']; $_SESSION['msg']=null;}
            
                $r = $db->prepare("SELECT * FROM carteira WHERE cpfCliente=? AND id=?");
                $r->execute(array($_SESSION['cpfCliente'],$_SESSION['idCarteira']));
                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                foreach($linhas as $l) {
                    echo "
                        <p><b>Nome:</b> ".$l['nome']."</p>
                        <p><b>T. Investimento:</b> R$ ".number_format($l['precoInvestimento'],2)."</p>
                    ";
                }
            ?>

            <h3>Ações relacionadas:</h3>
            <a href="addAcaoCarteira.php" class="btn btn-sm btn-primary">Adicionar ação</a>
            <?php
                $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                $r->execute(array($_SESSION['idCarteira']));

                if($r->rowCount()>0) {
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
                        $percentual = $l['percentual'];
                        $r = $db->prepare("SELECT * FROM acao WHERE id=?");
                        $r->execute(array($l['idAcao']));
                        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                        foreach($linhas as $l) {$nomeAcao = $l['nome']; $preco = number_format($l['preco'],2);}
                        
                        echo "
                            <p><b>".$l['nome']."(R$ ".$preco."):</b> ".$percentual."% (R$ ".$precoPercentual.")</p>
                            <a href='edAcaoCarteira.php?idAcao=".base64_encode($l['id'])."' class='btn btn-warning btn-sm'>Editar</a>
                            <a href='remAcaoCarteira.php?idAcao=".base64_encode($l['id'])."' class='btn btn-danger btn-sm'>Excluir</a>
                            <hr>
                        ";
                    }
                } else {echo "<p class='text-muted'>Nenhuma ação cadastrada</p>";}
            ?>
            
            <form action="tela2.php" method="post">
                <input type="hidden" name="fimCarteira" value=1>
                <button type="button" class="btn btn-lg btn-danger" onclick="window.location.href='canCarteira.php'">Cancelar carteira</button>
                <button type="submit" class="btn btn-lg btn-success">Finalizar carteira</button>
            </form>
        </div>
    </div>



</div>
</body>
</html>