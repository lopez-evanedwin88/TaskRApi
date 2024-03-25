<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {
    public function __construct() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding,Authorization");
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    public function upload() {
        $headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                if ($this->input->method() === 'post') {
                    // Set upload configurations
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|jpeg|png|mp4|avi|mov';
                    $config['max_size'] = 21000; // Adjust max size as needed
                    $config['max_width'] = 8000; // Adjust max width as needed
                    $config['max_height'] = 8000; // Adjust max height as needed
            
                    $this->load->library('upload', $config);
            
                    if (!$this->upload->do_upload('media')) {
                        return $this->sendJson(array("response" => $this->upload->display_errors($open = '', $close = ''), "status" => false));
                    } else {
                         // If upload is successful, determine file type and move to appropriate directory
                        $upload_data = $this->upload->data();
                        $file_type = $upload_data['file_ext'];

                        if (in_array($file_type, array('.gif', '.jpg', '.jpeg', '.png'))) {
                            // Image file, move to images directory
                            $new_path = './uploads/images/';
                        } elseif (in_array($file_type, array('.mp4', '.avi', '.mov'))) {
                            // Video file, move to videos directory
                            $new_path = './uploads/videos/';
                        } else {
                            // Unsupported file type, delete uploaded file and return error message
                            unlink($upload_data['full_path']);
                            return $this->sendJson(array("response" => "Unsupported file type.", "status" => false));
                        }

                        // Move uploaded file to the appropriate directory
                        $new_file_path = $new_path . $upload_data['file_name'];
                        rename($upload_data['full_path'], $new_file_path);
                        $data['url'] = $upload_data['file_name'];
                        $data['file_path'] = $new_file_path;

                        // Return success response with file details
                        return $this->sendJson(array("data" => $data, "status" => true, "response" => "Media uploaded successfully"));
                    }
                    
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
