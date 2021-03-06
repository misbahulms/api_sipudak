<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Korban extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Korban_model', 'korban');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $korban = $this->korban->getKorban();
        } else {
            $korban = $this->korban->getKorban($id);
        }

        if ($korban) {
            $this->response([
                'status' => true,
                'data' => $korban
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    // public function data_get()
    // {
    //     $jkl = $this->get()['jkl'];
    //     $jkp = $this->get()['jkp'];
    //     $query = $this->db->select('COUNT(id_korban) as korban')
    //         ->where('jenis_kelamin', $jkl)
    //         ->where('jenis_kelamin', $jkp)
    //         ->from('korban')->get()->row_array();
    //     // return $query;
    //     if ($query) {
    //         $this->response([
    //             'status' => true,
    //             'data' => $query
    //         ], REST_Controller::HTTP_OK);
    //     } else {
    //         $this->response([
    //             'status' => false,
    //             'message' => 'id not found'
    //         ], REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }

    // public function index_get()
    // {
    //     $id = $this->get('id');
    //     if ($id === null) {
    //         $kl = $this->korban->getKL();
    //     } else {
    //         $kl = $this->korban->getKL($id);
    //     }

    //     if ($kl) {
    //         $this->response([
    //             'status' => true,
    //             'data' => $kl
    //         ], REST_Controller::HTTP_OK);
    //     } else {
    //         $this->response([
    //             'status' => false,
    //             'message' => 'id not found'
    //         ], REST_Controller::HTTP_NOT_FOUND);
    //     }
    // }
}
