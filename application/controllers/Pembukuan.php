<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pembukuan extends MY_Controller 
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
        $this->session->set_flashdata('warning', 'Lagi dikerjain kelompok lain gan');
        redirect(base_url('home'));
    }
}

/* End of file Pembukuan.php */
