<?php
    require_once "conect.php";
    $msg = null;

    if((!empty($_POST['nome'])) and (!empty($_POST['senha']))) {
        $r = $db->prepare("SELECT id FROM analista WHERE nome=? AND senha=?");
        $r->execute(array($_POST['nome'],$_POST['senha']));
        $r2 = $db->prepare("SELECT cpf FROM cliente WHERE nome=? AND senha=?");
        $r2->execute(array($_POST['nome'],$_POST['senha']));
        
        if($r->rowCount()>0) {
            session_start();
            $_SESSION['nome'] = $_POST['nome'];
            $_SESSION['senha'] = $_POST['senha'];
            $_SESSION['msg'] = null;
            header("location: analista/index.php");
        } else if($r2->rowCount()>0) {
            $r = $db->prepare("SELECT email FROM cliente WHERE nome=? AND senha=?");
            $r->execute(array($_POST['nome'],$_POST['senha']));
            $linhas = $r->fetchAll(PDO::FETCH_ASSOC);
            foreach($linhas as $l) {$email = $l['email'];}
            if($email == null) {
                session_start();
                $_SESSION['nome'] = $_POST['nome'];
                $_SESSION['senha'] = $_POST['senha'];
                $_SESSION['msg'] = null;
                header("location: cliente/primeiroAcesso.php");
            } else {
                session_start();
                $_SESSION['nome'] = $_POST['nome'];
                $_SESSION['senha'] = $_POST['senha'];
                $_SESSION['msg'] = null;
                header("location: cliente/index.php");
            }
        } else {$msg = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Dado(s) incorreto(s)!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>EInvest</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="shortcut icon" href="https://img.icons8.com/color/48/000000/technical-support.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div class="container-fluid">


    <div class="row">
        <div class="col-sm-12 text-center">
            <h1>EInvest</h1>
            <h4 class="text-muted">Software de recomendações de compras de ações</h4>
            <form action="index.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="nome" required name="nome" maxlength="60" style="text-transform:lowercase;">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="senha" required name="senha" maxlength="5" style="text-transform:lowercase;">
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Entrar</button>
            </form>
            <?php if($msg!=null){echo $msg; $msg=null;}?>
            <br>
            <a href="analista/addAnalista.php" class="btn btn-secondary btn-sm">Novo analista</a>
        </div>
    </div>


</div>
</body>
</html>