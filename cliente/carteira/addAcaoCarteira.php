<?php
    require_once "../../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    $r = $db->prepare("SELECT sum(percentual) FROM carteira_acao WHERE idCarteira=?");
    $r->execute(array($_SESSION['idCarteira']));
    $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
    foreach($linhas as $l) {
        if($l['sum(percentual)']==100) {
            $_SESSION['msg'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Percentual já é de 100%!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            header("location: tela2.php");
        }
    }

    if( (!empty($_POST['idAcao'])) and (!empty($_POST['percentual'])) ) {
        $r = $db->prepare("INSERT INTO carteira_acao(idCarteira,idAcao,percentual) VALUES (?,?,?)");
        $r->execute(array($_SESSION['idCarteira'],$_POST['idAcao'],$_POST['percentual']));
        $_SESSION['msg'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Ação ".$_POST['idAcao']." adicionada à carteira!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        header("location: tela2.php");
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
            <h2>Adicionar ação à carteira <?=$_SESSION['idCarteira']?>:</h2>
            <form action="addAcaoCarteira.php" method="post">
                <div class="mb-3">
                    <select class="form-select" aria-label="Default select example" required name="idAcao">
                        <?php
                            $r = $db->query("SELECT * FROM acao");
                            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                            foreach($linhas as $l) {
                                $r = $db->prepare("SELECT * FROM carteira_acao WHERE idAcao=? AND idCarteira=?");
                                $r->execute(array($l['id'],$_SESSION['idCarteira']));
                                if($r->rowCount()==0) {echo "<option value=".$l['id'].">(".strtoupper($l['codigo']).") ".$l['nome'].": R$ ".number_format($l['preco'],2)."</option>";}
                            }
                        ?>
                    </select>
                </div>
                <?php
                    $r = $db->prepare("SELECT sum(percentual) FROM carteira_acao WHERE idCarteira=?");
                    $r->execute(array($_SESSION['idCarteira']));                    
                    if($r->rowCount()>0) {
                        $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
                        foreach($linhas as $l) {$maxPercentual = 100-number_format($l['sum(percentual)'],2);}
                    } else {$maxPercentual=100;}
                ?>
                <div class="mb-3">
                    <input type="number" class="form-control" placeholder="percentual" required name="percentual" min="1" max="<?=$maxPercentual?>">
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='tela2.php'">Cancelar</button>
                <button type="submit" class="btn btn-success">Confirmar</button>
            </form>
        </div>
    </div>



</div>
</body>
</html>