<?php
    require_once dirname(__FILE__).'/../../lib/_main.php';

    $name = $_POST['mail'];
    $pass = $_POST['pass'];

    $res = $User->login($name, $pass);

    if ($res) {
        if ($User->type === "NEG" || $User->type == "UTE" || $User->type == "ADM") {
            header('location: ../page.php');
            die();
        }
    } else {
        header('location: ../login.php?again=1');
    }

    $Base->bye();
