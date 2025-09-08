<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaction extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Transaction_model');
        $this->load->model('Product_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth/login');
        }
    }

    public function index() {
        $data['transactions'] = $this->Transaction_model->get_all_transactions();
        $data['products'] = $this->Product_model->get_active_product();
        $this->load->view('transaction/index', $data);
    }

    public function add() {
        $this->form_validation->set_rules('tgltransaksi', 'Tanggal Transaksi', 'required');
        $this->form_validation->set_rules('products[]', 'Produk', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('transaction');
        } else {
            $tgltransaksi = $this->input->post('tgltransaksi', true);
            $products = $this->input->post('products', true);
            $quantities = $this->input->post('quantities', true);
            $panjangs = $this->input->post('panjangs', true);
            $lebars = $this->input->post('lebars', true);

            $totalunit = 0;
            $totalharga = 0;
            foreach ($products as $index => $product_id) {
                $product = $this->Product_model->get_product_by_id($product_id);
                $qty = $quantities[$index];
                $totalunit += $qty;

                if ($product['jenis_formula'] == 1) {
                    $totalharga += $qty * $product['harga'];
                } else if ($product['jenis_formula'] == 2) {
                    $panjang = !empty($panjangs[$index]) ? $panjangs[$index] : 0;
                    $lebar = !empty($lebars[$index]) ? $lebars[$index] : 0;
                    $totalharga += $panjang * $lebar * $product['harga'];
					$totalunit++;
                }
            }

            $transaction_data = [
                'tgltransaksi' => $tgltransaksi,
                'totalunit' => $totalunit,
                'totalharga' => $totalharga
            ];
            $transaction_id = $this->Transaction_model->insert_transaction($transaction_data);

            if ($transaction_id) {
                foreach ($products as $index => $product_id) {
                    $detail_data = [
                        'transaction_id' => $transaction_id,
                        'product_id' => $product_id,
                        'qty' => $quantities[$index],
                        'panjang' => !empty($panjangs[$index]) ? $panjangs[$index] : null,
                        'lebar' => !empty($lebars[$index]) ? $lebars[$index] : null
                    ];
                    $this->Transaction_model->insert_transaction_detail($detail_data);
                }
                $this->session->set_flashdata('success', 'Transaksi berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan transaksi!');
            }
            redirect('transaction');
        }
    }

    public function delete($id) {
        $result = $this->Transaction_model->delete_transaction($id);
        if ($result) {
            $this->session->set_flashdata('success', 'Transaksi berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus transaksi!');
        }
        redirect('transaction');
    }

    public function get_details($transaction_id) {
        $data = $this->Transaction_model->get_transaction_details($transaction_id);
        echo json_encode($data);
    }
}
