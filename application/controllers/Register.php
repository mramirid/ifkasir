<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Register extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $is_login = $this->session->userdata('is_login');
        
        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $role = $this->session->userdata('role');

        // Cek role ketika mengakses menu registrasi
        if ($role != 'admin') { 
            $this->session->set_flashdata('warning', 'Anda tidak memiliki akses ke menu registrasi');
            redirect(base_url('home'));
            return;
        }

        if (!$_POST) {
            $input = (object) $this->register->getDefaultValues();
        } else {
            $input = (object) $this->input->post(null, true);
        }

        if (!$this->register->validate()) {     // Jika validasi gagal maka arahkan ke form register lagi
            $data['title'] = 'Register Karyawan';
            $data['input'] = $input;
            $data['page'] = 'pages/register/index';
            $data['breadcrumb_title']   = 'Register Karyawan';
            $data['breadcrumb_path']    = 'Manajemen Karyawan / Register Karyawan';
        
            return $this->view($data);
        }

        // Input data
        if ($this->register->run($input)) {
            $this->session->set_flashdata('success', 'Berhasil melakukan registrasi');
            redirect(base_url('register'));
        } else {
            $this->session->set_flashdata('error', 'Oops terjadi suatu kesalahan');
            redirect(base_url('register'));
        }
    }

    public function reset()
    {
        redirect(base_url('register'));
    }
}

/* End of file Register.php */
