<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_thr extends CI_Model {

	public function index()
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_master_thr.nik')
	                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
	                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
	                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
	                        ->get('tab_master_thr');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	
	public function index2($id)
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_master_thr.nik')
	                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
	                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
	                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
	                        ->where('tab_cabang.id_cabang',$id)
	                        ->get('tab_master_thr');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	
	public function find($id){
		//Query mencari record berdasarkan id-nya
		$hasil = $this->db->where('id_thr', $id)
						  ->limit(1)
						  ->get('tab_master_thr');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	
	public function add($data){
		$this->db->insert('tab_master_thr', $data);
	}

	public function delete($id){
		$this->db->where('id_thr', $id)->delete('tab_master_thr');
	}

	public function karyawan($cabang,$jabatan)
	{
		if (!empty($cabang)) {
			$this->db->where('b.cabang',$cabang);
		}
		if (!empty($jabatan)) {
			$this->db->where('b.jabatan',$jabatan);
		}
		$hasil = $this->db->join('tab_jabatan a','a.id_jabatan=b.jabatan')
                          ->join('tab_cabang c','c.id_cabang=b.cabang')
                          ->join('tab_department d','d.id_department=b.department')
                          ->get('tab_karyawan b');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	//public function rekapitulasi($tgl1,$tgl2,$cabang)
	public function rekapitulasi($tgl1,$tgl2)
	{
		
		if (!empty($tgl1) && !empty($tgl2)) {
			$hasil = $this->db->query(
				'
				SELECT d.id_cabang AS field0, d.cabang AS field1, COUNT(a.nik) AS field2, 
				SUM(a.tarif) AS field3, SUM(a.pph_thr) AS field4, 
				SUM(a.tarif) - SUM(a.pph_thr) AS field5, a.tanggal_ambil AS field6, 
				a.approved AS field7, a.keterangan AS field8 
				FROM tab_master_thr a
				JOIN tab_karyawan b ON b.nik=a.nik 
				JOIN tab_jabatan c ON c.id_jabatan=b.jabatan 
				JOIN tab_cabang d ON d.id_cabang=b.cabang 
				JOIN tab_department e ON e.id_department=b.department 
				WHERE a.approved="Ya" AND a.tanggal_ambil >= "'.$tgl1.'" 
				AND a.tanggal_ambil <= "'.$tgl2.'"
				GROUP BY d.id_cabang
				'
			);
        }else{
			$hasil = $this->db->query(
				'
				SELECT d.id_cabang AS field0, d.cabang AS field1, COUNT(a.nik) AS field2, 
				SUM(a.tarif) AS field3, SUM(a.pph_thr) AS field4, 
				SUM(a.tarif) - SUM(a.pph_thr) AS field5, a.tanggal_ambil AS field6, 
				a.approved AS field7, a.keterangan AS field8 
				FROM tab_master_thr a
				JOIN tab_karyawan b ON b.nik=a.nik 
				JOIN tab_jabatan c ON c.id_jabatan=b.jabatan 
				JOIN tab_cabang d ON d.id_cabang=b.cabang 
				JOIN tab_department e ON e.id_department=b.department 
				WHERE a.approved="Ya" AND MONTH(a.tanggal_ambil) = "'.date('m').'"
				GROUP BY d.id_cabang
				'
			);
        }
        /*if (!empty($cabang)) {
            $this->db->where('tab_cabang.id_cabang',$cb);   
        }*/
		/*$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_master_thr.nik')
	                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
	                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
	                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
	                        ->get('tab_master_thr');*/
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
}