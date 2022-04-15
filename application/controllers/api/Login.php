<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Login extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
    }

    public function index_post()
    {
        $nomorhp = $this->input->post('no_hp');
        $password = $this->input->post('password');
        $result = $this->user->loginApi($nomorhp, $password);
        // echo json_encode($result);

        if ($result) {
            $this->response([
                'status' => true,
                'data' => 'selamat anda berhasil login'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'nomor hp tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

}