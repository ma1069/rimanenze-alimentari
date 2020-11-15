<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

    if ($User->type !== "NEG" &&
        $User->type !== "UTE" &&
	$User->type !== "ADM")  {
        header('location: login.php');
        die;
    }

    if ($User->type == "NEG") {
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
            SELECT id, nome, icona, unita_misura, theme FROM tipi_prodotti
        ");

        $info = array(
            'username' => $User->name,  
            'inritiro' => $prenotati,
            'disponibili' => $disponibili,
            'activeP' => 1,

            'prodotti' => $prodotti,
        );
        
        $Twig->render('pages/inserisci_step1.twig', $info);
    } else if ($User->type == "UTE") {
        $prenotati = $DB->fetch("
            SELECT COUNT(*) Qta FROM prodotti 
            WHERE stato = 'PRE' AND id_utente = :userid
        ", array(
            'userid' => $User->id    
        ))[0]['Qta'];
        
        $prodotti = $DB->fetch("
            SELECT tp.id, nome, icona, count(DISTINCT prodotti.id) qta, theme FROM tipi_prodotti tp
                LEFT JOIN prodotti ON prodotti.id_tipo = tp.id AND prodotti.stato = 'DIS' AND (data_scadenza > NOW() OR data_scadenza IS NULL)
                GROUP BY tp.id
        ");
        
        $info = array (
            'username' => $User->name,
            'inritiro' => $prenotati,
            'activeP' => 1,
            
            'prodotti' => $prodotti,
        );
        $Twig->render('pages/trova_dash.twig', $info);
    } else if ($User->type == "ADM") {
        $negozi = $DB->fetch("
            SELECT id, nome FROM utenti WHERE tipo='NEG'
        ");
	$aziende = $DB->fetch("
	    SELECT id, nome FROM utenti WHERE tipo='UTE'
	");

	$Twig->render('pages/adm_lista.twig', array(
	    'negozi' => $negozi,
	    'aziende' => $aziende,
	));
    }

    $Base->bye();
