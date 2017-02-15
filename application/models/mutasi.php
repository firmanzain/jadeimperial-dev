<?php
class Mutasi extends CI_Model {
    
    function select_data() {
        $query = $this->db->get('tab_mutasi');
        return $query->result();
    }
	function index($tgl1,$tgl2){
        $baca=$this->db->join('tab_karyawan','tab_karyawan.nik=tab_mutasi.nik')
                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
                        ->where('tab_mutasi.tanggal_berlaku >=',$tgl1)
                        ->where('tab_mutasi.tanggal_berlaku <=',$tgl2)
                        ->order_by('tab_mutasi.tanggal_berlaku','desc')
                        ->get('tab_mutasi');
        if($baca->num_rows() > 0){
            foreach ($baca->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

	function mutasiKaryawan(){
		$n=$this->db->get('tab_mutasi');
		$no=$n->num_rows()+1;
			if($no >= '10'){
				$a = '0';
			}else{
				$a='00';
			}
		$tahun = date('Y');
		$nom = $a.$no.'/IX/CRN-HRD/IM/'.$tahun;
        $nik = $this->input->post('nik');
        $cabang1 = $this->input->post('cabang1');
        $cabang2 = $this->input->post('cabang2');
        $keterangan_cabang = $this->input->post('keterangan_cabang');
        $data = array(
				'no_mutasi'=>$nom,
                'nik'=>$nik,
                'cabang1'=>$cabang1,
                'jabatan1'=>$this->input->post('jabatan1'),
                'jabatan2'=>$this->input->post('jabatan2'),
                'department1'=>$this->input->post('department1'),
                'department2'=>$this->input->post('department2'),
                'hrd'=>$this->input->post('hrd'),
                'manager'=>$this->input->post('manager'),
                'tanggal_berlaku'=>$this->input->post('tanggal_per'),
                'entry_user'=>$this->session->userdata('username'),
                'cabang2'=>$cabang2
                );
		$datak = array(
                'cabang'=>$cabang2,
                'department'=>$this->input->post('department2'),
                'jabatan'=>$this->input->post('jabatan2')
                );
        $cek=$this->db->where($datak)
                      ->where('nik',$nik)
                      ->get('tab_karyawan')->num_rows();
        if ($cek<1) {
            $this->db->insert('tab_mutasi',$data);
            $this->db->where('nik',$nik);
            $this->db->update('tab_karyawan',$datak);

            return 1;
        }else{
            return 0;
        }
    }
	function filterdata($nik){
        return $this->db->get_where('tab_karyawan',
                          array('nik'=>$nik))->row();
    }
	function filterdatamutasi($id){
        $hasil=$this->db->join('tab_karyawan','tab_karyawan.nik=tab_mutasi.nik')
                        ->join('tab_jabatan','tab_jabatan.id_jabatan=tab_karyawan.jabatan')
                        ->join('tab_cabang','tab_cabang.id_cabang=tab_karyawan.cabang')
                        ->join('tab_department','tab_department.id_department=tab_karyawan.department')
                        ->order_by('tab_mutasi.tanggal_berlaku','desc')
                        ->where('tab_mutasi.id_mutasi',$id)
                        ->get('tab_mutasi')
                        ->row();
        if (count($hasil==1)) {
            return $hasil;
        } else {
            return array();
        }
    }
}