<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barangreturn extends CI_Controller
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
        $data['title'] = "Barang Return";
        $data['barangreturn'] = $this->admin->getBarangReturn();
        $this->template->load('templates/dashboard', 'barang_return/data', $data);
        // var_dump($data);
        // die;
        // $data['title'] = "Barang Return";
        // $data['barangreturn '] = $this->admin->getBarangReturn();
        // $this->template->load('templates/dashboard', 'barang_return/data', $data);
        // var_dump($data);
    }

    public function detail($id_barang_return = null)
	{
		if (!$id_barang_return) {
			header('Location: ../');
		}
		$data['title'] = "Barang Return Detail";
		$data['id_barang_return'] = $id_barang_return;
		$data['barang'] = $this->admin->get('barang');
		$data['barangmasuk'] = $this->admin->getBarangReturnDetail($id_barang_return);
		$this->template->load('templates/dashboard', 'barang_return_detail/data', $data);
		// var_dump($data);
	}

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_return', 'Tanggal return', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');

        $input = $this->input->post('barang_id', true);
        $stok = $this->admin->get('barang', ['id_barang' => $input])['stok'];
        $stok_valid = $stok + 1;

        $this->form_validation->set_rules(
            'jumlah_return',
            'Jumlah return',
            "required|trim|numeric|greater_than[0]|less_than[{$stok_valid}]",
            [
                'less_than' => "Jumlah return tidak boleh lebih dari {$stok}"
            ]
        );
    }

    public function add()
    {
        $this->_validasi();
        // $idku = $data['id_barang_return'];
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Return";
            $data['supplier'] = $this->admin->get('supplier');
            $data['barang'] = $this->admin->get('barang');

            // Mendapatkan dan men-generate kode transaksi barang return
            $kode = 'T-BR-' . date('ymd');
            $kode_terakhir = $this->admin->getMax('barang_return', 'id_barang_return', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_return'] = $kode . $number;

            // var_dump($data);
            // die;
            $this->template->load('templates/dashboard', 'barang_return/add', $data);
        } else {
            // $datareturn = $this->admin->get('barang_return', ['id_barang_return' => $id]);
            // $ambildatareturn = $datareturn['jumlah_return'];

            //ambil ID Barang
            // $data['barang'] = $this->admin->get('barang', ['id_barang' => $id]);
            
            // $c = $this->input->post('barang_id');
            // $d = $this->input->post('jumlah_return');
            // $e = $this->input->post('jumlahku');
            // $tukar = $c;
            // $id_barang=$tukar;
            $c = $this->input->post('id_barang_return');
            $d = $this->input->post('barang_id');
            $ambildatareturn = $this->input->post('jumlah_return');
            $tukar = $d;
            $id_barang=$tukar;
            
            $databarangku = $this->admin->get('barang',['id_barang'=>$id_barang]);
            $total_barang = $databarangku['stok']-$ambildatareturn;
        //     // $total_barang = $cekdata + $d;
           var_dump($total_barang);;
            
        //    update manual data barang
           $this->db->set('stok', $total_barang);
            $this->db->where('id_barang', $id_barang);
            $this->db->update('barang');

            // var_dump($c);
            // var_dump($d);
            // var_dump($ambildatareturn);
            // die;
            $input = $this->input->post(null, true);
            var_dump($input);
            // die;
            $insert = $this->admin->insert('barang_return', $input);
            // var_dump($insert);


            if ($insert) {
                set_pesan('data berhasil disimpan.');
                redirect('barangreturn');
            } else {
                set_pesan('Opps ada kesalahan!');
            
                redirect('barangreturn/add');
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
        $this->form_validation->set_rules('jumlah_return', 'Jumlah return', 'required|trim|numeric|greater_than[0]');


        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Return";
            // $data['supplier'] = $this->admin->get('supplier');
            // $data['satuan'] = $this->admin->get('satuan');
            $data['barangku'] = $this->admin->get('barang');
            // var_dump($data['supplier']);
            // die;
            // $data['stok'] = $this->admin->get('stok');
            $data['barang'] = $this->admin->get('barang_return', ['id_barang_return' => $id]);
            $this->template->load('templates/dashboard', 'barang_return/edit', $data);
        } else {
            $input = $this->input->post(null, true);
            // var_dump($input);
            // die;
            // $update = $this->admin->update('barang_return', 'id_barang_return', $id, $input);

            $datareturn = $this->admin->get('barang_return', ['id_barang_return' => $id]);
            $ambildatareturn = $datareturn['jumlah_return'];
            // var_dump($ambildatareturn);
            // die;

            //ambil ID Barang
            $data['barang'] = $this->admin->get('barang', ['id_barang' => $id]);
            
            $c = $this->input->post('barang_id');
            $d = $this->input->post('jumlah_return');
            $tukar = $c;
            $id_barang=$tukar;
            //
            var_dump($id_barang);
            $dataku = $this->admin->get('barang',['id_barang'=>$id_barang]);
            $cekdata = $dataku['stok']+$ambildatareturn;
            $total_barang = $cekdata - $d;
            // var_dump($cekdata);
            // var_dump($total_barang);
            // die;
            // die;
            
           //update manual data barang
           $this->db->set('stok', $total_barang);
            $this->db->where('id_barang', $id_barang);
            $this->db->update('barang');


            $input = $this->input->post(null, true);
            $update = $this->admin->update('barang_return', 'id_barang_return', $id, $input);
            if ($update) {
                set_pesan('data berhasil disimpan');
                redirect('barangreturn');

            } else {
                set_pesan('gagal menyimpan data');
                redirect('barang/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        if ($this->admin->delete('barang_return', 'id_barang_return', $id)) {
            set_pesan('data berhasil dihapus.');
        } else {
            set_pesan('data gagal dihapus.', false);
        }
        redirect('barangreturn');
    }
}
