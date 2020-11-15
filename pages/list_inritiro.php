<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

    if ($User->type !== "NEG") {
        header('location: login.php');
        die;
    }

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

    $inritiro = $DB->fetch("
        SELECT  P.icona, P.nome prodotto, PP.quantita, 
                P.unita_misura, U.nome azienda, if(PP.fresco,1,0) fresco, 
                PP.descrizione, PP.data_scadenza, PP.data_ritiro,
                IF (DATE_SUB(PP.data_scadenza, INTERVAL 7 DAY) < NOW(), 1, 0) ultima_sett,
                U.email
        FROM prodotti PP
            INNER JOIN tipi_prodotti P ON P.id = PP.id_tipo
            INNER JOIN utenti U ON PP.id_utente = U.id
        WHERE stato = 'PRE' AND id_negozio = :userid
    ", array(
        'userid' => $User->id
    ));

    $info = array(
        'username' => $User->name,  
        'inritiro' => $prenotati,
        'disponibili' => $disponibili,
        'activeP' => 2,
        
        'inritiro_prods' => $inritiro
    );

    $Twig->render('pages/list_inritiro.twig', $info);
    
    $Base->bye();
