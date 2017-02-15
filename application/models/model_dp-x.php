<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_dp extends CI_Model {

	public function index()
	{
		$hasil = $this->db->join('tab_department b','b.id_department=a.department')
						  ->join('tab_jabatan c','c.id_jabatan=a.jabatan')
						  ->get('tab_karyawan a');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
	public function detail($nik,$bulan,$tahun)
	{
		if(!empty($bulan)) $this->db->where('month(tab_master_dp.bulan)',$bulan);
		if(!empty($tahun))	$this->db->where('tab_master_dp.tahun',$tahun);
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_master_dp.nik')
						  ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
						  ->order_by('tab_master_dp.bulan','desc')
						  ->where('tab_master_dp.nik',$nik)
						  ->get('tab_master_dp');
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
						  ->get('tab_master_dp');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function add($data)
	  {
	      $this->db->insert('tab_master_dp', $data);
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_master_dp', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_master_dp');
	}
	public function rekap_data()
	{
		$hasil = $this->db->join('tab_karyawan b','b.cabang=a.id_cabang')
						  ->group_by('a.id_cabang')
						  ->select('a.id_cabang,a.cabang,count(b.nik) as jml_karyawan')	
						  ->get('tab_cabang a');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function detail_rekap($id,$bln,$thn)
	{
		$this->db->where('year(a.bulan)',$thn);
		$this->db->where('month(a.bulan)',$bln);
		$hasil = $this->db->join('tab_karyawan b','b.nik=a.nik')
						  ->join('tab_kontrak_kerja c','c.nik=b.nik')
						  ->join('tab_cabang d','d.id_cabang=b.cabang')
						  ->where('d.id_cabang',$id)
						  ->select('b.nama_ktp,d.cabang,a.saldo_dp,a.saldo_cuti,month(a.bulan) as bln,year(a.bulan) as thun,b.nik')	
						  ->get('tab_master_dp a');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}
}
//"IF (d.cuti_khusus = 'Ya' , 'okes' , 'NotExists' ),'b.cabang'",false
//