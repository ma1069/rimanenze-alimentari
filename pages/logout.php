<?php
  require_once dirname(__FILE__).'/../lib/_main.php';

  session_destroy();
  header('Location: login.php');

  $Base->bye();
