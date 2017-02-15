<?php
class Bonus extends CI_Model {
    
    function index(){
        /*$baca = $this->db
                         ->join('tab_cabang c','c.id_cabang=a.cabang')
                         ->select('*,c.cabang as nama_cabang')
                         ->where('month(a.entry_date)',date('m'))
                         ->get('tab_omset a');*/
        $this->db->select('a.*,b.cabang as nama_cabang');
        $this->db->from('tab_omset a');
        $this->db->join('tab_cabang b','b.id_cabang=a.cabang');
        $this->db->where('month(a.entry_date)',date('m'));
        $baca = $this->db->get();
        if($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }

    function index_rekap($bln){
        $this->db->select('a.*,b.cabang as nama_cabang');
        $this->db->from('tab_omset a');
        $this->db->join('tab_cabang b','b.id_cabang=a.cabang');
        $this->db->where('month(a.entry_date)',$bln);
        $baca = $this->db->get();
        if($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }


    function rekapitulasi($tgl1,$tgl2,$cb){
        if (!empty($tgl1) && !empty($tgl2)) {
            $this->db->where("(a.tanggal_bonus between '".$tgl1."' and '".$tgl2."')",null);
        }
        if (!empty($cb)) {
            $this->db->where('c.id_cabang',$cb);   
        }
        $baca = $this->db
                         ->join('tab_karyawan b','b.nik=a.nik')
                         ->join('tab_cabang c','c.id_cabang=b.cabang')
                         ->join('tab_jabatan e','e.id_jabatan=b.jabatan')
                         ->select('*,a.id as id_bns')
                         ->get('tab_bonus_karyawan a');
        if($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }


    function rekapitulasi_omset($tgl1,$tgl2,$cb){
        if (!empty($tgl1) && !empty($tgl2)) {
            $this->db->where("(date(a.entry_date) between '".$tgl1."' and '".$tgl2."')",null);
        }
        if (!empty($cb)) {
            $this->db->where('c.id_cabang',$cb);   
        }
        $baca = $this->db->join('tab_bonus_karyawan a','a.id_omset=d.id_omset')
                         ->join('tab_karyawan b','b.nik=a.nik')
                         ->join('tab_cabang c','c.id_cabang=b.cabang')
                         ->select('c.cabang,count(b.nik) as jml_karyawan,month(d.entry_date) as bln_omset,d.omset,d.prosen_mpd,d.prosen_lb,d.pure_bonus,
                                sum(a.nominal+a.grade+a.senioritas+a.persentase+a.prota) as bonus_bagi')
                         ->group_by('d.id_omset')
                         ->order_by('d.entry_date','desc')
                         ->get('tab_omset d');
        if($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }


	function cabang(){
        $baca = $this->db->get('tab_cabang');
        if($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }

    function filter($id){
        $baca = $this->db->join('tab_karyawan b','b.nik=a.nik')
                         ->join('tab_cabang c','c.id_cabang=b.cabang')
                         ->join('tab_jabatan e','e.id_jabatan=b.jabatan')
                         ->where('a.id',$id)
                         ->get('tab_bonus_karyawan a');
        if($baca->num_rows() > 0){
            return $baca->row();
        }else{
            return array();
        }
    }

	function bonus_cabang($id){
		$baca = $this->db->join('tab_karyawan b','b.nik=a.nik')
                         ->join('tab_cabang e','e.id_cabang=b.cabang')
                         ->join('tab_kontrak_kerja c','c.nik=b.nik')
                         ->where('b.cabang',$id)
                         ->select('sum(if(((to_days(CURRENT_DATE)-to_days(c.tanggal_masuk))/365)>5 and a.grade > 0,a.grade*2+2,0)) as total_grade, sum(a.nominal) as total_nominal,sum(a.persentase) as total_persentase,e.cabang as nama_cabang, count(a.nik) as jml_karyawan,sum(if(((to_days(CURRENT_DATE)-to_days(c.tanggal_masuk))/365)>=1,(to_days(CURRENT_DATE)-to_days(c.tanggal_masuk))/365,0)) as total_senioritas',false)
                         ->get('tab_master_bonus a');
        if($baca->num_rows() > 0){
            return $baca->row();
        }else{
            return array();
        }
    }

    function detail($id){
        /*$baca = $this->db->join('tab_karyawan b','b.nik=a.nik')
                         ->join('tab_cabang e','e.id_cabang=b.cabang')
                         ->join('tab_jabatan g','g.id_jabatan=b.jabatan')
                         ->join('tab_omset f','f.cabang=e.id_cabang')
                         ->join('tab_kontrak_kerja c','c.nik=b.nik')
                         ->where('f.id_omset',$id)
                         ->select('*,(if(((to_days(CURRENT_DATE)-to_days(c.tanggal_masuk))/365)>5 and a.grade > 0,a.grade*2+2,0)) as nilai_grade, (a.nominal) as total_nominal,(a.persentase) as total_persentase,e.cabang as nama_cabang,(if(((to_days(CURRENT_DATE)-to_days(c.tanggal_masuk))/365)>=1,(to_days(CURRENT_DATE)-to_days(c.tanggal_masuk))/365,0)) as total_senioritas,b.nik as nik_kar,b.nama_ktp as nama,g.jabatan as jabatan',false)
                         ->get('tab_master_bonus a');*/

        $this->db->select('a.*,a.bonus_point as bonus_point1,b.*,c.*,d.*,e.*,f.*,g.prota');
        $this->db->from('tab_bonus_karyawan a');
        $this->db->join('tab_karyawan b','b.nik=a.nik');
        $this->db->join('tab_cabang c','c.id_cabang=b.cabang');
        $this->db->join('tab_jabatan d','d.id_jabatan=b.jabatan');
        $this->db->join('tab_omset e','e.cabang=c.id_cabang');
        $this->db->join('tab_kontrak_kerja f','f.nik=b.nik');
        $this->db->join('tab_master_bonus g','g.nik=b.nik');
        $this->db->where('e.id_omset',$id);
        $baca = $this->db->get();
        if ($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }

    function detail_rekap($bln,$id){
        $this->db->select('a.*,a.bonus_point as bonus_point1,b.*,c.*,d.*,e.*,f.*,g.prota');
        $this->db->from('tab_bonus_karyawan a');
        $this->db->join('tab_karyawan b','b.nik=a.nik');
        $this->db->join('tab_cabang c','c.id_cabang=b.cabang');
        $this->db->join('tab_jabatan d','d.id_jabatan=b.jabatan');
        $this->db->join('tab_omset e','e.cabang=c.id_cabang');
        $this->db->join('tab_kontrak_kerja f','f.nik=b.nik');
        $this->db->join('tab_master_bonus g','g.nik=b.nik');
        $this->db->where('e.id_omset',$id);
        $this->db->where('month(a.entry_date)',$bln);
        $baca = $this->db->get();
        if ($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }

	function save_bonusCabang($data){
        $this->db->insert('tab_omset',$data);
    }
	
}
