<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Pemesanan
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
        $this->session->unset_userdata('keyword');

        $data['title']              = 'IFKasir - Pesan';
        $data['breadcrumb_title']   = "Menu Kasir";
        $data['breadcrumb_path']    = 'Kasir / Pesan';
        $data['content']            = $this->cashier->paginate($page)->get();
        $data['total_rows']         = $this->cashier->count();
        $data['pagination']         = $this->cashier->makePagination(base_url('cashier'), 2, $data['total_rows']);
        $data['page']               = 'pages/cashier/index';

        $this->view($data);
    }

    /**
     * Klasifikasi makanan/minuman
     * Param 1: tipe barang
     * Param 2: nilai pagination
     */
    public function type($type, $page = null)
    {  
        $this->session->unset_userdata('keyword');

        $data['title']              = 'IFKasir - Pesan';
        $data['breadcrumb_title']   = "Menu Kasir";
        $data['breadcrumb_path']    = 'Kasir / Tipe / ' . ucfirst($type);
        $data['content']            = $this->cashier->paginate($page)->where('tipe_barang', $type)->get();
        $data['total_rows']         = $this->cashier->where('tipe_barang', $type)->count();
        $data['pagination']         = $this->cashier->makePagination(
            base_url("cashier/type/$type"), 4, $data['total_rows']
        );
        $data['page']               = 'pages/cashier/index';

        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('cashier'));
        }

        $data['title']              = 'IFKasir - Pesan';
        $data['breadcrumb_title']   = "Menu Kasir";
        $data['breadcrumb_path']    = "Kasir / Search / $keyword";
        $data['content']            = $this->cashier->paginate($page)->like('nama_barang', $keyword)->get();
        $data['total_rows']         = $this->cashier->like('nama_barang', $keyword)->count();
        $data['pagination']         = $this->cashier->makePagination(
            base_url('cashier/search'), 3, $data['total_rows']
        );
        $data['page']               = 'pages/cashier/index';

        $this->view($data);
    }
}

/* End of file Cashier.php */
