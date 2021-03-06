<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    function __construct() {
        parent::__construct();
        // Load [session] Library
        $this->load->library('session');
        // Load [url] Helper
        $this->load->helper('url');
		// Load dbforge
		$this->load->dbforge();
		// Fields
		$fields = array(
            'username' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'unique' => false
            ),
            'email' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'unique' => true
            ),
            'login' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'unique' => true
            ),
            'password' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'unique' => false
            )
        );
        // id field - primary key
        $this->dbforge->add_field('id', true);
        // Add fields
        $this->dbforge->add_field($fields);
        // Create table 'users' IF NOT EXISTS
		$this->dbforge->create_table('users', true);
    }
    // ROUTE: users/login
    public function login() {
        $message = $this->session->flashdata('message');
        $csrf = array(
            'name' => $this->security->get_csrf_token_name(),
            'hash' => $this->security->get_csrf_hash()
        );
        $data = array(
            'message' => $message,
            'csrf' => $csrf
        );
        $this->load->view('login-page', $data);
    }

    // ROUTE: users/auth
    public function auth() {
        if($this->input->method() == 'get') {
            die(show_404());
        }

        $user = $this->input->post('fld_user');
        $pass = $this->input->post('fld_pass');
        
        // Connect to DB
        $this->load->database();

        // Verify user
        $sql = "SELECT * FROM users WHERE login = ?";
        $query = $this->db->query($sql, array('login' => $user));

        if (!$query->result()) {
            redirectTo($this, 'users/login', 'Usuário não encontrado');
        }

        // Verify password
        $sql = "SELECT password FROM users WHERE login = ?";
        $query = $this->db->query($sql, array($user));
        $savedPass = $query->result()[0]->password;

        if (!password_verify($pass, $savedPass)) {
            redirectTo($this, 'users/login', 'Login ou Senha incorretos');
        }

        // Authenticate user
        // Load Auth Library
        $this->load->library('Auth');
        if ($this->auth->authenticate($user)) {
            // Redirect after login
            $redirectUrl = $this->session->userdata('redirectAfterLogin');
            redirect($redirectUrl);
        }
    }
    
    // ROUTE: users/register
    public function register() {
        if($this->input->method() == 'get') {
            $message = $this->session->flashdata('message');
            $csrf = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $data = array(
                'message' => $message,
                'csrf' => $csrf
            );
            $this->load->view('signin-page', $data);
        }

        if($this->input->method() == 'post') {
            $name = $this->input->post('fld_name');
            $mail = $this->input->post('fld_mail');
            $user = $this->input->post('fld_user');
            $pass = password_hash($this->input->post('fld_pass'), PASSWORD_BCRYPT);

            // Connect to DB
            $this->load->database();
            
            // CREATE TABLE IF NOT EXISTS
            $sql = "
                CREATE TABLE IF NOT EXISTS  `users` (
                    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                    `username` varchar(100) DEFAULT NULL,
                    `email` varchar(100) DEFAULT NULL,
                    `login` varchar(100) DEFAULT NULL,
                    `password` varchar(100) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;
            ";

            $query = $this->db->query($sql);

            // User model - newUser
            $this->load->model('User_model');
            $this->User_model->newUser($name, $mail, $user, $pass);
            redirectTo($this, '/');
        }
    }
    
    // ROUTE: users/logout
    public function logout() {
        // Load Auth Library
        $this->load->library('Auth');
        // Logout
		$this->auth->logout();
    }
}

function redirectTo($self, $route, $message = null) {
    $self->session->set_flashdata('message', $message);
    redirect(base_url($route), 'location', 301);
}