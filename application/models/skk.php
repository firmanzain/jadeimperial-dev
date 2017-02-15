<?php
class Skk extends CI_Model {
    
	function index(){
        $baca = $this->db->get('tab_karyawan');
        if($baca->num_rows() > 0){
            foreach ($baca->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
	function lihatskk(){
        $baca = $this->db->get('tab_skk');
        if($baca->num_rows() > 0){
            foreach ($baca->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

	function skkKaryawan(){
		$n=$this->db->get('tab_skk');
		$no=$n->num_rows()+1;
			if($no >= '10'){
				$a = '0';
			}else{
				$a='00';
			}
		$tahun = date('Y');
		$nom = $a.$no.'/II/HRD/2016'.$tahun;
        $nik = $this->input->post('nik');
        $data = array(
				'no_skk'=>$nom,
                'nik'=>$nik
                );
        $this->db->insert('tab_skk',$data);
    }
	function skkbKaryawan(){
		$n=$this->db->get('tab_bpjs');
		$no=$n->num_rows()+1;
			if($no >= '10'){
				$a = '0';
			}else{
				$a='00';
			}
		$tahun = date('Y');
		$nom = $a.$no.'/III/HRD/2016'.$tahun;
        $nik = $this->input->post('nik');
        $data = array(
				'no_bpjs'=>$nom,
                'nik'=>$nik
                );
        $this->db->insert('tab_bpjs',$data);
    }
	  function filterdata($nik){
        return $this->db->get_where('tab_karyawan',
                          array('nik'=>$nik))->row();
    }
}