<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Kecamatan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Kecamatan_model', 'kecamatan');
    }

    public function index_get()
    {
        $id = $this->get()['id'];
        $query = $this->db->select('COUNT(id_pengaduan) as kasus')
            ->where('id_kecamatan', $id)
            ->from('pengaduan_kasus')->get()->row_array();
        // return $query;
        if ($query) {
            $this->response([
                'status' => true,
                'data' => $query
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

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
