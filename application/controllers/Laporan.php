<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends CI_Controller
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
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[barang_masuk,barang_keluar,barang_return,barang]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

        if ($this->form_validation->run() == false) {
            $data['title'] = "Laporan Transaksi";
            $this->template->load('templates/dashboard', 'laporan/form', $data);
            
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'barang_masuk') {
                $query = $this->admin->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else if($table == 'barang_keluar'){
                $query = $this->admin->getBarangKeluar(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else if($table == 'barang_return'){
                $query = $this->admin->getBarangReturn(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
                $this->_cetakReturn($query, $table, $tanggal);
            }else{
                $query = $this->admin->getBarangKu(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);

                $this->_cetakBarang($query, $table);
            } 
            
            $this->_cetak($query, $table, $tanggal);
        }
    }
// laporan cetak barang
    private function _cetakBarang($data, $table_){
        $this->load->library('CustomPDF');
        $table = $table_ == 'barang';

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan Data Barang' . $table, 0, 1, 'C');
        // $pdf->SetFont('Times', '', 10);
        // $pdf->Cell(190, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        if ($table_ == 'barang') :
            $pdf->Cell(30, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(45, 7, 'Id Barang', 1, 0, 'C');
            $pdf->Cell(90, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(20, 7, 'Stok', 1, 0, 'C');
            // $pdf->Cell(40, 7, 'Satuan Id', 1, 0, 'C');
            // $pdf->Cell(30, 7, 'Jenis Id', 1, 0, 'C');
            $pdf->Ln();
           
            
            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(30, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(45, 7, $d['id_barang'], 1, 0, 'C');
                $pdf->Cell(90, 7, $d['nama_barang'], 1, 0, 'C');
                $pdf->Cell(20, 7, $d['stok'], 1, 0, 'L');
                // $pdf->Cell(40, 7, $d['satuan_id'], 1, 0, 'L');
                // $pdf->Cell(30, 7, $d['jenis_id'], 1, 0, 'L');
                // $pdf->Cell(30, 7, $d['jenis_id'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Ln();
           
            } else :
            $pdf->Cell(30, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(45, 7, 'Id Barang', 1, 0, 'C');
            $pdf->Cell(90, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(20, 7, 'stok', 1, 0, 'C');
            // $pdf->Cell(30, 7, 'Satuan Id', 1, 0, 'C');
            // $pdf->Cell(30, 7, 'Jenis Id', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(30, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(45, 7, $d['id_barang'], 1, 0, 'C');
                $pdf->Cell(90, 7, $d['nama_barang'], 1, 0, 'C');
                $pdf->Cell(20, 7, $d['stok'], 1, 0, 'L');
                // $pdf->Cell(30, 7, $d['satuan_id'], 1, 0, 'C');
                // $pdf->Cell(30, 7, $d['jenis_id'], 1, 0, 'C');
                $pdf->Ln();
            }
        endif;

        // $pdf->Ln(70);
        $pdf->Ln(70);
        $tanggalku = date("d-M-Y");
        //  echo format_indo(date('Y-m-d H:i:s'));

        $nama =  userdata('nama');
        // $pdf->Cell(90, 4, 'Mengetahui ' . $nama, 0, 1, 'C');
        // $pdf->Cell(90, 4, 'Tanggal : ' . $tanggalku, 0, 1, 'C');
        // $pdf->Ln(20);
        // $pdf->Cell(90, 4, $nama, 0, 1, 'C');

        // batas
        // batas
        $pdf->Cell(182, 4, '                                                                                                   Yogyakarta ' . $tanggalku, 0, 1, 'C');
        $pdf->Cell(185, 4, '                                                                                                 Pimpinan Gudang ', 0, 1, 'C');
        // $pdf->Cell(290, 4, 'Petugas Gudang Tanggal : ' . $tanggalku, 0, 1, 'C');
        $pdf->Ln(20);
        $pdf->Cell(175, 4,  '                                                                                                         ALfikriJihadi', 0, 1, 'C');


        $file_name = $table . ' ';
        $pdf->Output('I', $file_name);

    }
    private function _cetakReturn($data, $table_, $tanggal){
        $this->load->library('CustomPDF');
        $table = $table_ == 'barang';

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan Barang Return ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(190, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        if ($table_ == 'barang_return') :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Tgl return', 1, 0, 'C');
            $pdf->Cell(45, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(65, 7, 'Nama Barang', 1, 0, 'C');
            // $pdf->Cell(40, 7, 'Supplier', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah return', 1, 0, 'C');
            $pdf->Ln();
           
            
            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(35, 7, $d['tanggal_return'], 1, 0, 'C');
                $pdf->Cell(45, 7, $d['id_barang_return'], 1, 0, 'C');
                $pdf->Cell(65, 7, $d['nama_barang'], 1, 0, 'L');
                // $pdf->Cell(40, 7, $d['nama_supplier'], 1, 0, 'L');
                $pdf->Cell(30, 7, $d['jumlah_masuk'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Ln();
           
            } else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(35, 7, 'Tgl Keluar', 1, 0, 'C');
            $pdf->Cell(45, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(65, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah Keluar', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(35, 7, $d['tanggal_keluar'], 1, 0, 'C');
                $pdf->Cell(45, 7, $d['id_barang_keluar'], 1, 0, 'C');
                $pdf->Cell(65, 7, $d['nama_barang'], 1, 0, 'L');
                $pdf->Cell(30, 7, $d['jumlah_keluar'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Ln();
            }
        endif;

        $pdf->Ln(70);
        $tanggalku = date("d-M-Y");
        //  echo format_indo(date('Y-m-d H:i:s'));

        $nama =  userdata('nama');
        // $pdf->Cell(90, 4, 'Mengetahui ' . $nama, 0, 1, 'C');
        // $pdf->Cell(90, 4, 'Tanggal : ' . $tanggalku, 0, 1, 'C');
        // $pdf->Ln(20);
        // $pdf->Cell(90, 4, $nama, 0, 1, 'C');

        // batas
       // batas
       $pdf->Cell(182, 4, '                                                                                                   Yogyakarta ' . $tanggalku, 0, 1, 'C');
       $pdf->Cell(185, 4, '                                                                                                 Pimpinan Gudang ', 0, 1, 'C');
       // $pdf->Cell(290, 4, 'Petugas Gudang Tanggal : ' . $tanggalku, 0, 1, 'C');
       $pdf->Ln(20);
       $pdf->Cell(175, 4,  '                                                                                                         AlfikriJihadi', 0, 1, 'C');


        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);

    }
    private function _cetak($data, $table_, $tanggal)
    {
        $this->load->library('CustomPDF');
        $table = $table_ == 'barang_masuk' ? 'Barang Masuk' : 'Barang Keluar';

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(190, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        if ($table_ == 'barang_masuk') :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Tgl Masuk', 1, 0, 'C');
            $pdf->Cell(35, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(40, 7, 'Supplier', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah Masuk', 1, 0, 'C');
            $pdf->Ln();
           
            
            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, 7, $d['tanggal_masuk'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['id_barang_masuk'], 1, 0, 'C');
                $pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'L');
                $pdf->Cell(40, 7, $d['nama_supplier'], 1, 0, 'L');
                $pdf->Cell(30, 7, $d['jumlah_masuk'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Ln();
           
            } else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(25, 7, 'Tgl Keluar', 1, 0, 'C');
            $pdf->Cell(35, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(95, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Jumlah Keluar', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(25, 7, $d['tanggal_keluar'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['id_barang_keluar'], 1, 0, 'C');
                $pdf->Cell(95, 7, $d['nama_barang'], 1, 0, 'L');
                $pdf->Cell(30, 7, $d['jumlah_masuk'] . ' ' . $d['nama_satuan'], 1, 0, 'C');
                $pdf->Ln();
            }
        endif;

        $pdf->Ln(70);
        $tanggalku = date("d-M-Y");
        //  echo format_indo(date('Y-m-d H:i:s'));

        $nama =  userdata('nama');
        // $pdf->Cell(90, 4, 'Mengetahui ' . $nama, 0, 1, 'C');
        // $pdf->Cell(90, 4, 'Tanggal : ' . $tanggalku, 0, 1, 'C');
        // $pdf->Ln(20);
        // $pdf->Cell(90, 4, $nama, 0, 1, 'C');

        // batas
        $pdf->Cell(182, 4, '                                                                                                   Yogyakarta ' . $tanggalku, 0, 1, 'C');
        $pdf->Cell(185, 4, '                                                                                                 Pimpinan Gudang ', 0, 1, 'C');
        // $pdf->Cell(290, 4, 'Petugas Gudang Tanggal : ' . $tanggalku, 0, 1, 'C');
        $pdf->Ln(20);
        $pdf->Cell(175, 4,  '                                                                                                         Afandi Ahmad', 0, 1, 'C');


        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);
    }
}
