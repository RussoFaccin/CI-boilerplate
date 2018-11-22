<?php

class Auth {
    public static function check() {
        $app = get_instance();
        $sessionData = $app->session->tempdata('credentials');
        $expiration = $app->config->item('authentication')['timeOut'];

        if (!isset($sessionData)) {
            $redirectUrl = $app->config->item('authentication')['redirectTo'];
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
        $app->session->set_tempdata('credentials', $sessionData, $expiration);
    }

    public function logout() {
        $app = get_instance();
        $app->session->unset_tempdata('credentials');
        redirect(base_url($redirectUrl), 'location', 301);
    }
}