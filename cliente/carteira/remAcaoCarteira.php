<?php
    require_once "../../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    $r = $db->prepare("DELETE FROM carteira_acao WHERE idCarteira=? AND idAcao=?");
    $r->execute(array($_SESSION['idCarteira'],base64_decode($_GET['idAcao'])));
    $_SESSION['msg'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Ação ".base64_decode($_GET['idAcao'])." removida da carteira!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    header("location: tela2.php");
?>