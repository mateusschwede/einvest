<?php
    try {
        $db = new PDO('mysql:host=localhost;dbname=einvest;charset=utf8','root','');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $exception) {header("location: offline.php");}
?>