<?php
class Rekapgaji extends CI_Model {
    
	function index(){
        $baca = $this->db->get('tab_karyawan');
        if($baca->num_rows() > 0){
            foreach ($baca->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
	function lihatrekapgaji(){
        $baca = $this->db->get('tab_karyawan');
        if($baca->num_rows() > 0){
            foreach ($baca->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

	function rekapgajiInternal(){
		// $n=$this->db->get('tab_rekapgaji');
		// $no=$n->num_rows()+1;
			// if($no >= '10'){
				// $a = '0';
			// }else{
				// $a='00';
			// }
		// $tahun = date('Y');
		// $nom = $a.$no.'/II/HRD/2016'.$tahun;
        // $nik = $this->input->post('nik');
        $rekapgaji = $this->input->post('rekapgaji');
        $data = array(
                'isi_rekapgaji'=>$rekapgaji
                );
        $this->db->insert('tab_rekapgaji',$data);
    }
	function rekapgajibKaryawan(){
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