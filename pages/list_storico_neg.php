<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

    if (isset($_GET['off'])) {
        $off = max(intVal($_GET['off']),0);
    } else {
        $off = 0;
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

    $prodotti = $DB->fetch("     
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
            LEFT JOIN distanze D ON D.id_negozio = :aid AND D.id_azienda = N.id
        WHERE PP.id_negozio = :aid AND stato = 'RIT'
        ORDER BY PP.data_ritiro DESC
	LIMIT 10 OFFSET $off
    ", array(
        'aid' => $User->id,
    ));

    $info = array(
        'username' => $User->name,
        'inritiro' => $prenotati,
        'disponibili' => $disponibili,
        'activeP' => 4,
        'storico_prods' => $prodotti,
	'off' => $off
    ); 
    
    $Twig->render('pages/list_storico_neg.twig', $info);
    
