<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Dashboard
 */
class Home extends MY_Controller 
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
        $nama = $this->session->userdata('nama');

        $data['title']              = 'IFKasir - Dashboard';
        $data['breadcrumb_title']   = "Hallo $nama 😊";
        $data['breadcrumb_path']    = 'Home / Dashboard';
        $data['page']               = 'pages/home/index';

        // Mendapatkan aktivitas penjualan
        $data['list_penjualan'] = $this->home->select([
                'user.nama', 'penjualan.id_penjualan',
                'penjualan.waktu_penjualan', 'penjualan.total_harga'
            ])
            ->join('user', $this->home->ACTION_ADD_JOIN)
            ->orderBy('penjualan.waktu_penjualan', 'DESC')
            ->limit(3)
            ->get();

        // Mendapatkan list user
        $this->home->table  = 'user';
        $data['users']      = $this->home->limit(5)->get();

        // print_r(getTodayCountSales()); exit;

        $this->view($data);
    }
}

/* End of file Home.php */
