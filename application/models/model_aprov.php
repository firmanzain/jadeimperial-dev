<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_aprov extends CI_Model {

	public function komisi_index()
	{
		$hasil = $this->db->join('tab_karyawan b','b.nik=a.nik','inner')
						  ->join('tab_jabatan c','c.id_jabatan=b.jabatan','inner')
						  ->join('tab_cabang d','d.id_cabang=b.cabang')
						  ->join('tab_department e','e.id_department=b.department')
					      ->where('a.approved',null)
					      ->get('tab_komisi a');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function aprov_casual()
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_casual_ekstra.nik')
	                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
	                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
	                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
	                        ->where('tab_casual_ekstra.approved',null)
	                        ->get('tab_casual_ekstra');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function aprov_casual2()
	{
		$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_casual_ekstra.nik')
	                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
	                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
	                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
	                        ->where('tab_casual_ekstra.approved !=','2')
	                        ->get('tab_casual_ekstra');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function aprov_thr()
	{
		/*$hasil = $this->db->join('tab_karyawan','tab_karyawan.nik=tab_master_thr.nik')
	                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
	                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
	                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
	                        ->where('tab_master_thr.approved',"Tidak")
	                        ->where('month(tab_master_thr.tanggal_ambil)',date('m'))
	                        ->get('tab_master_thr');*/
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
			WHERE a.approved="Ya" AND MONTH(a.tanggal_ambil) = '.date('m').'
			GROUP BY d.id_cabang
			'
		);
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function ekstra_index()
	{
		$hasil = $this->db->join('tab_karyawan b','b.nik=a.nik','inner')
					      ->join('tab_jabatan c','c.id_jabatan=b.jabatan','inner')
						  ->join('tab_cabang d','d.id_cabang=b.cabang')
						  ->join('tab_department e','e.id_department=b.department')
						  ->where('a.approved',null)
					      ->get('tab_extra a');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function tunjangan_index()
	{
		$hasil = $this->db->join('tab_karyawan b','b.nik=a.nik')
					      ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
						  ->join('tab_cabang d','d.id_cabang=b.cabang')
						  ->join('tab_master_tunjangan e','e.id_tunjangan=a.tunjangan')
						  ->where('a.approved','')
						  ->select('*,a.id as id_tj')
					      ->get('tab_tunjangan_karyawan a');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function aprove_tunjangan($id, $data){
		$this->db->where('id',$id)
				 ->update('tab_tunjangan_karyawan',$data);
	}

	public function aprove_casual($id, $data){
		$this->db->where('id_casual',$id)
				 ->update('tab_casual_ekstra',$data);
	}

	public function aprove_thr($id, $data){
		$this->db->where('id_thr',$id)
				 ->update('tab_master_thr',$data);
	}

	function bonus($bln,$thn){
		$this->db->select('a.*,b.cabang as nama_cabang');
		$this->db->from('tab_omset a');
		$this->db->join('tab_cabang b', 'b.id_cabang = a.cabang');
		$this->db->where('month(a.bulan_bonus)',date($bln));
		$this->db->where('year(a.bulan_bonus)',date($thn));
		$baca = $this->db->get();
        /*$baca = $this->db
                         ->join('tab_cabang c','c.id_cabang=a.cabang')
                         ->where('month(a.entry_date)',date('m'))
                         ->get('tab_omset a');*/
        if($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }

    function detail_bonus($id){
        $baca = $this->db->join('tab_karyawan b','b.nik=a.nik')
                         ->join('tab_cabang e','e.id_cabang=b.cabang')
                         ->join('tab_jabatan g','g.id_jabatan=b.jabatan')
                         ->join('tab_omset f','f.cabang=e.id_cabang')
                         ->join('tab_kontrak_kerja c','c.nik=b.nik')
                         ->where('f.id_omset',$id)
                         ->where('month(f.entry_date)',date('m'))
                         ->select('*,(if(((to_days(CURRENT_DATE)-to_days(c.tanggal_masuk))/365)>5 and a.grade > 0,a.grade*2+2,0)) as nilai_grade, (a.nominal) as total_nominal,(a.persentase) as total_persentase,e.cabang as nama_cabang,(if(((to_days(CURRENT_DATE)-to_days(c.tanggal_masuk))/365)>=1,(to_days(CURRENT_DATE)-to_days(c.tanggal_masuk))/365,0)) as total_senioritas,b.nik as nik_kar,b.nama_ktp as nama,g.jabatan as jabatan',false)
                         ->get('tab_master_bonus a');
        if ($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }

	public function gaji()
	{
		$hasil = $this->db->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
					      ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
					      ->join('tab_pph','tab_karyawan.nik=tab_pph.nik','left')
					      ->where('month(tab_pph.entry_date)',date('m'))
					      ->select('*,sum(tab_kontrak_kerja.gaji_pokok) as gaji,count(tab_karyawan.nik) as jml_karyawan,sum(tab_pph.jml_pph) as total_pph')
					      ->group_by('tab_karyawan.cabang')
					      ->get('tab_karyawan');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function detail_gaji($id_cabang) {
		$hasil = $this->db->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
					      ->join('tab_pph','tab_karyawan.nik=tab_pph.nik','left')
					      ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
					      ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
					      ->join('tab_department','tab_department.id_department=tab_karyawan.department')
					      ->where('month(tab_pph.entry_date)',date('m'))
					      ->where('tab_karyawan.cabang',$id_cabang)
					      ->select('*,tab_karyawan.nik as nik_karyawan')
					      ->get('tab_karyawan');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function aprove_data($id, $data){
		$this->db->where('id_komisi',$id)
				 ->update('tab_komisi',$data);
	}

	public function aprove_ekstra($id, $data){
		$this->db->where('id',$id)
				 ->update('tab_extra',$data);
	}

	public function aprove_bonus($data){
		$this->db->insert('tab_bonus_karyawan',$data);
	}

	public function aprove_t3($data){
		$this->db->insert('tab_t3',$data);
	}

	public function aproveGajiCabang($id,$approv,$keterangan){
		$q_cabang = $this->db->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
					      ->join('tab_pph','tab_karyawan.nik=tab_pph.nik','left')
					      ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
					      ->where('tab_karyawan.cabang',$id)
					      ->where('month(tab_pph.entry_date)',date('m'))
					      ->select('*,tab_karyawan.nik as nik_karyawan')
					      ->get('tab_karyawan')
					      ->result();
		foreach ($q_cabang as $rs_aprov) {
			$kalender=CAL_GREGORIAN;
	        $bulan = date('m');
	        $tahun= date('Y');
	        $jml_hari=cal_days_in_month($kalender, $bulan, $tahun);
	        $ekstra=$this->db->join('tab_karyawan a','a.nik=b.nik')
	                         ->where('a.nik',$rs_aprov->nik_karyawan)
	                         ->where('(Year(b.entry_date)=year(now()))',null)
	                         ->where('(month(b.entry_date)=month(now()))',null)
	                         ->where('b.vakasi','Dibayar')
	                         ->where('b.approved','Ya')
	                         ->select('sum(jumlah_vakasi) as total_vakasi')
	                         ->get('tab_extra b')->row();
	        $cuti=$this->db->join('tab_karyawan a','a.nik=b.nik')
	                       ->join('tab_kontrak_kerja c','c.nik=a.nik')
	                       ->where('a.nik',$rs_aprov->nik_karyawan)
	                       ->where('(month(b.entry_date)=month(now()))',null)
	                       ->where('(Year(b.entry_date)=year(now()))',null)
	                       ->where('b.saldo_cuti < ',0)
	                       ->select("sum((c.gaji_pokok/$jml_hari)*b.saldo_cuti) as total_cuti")
	                       ->get('tab_master_dp b')->row();
	        $gaji_bersih=($rs_aprov->gaji_pokok+$ekstra->total_vakasi)-$rs_aprov->jml_pph-(($rs_aprov->gaji_pokok*2/100)+($rs_aprov->gaji_pokok*0.54/100))-$cuti->total_cuti;
	    		$data=array(
	        			"nik" => $rs_aprov->nik_karyawan,
	        			"gaji_karyawan" => $gaji_bersih,
	        			"gaji_ekstra" => $ekstra->total_vakasi,
	        			"pph21" => $rs_aprov->jml_pph,
	        			"potongan_cuti" => $cuti->total_cuti,
	        			"approval" => $approv,
	        			"tanggal_gaji" => date('Y-m-d'),
	        			"keterangan" => $keterangan,
	        			"entry_user" => $this->session->userdata('username')
	        			);
	    	$cek_data=$this->db->where('month(tanggal_gaji)',date('m'))
	    					   ->where('nik',$rs_aprov->nik_karyawan)
	    					   ->get('tab_gaji_karyawan')->num_rows();
	    	if ($cek_data<1) {
		    	$this->db->insert('tab_gaji_karyawan',$data);
	    	}
		}
	}

	public function aproveGajikaryawan($input) {
    	$cek_data=$this->db->where('month(tanggal_gaji)',date('m'))
    					   ->where('nik',$input['nik'])
    					   ->get('tab_gaji_karyawan')->num_rows();
    	if ($cek_data<1) {
	    	$this->db->insert('tab_gaji_karyawan',$input);
    	}
	}
}