<?php
    require_once dirname(__FILE__).'/../lib/_main.php';

    $id = $_GET['nid'];

    $azienda = $DB->fetch("
	SELECT nome, email, CONVERT(indirizzo USING utf8) indirizzo, CONVERT(orariApertura USING utf8) orariApertura
        FROM utenti WHERE tipo = 'NEG' and id=:id
    ", array(
        'id' => $id
    ));

    if (count($azienda) > 0) {
        $Twig->render('pages/show_negozio.twig', $azienda[0]);
    } else {
        echo "Wrong link";
    }
    $Base->bye();
