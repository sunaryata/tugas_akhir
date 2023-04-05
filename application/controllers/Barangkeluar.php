<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangkeluar extends CI_Controller
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
        $data['title'] = "Barang keluar";
        $data['barangkeluar'] = $this->admin->getBarangkeluarList();
        $this->template->load('templates/dashboard', 'barang_keluar/data', $data);
    }

    public function detail($id_barang_keluar = null)
	{
		if (!$id_barang_keluar) {
			header('Location: ../');
		}
		$data['title'] = "Barang Keluar Detail";
		$data['id_barang_keluar'] = $id_barang_keluar;
		$data['barang'] = $this->admin->get('barang');
		$data['barangmasuk'] = $this->admin->getBarangKeluarDetail($id_barang_keluar);
		$this->template->load('templates/dashboard', 'barang_keluar_detail/data', $data);
		// var_dump($data);
	}

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
        // $this->form_validation->set_rules('barang_id', 'Barang', 'required');

        // $input = $this->input->post('barang_id', true);
        // $stok = $this->admin->get('barang', ['id_barang' => $input])['stok'];
        // $stok_valid = $stok + 1;

        // $this->form_validation->set_rules(
        //     'jumlah_keluar',
        //     'Jumlah Keluar',
        //     "required|trim|numeric|greater_than[0]|less_than[{$stok_valid}]",
        //     [
        //         'less_than' => "Jumlah Keluar tidak boleh lebih dari {$stok}"
        //     ]
        // );
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
            $data['title'] = "Barang Keluar";
            $data['barang'] = $this->admin->get('barang', null, ['stok >' => 0]);

            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'T-BK-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_keluar', 'id_barang_keluar', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_keluar'] = $kode . $number;

            $this->template->load('templates/dashboard', 'barang_keluar/add', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->admin->insert('barang_keluar', $input);

            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barangkeluar');
            } else {
                set_pesan('Opps ada kesalahan!');
                redirect('barangkeluar/add');
            }
        }
    }

    public function add_detail($id_barang_keluar)
	{
		$this->_validasi_detail();
		if ($this->form_validation->run() == false) {
			$data['title'] = "Barang Keluar";
			$data['supplier'] = $this->admin->get('supplier');
			$data['barang'] = $this->admin->get('barang');

			$data['id_barang_keluar'] = $id_barang_keluar;
			// var_dump($data);
			$this->template->load('templates/dashboard', 'barang_keluar_detail/add', $data);
		} else {
			$input = $this->input->post(null, true);
			$insert = $this->admin->insert('detail_barang_keluar', [
				'id_barang_keluar' => $id_barang_keluar,
				'barang_id' => $_REQUEST['barang_id'],
				'jumlah_masuk' => $_REQUEST['jumlah_masuk'],
			]);
			var_dump($input);

            $this->db->set('stok', $_REQUEST['total_stok']);
		$this->db->where('id_barang', $_REQUEST['barang_id']);
		$this->db->update('barang');
			// die;

			if ($insert) {
				set_pesan('data berhasil disimpan.');
				redirect('barangkeluar/detail/' . $id_barang_keluar);
			} else {
				set_pesan('Opps ada kesalahan!');
				redirect('barangkeluar/add_detail/' . $id_barang_keluar);
			}
		}
	}


    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        // $this->form_validation->set_rules('stok', 'stok Barang', 'required');
        // $this->_validasi();
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        // $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('jumlah_keluar', 'Jumlah keluar', 'required|trim|numeric|greater_than[0]');


        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang";
            $data['barangku'] = $this->admin->get('barang', null, ['stok >' => 0]);
            $data['barang'] = $this->admin->get('barang_keluar', ['id_barang_keluar' => $id]);
            $this->template->load('templates/dashboard', 'barang_keluar/edit', $data);
        } else {
            $datakeluar = $this->admin->get('barang_keluar', ['id_barang_keluar' => $id]);
            $ambildatakeluar = $datakeluar['jumlah_keluar'];

            //ambil ID Barang
            $data['barang'] = $this->admin->get('barang', ['id_barang' => $id]);
            
            $c = $this->input->post('barang_id');
            $d = $this->input->post('jumlah_keluar');
            
            $tukar = $c;
            $id_barang=$tukar;
            
            var_dump($id_barang);
            $dataku = $this->admin->get('barang',['id_barang'=>$id_barang]);
            $cekdata = $dataku['stok']+$ambildatakeluar;
            $total_barang = $cekdata - $d;
            // var_dump($cekdata);
            // var_dump($total_barang);
            // die;
            
           //update manual data barang
           $this->db->set('stok', $total_barang);
            $this->db->where('id_barang', $id_barang);
            $this->db->update('barang');


            $input = $this->input->post(null, true);
            $update = $this->admin->update('barang_keluar', 'id_barang_keluar', $id, $input);
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('barangkeluar');

            } else {
                set_pesan('gagal menyimpan data');
                redirect('barang/edit/' . $id);
            }
        }
    }

    public function edit_detail($id_detail_barang_keluar)
	{
		$detail_barang_keluar = $this->db->where('id_detail_barang_keluar', $id_detail_barang_keluar)->get('detail_barang_keluar')->row_array();
		$datamasuk = $this->db->where('id_barang_keluar', $detail_barang_keluar['id_barang_keluar'])->get('barang_keluar')->row_array();

		$ambildatamasuk = $detail_barang_keluar['jumlah_masuk'];

		//ambil ID Barang
		$data['barang'] = $this->admin->get('barang', ['id_barang' => $detail_barang_keluar['barang_id']]);

		$dataku = $this->admin->get('barang', ['id_barang' => $detail_barang_keluar['barang_id']]);

		$cekdata = $dataku['stok'] - $ambildatamasuk;
		$total_barang = $cekdata + $_POST['jumlah_barang'];
        $total_stok= $_POST['total_stok'];

		// echo "<pre>";
		// print_r($total_barang);
		// echo "</pre>";

		// die;

		//update manual data barang
		$this->db->set('stok', $total_stok);
		$this->db->where('id_barang', $detail_barang_keluar['barang_id']);
		$this->db->update('barang');


		// update data barang masuk kaka
		$update = $this->db->where('id_detail_barang_keluar', $id_detail_barang_keluar)->update('detail_barang_keluar', [
			'jumlah_masuk' => $_POST['jumlah_barang'],
		]);
		if ($update) {
			set_pesan('data berhasil disimpan');
			redirect('barangkeluar/detail/' . $detail_barang_keluar['id_barang_keluar']);
		} else {
			set_pesan('gagal menyimpan data');
			redirect('barangkeluar/detail/' . $detail_barang_keluar['id_barang_keluar']);
		}
	}


    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_keluar', 'id_barang_keluar', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangkeluar');
    }

    public function api_detail_barang_keluar($id_detail_barang_keluar)
	{
		$this->db->join('barang', 'detail_barang_keluar.barang_id = barang.id_barang');
		$this->db->where('id_detail_barang_keluar', $id_detail_barang_keluar);
		$data = $this->db->get('detail_barang_keluar')->row();
		echo json_encode($data);
	}
}
