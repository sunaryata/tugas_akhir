<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends CI_Model
{
	public function get($table, $data = null, $where = null)
	{
		if ($data != null) {
			return $this->db->get_where($table, $data)->row_array();
		} else {
			return $this->db->get_where($table, $where)->result_array();
		}
	}
	public function entry_update($id)
	{

		$this->db->select('barang');
		$this->db->from('stok');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $result = $query->row_array();
	}

	public function update($table, $pk, $id, $data)
	{
		$this->db->where($pk, $id);
		return $this->db->update($table, $data);
	}

	public function updateJoin($table, $pk, $id, $data)
	{
		$this->db->where($pk, $id);
		return $this->db->update($table, $data);
	}

	public function insert($table, $data, $batch = false)
	{
		return $batch ? $this->db->insert_batch($table, $data) : $this->db->insert($table, $data);
	}

	public function delete($table, $pk, $id)
	{
		return $this->db->delete($table, [$pk => $id]);
	}

	public function getUsers($id)
	{
		/**
		 * ID disini adalah untuk data yang tidak ingin ditampilkan. 
		 * Maksud saya disini adalah 
		 * tidak ingin menampilkan data user yang digunakan, 
		 * pada managemen data user
		 */
		$this->db->where('id_user !=', $id);
		$this->db->order_by('id_user', 'DESC');

		return $this->db->get('user')->result_array();
	}

	public function getBarang()
	{
		$this->db->join('jenis j', 'b.jenis_id = j.id_jenis');
		$this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
		$this->db->order_by('id_barang', 'DESC');
		return $this->db->get('barang b')->result_array();
	}

	public function getBarangMasuk($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('user u', 'bm.user_id = u.id_user');
		$this->db->join('supplier sp', 'bm.supplier_id = sp.id_supplier');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}
		if ($range != null) {
			$this->db->where('tanggal_masuk' . ' >=', $range['mulai']);
			$this->db->where('tanggal_masuk' . ' <=', $range['akhir']);
		}

		$this->db->order_by('bm.id_barang_masuk', 'DESC');
		return $this->db->get('barang_masuk bm')->result_array();
	}

	public function getBarangMasukDetail($id_barang_masuk, $limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->where('dbm.id_barang_masuk', $id_barang_masuk);
		$this->db->join('barang', 'dbm.barang_id = barang.id_barang');
		$this->db->join('satuan', 'barang.satuan_id = satuan.id_satuan');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}

		$this->db->order_by('dbm.id_barang_masuk', 'DESC');
		return $this->db->get('detail_barang_masuk dbm')->result_array();
	}

	public function getBarangMasukDetailAll($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('barang_masuk', 'dbm.id_barang_masuk = barang_masuk.id_barang_masuk');
		$this->db->join('barang', 'dbm.barang_id = barang.id_barang');
		$this->db->join('satuan', 'barang.satuan_id = satuan.id_satuan');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}

		$this->db->order_by('dbm.id_barang_masuk', 'DESC');
		return $this->db->get('detail_barang_masuk dbm')->result_array();
	}

	public function getBarangReturn($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('user u', 'br.user_id = u.id_user');
		$this->db->join('supplier s', 'br.id_supplier = s.id_supplier');

		


		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
		}
		if ($range != null) {
			$this->db->where('tanggal_return' . ' >=', $range['mulai']);
			$this->db->where('tanggal_return' . ' <=', $range['akhir']);
		}

		$this->db->order_by('id_barang_return', 'DESC');
		return $this->db->get('barang_return br')->result_array();
	}

	public function getBarangReturnDetail($id_barang_return, $limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->where('dbm.id_barang_return', $id_barang_return);
		// $this->db->join('supplier', 'dbm.id_supplier = supplier.id_supplier');
		
		$this->db->join('barang', 'dbm.barang_id = barang.id_barang');
		$this->db->join('satuan', 'barang.satuan_id = satuan.id_satuan');

		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}

		$this->db->order_by('dbm.id_barang_return', 'DESC');
		return $this->db->get('detail_barang_return dbm')->result_array();
	}

	public function getBarangReturnDetailAll($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('barang_return', 'dbm.id_barang_return = barang_return.id_barang_return');
		$this->db->join('barang', 'dbm.barang_id = barang.id_barang');
		$this->db->join('satuan', 'barang.satuan_id = satuan.id_satuan');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}

		$this->db->order_by('dbm.id_barang_return', 'DESC');
		return $this->db->get('detail_barang_return dbm')->result_array();
	}

	public function getBarangKeluar($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('user u', 'bK.user_id = u.id_user');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			// $this->db->where('id_barang', $id_barang);
		}
		if ($range != null) {
			$this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
			$this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
		}
		$this->db->order_by('bk.id_barang_keluar', 'DESC');
		return $this->db->get('barang_keluar bk')->result_array();
	}


	public function getBarangKeluarDetail($id_barang_keluar, $limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->where('dbm.id_barang_keluar', $id_barang_keluar);
		$this->db->join('barang', 'dbm.barang_id = barang.id_barang');
		$this->db->join('satuan', 'barang.satuan_id = satuan.id_satuan');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}

		$this->db->order_by('dbm.id_barang_keluar', 'DESC');
		return $this->db->get('detail_barang_keluar dbm')->result_array();
	}

	public function getBarangKeluarDetailAll($limit = null, $id_barang = null, $range = null)
	{
		$this->db->select('*');
		$this->db->join('barang_keluar', 'dbm.id_barang_keluar = barang_keluar.id_barang_keluar');
		$this->db->join('barang', 'dbm.barang_id = barang.id_barang');
		$this->db->join('satuan', 'barang.satuan_id = satuan.id_satuan');
		if ($limit != null) {
			$this->db->limit($limit);
		}
		if ($id_barang != null) {
			$this->db->where('id_barang', $id_barang);
		}

		$this->db->order_by('dbm.id_barang_keluar', 'DESC');
		return $this->db->get('detail_barang_keluar dbm')->result_array();
	}

	public function getBarangKu()
	{
		// $this->db->select('*');
		// $this->db->join('user u', 'br.user_id = u.id_user');
		// $this->db->join('barang b', 'br.barang_id = b.id_barang');
		// $this->db->join('satuan s', 'b.satuan_id = s.id_satuan');
		// if ($limit != null) {
		//     $this->db->limit($limit);
		// }
		// if ($id_barang != null) {
		//     $this->db->where('id_barang', $id_barang);
		// }
		// if ($range != null) {
		//     $this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
		//     $this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
		// }
		$this->db->order_by('id_barang', 'DESC');
		return $this->db->get('barang bk')->result_array();

		// return $this->db->get('barang')->result_array();
	}

	public function getMax($table, $field, $kode = null)
	{
		$this->db->select_max($field);
		if ($kode != null) {
			$this->db->like($field, $kode, 'after');
		}
		return $this->db->get($table)->row_array()[$field];
	}

	public function count($table)
	{
		return $this->db->count_all($table);
	}

	public function sum($table, $field)
	{
		$this->db->select_sum($field);
		return $this->db->get($table)->row_array()[$field];
	}

	public function min($table, $field, $min)
	{
		$field = $field . ' <=';
		$this->db->where($field, $min);
		return $this->db->get($table)->result_array();
	}

	public function chartBarangMasuk($bulan)
	{
		$like = 'T-BM-' . date('y') . $bulan;
		$this->db->like('id_barang_masuk', $like, 'after');
		return count($this->db->get('barang_masuk')->result_array());
	}

	public function chartBarangKeluar($bulan)
	{
		$like = 'T-BK-' . date('y') . $bulan;
		$this->db->like('id_barang_keluar', $like, 'after');
		return count($this->db->get('barang_keluar')->result_array());
	}

	public function laporan($table, $mulai, $akhir)
	{
		$tgl = $table == 'barang_masuk' ? 'tanggal_masuk' : 'tanggal_keluar';
		$this->db->where($tgl . ' >=', $mulai);
		$this->db->where($tgl . ' <=', $akhir);
		return $this->db->get($table)->result_array();
	}

	public function cekStok($id)
	{
		$this->db->join('satuan s', 'b.satuan_id=s.id_satuan');
		return $this->db->get_where('barang b', ['id_barang' => $id])->row_array();
	}
}
