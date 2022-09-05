<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Login extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $user = $this->user->getUser();
        } else {
            $user = $this->user->getUser($id);
        }

        if ($user) {
            $this->response([
                'status' => true,
                'data' => $user
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
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
                'data' => $result,
                'message' => 'selamat anda berhasil login'
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'data' => 'nomor hp tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}
