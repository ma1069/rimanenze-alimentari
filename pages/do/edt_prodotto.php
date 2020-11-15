<?php
    require_once dirname(__FILE__).'/../../lib/_main.php';

    $id = $_POST['id'];
    $desc = $_POST['desc'];
    $qta = $_POST['qta'];
    $scad = $_POST['scad'];
    if (isset($_POST['fresco']) && $_POST['fresco']=='on') {
        $fresco = true;
    } else {
        $fresco = false;   
    }

    $DB->run("UPDATE prodotti
        SET descrizione = :desc, quantita = :qta, data_scadenza = STR_TO_DATE(:scad, '%d/%c/%Y'), fresco = :fresco
        WHERE id = :id and id_negozio = :id_neg and stato = 'DIS'
    ", array(
        ':id' => $id,
        ':desc' => $desc,
        ':qta' => $qta,
        ':scad' => $scad,
        ':fresco' => $fresco,
        ':id_neg' => $User->id,
    ));
    
    header('location: ../list_pubblicati.php');
    $Base->bye();
