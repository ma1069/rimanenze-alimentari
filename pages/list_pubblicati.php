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

    $disps = $DB->fetch("
        SELECT  PP.id, P.icona, P.nome prodotto, PP.quantita, 
                P.unita_misura, IF(PP.fresco,1,0) fresco, 
                PP.descrizione, PP.data_scadenza,
                IF (DATE_SUB(PP.data_scadenza, INTERVAL 7 DAY) < NOW(), 1, 0) ultima_sett
        FROM prodotti PP
            INNER JOIN tipi_prodotti P ON P.id = PP.id_tipo
        WHERE stato = 'DIS' AND id_negozio = :userid
		AND (PP.data_scadenza > NOW() OR PP.data_scadenza IS NULL)
    ", array(
        'userid' => $User->id
    ));

    $exps = $DB->fetch("
        SELECT  PP.id, P.icona, P.nome prodotto, PP.quantita, 
                P.unita_misura, IF(PP.fresco,1,0) fresco, 
                PP.descrizione, PP.data_scadenza,
                IF (DATE_SUB(PP.data_scadenza, INTERVAL 7 DAY) < NOW(), 1, 0) ultima_sett
        FROM prodotti PP
            INNER JOIN tipi_prodotti P ON P.id = PP.id_tipo
        WHERE stato = 'DIS' AND id_negozio = :userid
		AND PP.data_scadenza <= NOW()
    ", array(
        'userid' => $User->id
    ));

    $info = array(
        'username' => $User->name,  
        'inritiro' => $prenotati,
        'disponibili' => $disponibili,
        'activeP' => 3,
        'disponibili_prods' => $disps,
	'scaduti_prods' => $exps,
    );

    $Twig->render('pages/list_pubblicati.twig', $info);
    
    $Base->bye();
