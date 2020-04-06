<?php

defined('BASEPATH') or exit('No direct script access allowed');

class InvLoss extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('inv_model');

        $is_login = $this->session->userdata('is_login');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }

        $this->data['user'] = $this->inv_model->get_session();
    }

    public function index($id = null)
    {
        if ($this->session->userdata('email') === null) {
            redirect();
        }

        $data['id'] = $id;
        $data['list_barang'] = $this->inv_model->list_barang();
        $data['loss_pembelian'] = $this->inv_model->list_loss_pembelian();

        $data['title']              = 'IFkasir - Daftar Rugi';
        $data['breadcrumb_title']   = "Daftar Rugi";
        $data['breadcrumb_path']    = "Invetory / Daftar Rugi";
        $data['page']               = 'pages/inv/list_loss';

        $this->view($data);
    }

    public function set_rugi($id = null)
    {
        if ($this->session->userdata('email') === null) {
            redirect();
        }

        if (!isset($id)) {
            redirect();
        }

        $data['id'] = $id;
        $data['list_barang_pembelian'] = $this->inv_model->list_barang_pembelian($id);
        $data['detail_pembelian'] = $this->inv_model->list_detail_pembelian($id);
        $data['list_barang'] = $this->inv_model->list_barang();
        $data['detail_pembelian'] = $this->inv_model->list_detail_pembelian($id);

        $data['title']              = 'IFkasir -  Rugi Detail';
        $data['breadcrumb_title']   = "Detail Rugi";
        $data['breadcrumb_path']    = "Invetory / Detail Rugi / $id";
        $data['page']               = 'pages/inv/set_loss';

        $this->view($data);
    }

    // ============================ FUNCTION RUGI ==================================
    public function edit_rugi($id)
    {
        $cek_detail_pembelian = $this->db->where('id_detail_pembelian', $id)->get('detail_pembelian')->row_array();
        $id_pembelian = $this->input->post('id_pembelian');
        $qty_rusak = $this->input->post('jumlah_rusak');
        $subtotal_rugi = $this->input->post('total_rugi');
        $data = array(
            'qty_rusak' => $qty_rusak,
            'subtotal_rugi' => $subtotal_rugi
        );
        $this->db->where('id_detail_pembelian', $id);
        $this->db->update('detail_pembelian', $data);

        $cek_barang = $this->db->where('id_barang', $cek_detail_pembelian['id_barang'])->get('stock_barang')->row_array();
        $qty_inventory = $cek_barang['qty_inventory'] + $cek_detail_pembelian['qty_rusak'] - $qty_rusak;
        $data = array(
            'qty_inventory' => $qty_inventory
        );
        $this->db->where('id_barang', $cek_detail_pembelian['id_barang']);
        $this->db->update('stock_barang', $data);

        $stock_barang = $this->db->query("SELECT SUM(subtotal_rugi) AS total_rugi FROM detail_pembelian WHERE id_pembelian='$id_pembelian'")->row_array();
        $data = array(
            'total_rugi' => $stock_barang['total_rugi']
        );
        $this->db->where('id_pembelian', $id_pembelian);
        $this->db->update('pembelian', $data);
        redirect("InvLoss/set_rugi/$id_pembelian");
    }
}

/* End of file Invloss.php */
