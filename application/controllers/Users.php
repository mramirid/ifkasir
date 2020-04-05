<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Kontroller list user
 */
class Users extends MY_Controller 
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

    public function index($page = null)
    {
        $this->session->unset_userdata('keyword');
        
        $data['title']              = 'IFKasir - List Karyawan';
        $data['breadcrumb_title']   = 'List Karyawan';
        $data['breadcrumb_path']    = 'Manajemen Karyawan / List Karyawan';
        $data['content']            = $this->users->paginate($page)->get();
        $data['total_rows']         = $this->users->count();
        $data['pagination']         = $this->users->makePagination(base_url('users'), 2, $data['total_rows']);
        $data['page']               = 'pages/users/index';
        
        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('users'));
        }

        $keyword = $this->session->userdata('keyword');

        $data['title']              = 'IFKasir - Cari User';
        $data['breadcrumb_title']   = "Daftar Karyawan";
        $data['breadcrumb_path']    = "Daftar Karyawan / Cari / $keyword";
        $data['content']            = $this->users->paginate($page)
                                        ->like('nama', $keyword)
                                        ->orLike('ktp', $keyword)
                                        ->orLike('email', $keyword)
                                        ->paginate($page)
                                        ->get();
        $data['total_rows']         = $this->users->like('nama', $keyword)
                                        ->orLike('ktp', $keyword)
                                        ->orLike('email', $keyword)
                                        ->count();
        $data['pagination']         = $this->users->makePagination(base_url('users/search'), 3, $data['total_rows']);
        $data['page']               = 'pages/users/index';

        $this->view($data);
    }

    public function edit($id_user)
    {
        if ($this->session->userdata('id_user') != 'id_user' && $this->session->userdata('role') != 'admin') {
            $this->session->set_flashdata('error', 'Akses edit ditolak!');
            redirect(base_url('home'));
        }

        $data['content'] = $this->users->where('id_user', $id_user)->first();

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

        if (!$this->users->validate()) {
            $data['title']              = 'IFKasir - Edit Keryawan';
            $data['page']               = 'pages/users/edit';
            $data['breadcrumb_title']   = 'Edit Data Karyawan';
            $data['breadcrumb_path']    = "Manajemen Karyawan / Edit Data Karyawan / " . $data['input']->nama;

            return $this->view($data);
        }

        if ($this->users->where('id_user', $id_user)->update($data['input'])) {   // Update data
            $this->session->set_flashdata('success', 'Data berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi suatu kesalahan');
        }

        redirect(base_url('users'));
    }

    public function unique_email()
    {
        $email      = $this->input->post('email');
        $id_user    = $this->input->post('id_user');
        $user       = $this->users->where('email', $email)->first(); // Akan terisi jika terdapat email yang sama

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

    public function unique_ktp()
    {
        $ktp        = $this->input->post('ktp');
        $id_user    = $this->input->post('id_user');
        $user       = $this->users->where('ktp', $ktp)->first();

        if ($user) {
            if ($id_user == $user->id_user) {  // Keperluan edit tidak perlu ganti ktp, jadi tidak masalah
                return true;
            }

            // Jika terdapat suatu nilai pada $user, berikan pesan error pertanda ktp sudah ada di db
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_ktp', '%s sudah digunakan');
            return false;
        }

        return true;
    }
}

/* End of file Users.php */
