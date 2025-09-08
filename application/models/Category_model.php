<?php
class Category_model extends CI_Model 
{
    public function get_all_categories() {
        return $this->db->get('categories')->result_array();
    }

    public function get_active_categories() {
        return $this->db->get_where('categories', ['status' => 1])->result_array();
    }

    public function get_category_by_id($id) {
        return $this->db->get_where('categories', ['id' => $id])->row_array();
    }

    public function insert_category($data) {
        return $this->db->insert('categories', $data);
    }

    public function update_category($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('categories', $data);
    }

    public function delete_category($id) {
        return $this->db->delete('categories', ['id' => $id]);
    }
}
