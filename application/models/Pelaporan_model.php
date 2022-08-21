<?php

class Pelaporan_model extends CI_model
{
    public function getPelaporan($id = null)
    {
        if ($id === null) {
            return $this->db->get('pelaporan')->result_array();
        } else {
            return $this->db->get_where('pelaporan', ['id_pelapor' => $id])->row_array();
        }
    }

    public function createPelaporan($data)
    {
        $this->db->insert('pelaporan', $data);
        return $this->db->affected_rows();
    }
}
