<?php

class User_model extends CI_Model {
    public $username;
    public $email;
    public $login;
    public $pass;
    public function __construct() {

    }

    public function newUser($username, $email, $login, $pass) {
        // Connect to DB
        $this->load->database();
        // Insert user
        $sql = "
        INSERT INTO `users` (`id`, `username`, `email`, `login`, `password`)
        VALUES(
            NULL,
            ?,
            ?,
            ?,
            ?
        );
    ";
    $query = $this->db->query($sql, array($username, $email, $login, $pass));
    }
}