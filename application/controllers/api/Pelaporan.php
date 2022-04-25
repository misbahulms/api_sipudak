<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Pelaporan extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pelaporan_model', 'pelaporan');
    }

    public function index_get()
    {
        $id = $this->get('id');
        if ($id === null) {
            $pelaporan = $this->pelaporan->getPelaporan();
        } else {
            $pelaporan = $this->pelaporan->getPelaporan($id);
        }

        if ($pelaporan) {
            $this->response([
                'status' => true,
                'data' => $pelaporan
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
        // upload image
        if ($_FILES['image']['size'] == 0) {
            $image = 'no_file';
        } else {
            if (is_uploaded_file($_FILES['image']['tmp_name'])) {
                // check for image type 
                $allowed = array('png', 'jpg', 'jpeg');
                $filename = $_FILES['image']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                if (in_array($ext, $allowed)) {
                    $tmp_name = $_FILES["image"]["name"];
                    $image = "assets/images/";

                    $lname = basename($_FILES["image"]["name"]);
                    $newfilename = 'image_' . round(microtime(true)) . '.' . $ext;
                    move_uploaded_file($image, $newfilename);
                    $name = $newfilename;
                } else {
                    $Return['status'] = '0';
                    $Return['messasge'] = 'file gagal di upload';
                }
            }
        }

        // insert to database
        $data = [
            'id_user' => $this->post('id_user'),
            'alamat_pelapor' => $this->post('alamat_pelapor'),
            'no_hp' => $this->post('no_hp'),
            'korban_kekerasan' => $this->post('korban_kekerasan'),
            'tanggal_pelaporan' => date('Y-m-d H:i:s'),
            'tempat_kejadian' => $this->post('tempat_kejadian'),
            'alamat_kejadian' => $this->post('alamat_kejadian'),
            'kronologis_kejadian' => $this->post('kronologis_kejadian', true),
            'image' => $name,
            'id_status' => 1,
            'hubungan_dengan_korban' => $this->post('hubungan_dengan_korban', true),
            'id_desa' => $this->post('id_desa'),
            'date_created' => date('Y-m-d H:i:s')

        ];

        if ($this->pelaporan->createPelaporan($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data pelaporan berhasil ditambah'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data pelaporan gagal ditambahkan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function _uploadImage()
    {
        $config['upload_path']    = './assets/images/';
        $config['allowed_types']  = 'gif|jpg|png';
        // $config['file_name']      = $this->id_pelapor;
        $config['overwrite']      = true;
        $config['max_size']       = 1024;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('image')) {
            return $this->upload->data("file_name");
        }

        return "default.png";
    }
}
