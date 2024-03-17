<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TaskRecord extends CI_Controller {

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
					$tasks = $this->db->get('task_record')->result();
                    return $this->sendJson(array("data" => $tasks, "status" => 200, "response" => "Successfully get all task records"));
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

    public function getTaskRecords($id = NULL)
	{
		$headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                if ($this->input->method() === 'get') {
                    $query = $this->db->get_Where('task_record', array('task_id'=> (int) $id));
                    $task_records = $query->result();

                    return $this->sendJson(array("data" => $task_records, "status" => 200, "response" => "Successfully retrieve task records"));
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

    public function insertTaskRecord()
	{
		$headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                if ($this->input->method() === 'post') {
                    $task_id = $this->input->post('task_id');
                    $message = $this->input->post('message');
                    $image_url = $this->input->post('image_url');

                    $task_record = array(
                        'task_id' => $task_id,
                        'message' => $message,
                        'image_url' => $image_url,
                    );

                    $this->db->insert('task_record', $task_record);

                    return $this->sendJson(array("status" => 200, "response" => "Successfully added a task record"));
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
