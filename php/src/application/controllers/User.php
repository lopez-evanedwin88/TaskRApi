<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	 public function __construct($config = "rest")
	 {
		 header("Access-Control-Allow-Origin: *");
		 header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
		 header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding,Authorization");
		 parent::__construct();
	 }

	public function index()
	{
		$headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                if ($this->input->method() === 'get') {
					$users = $this->db->get('user')->result();
                    return $this->sendJson(array("data" => $users, "status" => 200, "response" => "Successfully all users"));
                } else {
                    return $this->sendJson(array("response" => "GET Method", "status" => false));
                }
            } else {
                return $this->sendJson(array("status" => false, "response" => "Invalid Token"));
            }
        } else {
            return $this->sendJson(array("status" => true, "response" => "Token Required"));
        }
	}

    public function getUser($id = NULL)
	{
		$headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                if ($this->input->method() === 'get') {
                    $query = $this->db->get_Where('user', array('id'=> (int) $id));
					$user = $query->row();
                    return $this->sendJson(array("data" => $user, "status" => 200, "response" => "Successfully get user"));
                } else {
                    return $this->sendJson(array("response" => "GET Method", "status" => false));
                }
            } else {
                return $this->sendJson(array("status" => false, "response" => "Invalid Token"));
            }
        } else {
            return $this->sendJson(array("status" => true, "response" => "Token Required"));
        }
	}

    public function insertUser()
	{
		$headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                if ($this->input->method() === 'post') {
                    $first_name = $this->input->post('first_name');
                    $last_name = $this->input->post('last_name');
                    $password = $this->input->post('password');
                    $email = $this->input->post('email');
                    $gender = $this->input->post('gender');
                    $roles = $this->input->post('roles');

                    $data = array(
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'password' => $password,
                        'email' => $email,
                        'gender' => $gender,
                        'roles' => $roles
                    );

                    $this->db->insert('user', $data);
                    $new_id =  $this->db->insert_id();
                    $this->db->where('id', $new_id);
                    $this->db->update('user', array('staff_id' => sprintf("%03d", $new_id)));

                    return $this->sendJson(array("status" => 200, "response" => "Successfully created a user"));
                } else {
                    return $this->sendJson(array("response" => "POST Method", "status" => false));
                }
            } else {
                return $this->sendJson(array("status" => false, "response" => "Invalid Token"));
            }
        } else {
            return $this->sendJson(array("status" => true, "response" => "Token Required"));
        }
	}

	private function sendJson($data)
    {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')->set_output(json_encode($data));
    }
}
