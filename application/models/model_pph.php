<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_pph extends CI_Model {

	public function index() {
		$hasil = $this->db->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
      					      ->join('tab_pajak','tab_pajak.id_pajak=tab_karyawan.status_pajak')
      					      ->join('tab_npwp','tab_npwp.nik=tab_karyawan.nik')
      					     // ->join('tab_department','tab_department.id_department=tab_karyawan.department')
      					      ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
      					      //->join('tab_gaji_karyawan','tab_gaji_karyawan.nik=tab_karyawan.nik','left')
      					      //->where('month(tab_pph.entry_date)',date('m'))
      					      //->where('tab_karyawan.cabang',$id_cabang)
      					      ->select('*,tab_karyawan.nik as nik_karyawan')
      					      ->get('tab_karyawan');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function pph_karyawan($nik,$jml_hari){
	$ekstra=$this->db->join('tab_karyawan a','a.nik=b.nik')
                     ->where('a.nik',$id)
                     ->where('(Year(b.entry_date)=year(now()))',null)
                     ->where('(month(b.entry_date)=month(now()))',null)
                     ->where('b.vakasi','Dibayar')
                     ->or_where('b.vakasi','Ekstra Lain')
                     ->where('b.approved','Ya')
                     ->select('sum(jumlah_vakasi) as total_vakasi')
                     ->get('tab_extra b')->row();
  $cuti=$this->db->join('tab_karyawan a','a.nik=b.nik')
                 ->join('tab_kontrak_kerja c','c.nik=a.nik')
                 ->where('a.nik',$nik)
                 ->where('(month(b.entry_date)=month(now()))',null)
                 ->where('(Year(b.entry_date)=year(now()))',null)
                 ->where('b.saldo_cuti < ',0)
                 ->select("sum((c.gaji_pokok/$jml_hari)*b.saldo_cuti) as total_cuti",false)
                 ->get('tab_master_dp b')
                 ->row();
  $tunjangan_t3=$this->db->join('tab_karyawan a','a.nik=b.nik')
                         ->select('sum(b.total_t3) as jml_t3')
                         ->where('a.nik',$nik)
                         ->where('approved','Ya')
                         ->where('month(b.tanggal)',date('m'))
                         ->get('tab_t3 b')->row();
  $jpk_val=$this->db->join('tab_master_bpjs b','b.id_bpjs=a.id_bpjs')
                      ->where('b.id_bpjs',2)
                      ->where('a.nik',$nik)
                      ->where('a.no_bpjs !=','')
                      ->select('b.jpk_1')
                      ->get('tab_bpjs_karyawan a')
                      ->row();
    $jht_val=$this->db->join('tab_master_bpjs b','b.id_bpjs=a.id_bpjs')
                      ->where('b.id_bpjs',1)
                      ->where('a.nik',$nik)
                      ->where('a.no_bpjs !=','')
                      ->select('b.jkk,b.jkm,b.jht_1,b.jht_2')
                      ->get('tab_bpjs_karyawan a')
                      ->row();
    $masuk1=$this->db->where('date(jam_masuk)>=',date('Y-m-01'))
                    ->where('date(jam_masuk)<=',date('Y-m-15'))
                    ->where('nik',$nik)
                    ->select('count(nik) as jml_1')
                    ->group_by('date(jam_masuk)')
                    ->get('tab_absensi_masuk')->row();
    $masuk2=$this->db->where('date(jam_masuk)>=',date('Y-m-16'))
                    ->where('date(jam_masuk)<=',date('Y-m-t'))
                    ->where('nik',$nik)
                    ->select('count(nik) as jml_2')
                    ->group_by('date(jam_masuk)')
                    ->get('tab_absensi_masuk')->row();
    $data= array(
              "ekstra" => $ekstra->total_vakasi,
              "cuti" => $cuti->jml_t3,
              "t3" => $tunjangan_t3->jml_t3,
              "jkk"   => $jht_val->jkk,
              "jkm"   => $jht_val->jkm,
              "jpk"   => $jpk_val->jpk_1,
              "jht"   => $jht_val->jht_1,
              "jht_k"   => $jht_val->jht_2,
              "masuk1"   => $masuk1->jml_1,
              "masuk2"   => $masuk2->jml_2
          );
    return $data;
	}
}