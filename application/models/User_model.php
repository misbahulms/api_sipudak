<?php

class User_model extends CI_model
{
    public function getUser($id = null)
    {
        if ($id === null) {
            return $this->db->get('users')->result_array();
        } else {
            return $this->db->get_where('users', ['id_user' => $id])->result_array();
        }
    }

    public function deleteUser($id)
    {
        $this->db->delete('users', ['id_user' => $id]);
        return $this->db->affected_rows();
    }

    public function createUser($data)
    {
        $this->db->insert('users', $data);
        return $this->db->affected_rows();
    }

    public function updateUser($data, $id)
    {
        $this->db->update('users', $data, ['id_user' => $id]);
        return $this->db->affected_rows();
    }

    function loginApi($nomorhp)
    {
        $this->db->select('no_hp, password, nama, id_users');
        $this->db->from('users');
        $this->db->where('users.no_hp =' . $nomorhp);
        $query = $this->db->get();

        return $query->row_array();
    }
}
