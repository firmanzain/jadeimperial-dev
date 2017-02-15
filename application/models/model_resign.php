<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_resign extends CI_Model {

	public function index($tgl1,$tgl2)
	{
		$hasil = $this->db->join('tab_karyawan b','b.nik=f.nik')
						  ->join('tab_cabang a','a.id_cabang=b.cabang')
	                      ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
	                      ->join('tab_department d','d.id_department=b.department')
	                      ->where('f.tanggal_resign >=',$tgl1)
	                      ->where('f.tanggal_resign <=',$tgl2)
	                      ->get('tab_resign f');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	public function find($id){
		//Query mencari record berdasarkan ID-nya
		$hasil = $this->db->where('id', $id)
						  ->limit(1)
						  ->get('tab_resign');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}

	public function show($id){
		//Query mencari record berdasarkan ID-nya
		$hasil = $this->db->where('a.id', $id)
						  ->join('tab_karyawan b','b.nik=a.nik')
						  ->join('tab_bpjs_karyawan c','c.nik=b.nik','left')
						  ->join('tab_master_bpjs d','d.id_bpjs=c.id_bpjs')
						  ->join('tab_kontrak_kerja f','f.nik=b.nik')
						  ->join('tab_jabatan e','e.id_jabatan=b.jabatan','left')
						  ->limit(1)
						  ->get('tab_resign a');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}

	public function add($data)
	  {
	      $this->db->insert('tab_resign', $data);
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_resign', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_resign');
	}
}