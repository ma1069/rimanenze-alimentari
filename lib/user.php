<?php

class UserObj {
    public $id;
    public $name;
    public $type;
    public $logged;

    private $DB;

    function init($mode, $DB) {
        session_start();

        $this->DB = $DB;

        if (!isset($_SESSION['name'])) {
            $this->id = 0;
            $this->name = 'guest';
            $this->type = 'GST';
            $this->logged = false;
        } else {
            $this->id = $_SESSION['id'];
            $this->name = $_SESSION['name'];
            $this->type = $_SESSION['type'];
            $this->logged = true;
        }
    }

    function logout() {
        $this->id = 0;
        $this->name = 'guest';
        $this->type = 'GST';
        $this->logged = false;

        $_SESSION['id'] = $this->id;
        $_SESSION['name'] = $this->name;
        $_SESSION['type'] = $this->type;
        session_destroy ();
    }
    function login($user, $pass) {
        $res = $this->DB->fetch(
            "SELECT id, nome, tipo, pass FROM utenti WHERE email = :user", 
            [ 'user' => $user ]);

        if (count($res) > 0) {

            if (!password_verify($pass, $res[0]['pass'])) {
                return false;
            }

            $this->id = $res[0]['id'];
            $this->name = $res[0]['nome'];
            $this->type = $res[0]['tipo'];
            $_SESSION['id'] = $this->id;
            $_SESSION['name'] = $this->name;
            $_SESSION['type'] = $this->type;

            return true;
        } else {
            //Useless code - just to keep elab times even. Further elabs are just to prevent any optimizer to remove this code
            if (password_verify($pass ,'$2y$10$WJnUKUevNcF7KG3RTIUbU.m0QVvTlJt4vdGelOTbHbSNb.xugk0Gm')) {
                $x = $user . 'x' . $pass;
            } else {
                $x = 'x' . $pass;
            }

            $this->id = ($x == '?' ? true : null);
        }

        return false;
    }

    function close() { }
}

$User = new UserObj();
