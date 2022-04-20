<?php

class Peta_model extends CI_model
{
    public function getPeta($id = null)
    {
        if ($id === null) {
            return $this->db->get('titik_kecamatan')->result_array();
        } else {
            return $this->db->get_where('peta', ['id_t' => $id])->result_array();
        }
    }
}
