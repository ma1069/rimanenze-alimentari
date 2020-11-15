<?php
  require_once dirname(__FILE__).'/../vendor/autoload.php';
  include_once(dirname(__FILE__).'/database.php');
  include_once(dirname(__FILE__).'/user.php');
  include_once(dirname(__FILE__).'/templates.php');

  class BaseObj
  {
    const MODE = "DEBUG";

    private $twig;
    private $db;
    private $user;

    function init($twig, $db, $user) {
      $this->twig = $twig;
      $this->db = $db;
      $this->user = $user;

      $this->twig->init(self::MODE, $this->user);
      $this->db->init(self::MODE);
      $this->user->init(self::MODE, $this->db);
    }
    function bye() {
      $this->twig->close();
      $this->db->close();
      $this->user->close();
    }
  }
  $Base = new BaseObj();
  $Base->init($Twig, $DB, $User);
