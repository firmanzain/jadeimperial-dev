<?php
class Komisi extends CI_Model {
    
	function index($tgl1,$tgl2,$cb){
    //function index($bln,$thn,$cb){
        /*if (!empty($tgl1) && !empty($tgl2)) 
        { // jika tidak kosong
            $this->db->where("(d.bulan between '".$tgl1."' and '".$tgl2."')",null);
        }
        else // jika kosong, tampilkan bulan sekarang
        {
            $this->db->where("month(d.bulan)",date('m'));
        }*/
        //$this->db->where("month(d.bulan)",date($bln));
        //$this->db->where("year(d.bulan)",date($thn));

        if (!empty($cb)) // jika cabang tidak kosong
        {
            $this->db->where('c.id_cabang',$cb);   
        }
        
        $baca = $this->db->join('tab_karyawan a','a.nik=d.nik')
                         ->join('tab_jabatan b','b.id_jabatan=a.jabatan')
                         ->join('tab_cabang c','c.id_cabang=a.cabang')
                         ->where('d.bulan >=',$tgl1)
                         ->where('d.bulan <=',$tgl2)
                         ->order_by('d.bulan','desc')
                         ->get('tab_komisi d');
        if($baca->num_rows() > 0){
             return $baca->result();
        }else{
            return array();
        }
    }
	
    function save($data){
        $this->db->insert('tab_komisi',$data);
    }
	
    function filterdata($nik){
        $baca = $this->db->join('tab_karyawan a','a.nik=d.nik')
                         ->join('tab_jabatan b','b.id_jabatan=a.jabatan')
                         ->join('tab_cabang c','c.id_cabang=a.cabang')
                         ->where('a.nik',$nik)
                         ->get('tab_komisi d');
        if($baca->num_rows() > 0)
        {
             return $baca->row();
        }
        else
        {
            return array();
        }
    }
}