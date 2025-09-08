<?php
class Product_model extends CI_Model {

    public function get_all_products() {
        $this->db->select('products.*, categories.nama as kategori_nama');
        $this->db->from('products');
        $this->db->join('categories', 'products.kategori_id = categories.id', 'left');
        return $this->db->get()->result_array();
    }

    public function get_active_product() {
        return $this->db->get_where('products', ['status' => 1])->result_array();
    }

    public function get_product_by_id($id) {
        return $this->db->get_where('products', ['id' => $id])->row_array();
    }

    public function insert_product($data) {
        return $this->db->insert('products', $data);
    }

    public function update_product($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    public function delete_product($id) {
        return $this->db->delete('products', ['id' => $id]);
    }
}
