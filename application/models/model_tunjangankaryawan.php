<?php
class Model_tunjanganKaryawan extends CI_Model {
    
	function index($tgl1,$tgl2){
        $baca = $this->db->join('tab_karyawan a','a.nik=d.nik')
                         ->join('tab_jabatan b','b.id_jabatan=a.jabatan')
                         ->join('tab_cabang c','c.id_cabang=a.cabang')
                         ->join('tab_master_tunjangan e','e.id_tunjangan=d.tunjangan')
                         ->select('*,d.id as id_tun_kar')
                          ->where('d.entry_user >=',$tgl1)
                          ->where('d.entry_user <=',$tgl2)
                         ->get('tab_tunjangan_karyawan d');
        if($baca->num_rows() > 0){
             return $baca->result();
        }else{
            return array();
        }
    }
	
    function add($data){
        $this->db->insert('tab_tunjangan_karyawan',$data);
    }
	
    function find($id){
		$baca = $this->db->join('tab_karyawan a','a.nik=d.nik')
                         ->join('tab_master_tunjangan e','e.id_tunjangan=d.tunjangan')
                         ->where('d.id',$id)
                         ->get('tab_tunjangan_karyawan d');
        if($baca->num_rows() > 0){
             return $baca->row();
        }else{
            return array();
        }
    }

    function update($id,$data){
        $this->db->where('id',$id)->update('tab_tunjangan_karyawan',$data);
    }

    function delete($id){
        $this->db->where('id',$id)->delete('tab_tunjangan_karyawan');
    }
}
