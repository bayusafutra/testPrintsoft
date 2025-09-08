<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->library('form_validation');
		$this->load->library('session');
    }
	public function index() {
		$this->load->view('auth/register');
    }
    public function store() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|is_unique[users.username]', [
            'is_unique' => 'Username sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]', [
            'valid_email' => 'Email tidak valid!',
            'is_unique' => 'Email sudah terdaftar!'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]', [
            'min_length' => 'Password harus minimal 6 karakter!'
        ]);

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth');
        } else {
            $username = $this->input->post('username', true);
            $email = $this->input->post('email', true);
            $password = $this->input->post('password', true);

            $data = [
                'username' => $username,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'created_at' => date('Y-m-d H:i:s')
            ];
            $result = $this->Auth_model->register($data);

            if ($result) {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal! Silakan coba lagi.');
                redirect('auth/register');
            }
        }
    }
	public function login() {
        if ($this->session->userdata('logged_in')) {
            redirect('home');
        }
        
        $this->load->view('auth/login');
    }
	public function postLogin() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('auth/login');
        } else {
            $username = $this->input->post('username', true);
            $password = $this->input->post('password', true);

            $user = $this->Auth_model->get_user($username);
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $session_data = [
                        'user_id' => $user['id'],
                        'username' => $user['username'],
                        'logged_in' => TRUE
                    ];
                    $this->session->set_userdata($session_data);
                    $this->session->set_flashdata('success', 'Login berhasil!');
                    redirect('home');
                } else {
                    $this->session->set_flashdata('error', 'Password salah!');
                    redirect('auth/login');
                }
            } else {
                $this->session->set_flashdata('error', 'Username tidak ditemukan!');
                redirect('auth/login');
            }
        }
    }
    public function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Logout berhasil!');
        redirect('auth/login');
    }
}
