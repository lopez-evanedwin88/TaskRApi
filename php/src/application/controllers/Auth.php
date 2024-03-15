<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function login() {
        // Dummy authentication
        $token = "dummy_token";

        $response = array(
            'status' => true,
            'message' => 'Login successful',
            'token' => $token
        );

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($response));
    }
}