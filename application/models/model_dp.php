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
		if(!empty($bulan)) $this->db->where('tab_master_dp.bulan',$bulan);
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
						  ->join('tab_kontrak_kerja c','c.nik=b.nik','left')
						  ->join('tab_resign e','e.nik=b.nik','left')
						  ->not_like('c.status_kerja','casual')
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
		$tgl_awal   = date('Y-m-01',strtotime($thn."-".$bln));
		$tgl_akhir  = date('Y-m-t',strtotime($thn."-".$bln));

		$this->db->where('a.tahun',$thn); // dimana tahun = $tahun
		$this->db->where('a.bulan',$bln); // dimana bulan = $bulan

		$hasil = $this->db->join('tab_karyawan b','b.nik=a.nik','left') // join tab_karyawan & tab_master_dp, nik
						  ->join('tab_history_kontrak_kerja c','c.nik=b.nik','left') // join tab_karyawan & tab_kontrak_kerja, nik
						  ->join('tab_cabang d','d.id_cabang=b.cabang','left') // join tab_karyawan & tab_cabang, id cabang
						  ->join('tab_resign e','e.nik=a.nik','left')

						  ->where('d.id_cabang',$id)
						  ->not_like('c.status_kerja','casual')
						  ->where('(c.tanggal_masuk > e.tanggal_resign AND c.tanggal_masuk <= "'.$tgl_akhir.'" OR e.nik IS NULL OR e.nik IS NOT NULL AND c.tanggal_resign >= "'.$tgl_akhir.'" AND c.tanggal_masuk <= "'.$tgl_akhir.'")')
						  ->where('(c.tanggal_resign >= "'.$tgl_akhir.'" OR c.tanggal_resign = "0000-00-00")')
						  ->group_by('b.nik')
						  ->order_by('b.nama_ktp','ASC')

						  ->select('b.nama_ktp,c.status_kerja,d.cabang,a.saldo_dp,a.saldo_cuti,a.saldo_dp_awal,a.saldo_cuti_awal,a.bulan as bln,a.tahun as thun,b.nik,c.tanggal_masuk,e.nik as nik_resign,e.tanggal_resign')

						  ->get('tab_master_dp a');

		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function detail_rekap2($bln,$thn)
	{
		$tgl_awal   = date('Y-m-01',strtotime($thn."-".$bln));
		$tgl_akhir  = date('Y-m-t',strtotime($thn."-".$bln));
		
		$this->db->where('a.tahun',$thn); // dimana tahun = $tahun
		$this->db->where('a.bulan',$bln); // dimana bulan = $bulan

		$hasil = $this->db->join('tab_karyawan b','b.nik=a.nik','left') // join tab_karyawan & tab_master_dp, nik
						  ->join('tab_history_kontrak_kerja c','c.nik=b.nik','left') // join tab_karyawan & tab_kontrak_kerja, nik
						  ->join('tab_cabang d','d.id_cabang=b.cabang','left') // join tab_karyawan & tab_cabang, id cabang
						  ->join('tab_resign e','e.nik=a.nik','left')

						  ->not_like('c.status_kerja','casual')
						  ->where('(c.tanggal_masuk > e.tanggal_resign OR e.nik IS NULL)')
						  ->where('(c.tanggal_resign >= "'.$tgl_akhir.'" OR c.tanggal_resign = "0000-00-00")')
						  ->group_by('b.nik')
						  ->order_by('b.nama_ktp','ASC')

						  ->select('b.nama_ktp,c.status_kerja,d.cabang,a.saldo_dp,a.saldo_cuti,a.saldo_dp_awal,a.saldo_cuti_awal,a.bulan as bln,a.tahun as thun,b.nik,c.tanggal_masuk,e.nik as nik_resign,e.tanggal_resign')

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