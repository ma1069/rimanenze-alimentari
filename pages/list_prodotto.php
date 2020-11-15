<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

    $cat = $_GET['cat'];

    $categoria = $DB->fetch("
        SELECT nome FROM tipi_prodotti WHERE id = :pid
    ", array(
        'pid' => $cat,
    ))[0]['nome'];

    $prenotati = $DB->fetch("
        SELECT COUNT(*) Qta FROM prodotti 
        WHERE stato = 'PRE' AND id_utente = :userid
    ", array(
        'userid' => $User->id    
    ))[0]['Qta'];
        

    $prodotti = $DB->fetch("     
        SELECT  PP.id PPid, P.icona, P.nome prodotto, PP.quantita, 
                P.unita_misura, U.nome azienda, if(PP.fresco,1,0) fresco, 
                PP.descrizione, PP.data_scadenza, PP.data_ritiro,
                IF (DATE_SUB(PP.data_scadenza, INTERVAL 7 DAY) < NOW(), 1, 0) ultima_sett,
                distanza, U.id negId
        FROM prodotti PP
            INNER JOIN tipi_prodotti P ON P.id = PP.id_tipo
            INNER JOIN utenti U ON PP.id_negozio = U.id
            LEFT JOIN distanze D ON D.id_negozio = U.id AND D.id_azienda = :uid
        WHERE stato = 'DIS' AND id_tipo = :tid AND (data_scadenza > NOW() OR data_scadenza IS NULL)
    ", array(
        'tid' => $cat,
        'uid' => $User->id,
    ));

    $Twig->render('pages/list_prodotto.twig', array(
        'username' => $User->name,
        'inritiro' => $prenotati,
        'activeP' => 1,
        
        'titolo' => $categoria,
        'prodotti' => $prodotti,
    ));
    
    $Base->bye();
