<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Task extends CI_Controller {

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
					$tasks = $this->db->get('task')->result();
                    return $this->sendJson(array("data" => $tasks, "status" => 200, "response" => "Successfully get all tasks"));
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

    public function getTaskbyUser($id = NULL)
	{
		$headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                if ($this->input->method() === 'get') {
                    $query = $this->db->get_Where('user', array('id'=> (int) $id));
					$user = $query->row();
                    $tasks = "";

                    $this->db->select('task.id, task.title, task.description, task.assignee_id, task.client_id, task.start_date, task.due_date, task.status, GROUP_CONCAT(task_record.image_url) AS medias');
                    $this->db->from('task');
                    $this->db->join('task_record', 'task.id = task_record.task_id', 'left');

                    if((string) $user->roles == "Client") {
                        $this->db->where('task.client_id', (string) $user->staff_id);
                    } else if ((string) $user->roles == "Staff") {
                        $this->db->where('task.assignee_id', (string) $user->staff_id);
                    } // else default Admin

                    $this->db->group_by('task.id');
                    $query = $this->db->get();
                    $tasks = $query->result_array();

                    return $this->sendJson(array("data" => $tasks, "status" => 200, "response" => "Successfully get tasks"));
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

    public function insertTask()
	{
		$headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                if ($this->input->method() === 'post') {
                    $client_id = $this->input->post('client_id');
                    $start_date = $this->input->post('start_date') ? $this->input->post('start_date') : NULL;
                    $due_date = $this->input->post('due_date') ? $this->input->post('due_date') : NULL;
                    $title = $this->input->post('title');
                    $description = $this->input->post('description') ? $this->input->post('description') : NULL;
                    $status = $this->input->post('status');
                    $assignee_id = $this->input->post('assignee_id') ? $this->input->post('assignee_id') : NULL;

                    $message = $this->input->post('message') ? $this->input->post('message') : NULL;
                    $image_url = $this->input->post('image_url') ? $this->input->post('image_url') : NULL;

                    $task = array(
                        'client_id' => $client_id,
                        'start_date' => $start_date,
                        'due_date' => $due_date,
                        'title' => $title,
                        'description' => $description,
                        'status' => $status,
                        'assignee_id' => $assignee_id
                    );

                    $this->db->insert('task', $task);

                    if(!empty($description) || !empty($image_url)) {
                        $new_id =  $this->db->insert_id();
                        $task_record = array(
                            'task_id' => $new_id,
                            'message' => $description,
                            'image_url' => $image_url,
                        );
                        $this->db->insert('task_record', $task_record);
                    }
                    return $this->sendJson(array("status" => 200, "response" => "Successfully added a task"));
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
