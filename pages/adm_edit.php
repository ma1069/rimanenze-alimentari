<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

    if ($User->type !== 'ADM') {
        die();
    }
    
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $id = "";
    }
    
    if ($id !== "") {
    	$utente = $DB->fetch("
    	    SELECT id, nome, email, indirizzo, tipo
    	    FROM utenti WHERE id=:id
    	", array(
    	    ':id' => $id,
   	))[0];
    } else {
        $utente = array(
	    'id' => '',
	    'nome' => '',
	    'email' => '',
	    'indirizzo' => '',
	    'tipo' => '',
	);
    }

    $Twig->render('pages/adm_edit.twig', $utente);
    $Base->bye();
