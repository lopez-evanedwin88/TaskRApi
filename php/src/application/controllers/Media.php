<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function upload() {
        // Load the file uploading library
    $this->load->library('upload');

    // Specify upload configuration for images
    $image_config['upload_path']   = './uploads/images/';
    $image_config['allowed_types'] = 'gif|jpg|jpeg|png';
    $image_config['max_size']      = 10240; // 10MB max size (adjust as needed)

    // Initialize image upload
    $this->upload->initialize($image_config);

    // Check if image upload is successful
    if ($this->upload->do_upload('image')) {
        // Image uploaded successfully
        $image_data = $this->upload->data();
        // Process image data as needed
    } else {
        // Image upload failed
        $image_error = $this->upload->display_errors();
        // Handle error
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
        $video_data = $this->upload->data();
        // Process video data as needed
        print_r($video_data);
    } else {
        // Video upload failed
        $video_error = $this->upload->display_errors();
        print_r($video_error);
        // Handle error
    }

    // Return response or perform any other actions
}
