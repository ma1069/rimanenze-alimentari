<?php
    require_once dirname(__FILE__).'/../../lib/_main.php';

    $id = $_GET['pid'];

    $qta = $_POST['amount'];
    $max_qta = $_POST['max_amount'];
    $ritiro = $_POST['ritiro'];
    $note = $_POST['note'];

    //Interpreta data
    $data = date_parse_from_format("j/n/Y H:i", $ritiro);
    $data = mktime(
     $data['hour'],
     $data['minute'],
     $data['second'],
     $data['month'],
     $data['day'],
     $data['year']
    );

    /*ar_dump($User->id);
    var_dump($id);
    var_dump(" UPDATE prodotti
            SET id_utente = :uid, data_ritiro = from_unixtime($data), stato='PRE'
        WHERE id=:pid AND stato='DIS'");
    die;*/
    //27/01/2016 11:20    
    //Caso facile. Le quantitá sono uguali
    $DB->run("
        UPDATE prodotti 
            SET id_utente = :uid, data_ritiro = from_unixtime($data), stato='PRE'
        WHERE id=:pid AND stato='DIS'
    ", array(
        ':uid' => $User->id,
        ':pid' => $id,
    ));

    if (abs(floatval($qta) - floatval($max_qta)) > 0.01) {
        //Complicato. Duplica la riga, marcane una come prenotata e l'altra come disponibile con le rimanenze
        $DB->run("UPDATE prodotti SET quantita = :qta WHERE id=:pid", array(
            ':qta' => $qta,
            ':pid' => $id,
        ));
        $DB->run("
            INSERT INTO prodotti (pubblicazione, id_negozio, descrizione, fresco, stato, quantita, id_tipo, data_scadenza)
            SELECT pubblicazione, id_negozio, descrizione, fresco, 'DIS', :qta, id_tipo, data_scadenza
            FROM prodotti WHERE id = :pid
        ", array(
            ':qta' => floatval($max_qta) - floatval($qta),
            ':pid' => $id,
        ));
    }

    header('location: ../list_prenotati.php');
    $Base->bye();
