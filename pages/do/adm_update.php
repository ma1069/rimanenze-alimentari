<?php
    require_once dirname(__FILE__).'/../../lib/_main.php';

    if ($User->type != 'ADM') {
        die();
    }
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $addr = $_POST['addr'];
    $tipo = $_POST['tipo'];
    $pass = $_POST['pass'];
   
    if ($id != "") {
	$DB->run("UPDATE utenti SET nome = :nome, indirizzo = :addr, tipo = :tipo WHERE id = :id", array(
		':id' => $id,
		':nome' => $nome,
		':addr' => $addr,
		':tipo' => $tipo,
	));
	if (strlen($pass) > 0) {
		$DB->run("UPDATE utenti SET email = :email, password = MD5(CONCAT(MD5(:pass), :email)) WHERE id = :id", array (
			':id' => $id,
			':email' => $email,
			':pass' => $pass,
		));
	}
    } else {
	$DB->run("INSERT INTO utenti (nome, cognome, email, password, indirizzo, tipo)
		VALUES (:nome, '', :email, MD5(CONCAT(MD5(:pass), :email)), :addr, :tipo)
	", array (
		':nome' => $nome,
		':email' => $email,
		':pass' => $pass,
		':addr' => $addr,
		':tipo' => $tipo,
	));
    }
    header('location: ../page.php');
    $Base->bye();
