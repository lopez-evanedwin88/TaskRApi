<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
                    // Business Logic of the endpoint here....
					$this->load->view('welcome_message');
					$this->load->view('users', array('users' => $this->db->get('user')->result()));
                    return $this->sendJson(array("response" => "API End point accessed successfuly !", "status" => 200));
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

	private function sendJson($data)
    {
        $this->output->set_header('Content-Type: application/json; charset=utf-8')->set_output(json_encode($data));
    }
}
