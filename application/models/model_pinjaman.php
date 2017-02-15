<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pinjaman extends CI_Model {

	public function index()
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_pinjaman.nik')
	                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
	                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
	                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
	                        ->get('tab_pinjaman');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function index2()
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_pembayaran_pinjaman.nik')
	                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
	                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
	                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
	                        ->get('tab_pembayaran_pinjaman');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	
	public function find($id_pinjaman){
		//Query mencari record berdasarkan id_pinjaman-nya
		$hasil = $this->db->where('id_pinjaman', $id_pinjaman)
						  ->limit(1)
						  ->get('tab_pinjaman');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	
	public function update($id_pinjaman, $data){
		$this->db->where('id_pinjaman', $id_pinjaman)
				 ->update('tab_pinjaman', $data);
	}

	public function add($data){
		$this->db->insert('tab_pinjaman', $data);
	}

	public function delete($id_pinjaman){
		$this->db->where('id_pinjaman', $id_pinjaman)->delete('tab_pinjaman');
	}

	public function add2($data){
		$this->db->insert('tab_pembayaran_pinjaman', $data);
	}

	public function delete2($id_pinjaman){
		$this->db->where('id_pembayaran', $id_pinjaman)->delete('tab_pembayaran_pinjaman');
	}
}