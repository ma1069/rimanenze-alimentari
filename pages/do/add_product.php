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

//Interpreta data
    if ($scad != '') {
      $data = date_parse_from_format("j/n/Y", $scad);
      $scad = mktime(
        $data['hour'],
        $data['minute'],
        $data['second'],
        $data['month'],
        $data['day'],
        $data['year']
      );
    }
    
    $DB->run("INSERT INTO prodotti
        (pubblicazione, id_negozio, descrizione, fresco, stato, quantita, id_tipo, data_scadenza)
    VALUES
        (NOW(), :id_neg, :desc, :fresco, 'DIS', :qta, :id, from_unixtime($scad))
    ", array(
        ':id' => $id,
        ':desc' => $desc,
        ':qta' => $qta,
        ':fresco' => $fresco,
        ':id_neg' => $User->id,
    ));

    header('location: ../list_pubblicati.php');
    $Base->bye();
