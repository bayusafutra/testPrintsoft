<?php
class Transaction_model extends CI_Model {

    public function get_all_transactions() {
        return $this->db->get('transactions')->result_array();
    }

    public function get_transaction_details($transaction_id) {
        $this->db->select('transaction_details.*, products.nama as product_nama');
        $this->db->from('transaction_details');
        $this->db->join('products', 'transaction_details.product_id = products.id', 'left');
        $this->db->where('transaction_details.transaction_id', $transaction_id);
        return $this->db->get()->result_array();
    }

    public function insert_transaction($data) {
        $this->db->insert('transactions', $data);
        return $this->db->insert_id();
    }

    public function insert_transaction_detail($data) {
        return $this->db->insert('transaction_details', $data);
    }

    public function delete_transaction($id) {
        return $this->db->delete('transactions', ['id' => $id]);
    }
}
