<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

    $prenotati = $DB->fetch("
        SELECT COUNT(*) Qta FROM prodotti 
        WHERE stato = 'PRE' AND id_utente = :userid
    ", array(
        'userid' => $User->id    
    ))[0]['Qta'];

    $prodotti = $DB->fetch("     
        SELECT  PP.id, PP.quantita, PP.descrizione, PP.data_scadenza, PP.data_ritiro, if(PP.fresco,1,0) fresco, 
                IF (DATE_SUB(PP.data_scadenza, INTERVAL 7 DAY) < NOW(), 1, 0) ultima_sett,
                PP.stato,
                P.icona, P.nome prodotto, P.unita_misura,
                N.nome negozio, A.nome azienda, N.id negId,
                distanza
        FROM prodotti PP
            INNER JOIN tipi_prodotti P ON P.id = PP.id_tipo
            INNER JOIN utenti N ON PP.id_negozio = N.id
            LEFT JOIN  utenti A ON PP.id_utente = A.id
            LEFT JOIN distanze D ON D.id_negozio = N.id AND D.id_azienda = :uid
        WHERE id_utente = :uid AND stato = 'PRE'
        ORDER BY PP.data_ritiro
    ", array(
        'uid' => $User->id,
    ));
    
    $Twig->render('pages/list_prenotati.twig', array(
        'username' => $User->name,
        'inritiro' => $prenotati,
        'activeP' => 3,
        
        'prodotti' => $prodotti
    ));
    
