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
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="cliente.php">Perfil</a></li>
                            <li class="nav-item"><a class="nav-link" href="../logout.php" id="logout"><?=$_SESSION['nome']?>-logout</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-8">
            <?php if($_SESSION['msg']!=null){echo $_SESSION['msg']; $_SESSION['msg']=null;} ?>
            <h1>Carteiras de <?=$_SESSION['nome']?></h1>
            <a href="carteira/tela1.php" class="btn btn-primary">Adicionar carteira</a>

            <?php
                $r = $db->prepare("SELECT cpf FROM cliente WHERE nome=? AND senha=?");
                $r->execute(array($_SESSION['nome'],$_SESSION['senha']));
                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                foreach($linhas as $l) {$cpf = $l['cpf'];}

                $r = $db->prepare("SELECT * FROM carteira WHERE cpfCliente=?");
                $r->execute(array($cpf));
                if($r->rowCount()>0) {
                    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                    foreach($linhas as $l) {
                        $precoInvestimento = number_format($l['precoInvestimento'],2);
                        echo "
                            <h4>Carteira ".$l['id']."</h4>
                            <p>".$l['nome']."</p>
                            <p><b>Investimento:</b> R$ ".$precoInvestimento."</p>
                            <h5>Ações:</h5>
                        ";
                        
                        $r = $db->prepare("SELECT * FROM carteira_acao WHERE idCarteira=?");
                        $r->execute(array($l['id']));
                        $linhas2 = $r->fetchAll(PDO::FETCH_ASSOC);
                        foreach($linhas2 as $l2) {
                            $percentual = $l2['percentual'];
                            $r = $db->prepare("SELECT * FROM acao WHERE id=?");
                            $r->execute(array($l2['idAcao']));
                            $linhas3 = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach($linhas3 as $l3) {$nomeAcao = $l3['nome']; $preco = number_format($l3['preco'],2);}
                        }
                        echo "
                            <p><b>(".strtoupper($l3['codigo']).") ".$l3['nome']."(R$ ".$preco."):</b> ".$percentual."% (precoPercentual aqui)</p>
                            <h6>Recomendação de compra aqui</h6>
                            <p>Botão Investir aqui</p>
                            <hr>
                        ";
                    }
                } else {echo "<p class='text-muted'>Não há carteiras cadastradas</p>";}
            ?>
        </div>


        <div class="col-sm-4">
            <div class="accordion" id="listaAcoes">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="lista1">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Ver todas ações</button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="lista1" data-bs-parent="#listaAcoes">
                        <div class="accordion-body">
                            <?php
                                $r = $db->query("SELECT codigo,nome,preco FROM acao ORDER BY codigo");
                                $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                                foreach($linhas as $l) {echo "<p>(".strtoupper($l['codigo']).") ".$l['nome'].": R$ ".number_format($l['preco'],2)."</p>";}
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
</body>
</html>