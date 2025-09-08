<?php
class Auth_model extends CI_Model {
    public function register($data) {
        return $this->db->insert('users', $data);
    }

    public function get_user($username) {
        return $this->db->get_where('users', ['username' => $username])->row_array();
    }
}
