<?php
    require_once dirname(__FILE__).'/../../lib/_main.php';

    $id = $_GET['pid'];
    
    //Caso facile. Le quantitá sono uguali
    $DB->run("
        UPDATE prodotti 
            SET stato='DIS'
        WHERE id=:pid AND stato='PRE' AND id_utente = :uid
    ", array(
        ':uid' => $User->id,
        ':pid' => $id,
    ));

    header('location: ../list_prenotati.php');
    $Base->bye();
