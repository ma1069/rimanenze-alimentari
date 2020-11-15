<?php
  require_once dirname(__FILE__).'/../lib/_main.php';

  if (isset($_GET['again'])) {
      $again = $_GET['again'];
  } else {
      $again = 0;
  }

  $Twig->render('pages/login.twig', array(
    'again' => $again,
  ));

  $Base->bye();
