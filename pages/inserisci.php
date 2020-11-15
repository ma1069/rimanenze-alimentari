<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

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

    $prod_id = $_GET['prodotto'];

    $prodotto = $DB->fetch("
        SELECT id, nome, icona, unita_misura FROM tipi_prodotti
        WHERE id = :prid
    ", array(
        'prid' => $prod_id,
    ))[0];

    $info = array(
        'username' => $User->name,  
        'inritiro' => $prenotati,
        'disponibili' => $disponibili,
        'activeP' => 1,
        
        'prodotto' => $prodotto,
    );


    $Twig->render('pages/inserisci_step2.twig', $info);
    
    $Base->bye();
