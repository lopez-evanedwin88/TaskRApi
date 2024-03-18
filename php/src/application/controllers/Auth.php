<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct($config = "rest")
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding,Authorization");
        parent::__construct();
    }

    public function login()
    {
        if ($this->input->method() === 'post') {
            $email = $this->input->post('staff_id');
            $password = $this->input->post('password');

            $this->db->select('id, staff_id, roles');
            $query = $this->db->get_Where('user', array('staff_id'=> (string) $email, 'password' => (string) $password));

            if (!empty($query->row())) {
                $user = $query->row();
                $token_data['id'] = $user->id;
                $token_data['staff_id'] = $user->staff_id;
                $token_data['role'] = $user->roles;
                $tokenData = $this->authorization_token->generateToken($token_data);
                $token_data['token'] = $tokenData;
                return $this->sendJson(array("user"=> $token_data,"token" => $tokenData, "status" => true, "response" => "Login Success!"));
            } else {
                return $this->sendJson(array("token" => null, "status" => false, "response" => "Login Failed!"));
            }
        } else {
            return $this->sendJson(array("message" => "POST Method", "status" => false));
        }
    }

    private function sendJson($data)
    {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')->set_output(json_encode($data));
    }
}