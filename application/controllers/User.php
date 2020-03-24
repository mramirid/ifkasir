<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller 
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
        $data['content']            = $this->user->paginate($page)->get();
        $data['total_rows']         = $this->user->count();
        $data['pagination']         = $this->user->makePagination(base_url('user'), 2, $data['total_rows']);
        $data['page']               = 'pages/user/index';
        
        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('user'));
        }

        $keyword = $this->session->userdata('keyword');

        $data['title']              = 'IFKasir - Cari User';
        $data['breadcrumb_title']   = "User";
        $data['breadcrumb_path']    = "User / Search / $keyword";
        $data['content']            = $this->user->paginate($page)
                                        ->like('nama', $keyword)
                                        ->orLike('ktp', $keyword)
                                        ->orLike('email', $keyword)
                                        ->get();
        $data['total_rows']         = $this->user->like('nama', $keyword)
                                        ->orLike('ktp', $keyword)
                                        ->orLike('email', $keyword)
                                        ->count();
        $data['pagination']         = $this->user->makePagination(base_url('user/search'), 3, $data['total_rows']);
        $data['page']               = 'pages/user/index';

        $this->view($data);
    }

    public function edit($id_user)
    {
        $data['content'] = $this->user->where('id_user', $id_user)->first();

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('user'));
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
            $data['title']              = 'IFKasir - Edit Keryawan';
            $data['page']               = 'pages/user/edit';
            $data['breadcrumb_title']   = 'Edit Data Karyawan';
            $data['breadcrumb_path']    = "Manajemen Karyawan / Edit Data Karyawan / " . $data['input']->nama;

            return $this->view($data);
        }

        if ($this->user->where('id_user', $id_user)->update($data['input'])) {   // Update data
            $this->session->set_flashdata('success', 'Data berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi suatu kesalahan');
        }

        redirect(base_url('user'));
    }

    public function delete()
    {
        if (!$_POST) {
            $this->session->set_flashdata('error', 'Akses penghapusan ditolak!');
            redirect(base_url('user'));
        }

        $id_user    = $this->input->post('id_user');
        $user       = $this->user->where('id_user', $id_user)->first();

        if ($user->role == 'admin') {
            $this->session->set_flashdata('warning', 'Sebagai admin, anda tidak dapat menghapus akun anda sendiri');
            redirect(base_url('user'));
        }

        if (!$user) {
            $this->session->set_flashdata('warning', 'Maaf user tidak ditemukan');
            redirect(base_url('user'));
        }

        if ($this->user->where('id_user', $id_user)->delete()) {   // Lakukan penghapusan di db
            $this->session->set_flashdata('success', 'User berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
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

    public function unique_ktp()
    {
        $ktp        = $this->input->post('ktp');
        $id_user    = $this->input->post('id_user');
        $user       = $this->user->where('ktp', $ktp)->first();

        if ($user) {
            if ($id_user == $user->id_user) {  // Keperluan edit tidak perlu ganti ktp, jadi tidak masalah
                return true;
            }

            // Jika terdapat suatu nilai pada $user, berikan pesan error pertanda ktp sudah ada di db
            $this->load->library('form_validation');
            $this->form_validation->set_message('unique_ktp', 'Nomor KTP %s sudah digunakan');
            return false;
        }

        return true;
    }
}

/* End of file User.php */
