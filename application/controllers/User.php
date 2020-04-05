<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kontroller Manajemen Akun
 */
class User extends MY_Controller 
{
    public function __construct()
    {
        parent::__construct();
        
        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
        }
    }

    public function index($page = null)
    {
        $this->session->unset_userdata('keyword');

        $id_user = $this->session->userdata('id_user');
        
        $data['title']              = 'IFKasir - Profile';
        $data['breadcrumb_title']   = 'Profile';
        $data['breadcrumb_path']    = 'Profile';
        $data['content']            = $this->user->where('id_user', $id_user)->first();
        $data['page']               = 'pages/user/index';
        
        $this->view($data);
    }

    public function edit($id_user)
    {
        if ($this->session->userdata('id_user') != $id_user) {
            $this->session->set_flashdata('error', 'Akses ditolak!');
            redirect(base_url('home'));
        }

        $data['content'] = $this->user->where('id_user', $id_user)->first();

        // print_r($data['content']); exit;

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('users'));
        }

        if (!$_POST) {
            $data['input'] = $data['content'];
        } else {
            $data['input'] = (object) $this->input->post(null, true);

            if ($data['input']->password !== '') {
                // Jika password tidak kosong, berati user mengubah password lalu encrypt
                $data['input']->password = hashEncrypt($data['input']->password);
            } else {
                // Jika tidak kosong berati user tidak mengubah password
                $data['input']->password = $data['content']->password;
            }
        }

        if (!$this->user->validate()) {
            $data['title']              = 'IFKasir - Edit Profile';
            $data['page']               = 'pages/user/edit';
            $data['breadcrumb_title']   = 'Edit Profile';
            $data['breadcrumb_path']    = "Profile / Edit Profile / " . $data['input']->nama;

            return $this->view($data);
        }

        if ($this->user->where('id_user', $id_user)->update($data['input'])) {   // Update data
            // Perbaharui data di session
            $sess_data = (array) $this->user->where('id_user', $id_user)->first();
            $this->session->set_userdata($sess_data);

            $this->session->set_flashdata('success', 'Data berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi suatu kesalahan');
        }

        redirect(base_url('user'));
    }

    public function unique_email()
    {
        $email      = $this->input->post('email');
        $id_user    = $this->input->post('id_user');
        $user       = $this->user->where('email', $email)->first(); // Akan terisi jika terdapat email yang sama

        if ($user) {
            if ($id_user == $user->id_user) {  // Keperluan edit tidak perlu ganti email, jadi tidak masalah
                return true;
            }

            // Jika terdapat suatu nilai pada $user, berikan pesan error pertanda email sudah ada di db
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_email', '%s sudah digunakan');
            return false;
        }

        return true;
    }
}

/* End of file User.php */
