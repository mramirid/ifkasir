<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Penjualan
 */
class Cashier extends MY_Controller 
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
        $nama = $this->session->userdata('nama');

        $data['title']              = 'IFKasir - Pesan';
        $data['breadcrumb_title']   = "Hallo $nama 😊";
        $data['breadcrumb_path']    = 'Kasir / Pesan';
        $data['content']            = $this->cashier->paginate($page)->get();
        $data['total_rows']         = $this->cashier->count();
        $data['pagination']         = $this->cashier->makePagination(base_url('cashier'), 2, $data['total_rows']);
        $data['page']               = 'pages/cashier/index';

        $this->view($data);
    }
}

/* End of file Cashier.php */
