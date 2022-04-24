<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class User extends REST_Controller
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

        //  Convert password into hash
        $options = array('cost' => 12);
        $password_hash = password_hash($this->post('password'), PASSWORD_BCRYPT, $options);


        // insert to database
        $data = [
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'password' => $password_hash,
            'no_hp' => $this->post('no_hp'),
            'alamat' => $this->post('alamat'),
            'is_active' => 1,
            'role' => "User",
            // 'image' => $name,
            'date_created' => date('Y-m-d H:i:s')

        ];

        if ($this->user->createUser($data) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data user berhasil ditambah'
            ], REST_Controller::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data user gagal ditambahkan'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }


        // upload image
        // if($_FILES['image']['size']==0){
        //     $name = 'no_file';
        // } else {
        //     if(is_uploaded_file($_FILES['image']['tmp_name'])){
        //         // check for image type 
        //         $allowed = array('png', 'jpg', 'jpeg');
        //         $filename = $_FILES['image']['name'];
        //         $ext = pathinfo($filename,PATHINFO_EXTENSION);

        //         if(in_array($ext,$allowed)){
        //             $tmp_name = $_FILES["image"]["name"];
        //             $image = "uploads/";

        //             $lname = basename($_FILES["image"]["name"]);
        //             $newfilename = 'image_'.round(microtime(true)).'.'.$ext;
        //             move_uploaded_file($image, $newfilename);
        //             $name = $newfilename;
        //         } else {
        //             $Return['status']='0';
        //             $Return['messasge']='file gagal di upload';
        //         }
        //     }
        // }
    }

    public function index_delete()
    {
        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->user->deleteUser($id) > 0) {
                // ok
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'data user dihapus'
                ], REST_Controller::HTTP_NO_CONTENT);
            } else {
                // id not found 
                $this->response([
                    'status' => false,
                    'id' => $id,
                    'message' => 'id tidak ditemukan'
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_put()
    {
        $id = $this->put('id');
        $data = [
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'image' => $this->put('default.png'),
            'password' => $this->put('password'),
            'no_hp' => $this->put('no_hp'),
            'alamat' => $this->put('alamat'),

        ];

        if ($this->user->updateUser($data, $id) > 0) {
            $this->response([
                'status' => true,
                'message' => 'data user berhasil diubah'
            ], REST_Controller::HTTP_NO_CONTENT);
        } else {
            $this->response([
                'status' => false,
                'message' => 'data user gagal diubah'
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}
