<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {
    public function __construct() {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding,Authorization");
        parent::__construct();
    }

    public function upload() {
        $headers = $this->input->request_headers();
        if (isset($headers['Authorization'])) {
            $decodedToken = $this->authorization_token->validateToken($headers['Authorization']);
            if ($decodedToken['status']) {
                if ($this->input->method() === 'post') {
                    // Load the file uploading library
                    $this->load->library('upload');
                    
                    $media_data="";
                    $media_error = "";
                    $isImage = false;
                    $isVideo = false;

                    // Specify upload configuration for images
                    $image_config['upload_path']   = './uploads/images/';
                    $image_config['allowed_types'] = 'gif|jpg|jpeg|png';
                    $image_config['max_size']      = 10240; // 10MB max size (adjust as needed)

                    // Initialize image upload
                    $this->upload->initialize($image_config);

                    // Check if image upload is successful
                    if ($this->upload->do_upload('image')) {
                        // Image uploaded successfully
                        $media_data = $this->upload->data();
                        // Process video data as needed to compress
                    } else {
                        // Image upload failed
                        $media_error = $this->upload->display_errors($open = '', $close = '');
                        $isImage = true;
                    }

                    // Specify upload configuration for videos
                    $video_config['upload_path']   = './uploads/videos/';
                    $video_config['allowed_types'] = 'mp4|avi|mov|flv';
                    $video_config['max_size']      = 102400; // 100MB max size (adjust as needed)

                    // Initialize video upload
                    $this->upload->initialize($video_config);

                    // Check if video upload is successful
                    if ($this->upload->do_upload('video')) {
                        // Video uploaded successfully
                        $media_data = $this->upload->data();
                        // Process video data as needed to compress
                    } else {
                        // Video upload failed
                        $media_error = $this->upload->display_errors($open = '', $close = '');
                        $isVideo = true;
                    }

                    if(!empty($media_error) && $isImage && $isVideo) {
                        return $this->sendJson(array("status" => 404, "response" => $media_error));
                    } else {
                        //Return response or perform any other actions
                        $data['url'] = $media_data['file_name'];
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
