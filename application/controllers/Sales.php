<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller list penjualan
 */
class Sales extends MY_Controller 
{
    private $id_user;

    public function __construct()
    {
        parent::__construct();
        
        $this->id_user  = $this->session->userdata('id_user');
        $is_login       = $this->session->userdata('is_login');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index($page = null)
    {
        $this->session->unset_userdata('keyword');
        $this->session->unset_userdata('time');
        
        $data['title']              = 'IFKasir - List Penjualan';
        $data['breadcrumb_title']   = 'List Penjualan';
        $data['breadcrumb_path']    = 'Kasir / List Penjualan';
        $data['content']            = $this->sales->select([
                'penjualan.id_penjualan', 'user.nama', 
                'penjualan.waktu_penjualan', 'penjualan.total_harga'
            ])
            ->join('user', $this->sales->ACTION_ADD_JOIN)
            ->orderBy('penjualan.waktu_penjualan', 'DESC')
            ->paginate($page)
            ->get();
        $data['total_rows'] = $this->sales->count();
        $data['pagination'] = $this->sales->makePagination(base_url('sales'), 2, $data['total_rows']);
        $data['page']       = 'pages/sales/index';
        
        $this->view($data);
    }

    /**
     * Fungsi search berdasarkan id penjualan / nama kasir
     */
    public function search($page = null)
    {
        if (isset($_POST['keyword'])) {
            $this->session->set_userdata('keyword', $this->input->post('keyword'));
        }

        $this->session->unset_userdata('time');
        $keyword = $this->session->userdata('keyword');

        if (empty($keyword)) {
            redirect(base_url('sales'));
        }

        $data['title']              = 'IFKasir - List Penjualan';
        $data['breadcrumb_title']   = "List Penjualan";
        $data['breadcrumb_path']    = "Kasir / List Penjualan / Cari / $keyword";
        $data['content']            = $this->sales->select([
                'penjualan.id_penjualan', 'user.nama', 
                'penjualan.waktu_penjualan', 'penjualan.total_harga'
            ])
            ->join('user', $this->sales->ACTION_ADD_JOIN)
            ->like('penjualan.id_penjualan', $keyword)
            ->orLike('user.nama', $keyword)
            ->paginate($page)
            ->get();
        $data['total_rows'] = $this->sales->join('user', $this->sales->ACTION_ADD_JOIN)
            ->like('penjualan.id_penjualan', $keyword)
            ->orLike('user.nama', $keyword)
            ->count();
        $data['pagination'] = $this->sales->makePagination(base_url('sales/search'), 3, $data['total_rows']);
        $data['page']       = 'pages/sales/index';

        $this->view($data);
    }

    /**
     * Fungsi search berdasarkan waktu
     */
    public function search_time($page = null)
    {
        if (isset($_POST['time'])) {
            $this->session->set_userdata('time', $this->input->post('time'));
        }

        $this->session->unset_userdata('keyword');
        $time = $this->session->userdata('time');

        if (empty($time)) {
            redirect(base_url('sales'));
        }

        $data['title']              = 'IFKasir - List Penjualan';
        $data['breadcrumb_title']   = "List Penjualan";
        $data['breadcrumb_path']    = "Kasir / List Penjualan / Cari / $time";
        $data['content']            = $this->sales->select([
                'penjualan.id_penjualan', 'user.nama', 
                'penjualan.waktu_penjualan', 'penjualan.total_harga'
            ])
            ->join('user', $this->sales->ACTION_ADD_JOIN)
            ->like('DATE(penjualan.waktu_penjualan)', date('Y-m-d', strtotime($time)))
            ->paginate($page)
            ->get();
        $data['total_rows'] = $this->sales->join('user', $this->sales->ACTION_ADD_JOIN)
            ->like('DATE(penjualan.waktu_penjualan)', date('Y-m-d', strtotime($time)))
            ->count();
        $data['pagination'] = $this->sales->makePagination(base_url('sales/search_time'), 3, $data['total_rows']);
        $data['page']       = 'pages/sales/index';

        $this->view($data);
    }

    public function detail($id_penjualan)
    {
        $data['title']              = 'IFKasir - Detail Penjualan';
        $data['breadcrumb_title']   = "Detail Penjualan";
        $data['breadcrumb_path']    = "Kasir / List Penjualan / Detail Penjualan / $id_penjualan";
        $data['page']               = 'pages/sales/detail';
        $data['penjualan']  = $this->sales->select([
                'user.id_user', 'user.nama',
                'penjualan.id_penjualan', 'penjualan.waktu_penjualan'
            ])
            ->join('user', $this->sales->ACTION_ADD_JOIN)
            ->where('penjualan.id_penjualan', $id_penjualan)
            ->first();

        $this->sales->table          = 'detail_penjualan';
        $data['list_pesanan'] = $this->sales->select([
                'detail_penjualan.qty_jual', 'detail_penjualan.subtotal_jual',
                'stock_barang.nama_barang', 'stock_barang.harga_jual',
            ])
            ->join('stock_barang', $this->sales->ACTION_TRIM_JOIN)
            ->where('detail_penjualan.id_penjualan', $id_penjualan)
            ->get();

        $this->view($data);
    }
}

/* End of file Sales.php */
