<?php

class Korban_model extends CI_model
{
    public function getKorban($id = null)
    {
        if ($id === null) {
            return $this->db->get('korban')->num_rows();
        } else {
            return $this->db->get_where('korban', ['id_korban' => $id])->num_rows();
        }
    }

    public function getKL($id = null)
    {
        if ($id === null) {
            return $this->db->get('korban')->num_rows();
        } else {
            $this->db->select('*');
            $this->db->where('jenis_kelamin', 'laki-laki');
            $query = $this->db->get('korban');
            return $query->num_rows();
        }
    }
}
