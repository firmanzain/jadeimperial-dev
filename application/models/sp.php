<?php
class Sp extends CI_Model {
    
    function select_data() {
        $query = $this->db->get('tab_sp');
        return $query->result();
    }
	function index($tgl1,$tgl2){
        $baca = $this->db->join('tab_karyawan b','b.nik=e.nik')
                         ->join('tab_cabang a','a.id_cabang=b.cabang')
                         ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
                         ->join('tab_department d','d.id_department=b.department')
                         ->where('e.tanggal_sp >=',$tgl1)
                         ->where('e.tanggal_sp <=',$tgl2)
                         ->get('tab_sp e');
        if($baca->num_rows() > 0){
            return $baca->result();
        } else {
            return array();
        }
    }
	
    function add($data){
        $this->db->insert('tab_sp',$data);
    }

    function delete($id){
        $this->db->where('id_sp',$id)->delete('tab_sp');
    }

	function filterdata($nik){
        return $this->db->get_where('tab_karyawan',
                          array('nik'=>$nik))->row();
    }
	function filterdatasp($id){
        $baca = $this->db->join('tab_karyawan b','b.nik=e.nik')
                         ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
                         ->join('tab_department d','d.id_department=b.department')
                         ->where('e.id_sp',$id)
                         ->get('tab_sp e');
        if($baca->num_rows() > 0){
            return $baca->row();
        } else {
            return array();
        }
    }

    function periksa($id){
        $baca = $this->db->join('tab_karyawan b','b.nik=e.pemeriksa')
                         ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
                         ->join('tab_department d','d.id_department=b.department')
                         ->where('e.id_sp',$id)
                         ->get('tab_sp e');
        if($baca->num_rows() > 0){
            return $baca->row();
        } else {
            return array();
        }
    }
}