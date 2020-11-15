<?php
    require_once dirname(__FILE__).'/../../lib/_main.php';

    $id = $_GET['pid'];

    $DB->run("UPDATE prodotti
        SET stato = 'XXX' where stato='DIS' and id=:id
    ", array(
        ':id' => $id,
    ));

    header('location: ../list_pubblicati.php');
    $Base->bye();
