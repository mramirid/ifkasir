<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends MY_Controller
{
    private $id_user;

    public function __construct()
    {
        parent::__construct();
        
        $is_login       = $this->session->userdata('is_login');
        $this->id_user  = $this->session->userdata('id_user');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $this->logout->where('id_user', $this->id_user)->delete();    // Hapus seluruh pesanan dari user

        if ($this->logout->count() < 1) {  // Jika tabel pesanan kosong, reset index id_pesanan
            $this->logout->resetIndex();
        }

        $sess_data = ['id', 'nama', 'email', 'telefon', 'ktp', 'role', 'is_login'];
        $this->session->unset_userdata($sess_data);
        $this->session->sess_destroy();

        redirect(base_url('login'));
    }
}

/* End of file Logout.php */
