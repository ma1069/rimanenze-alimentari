<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

    $pid = $_GET['id'];

    $prenotati = $DB->fetch("
        SELECT COUNT(*) Qta FROM prodotti 
        WHERE stato = 'PRE' AND id_utente = :userid
    ", array(
        'userid' => $User->id    
    ))[0]['Qta'];

    $prodotto = $DB->fetch("     
        SELECT  PP.id, PP.quantita, PP.descrizione, PP.data_scadenza, PP.data_ritiro, if(PP.fresco,1,0) fresco, 
                IF (DATE_SUB(PP.data_scadenza, INTERVAL 7 DAY) < NOW(), 1, 0) ultima_sett,
                PP.stato,
                P.icona, P.nome prodotto, P.unita_misura,
                N.nome negozio, A.nome azienda,
                distanza
        FROM prodotti PP
            INNER JOIN tipi_prodotti P ON P.id = PP.id_tipo
            INNER JOIN utenti N ON PP.id_negozio = N.id
            LEFT JOIN  utenti A ON PP.id_utente = A.id
            LEFT JOIN distanze D ON D.id_negozio = N.id AND D.id_azienda = :uid
        WHERE PP.id = :id
    ", array(
        'id' => $pid,
        'uid' => $User->id,
    ))[0];
    
    $Twig->render('pages/prenota.twig', array(
        'username' => $User->name,
        'inritiro' => $prenotati,
        'activeP' => 1,
        
        'prodotto' => $prodotto
    ));
    
    $Base->bye();
