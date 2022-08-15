<?php

class Desa_model extends CI_model
{
    public function getDesa($id = null)
    {
        if ($id === null) {
            return $this->db->get('desa')->result_array();
        } else {
            return $this->db->get_where('desa', ['id_desa' => $id])->result_array();
        }
    }
}
