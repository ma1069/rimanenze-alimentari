<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

    $id = $_GET['pid'];

    $prenotati = $DB->fetch("
        SELECT COUNT(*) Qta FROM prodotti 
        WHERE stato = 'PRE' AND id_negozio = :userid
    ", array(
        'userid' => $User->id    
    ))[0]['Qta'];

    $disponibili = $DB->fetch("
        SELECT COUNT(*) Qta FROM prodotti
        WHERE stato = 'DIS' AND id_negozio = :userid
    ", array(
        'userid' => $User->id
    ))[0]['Qta'];

    $prod = $DB->fetch("
        SELECT id, pubblicazione, id_negozio, descrizione, fresco, stato, quantita, id_tipo, data_scadenza
        FROM prodotti WHERE id=:id
    ", array(
        ':id' => $id,
    ))[0];

    $info = array(
        'username' => $User->name,  
        'inritiro' => $prenotati,
        'disponibili' => $disponibili,
        'activeP' => 3,
        'prodotto' => $prod
    );

    $Twig->render('pages/edt_prodotto.twig', $info);
    $Base->bye();
