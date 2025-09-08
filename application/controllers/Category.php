<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Category_model');
        $this->load->library('session');
        // Cek jika belum login, redirect ke login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu!');
            redirect('auth/login');
        }
    }

    public function index() {
        $data['categories'] = $this->Category_model->get_all_categories();
        $this->load->view('category/index', $data);
    }

    public function add() {
        // Validasi input
        $this->form_validation->set_rules('nama', 'Nama Kategori', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('category');
        } else {
            $data = [
                'nama' => $this->input->post('nama', true),
                'status' => 1 // Default true
            ];

            $result = $this->Category_model->insert_category($data);

            if ($result) {
                $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menambahkan kategori!');
            }
            redirect('category');
        }
    }

    public function edit($id) {
        // Validasi input
        $this->form_validation->set_rules('nama', 'Nama Kategori', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('category');
        } else {
            $data = [
                'nama' => $this->input->post('nama', true)
            ];

            $result = $this->Category_model->update_category($id, $data);

            if ($result) {
                $this->session->set_flashdata('success', 'Kategori berhasil diupdate!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate kategori!');
            }
            redirect('category');
        }
    }

    public function toggle_status($id) {
        $category = $this->Category_model->get_category_by_id($id);
        if ($category) {
            $new_status = $category['status'] ? 0 : 1;
            $result = $this->Category_model->update_category($id, ['status' => $new_status]);
            if ($result) {
                $this->session->set_flashdata('success', 'Status kategori berhasil diubah!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengubah status!');
            }
        } else {
            $this->session->set_flashdata('error', 'Kategori tidak ditemukan!');
        }
        redirect('category');
    }

    public function delete($id) {
        $result = $this->Category_model->delete_category($id);
        if ($result) {
            $this->session->set_flashdata('success', 'Kategori berhasil dihapus!');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kategori!');
        }
        redirect('category');
    }
}
