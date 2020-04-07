<?php

class Inv_model extends CI_Model
{
	public function get_session()
	{
		$query = $this->db->get_where('user', ['email' => $this->session->userdata('email')]);
		return $query->row_array();
	}
	public function list_barang()
	{
		return $this->db->get('stock_barang');
	}
	public function list_pembelian($id = null)
	{
		if ($id == null) {
			return $this->db->query("SELECT id_pembelian, user.nama, nama_toko, waktu_pembelian, banyak_barang, total_harga, pembelian.status FROM pembelian JOIN user ON user.id_user=pembelian.id_user");
		} else {
			return $this->db->query("SELECT id_pembelian, user.nama, nama_toko, waktu_pembelian, banyak_barang, total_harga, pembelian.status FROM pembelian JOIN user ON user.id_user=pembelian.id_user WHERE id_pembelian='$id'")->row_array();
		}
	}
	public function list_loss_pembelian()
	{
		return $this->db->query("SELECT id_pembelian, user.nama, nama_toko, waktu_pembelian, banyak_barang, total_harga, total_rugi, pembelian.status FROM pembelian JOIN user ON user.id_user=pembelian.id_user WHERE pembelian.status='1' ORDER BY id_pembelian DESC");
		return $this->db->where('status', 1)->get('pembelian');
	}
	public function list_detail_pembelian($id)
	{
		return $this->db->query("SELECT id_detail_pembelian, id_pembelian, stock_barang.nama_barang, qty_beli, qty_rusak, subtotal_beli, subtotal_rugi FROM detail_pembelian JOIN stock_barang ON detail_pembelian.id_barang=stock_barang.id_barang WHERE id_pembelian='$id'");
	}
	public function jumlah_barang()
	{
		return $this->db->count_all_results('stock_barang');
	}
	public function jumlah_total_barang()
	{
		return $this->db->select('SUM(qty_inventory) as qty_inventory')->get('stock_barang')->row_array();
	}
	public function jumlah_pegawai()
	{
		return $this->db->count_all_results('user');
	}
	public function kerugian()
	{
		return $this->db->select('SUM(total_rugi) as kerugian')->get('pembelian')->row_array();
	}

	public function list_barang_pembelian($id = null)
	{
		return $this->db->query("SELECT detail_pembelian.id_barang, stock_barang.nama_barang FROM detail_pembelian JOIN stock_barang ON detail_pembelian.id_barang=stock_barang.id_barang WHERE id_pembelian='$id'");
	}
}
