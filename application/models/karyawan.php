<?php
class Karyawan extends CI_Model {
    
    function find_data($nik){
        return $this->db->get_where('tab_karyawan',
                          array('nik'=>$nik))->row();
    }

    public function find_data_status($nik)
    {
        $hasil=$this->db->join('tab_karyawan','tab_karyawan.nik=tab_kontrak_kerja.nik')
                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
                        ->select('*,tab_kontrak_kerja.entry_date as masuk')
                        ->where('tab_karyawan.nik',$nik)->get('tab_kontrak_kerja')->result();

        if (count($hasil)>=1) {
            return $hasil;
        } else {
            return array();
        }
    }

    function deletekaryawan($id_karyawan){
      
        $this->db->where('id_karyawan',$id_karyawan);
        $this->db->delete('tab_karyawan');
    }
 
    function find($nik){
         $baca = $this->db->join('tab_jabatan a','a.id_jabatan=b.jabatan','left')
                          ->where('b.nik',$nik)
                          ->join('tab_cabang c','c.id_cabang=b.cabang','left')
                          ->join('tab_master_bonus e','e.nik=b.nik','left')
                          ->join('tab_npwp f','f.nik=b.nik','left')
                          ->join('tab_kontrak_kerja g','g.nik=b.nik','left')
                          ->join('tab_asuransi_karyawan i','i.nik=b.nik','left')
                          ->join('tab_asuransi j','j.id=i.asuransi','left')
                          ->join('tab_pajak h','h.id_pajak=b.status_pajak','left')
                          ->join('tab_department d','d.id_department=b.department','left')
                          ->select('*,b.nik as nik_real,i.asuransi as id_vend,e.nominal as nominal_bonus')
                          ->get('tab_karyawan b');
        if (count($baca)>=1) {
            return $baca->row();
        } else {
            return array();
        }
    }


    function findKeluarga($nik){
        $baca = $this->db->where('nik',$nik)->get('tab_keluarga');
        if (count($baca)>=1) {
            return $baca->result();
        } else {
            return array();
        }
    }
    
    public function karyawan_show($id_cabang){
        if (isset($id_cabang) && $id_cabang != 0) {
            $this->db->where('tab_karyawan.cabang',$id_cabang);
        }
        $hasil=$this->db->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                        ->join('tab_pajak','tab_pajak.id_pajak=tab_karyawan.status_pajak')
                        ->join('tab_asuransi_karyawan','tab_asuransi_karyawan.nik=tab_karyawan.nik')
                        ->join('tab_asuransi','tab_asuransi.id=tab_asuransi_karyawan.asuransi')
                        ->join('tab_master_bonus','tab_master_bonus.nik=tab_karyawan.nik')
                        ->join('tab_kontrak_kerja','tab_kontrak_kerja.nik=tab_karyawan.nik')
                        ->join('tab_npwp','tab_npwp.nik=tab_karyawan.nik')
                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
                        ->select('*,tab_karyawan.nik as nik_karyawan')
                        ->order_by('tab_karyawan.nama_ktp','asc')
                        ->get('tab_karyawan')->result();
        if (count($hasil)>=1) {
            return $hasil;
        }else {
            return array();
        }
    }
    function index (){
        $baca = $this->db->join('tab_jabatan a','a.id_jabatan=b.jabatan','left')
                         ->join('tab_cabang c','c.id_cabang=b.cabang','left')
                         ->join('tab_department d','d.id_department=b.department','left')
                         ->get('tab_karyawan b');
        if($baca->num_rows() > 0){
            return $baca->result();
        }else{
            return array();
        }
    }
    
    function input_karyawan($data){
        $this->db->insert('tab_karyawan',$data);
    }

    function input_keluarga($data){
        $this->db->insert('tab_keluarga',$data);
    }

    function input_bpjs($data){
        $this->db->insert('tab_bpjs_karyawan',$data);
    }

    function input_bonus($data){
        $this->db->insert('tab_master_bonus',$data);
    }

    function input_asuransi($data){
        $this->db->insert('tab_asuransi_karyawan',$data);
    }

    function input_npwp($data){
        $this->db->insert('tab_npwp',$data);
    }

    function input_kontrak($data){
        $this->db->insert('tab_kontrak_kerja',$data);
    }

    function input_pajak($data){
        $cek=$this->db->where('nik',$data['nik'])
                      ->where('id_pajak',$data['id_pajak'])
                      ->get('tab_status_pajak')->num_rows();
        if ($cek<1) {
            $this->db->insert('tab_status_pajak',$data);
        }
    }

    function input_history_pajak($data,$type){
        if ($type == 0) {
            $cek=$this->db->where('nik',$data['nik'])
                          ->where('id_pajak',$data['id_pajak'])
                          ->get('tab_status_pajak')->num_rows();
            if ($cek<1) {
                $this->db->insert('tab_status_pajak',$data);
            }
            $this->db->insert('tab_history_status_pajak',$data);
        } else {
            $cek=$this->db->where('nik',$data['nik'])
                          ->where('id_pajak',$data['id_pajak'])
                          ->get('tab_status_pajak')->num_rows();
            if ($cek<1) {
                $this->db->insert('tab_status_pajak',$data);
            }
            $cek2=$this->db->where('nik',$data['nik'])
                          ->where('id_pajak',$data['id_pajak'])
                          ->get('tab_history_status_pajak')->num_rows();
            if ($cek2<1) {
                $this->db->insert('tab_history_status_pajak',$data);
            }
        }
    }

    function update_karyawan($nik,$data){
        $this->db->where('nik',$nik)->update('tab_karyawan',$data);
    }

    function update_keluarga($nik,$data){
        $this->db->where('nik',$nik)->update('tab_keluarga',$data);
    }

    function update_bpjs($nik,$data){
        $this->db->where('nik',$nik)->where('id_bpjs',$data['id_bpjs'])->update('tab_bpjs_karyawan',$data);
    }

    function update_bonus($nik,$data){
        $this->db->where('nik',$nik)->update('tab_master_bonus',$data);
    }

    function update_asuransi($nik,$data){
        $this->db->where('nik',$nik)->update('tab_asuransi_karyawan',$data);
    }

    function update_npwp($nik,$data){
        $this->db->where('nik',$nik)->update('tab_npwp',$data);
    }

    function update_kontrak($nik,$data){
        $this->db->where('nik',$nik)->update('tab_kontrak_kerja',$data);
    }
     
}
?>