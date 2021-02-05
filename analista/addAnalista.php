<?php
    require_once "../conect.php";
    session_start();

    if((!empty($_POST['nome'])) and (!empty($_POST['termo'])) and (!empty($_POST['senha']))) {
        $r = $db->prepare("SELECT * FROM analista WHERE nome=? AND senha=?");
        $r->execute(array($_POST['nome'],$_POST['senha']));
        if(($r->rowCount()==0) and ($_POST['termo']=="admin")) {
            $r = $db->prepare("INSERT INTO analista(nome,senha) VALUES (?,?)");
            $r->execute(array($_POST['nome'],$_POST['senha']));
            $_SESSION['msg'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Analista adicionado!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        } else {$_SESSION['msg'] = "<br><div class='alert alert-danger alert-dismissible fade show' role='alert'>Dado(s) inválido(s)!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";}
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
            <h1>Novo analista</h1>
            <form action="addAnalista.php" method="post">
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="nome" required name="nome" maxlength="60" style="text-transform:lowercase;">
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="termo" required name="termo" maxlength="5" style="text-transform:lowercase;">
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="senha" required name="senha" maxlength="5" style="text-transform:lowercase;">
                </div>
                <button type="button" class="btn btn-danger" onclick="window.location.href='../index.php'">Voltar</button>
                <button type="submit" class="btn btn-success">Adicionar</button>
            </form>
        </div>
    </div>


</div>
</body>
</html>