<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mycustom_controller extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
	}

    public function update_absensi() {
        $tgl_awal = "2017-01-01";
        $tgl_akhir = "2017-01-31";
        $query = $this->db->query('
            SELECT * FROM tab_izin 
            WHERE tanggal_mulai >= "'.$tgl_awal.'" 
            AND tanggal_finish <= "'.$tgl_akhir.'"
        ');
        foreach ($query->result() as $row) {
            if ($row->jenis_izin == "Tidak Dapat Masuk") {
                $query_update = $this->db->query('
                    UPDATE tab_absensi SET 
                        status_masuk = "Izin", 
                        keterangan_masuk = "Izin", 
                        status_keluar = "Izin", 
                        keterangan_keluar = "Izin",
                        status_masuk2 = "Izin", 
                        keterangan_masuk2 = "Izin", 
                        status_keluar2 = "Izin", 
                        keterangan_keluar2 = "Izin" 
                    WHERE nik = '.$row->nik.' 
                    AND tgl_kerja >= "'.$row->tanggal_mulai.'" 
                    AND tgl_kerja <= "'.$row->tanggal_akhir.'" 
                ');
            }
        }
    }

    public function analisa(){
        $filename = "ANALISA".date('dmY').".xls";
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Expires: 0");
        header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
        header("Content-disposition: attachment; filename=".$filename);

        $this->load->view('analisa');
    }

    public function pegawai(){
        $filename = "ANALISA".date('dmY').".xls";
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Expires: 0");
        header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
        header("Content-disposition: attachment; filename=".$filename);

        $this->load->view('pegawai');
    }

}
