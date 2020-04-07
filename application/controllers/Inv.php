<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Inv extends MY_Controller 
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

    // ============================ MAIN FUNCTION ==================================
    public function index()
    {
        $data['list_barang'] = $this->inv_model->list_barang();
        $data['list_pembelian'] = $this->inv_model->list_pembelian();
        $data['jumlah_barang'] = $this->inv_model->jumlah_barang();
        $data['jumlah_total_barang'] = $this->inv_model->jumlah_total_barang()['qty_inventory'];
        $data['jumlah_pegawai'] = $this->inv_model->jumlah_pegawai();
        $data['kerugian'] = $this->inv_model->kerugian()['kerugian'];

        $data['title']              = 'IFkasir - Inventory';
        $data['breadcrumb_title']   = "Dashboard Inventory";
        $data['breadcrumb_path']    = 'Invetory / Dashboard';
        $data['page']               = 'pages/inv/index';
        
        $this->view($data);
    }

    public function buy($id = null)
    {
        if ($this->session->userdata('email') === null) {
            redirect();
        }
        if (!isset($id)) {
            redirect();
        }
        $data['id'] = $id;
        $data['list_barang'] = $this->inv_model->list_barang();
        $data['pembelian'] = $this->inv_model->list_pembelian($id);
        $data['detail_pembelian'] = $this->inv_model->list_detail_pembelian($id);

        $data['title']              = 'IFkasir - Daftar Beli';
        $data['breadcrumb_title']   = "Daftar Beli";
        $data['breadcrumb_path']    = "Invetory / Daftar Beli / $id";
        $data['page']               = 'pages/inv/list_buy';

        $this->view($data);
    }

    // ============================ FUNCTION STOCK ==================================
    public function add_barang()
    {
        $nama_barang = $this->input->post('nama_barang');
        $tipe_barang = $this->input->post('jenis_makanan');
        $qty_inventory = $this->input->post('jumlah_barang');
        $harga_jual = $this->input->post('harga_barang');
        $data = array(
            'tipe_barang' => $tipe_barang,
            'nama_barang' => $nama_barang,
            'qty_inventory' => $qty_inventory,
            'harga_jual' => $harga_jual
        );
        $this->db->insert('stock_barang', $data);
        redirect('inv');
    }

    public function edit_barang($id)
    {
        $nama_barang = $this->input->post('nama_barang');
        $tipe_barang = $this->input->post('jenis_makanan');
        $qty_inventory = $this->input->post('jumlah_barang');
        $harga_jual = $this->input->post('harga_barang');
        $data = array(
            'tipe_barang' => $tipe_barang,
            'nama_barang' => $nama_barang,
            'qty_inventory' => $qty_inventory,
            'harga_jual' => $harga_jual
        );
        $this->db->where('id_barang', $id);
        $this->db->update('stock_barang', $data);
        redirect('inv');
    }

    public function delete_barang($id)
    {
        $this->db->where('id_barang', $id)->delete('stock_barang');
        redirect('inv');
    }

    // ============================ FUNCTION PEMBELIAN ==================================
    public function add_pembelian()
    {
        $id_pembelian = md5(uniqid());
        $nama_toko = $this->input->post('nama_toko');
        $waktu_pembelian = $this->input->post('date');
        $data = array(
            'id_pembelian' => $id_pembelian,
            'id_user' => $this->data['user']['id_user'],
            'nama_toko' => $nama_toko,
            'waktu_pembelian' => $waktu_pembelian
        );
        $this->db->insert('pembelian', $data);
        redirect("inv/buy/$id_pembelian");
    }

    public function edit_pembelian($id)
    {
        $nama_toko = $this->input->post('nama_toko');
        $banyak_barang = $this->input->post('banyak_barang');
        $total_harga = $this->input->post('total_harga');
        $data = array(
            'nama_toko' => $nama_toko,
            'banyak_barang' => $banyak_barang,
            'total_harga' => $total_harga
        );
        $this->db->where('id_pembelian', $id);
        $this->db->update('pembelian', $data);
        redirect('inv');
    }

    public function delete_pembelian($id)
    {
        $this->db->where('id_pembelian', $id)->delete('pembelian');
        redirect('inv');
    }

    public function set_status($id)
    {
        $cek_beli = $this->db->where('id_pembelian', $id)->get('pembelian')->row_array();
        $cek_detail_beli = $this->db->where('id_pembelian', $id)->get('detail_pembelian');


        if ($cek_beli['status'] == 1) {
            foreach ($cek_detail_beli->result() as $row) {
                $cek_barang = $this->db->where('id_barang', $row->id_barang)->get('stock_barang')->row_array();
                $qty_inventory = $cek_barang['qty_inventory'] - ($row->qty_beli - $row->qty_rusak);
                $data = array(
                    'qty_inventory' => $qty_inventory
                );
                $this->db->where('id_barang', $row->id_barang);
                $this->db->update('stock_barang', $data);
            }

            $data = array(
                'status' => 0
            );
        } else if ($cek_beli['status'] == 0) {
            foreach ($cek_detail_beli->result() as $row) {
                $cek_barang = $this->db->where('id_barang', $row->id_barang)->get('stock_barang')->row_array();
                $qty_inventory = $cek_barang['qty_inventory'] + ($row->qty_beli - $row->qty_rusak);
                $data = array(
                    'qty_inventory' => $qty_inventory
                );
                $this->db->where('id_barang', $row->id_barang);
                $this->db->update('stock_barang', $data);
            }

            $data = array(
                'status' => 1
            );
        }
        $this->db->where('id_pembelian', $id);
        $this->db->update('pembelian', $data);
        redirect('inv');
    }

    // ============================ FUNCTION PEMBELIAN DETAIL ==================================
    public function add_detail_pembelian()
    {
        $id_pembelian = $this->input->post('id_pembelian');
        $id_barang = $this->input->post('nama_barang');
        $qty_beli = $this->input->post('jumlah_barang');
        $subtotal_beli = $this->input->post('harga_barang');
        $cek_beli = $this->db->query("SELECT * FROM detail_pembelian WHERE id_pembelian = '$id_pembelian' AND id_barang = $id_barang")->row_array();
        if ($cek_beli) {
            $data = array(
                'qty_beli' => $qty_beli + $cek_beli['qty_beli'],
                'subtotal_beli' => $subtotal_beli + $cek_beli['subtotal_beli']
            );
            $this->db->where('id_detail_pembelian', $cek_beli['id_detail_pembelian']);
            $this->db->update('detail_pembelian', $data);
        } else {
            $data = array(
                'id_pembelian' => $id_pembelian,
                'id_barang' => $id_barang,
                'qty_beli' => $qty_beli,
                'subtotal_beli' => $subtotal_beli
            );
            $this->db->insert('detail_pembelian', $data);
        }
        $stock_barang = $this->db->query("SELECT SUM(qty_beli) AS banyak_barang, SUM(subtotal_beli) AS total_harga FROM `detail_pembelian` WHERE id_pembelian='$id_pembelian'")->row_array();
        $data = array(
            'banyak_barang' => $stock_barang['banyak_barang'],
            'total_harga' => $stock_barang['total_harga']
        );
        $this->db->where('id_pembelian', $id_pembelian);
        $this->db->update('pembelian', $data);
        redirect("inv/buy/$id_pembelian");
    }

    public function edit_detail_pembelian($id)
    {
        $id_pembelian = $this->input->post('id_pembelian');
        $qty_beli = $this->input->post('jumlah_barang');
        $subtotal_beli = $this->input->post('harga_barang');
        $data = array(
            'qty_beli' => $qty_beli,
            'subtotal_beli' => $subtotal_beli
        );
        $this->db->where('id_detail_pembelian', $id);
        $this->db->update('detail_pembelian', $data);


        $stock_barang = $this->db->query("SELECT SUM(qty_beli) AS banyak_barang, SUM(subtotal_beli) AS total_harga FROM `detail_pembelian` WHERE id_pembelian='$id_pembelian'")->row_array();
        $data = array(
            'banyak_barang' => $stock_barang['banyak_barang'],
            'total_harga' => $stock_barang['total_harga']
        );
        $this->db->where('id_pembelian', $id_pembelian);
        $this->db->update('pembelian', $data);
        redirect("inv/buy/$id_pembelian");
    }

    public function delete_detail_pembelian($id)
    {
        $cek_beli = $this->db->where('id_detail_pembelian', $id)->get('detail_pembelian')->row_array();
        if ($cek_beli) {
            $this->db->where('id_detail_pembelian', $id)->delete('detail_pembelian');

            $id_pembelian = $cek_beli['id_pembelian'];
            $stock_barang = $this->db->query("SELECT SUM(qty_beli) AS banyak_barang, SUM(subtotal_beli) AS total_harga FROM `detail_pembelian` WHERE id_pembelian='$id_pembelian'")->row_array();
            $data = array(
                'banyak_barang' => $stock_barang['banyak_barang'],
                'total_harga' => $stock_barang['total_harga']
            );
            $this->db->where('id_pembelian', $id_pembelian);
            $this->db->update('pembelian', $data);
        }

        redirect('inv');
    }
}

/* End of file Inv.php */
