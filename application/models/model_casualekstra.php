<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_casualEkstra extends CI_Model {

	public function index($tgl1,$tgl2)
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_casual_ekstra.nik')
	                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
	                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
	                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
							->where('tab_casual_ekstra.tgl_ekstra >=',$tgl1)
							->where('tab_casual_ekstra.tgl_ekstra <=',$tgl2)
	                        ->get('tab_casual_ekstra');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	
	public function find($id_casual){
		//Query mencari record berdasarkan id_casual-nya
		$hasil = $this->db->where('id_casual', $id_casual)
						  ->limit(1)
						  ->get('tab_casual_ekstra');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	
	public function update($id_casual, $data){
		$this->db->where('id_casual', $id_casual)
				 ->update('tab_casual_ekstra', $data);
	}

	public function add($data){
		$this->db->insert('tab_casual_ekstra', $data);
	}

	public function delete($id_casual){
		$this->db->where('id_casual', $id_casual)->delete('tab_casual_ekstra');
	}
}