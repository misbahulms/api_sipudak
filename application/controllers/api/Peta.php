<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Peta extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Peta_model', 'peta');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $peta = $this->peta->getPeta();
        } else {
            $peta = $this->peta->getPeta($id);
        }

        if ($peta) {
            $this->response([
                'status' => true,
                'data' => $peta
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], REST_Controller::HTTP_NOT_FOUND);
        }

        if ($this->input->get('cari')) {

            $key = $this->input->get('cari');

            // echo "<pre>";
            // // print_r($this->input->post());


            $query = $this->db->select('*, SUM(Jlh_Kasus / Jarak) as zd, SUM(1 / Jarak) as satud, SUM(Jlh_Kasus) as jumlahkasus, kecamatan.nama_kecamatan as nama')
                ->from('titik_kecamatan')
                ->join('kecamatan', 'kecamatan.id_kecamatan = titik_kecamatan.id_titik_hitung')
                ->group_by('id_titik_hitung')
                ->where('tahun', $key)
                ->get();


            // print_r($this->db->last_query());
            // die;

            $data['titikhitung'] = $query->result_array();
            print_r($data['titikhitung => 2017']);
            die;
        }
    }
}
