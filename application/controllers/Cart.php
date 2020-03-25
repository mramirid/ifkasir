<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends MY_Controller 
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
        $this->session->unset_userdata('keyword');

        $data['title']              = 'IFKasir - Keranjang Pesanan';
        $data['breadcrumb_title']   = "Keranjang Pesanan";
        $data['breadcrumb_path']    = 'Kasir / Keranjang Pesanan';
        $data['content']            = $this->cart->select([
                'stock_barang.id_barang', 'stock_barang.nama_barang', 'stock_barang.harga_jual', 
                'keranjang.id_pesanan', 'keranjang.qty_pesanan', 'keranjang.subtotal_pesanan',
            ])
            ->where('keranjang.id_user', $this->id_user)
            ->join('stock_barang', $this->cart->ACTION_TRIM_JOIN)
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
        $cart               = $this->cart->where('id_barang', $input->id_barang)
                                ->where('id_user', $this->id_user)
                                ->first();

        $subtotal_pesanan   = $barang->harga_jual * $input->qty_pesanan;

        if ($cart) {    // Jika ternyata user sudah pesan, maka update cart
            $data = [
                'qty_pesanan'       => $cart->qty_pesanan + $input->qty_pesanan,
                'subtotal_pesanan'  => $cart->subtotal_pesanan + $subtotal_pesanan
            ];

            // Update data
            if ($this->cart->where('id_pesanan', $cart->id_pesanan)
                           ->where('id_user', $this->id_user)
                           ->update($data)) 
            {
                $this->session->set_flashdata('success', 'Barang berhasil ditambahkan');
            } else {
                $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            }

            redirect(base_url('cart'));
        }

        // --- Insert cart baru ---
        $data = [
            'id_user'           => $this->id_user,
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
        }

        if ($this->cart->where('id_user', $this->id_user)->count() < 1) {
            $this->session->set_flashdata('warning', 'Tidak ada pesanan di dalam keranjang');
            redirect(base_url('cart'));
        }

        $this->cart->where('id_user', $this->id_user)->delete();    // Hapus seluruh pesanan dari user

        if ($this->cart->count() < 1) {  // Jika tabel pesanan kosong, reset index id_pesanan
            $this->cart->nukeTable();
        }

        $this->session->set_flashdata('success', 'Keranjang belanja dibersihkan');

        redirect(base_url('cart'));
    }

    /**
     * Fungsi ini memasukan informasi penjualan ke tabel 'penjualan' 
     * dan memindahkan list keranjang pesanan ke 'detail_penjualan'
     */
    public function checkout()
    {
        if (!isset($this->id_user)) {
            $this->session->set_flashdata('error', 'Akses checkout ditolak!');
            redirect(base_url('home'));
        }

        // Cek apakah user memiliki pesanan di keranjang
        $jumlahPesanan = $this->cart->where('id_user', $this->id_user)->count();
        
        if (!$jumlahPesanan) {
            $this->session->set_flashdata('warning', 'Tidak ada pesanan!');
            redirect(base_url('home'));
        }

        if (!$this->cart->validateStock()) { // Valdasi stok
            return $this->index();
        }

        // Menghitung total dari subtotal pesanan suatu user
        $total = $this->db->select_sum('subtotal_pesanan')
            ->where('id_user', $this->id_user)
            ->get('keranjang')
            ->row()                 // Select first row
            ->subtotal_pesanan;     // Select column subtotal_pesanan

        // Menyiapkan insert table penjualan
        $data['id_user'] = $this->id_user;

        // Jika insert penjualan berhasil, siapkan insert lagi ke dalam detail_penjualan
        $this->cart->table = 'penjualan';
        if ($id_penjualan = $this->cart->create($data)) { 
            // Ambil list pesanan yang telah dipesan user
            $cart = $this->db->where('id_user', $this->id_user) 
                             ->get('keranjang')
                             ->result_array();

            // Modifikasi tiap cart
            foreach ($cart as $row) {
                $row['id_penjualan'] = $id_penjualan;           // Tambah kolom id_order
                $row['qty_jual']     = $row['qty_pesanan'];
                unset($row['id_pesanan'], $row['id_user'], $row['qty_pesanan'], $row['subtotal_pesanan']);   // Hapus kolom tidak penting
                $this->db->insert('detail_penjualan', $row);    // Insert ke tabel detail_penjualan
            }

            $this->db->delete('keranjang', ['id_user' => $this->id_user]);    // Hapus cart user sekarang

            $this->session->set_flashdata('success', 'Data berhasil disimpan');

            $data['title']              = 'Checkout';
            $data['breadcrumb_title']   = "Checkout";
            $data['breadcrumb_path']    = 'Kasir / Keranjang Pesanan / Checkout';
            $data['page']               = 'pages/checkout/index';

            // Ambil data penjualan
            $this->table        = 'penjualan';
            $data['penjualan']  = $this->cart->select([
                    'user.id_user', 'user.nama',
                    'penjualan.id_penjualan', 'penjualan.waktu_penjualan'
                ])
                ->join('user', $this->cart->ACTION_ADD_JOIN)
                ->where('penjualan.id_penjualan', $id_penjualan)
                ->where('penjualan.id_user', $this->id_user)
                ->first();

            $this->cart->table          = 'detail_penjualan';
            $data['list_pesanan'] = $this->cart->select([
                    'detail_penjualan.qty_jual', 'detail_penjualan.subtotal_jual',
                    'stock_barang.nama_barang', 'stock_barang.harga_jual',
                ])
                ->join('stock_barang', $this->cart->ACTION_TRIM_JOIN)
                ->where('detail_penjualan.id_penjualan', $id_penjualan)
                ->get();

            $this->view($data);

        } else {
            $this->session->set_flashdata('error', 'Oops! Terjadi kesalahan');
            $this->index();
        }
    }
}

/* End of file Cart.php */
