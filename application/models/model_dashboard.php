<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_dashboard extends CI_Model {

	public function notifikasi_disiplin($param)
	{
		$hasil = $this->db->query("SELECT tab_department.department,tab_jabatan.jabatan,month(tab_absensi.tgl_kerja) as bulan_absen,tab_karyawan.nik,tab_karyawan.nama_ktp,tab_cabang.cabang,sum(if(tab_absensi.status_masuk='On Time',1,0)) as total_masuk FROM tab_absensi JOIN tab_karyawan ON tab_karyawan.nik=tab_absensi.nik join tab_cabang on tab_cabang.id_cabang=tab_karyawan.cabang join tab_jabatan on tab_jabatan.id_jabatan=tab_karyawan.jabatan join tab_department on tab_department.id_department=tab_karyawan.department $param  GROUP BY (tab_karyawan.nik) ORDER BY (total_masuk) DESC, month(tab_absensi.tgl_kerja) DESC");
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function notifikasi_terlambat($param)
	{
		$hasil = $this->db->query("SELECT tab_department.department,tab_jabatan.jabatan,month(tab_absensi.tgl_kerja) as bulan_absen,tab_karyawan.nik,tab_karyawan.nama_ktp,tab_cabang.cabang,sum(if(tab_absensi.status_masuk='Telat',1,0)) as total_masuk FROM tab_absensi JOIN tab_karyawan ON tab_karyawan.nik=tab_absensi.nik join tab_cabang on tab_cabang.id_cabang=tab_karyawan.cabang join tab_jabatan on tab_jabatan.id_jabatan=tab_karyawan.jabatan join tab_department on tab_department.id_department=tab_karyawan.department $param  GROUP BY (tab_karyawan.nik) ORDER BY (total_masuk) DESC, month(tab_absensi.tgl_kerja) DESC");
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function notifikasi_resign($tgl1,$tgl2)
	{
		//$hasil = $this->db->where('month(b.tanggal_resign)',date('m',strtotime('+ 1 month',strtotime(date('Y-m-d')))))
		$hasil = $this->db->where('b.tanggal_resign >=',$tgl1)
						  ->where('b.tanggal_resign <=',$tgl2)
						  ->join('tab_kontrak_kerja b','b.nik=a.nik')
						  ->join('tab_cabang c','c.id_cabang=a.cabang')
						  ->join('tab_jabatan d','d.id_jabatan=a.jabatan')
						  ->join('tab_department e','e.id_department=a.department')
						  ->select('*,b.id as id_kon')
						  ->get('tab_karyawan a')
						  ->result();
		if(count($hasil) > 0){
			return $hasil;
		} else {
			return array();
		}
	}

	public function schedule_pindah($param)
	{
		if (!empty($param)) {
			$this->db->where("(".$param.")",null);
		}else{
			$this->db->where('b.tanggal_pindah >=',date('Y-m-01'));
			$this->db->where('b.tanggal_pindah <=',date('Y-m-t'));
		}
		$hasil = $this->db->join('tab_karyawan a','a.nik=b.nik')
						  ->join('tab_cabang c','c.id_cabang=a.cabang')
						  ->get('tab_pindah_jam b')
						  ->result();
		if(count($hasil) > 0){
			return $hasil;
		} else {
			return array();
		}
	}

	public function bpjs_kesehatan($tgl1,$tgl2)
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_bpjs_karyawan.nik')
						  ->join('tab_master_bpjs','tab_bpjs_karyawan.id_bpjs=tab_master_bpjs.id_bpjs')
						  ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
						  ->where('tab_bpjs_karyawan.bulan_ambil >=',$tgl1)
						  ->where('tab_bpjs_karyawan.bulan_ambil <=',$tgl2)
						  //->where('tab_bpjs_karyawan.no_bpjs','')
						  ->where('tab_master_bpjs.id_bpjs',2)
						  ->get('tab_bpjs_karyawan')
						  ->result();
		if(count($hasil) > 0){
			return $hasil;
		} else {
			return array();
		}
	}

	public function bpjs_ketenagakerjaan($tgl1,$tgl2)
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_bpjs_karyawan.nik')
						  ->join('tab_master_bpjs','tab_bpjs_karyawan.id_bpjs=tab_master_bpjs.id_bpjs')
						  ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
						  ->where('tab_bpjs_karyawan.bulan_ambil >=',$tgl1)
						  ->where('tab_bpjs_karyawan.bulan_ambil <=',$tgl2)
						  ->where('tab_master_bpjs.id_bpjs',1)
						  //->where('tab_bpjs_karyawan.no_bpjs','')
						  ->get('tab_bpjs_karyawan')
						  ->result();
		if(count($hasil) > 0){
			return $hasil;
		} else {
			return array();
		}
	}

	public function hitung()
	{
		$ekstra=$this->db->where('approved',null)->get('tab_extra')->num_rows();
		$tunjangan=$this->db->where('approved',null)->get('tab_tunjangan_karyawan')->num_rows();
		$komisi=$this->db->where('approved',null)->get('tab_komisi')->num_rows();
		$karyawan=$this->db->join('tab_kontrak_kerja b','b.nik=a.nik')
						   ->join('tab_pph c','c.nik=a.nik')
						   ->where('a.nik !=','null')
						   ->get('tab_karyawan a')->num_rows();
		$gaji=$this->db->where('month(tanggal_gaji)',date('m'))->where('approval !=',2)->get('tab_gaji_karyawan_new')->num_rows();
		//$sisa_gaji=$karyawan-$gaji;
		$data=array(
				"ekstra" => $ekstra,
				"komisi" => $komisi,
				"gaji" => $gaji,
				"tunjangan" => $tunjangan,
			);
		return $data;
	}

}