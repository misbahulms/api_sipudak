<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Desa extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Desa_model', 'desa');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $desa = $this->desa->getDesa();
        } else {
            $desa = $this->desa->getDesa($id);
        }

        if ($desa) {
            $this->response([
                'status' => true,
                'data' => $desa
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'Desa tidak ditemukan'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // public function index_post()
    // {
    //     $nomorhp = $this->input->post('no_hp');
    //     $password = $this->input->post('password');
    //     $result = $this->user->loginApi($nomorhp, $password);
    //     // echo json_encode($result);

    //     if ($result) {
    //         $this->response([
    //             'status' => true,
    //             'data' => 'selamat anda berhasil login'
    //         ], REST_Controller::HTTP_OK);
    //     } else {
    //         $this->response([
    //             'status' => false,
    //             'data' => 'nomor hp tidak ditemukan'
    //         ], REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }
}
