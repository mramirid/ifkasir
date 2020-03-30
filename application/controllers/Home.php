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

        // Mendapatkan total harga dari penjualan seminggu terakhir
        $this->home->table  = 'penjualan';
        $data['list_penjualan_seminggu'] = $this->home->select([
                'DAY(penjualan.waktu_penjualan) AS tanggal',
                'SUM(penjualan.total_harga) AS total'
            ])
            ->groupBy('DAY(penjualan.waktu_penjualan)')
            ->orderBy('DAY(penjualan.waktu_penjualan)')
            ->limit(7)
            ->get();

        // Pasang default value jika kosong (Warning)
        for ($i = 0; $i < 7; ++$i) {
            if (!isset($data['list_penjualan_seminggu'][$i])) {
                $data['list_penjualan_seminggu'][$i] = new StdClass;    // Jika row tidak ada, buat row baru
                $data['list_penjualan_seminggu'][$i]->tanggal = 0;
                $data['list_penjualan_seminggu'][$i]->total   = 0;
            }
        }
        
        $this->view($data);
    }
}

/* End of file Home.php */
