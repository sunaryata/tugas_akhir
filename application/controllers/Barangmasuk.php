<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangmasuk extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		cek_login();

		$this->load->model('Admin_model', 'admin');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['title'] = "Barang Masuk";
		$data['barangmasuk'] = $this->admin->getBarangMasukList();
		$this->template->load('templates/dashboard', 'barang_masuk/data', $data);
		// var_dump($data);
	}

	public function detail($id_barang_masuk = null)
	{
		if (!$id_barang_masuk) {
			header('Location: ../');
		}
		$data['title'] = "Barang Masuk Detail";
		$data['id_barang_masuk'] = $id_barang_masuk;
		$data['barang'] = $this->admin->get('barang');
		$data['barangmasuk'] = $this->admin->getBarangMasukDetail($id_barang_masuk);
		$this->template->load('templates/dashboard', 'barang_masuk_detail/data', $data);
		// var_dump($data);
	}

	private function _validasi()
	{
		$this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
		$this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
		// $this->form_validation->set_rules('barang_id', 'Barang', 'required');
		// $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim|numeric|greater_than[0]');
	}

	private function _validasi_detail()
	{
		$this->form_validation->set_rules('barang_id', 'Barang', 'required');
		$this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim|numeric|greater_than[0]');
	}

	public function add()
	{
		$this->_validasi();
		if ($this->form_validation->run() == false) {
			$data['title'] = "Barang Masuk";
			$data['supplier'] = $this->admin->get('supplier');
			$data['barang'] = $this->admin->get('barang');

			// Mendapatkan dan men-generate kode transaksi barang masuk
			$kode = 'T-BM-' . date('ymd');
			$kode_terakhir = $this->admin->getMax('barang_masuk', 'id_barang_masuk', $kode);
			$kode_tambah = substr($kode_terakhir, -5, 5);
			$kode_tambah++;
			$number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
			$data['id_barang_masuk'] = $kode . $number;
			// var_dump($data);
			$this->template->load('templates/dashboard', 'barang_masuk/add', $data);
		} else {
			$input = $this->input->post(null, true);
			$insert = $this->admin->insert('barang_masuk', $input);
			var_dump($input);
			// die;

			if ($insert) {
				set_pesan('data berhasil disimpan.');
				redirect('barangmasuk');
			} else {
				set_pesan('Opps ada kesalahan!');
				redirect('barangmasuk/add_detail/');
			}
		}
	}

	public function add_detail($id_barang_masuk)
	{
		$this->_validasi_detail();
		if ($this->form_validation->run() == false) {
			$data['title'] = "Barang Masuk";
			$data['supplier'] = $this->admin->get('supplier');
			$data['barang'] = $this->admin->get('barang');

			$data['id_barang_masuk'] = $id_barang_masuk;
			// var_dump($data);
			$this->template->load('templates/dashboard', 'barang_masuk_detail/add', $data);
		} else {
			$input = $this->input->post(null, true);
			$insert = $this->admin->insert('detail_barang_masuk', [
				'id_barang_masuk' => $id_barang_masuk,
				'barang_id' => $_REQUEST['barang_id'],
				'jumlah_masuk' => $_REQUEST['jumlah_masuk'],
			]);
			var_dump($input);
			$id_barang = $_REQUEST['barang_id'];

			$dataku = $this->admin->get('barang', ['id_barang' => $id_barang]);
			$total_stok = $dataku['stok'] + $_REQUEST['jumlah_masuk'];
			$this->db->set('stok', $total_stok);
			$this->db->where('id_barang', $_REQUEST['barang_id']);
			$this->db->update('barang');
			// die;

			if ($insert) {
				set_pesan('data berhasil disimpan.');
				redirect('barangmasuk/detail/' . $id_barang_masuk);
			} else {
				set_pesan('Opps ada kesalahan!');
				redirect('barangmasuk/add_detail/' . $id_barang_masuk);
			}
		}
	}
	
	public function edit($getId)
	{
		$id = encode_php_tags($getId);
		// $this->_validasi();
		// $this->form_validation->set_rules('stok', 'stok Barang', 'required');
		// $this->form_validation->set_rules('total_stok', 'stok Barang', 'required');
		$this->form_validation->set_rules('barang_id', 'Barang', 'required');
		$this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
		// $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim|numeric|greater_than[0]');
		if ($this->form_validation->run() == false) {
			$data['title'] = "Barang";
			$data['supplier'] = $this->admin->get('supplier');
			$data['satuan'] = $this->admin->get('satuan');
			$data['barangku'] = $this->admin->get('barang');

			$data['barang'] = $this->admin->get('barang_masuk', ['id_barang_masuk' => $id]);
			$this->template->load('templates/dashboard', 'barang_masuk/edit', $data);
		} else {
			$datamasuk = $this->admin->get('barang_masuk', ['id_barang_masuk' => $id]);
			$ambildatamasuk = $datamasuk['jumlah_masuk'];

			//ambil ID Barang
			$data['barang'] = $this->admin->get('barang', ['id_barang' => $id]);

			$c = $this->input->post('barang_id');
			$d = $this->input->post('jumlah_masuk');
			$e = $this->input->post('jumlahku');
			$tukar = $c;
			$id_barang = $tukar;

			$dataku = $this->admin->get('barang', ['id_barang' => $id_barang]);
			$cekdata = $dataku['stok'] - $ambildatamasuk;
			$total_barang = $cekdata + $d;
			var_dump($total_barang);

			//update manual data barang
			$this->db->set('stok', $total_barang);
			$this->db->where('id_barang', $id_barang);
			$this->db->update('barang');


			// update data barang masuk kaka
			$input = $this->input->post(null, true);
			$update = $this->admin->update('barang_masuk', 'id_barang_masuk', $id, $input);
			if ($update) {
				set_pesan('data berhasil disimpan');
				redirect('barangmasuk');
			} else {
				set_pesan('gagal menyimpan data');
				redirect('barang/edit/' . $id);
			}
		}
	}
	public function edit_detail($id_detail_barang_masuk)
	{
		$detail_barang_masuk = $this->db->where('id_detail_barang_masuk', $id_detail_barang_masuk)->get('detail_barang_masuk')->row_array();
		$datamasuk = $this->db->where('id_barang_masuk', $detail_barang_masuk['id_barang_masuk'])->get('barang_masuk')->row_array();

		$ambildatamasuk = $detail_barang_masuk['jumlah_masuk'];

		//ambil ID Barang
		$data['barang'] = $this->admin->get('barang', ['id_barang' => $detail_barang_masuk['barang_id']]);

		$dataku = $this->admin->get('barang', ['id_barang' => $detail_barang_masuk['barang_id']]);

		$cekdata = $dataku['stok'] - $ambildatamasuk;
		$total_barang = $cekdata + $_POST['jumlah_barang'];

		// echo "<pre>";
		// print_r($total_barang);
		// echo "</pre>";

		// die;

		//update manual data barang
		$this->db->set('stok', $total_barang);
		$this->db->where('id_barang', $detail_barang_masuk['barang_id']);
		$this->db->update('barang');


		// update data barang masuk kaka
		$update = $this->db->where('id_detail_barang_masuk', $id_detail_barang_masuk)->update('detail_barang_masuk', [
			'jumlah_masuk' => $_POST['jumlah_barang'],
		]);
		if ($update) {
			set_pesan('data berhasil disimpan');
			redirect('barangmasuk/detail/' . $detail_barang_masuk['id_barang_masuk']);
		} else {
			set_pesan('gagal menyimpan data');
			redirect('barangmasuk/detail/' . $detail_barang_masuk['id_barang_masuk']);
		}
	}

	public function deleteitem($getId)
    {
        echo $id = encode_php_tags($getId);
        if ($this->admin->delete('detail_barang_masuk', 'id_detail_barang_masuk', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangmasuk');
    }

	public function delete($getId)
	{
		$id = encode_php_tags($getId);

		$this->db->where('id_barang_masuk', $getId);
		$data_detail = count($this->db->get('detail_barang_masuk')->result());
		if ($data_detail > 0) {
			set_pesan('data gagal dihapus. Data detail sudah ada', false);
			redirect('barangmasuk');
		}
		if ($this->admin->delete('barang_masuk', 'id_barang_masuk', $id)) {
			set_pesan('data berhasil dihapus.');
		} else {
			set_pesan('data gagal dihapus.', false);
		}
		redirect('barangmasuk');
	}


	public function api_detail_barang_masuk($id_detail_barang_masuk)
	{
		$this->db->join('barang', 'detail_barang_masuk.barang_id = barang.id_barang');
		$this->db->where('id_detail_barang_masuk', $id_detail_barang_masuk);
		$data = $this->db->get('detail_barang_masuk')->row();
		echo json_encode($data);
	}
}
