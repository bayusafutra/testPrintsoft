<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->library('session');
        $this->load->library('form_validation');
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth/login');
        }
    }

    public function index() {
        $data['products'] = $this->Product_model->get_all_products();
        $data['categories'] = $this->Category_model->get_active_categories();
        $this->load->view('product/index', $data);
    }

    public function add() {
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|numeric');
        $this->form_validation->set_rules('nama', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('product');
        } else {
            $data = [
                'kategori_id' => $this->input->post('kategori_id', true),
                'nama' => $this->input->post('nama', true),
                'jenis_formula' => $this->input->post('jenis_formula', true),
                'harga' => $this->input->post('harga', true),
                'satuan' => $this->input->post('satuan', true),
                'deskripsi' => $this->input->post('deskripsi', true),
            ];
            $result = $this->Product_model->insert_product($data);
            if ($result) {
                $this->session->set_flashdata('success', 'Produk berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan produk!');
            }
            redirect('product');
        }
    }

    public function edit($id) {
        $this->form_validation->set_rules('kategori_id', 'Kategori', 'required|numeric');
        $this->form_validation->set_rules('nama', 'Nama Produk', 'required|trim');
        $this->form_validation->set_rules('satuan', 'Satuan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('product');
        } else {
            $data = [
                'kategori_id' => $this->input->post('kategori_id', true),
                'nama' => $this->input->post('nama', true),
                'jenis_formula' => $this->input->post('jenis_formula', true),
                'harga' => $this->input->post('harga', true),
                'satuan' => $this->input->post('satuan', true),
                'deskripsi' => $this->input->post('deskripsi', true),
            ];

            $result = $this->Product_model->update_product($id, $data);

            if ($result) {
                $this->session->set_flashdata('success', 'Produk berhasil diupdate!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate produk!');
            }
            redirect('product');
        }
    }

    public function toggle_status($id) {
        $product = $this->Product_model->get_product_by_id($id);
        if ($product) {
            $new_status = $product['status'] ? 0 : 1;
            $result = $this->Product_model->update_product($id, ['status' => $new_status]);
            if ($result) {
                $this->session->set_flashdata('success', 'Status produk berhasil diubah!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah status!');
            }
        } else {
            $this->session->set_flashdata('error', 'Produk tidak ditemukan!');
        }
        redirect('product');
    }

    public function delete($id) {
        $result = $this->Product_model->delete_product($id);
        if ($result) {
            $this->session->set_flashdata('success', 'Produk berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus produk!');
        }
        redirect('product');
    }
}
