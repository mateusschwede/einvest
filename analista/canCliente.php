<?php
    require_once "../conect.php";
    session_start();
    if((empty($_SESSION['nome'])) or (empty($_SESSION['senha']))) {header("location: index.php");}

    $r = $db->prepare("DELETE FROM cliente WHERE cpf=?");
    $r->execute(array(base64_decode($_GET['cpf'])));
    $_SESSION['msg'] = "<br><div class='alert alert-success alert-dismissible fade show' role='alert'>Cliente Cpf ".base64_decode($_GET['cpf'])." removido!<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    header("location: index.php");
?>