<?php
    require_once dirname(__FILE__).'/../../lib/_main.php';

    $id = $_GET['pid'];

    $DB->run("
        UPDATE prodotti 
            SET stato='RIT'
        WHERE id=:pid AND stato='PRE' and id_utente = :uid
    ", array(
        ':uid' => $User->id,
        ':pid' => $id,
    ));

    header('location: ../list_prenotati.php');
    $Base->bye();
