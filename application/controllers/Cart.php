<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller 
{
    private $id;

    public function __construct()
    {
        parent::__construct();
        
        $is_login = $this->session->userdata('is_login');
        $this->id = $this->session->userdata('id');

        if (!$is_login) {
            $this->session->set_flashdata('warning', 'Anda belum login');
            redirect(base_url('login'));
            return;
        }
    }

    public function index()
    {
        $this->session->unset_userdata('keyword');

        $data['title']              = 'IFKasir - Keranjang Pesanan';
        $data['breadcrumb_title']   = "Keranjang Pesanan";
        $data['breadcrumb_path']    = 'Kasir / Keranjang Pesanan';
        $data['content']            = $this->cart->select([
                'stock_barang.id_barang', 'stock_barang.nama_barang', 'stock_barang.harga_jual', 
                'keranjang.id_pesanan', 'keranjang.qty_pesanan', 'keranjang.subtotal_pesanan',
            ])
            ->join('stock_barang', true)
            ->get();
        $data['page']               = 'pages/cart/index';

        $this->view($data);
    }

    /**
     * Menambah produk beserta kuantitasnya di home
     */
    public function add()
    {
        if (!$_POST || $this->input->post('qty_pesanan') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect(base_url('cashier'));
            return;
        }
        
        $input = (object) $this->input->post(null, true);

        // Mengambil data barang yang dipilih, untuk mendapatkan nama barang & harga barang
        $this->cart->table  = 'stock_barang';
        $barang             = $this->cart->where('id_barang', $input->id_barang)->first();

        // Ambil cart untuk dicek apakah barang sudah dipesan
        $this->cart->table  = 'keranjang';
        $cart               = $this->cart->where('id_barang', $input->id_barang)->first();

        $subtotal_pesanan   = $barang->harga_jual * $input->qty_pesanan;

        if ($cart) {    // Jika ternyata user sudah pesan, maka update cart
            $data = [
                'qty_pesanan'       => $cart->qty_pesanan + $input->qty_pesanan,
                'subtotal_pesanan'  => $cart->subtotal_pesanan + $subtotal_pesanan
            ];

            if ($this->cart->where('id_pesanan', $cart->id_pesanan)->update($data)) {   // Jika update berhasil
                $this->session->set_flashdata('success', 'Barang berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            }

            redirect(base_url('cart'));
        }

        // --- Insert cart baru ---
        $data = [
            'id_barang'         => $input->id_barang,
            'qty_pesanan'       => $input->qty_pesanan,
            'subtotal_pesanan'  => $subtotal_pesanan
        ];

        if ($this->cart->create($data)) {   // Jika insert berhasil
            $this->session->set_flashdata('success', 'Barang berhasil ditambahkan');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cart'));
    }

    /**
     * Update kuantitas di keranjang belanja
     */
    public function update()
    {
        if (!$_POST || $this->input->post('qty_pesanan') < 1) {
            $this->session->set_flashdata('error', 'Kuantitas tidak boleh kosong');
            redirect(base_url('cart'));
        }

        $id_barang = $this->input->post('id_barang');

        $data['content'] = $this->cart->where('id_barang', $id_barang)->first();   // Mengambil data dari cart

        if (!$data['content']) {
            $this->session->set_flashdata('warning', 'Data tidak ditemukan');
            redirect(base_url('cart'));
        }

        // Mengambil data barang yang dipilih, untuk mendapatkan harga barang
        $this->cart->table  = 'stock_barang';
        $barang             = $this->cart->where('id_barang', $data['content']->id_barang)->first();

        // Menghitung subtotal baru
        $data['input']      = (object) $this->input->post(null, true);
        $subtotal_pesanan   = $data['input']->qty_pesanan * $barang->harga_jual;

        // Update data
        $cart = [
            'qty_pesanan'       => $data['input']->qty_pesanan,
            'subtotal_pesanan'  => $subtotal_pesanan
        ];

        $this->cart->table  = 'keranjang';
        if ($this->cart->where('id_barang', $id_barang)->update($cart)) {   // Jika update berhasil
            $this->session->set_flashdata('success', 'Kuantitas berhasil diubah');
        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
        }

        redirect(base_url('cart'));
    }

    /**
     * Delete suatu cart di halaman cart
     */
    public function delete()
    {
        if (!$_POST) {
            // Jika diakses tidak dengan menggunakan method post, kembalikan ke home (forbidden)
            $this->session->set_flashdata('error', 'Akses penghapusan pesanan ditolak!');
            redirect(base_url('home'));
        }

        $id_pesanan = $this->input->post('id_pesanan');

        if (!$this->cart->where('id_pesanan', $id_pesanan)->first()) {  // Jika pesanan tidak ditemukan
            $this->session->set_flashdata('warning', 'Maaf data tidak ditemukan');
            redirect(base_url('cart'));
        }

        if ($this->cart->where('id_pesanan', $id_pesanan)->delete()) {  // Jika penghapusan pesanan berhasil
            $this->session->set_flashdata('success', '1 Pesanan berhasil dihapus');
        } else {
            $this->session->set_flashdata('error', 'Oops, terjadi suatu kesalahan');
        }

        redirect(base_url('cashier'));
    }

    /**
     * Menghapus seluruh isi keranjang
     */
    public function drop()
    {
        if (!$_POST) {
            $this->session->set_flashdata('error', 'Aksi ditolak');
            redirect(base_url('cart'));
            return;
        }

        if ($this->cart->count() < 1) {
            $this->session->set_flashdata('warning', 'Tidak ada pesanan di dalam keranjang');
            redirect(base_url('cart'));
            return;
        }

        $this->cart->nukeTable();
        $this->session->set_flashdata('success', 'Keranjang belanja dibersihkan');

        redirect(base_url('cart'));
    }
}

/* End of file Cart.php */
