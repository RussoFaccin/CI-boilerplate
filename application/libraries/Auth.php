<?php

class Auth {
    public static function check() {
        $app = get_instance();
        // Load [session] Library
        $app->load->library('session');
        $sessionData = $app->session->tempdata('credentials');
        $expiration = $app->config->item('authentication')['timeOut'];

        if (!isset($sessionData)) {
            $redirectUrl = $app->config->item('authentication')['redirectTo'];
            // Load [url] Helper
            $app->load->helper('url');

            redirect(base_url($redirectUrl), 'location', 301);
        } else {
            $app->session->set_tempdata('credentials', $sessionData, $expiration);
        }
    }

    public static function authenticate($user) {
        $app = get_instance();
        
        $sessionData = array(
            'isLoggedIn' => true,
            'user' => $user
        );

        $expiration = $app->config->item('authentication')['timeOut'];
        // Load [session] Library
        $app->load->library('session');
        $app->session->set_tempdata('credentials', $sessionData, $expiration);
        return true;
    }

    public function logout() {
        $app = get_instance();
        // Load [session] Library
        $app->load->library('session');
        $app->session->unset_tempdata('credentials');
        // Load [url] helper
        $app->load->helper('url');
        redirect(base_url($redirectUrl), 'location', 301);
    }
}