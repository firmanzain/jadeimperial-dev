<?php
class Pengangkatan extends CI_Model {
    
    function select_data() {
        $query = $this->db->get('tab_pengangkatan');
        return $query->result();
    }
	function index($tgl1,$tgl2){
        $baca = $this->db->join('tab_karyawan b','b.nik=d.nik')
                         ->join('tab_cabang c','c.id_cabang=b.cabang')
                         ->join('tab_jabatan s','s.id_jabatan=d.jabatan2')
                         ->join('tab_department f','f.id_department=b.department')
                         ->join('tab_kontrak_kerja e','e.nik=b.nik')
                         ->select('*,d.id as id_pangkat')
                         ->where('d.entry_date >=',$tgl1)
                         ->where('d.entry_date <=',$tgl2)
                         ->order_by('d.entry_date','desc')
                         ->get('tab_pengangkatan d');
        if($baca->num_rows() > 0){
            return $baca->result();
        }
    }

	function pengangkatanKaryawan(){
		$n=$this->db->get('tab_pengangkatan');
		$no=$n->num_rows()+1;
			if($no >= '10'){
				$a = '0';
			}else{
				$a='00';
			}
		$tahun = date('Y');
		$nom = $a.$no.'/III/CRN-PM/SDM/PKT/'.$tahun;
        $nik = $this->input->post('nik');
        $jabatan1 = $this->input->post('jabatan1');
        $jabatan2 = $this->input->post('jabatan2');
        $mulai = $this->input->post('tanggal_per');
        $data = array(
				'no_pengangkatan'=>$nom,
                'nik'=>$nik,
                'jabatan1'=>$jabatan1,
                'jabatan2'=>$jabatan2,
                'department1'=>$this->input->post('department1'),
                'department2'=>$this->input->post('department2'),
                'status1'=>$this->input->post('status1'),
                'status2'=>$this->input->post('status2'),
                'hrd'=>$this->input->post('hrd'),
                'manager'=>$this->input->post('manager'),
                'entry_user'=>$this->session->userdata('username'),
				'tanggal_per'=>$mulai
                );
		$datak = array(
                'department'=>$this->input->post('department2'),
                'jabatan'=>$jabatan2
                );
        $data_kontrak = array(
                'tanggal_masuk'=>$this->input->post('tanggal_per'),
                'tanggal_resign'=>$this->input->post('tanggal2'),
                'status_kerja'=>$this->input->post('status2')
                );
        $cek=$this->db->where($datak)
                      ->where('nik',$nik)
                      ->get('tab_karyawan')->num_rows();
        $cek2=$this->db->where('status_kerja',$this->input->post('status2'))
                      ->where('nik',$nik)
                      ->get('tab_kontrak_kerja')->num_rows();

        if ($cek>=1 && $cek2>=1) {
            return 0;
        }else {
            $this->db->insert('tab_pengangkatan',$data);
            $this->db->where('nik',$nik)
                     ->update('tab_karyawan',$datak);

            $query_his = $this->db->query(
                '
                select * from tab_kontrak_kerja 
                WHERE nik="'.$nik.'"
                '
            );
            foreach ($query_his->result() as $row) {
                $data_his = array(
                    'nik' => $row->nik,
                    'status_kerja' => $row->status_kerja,
                    'tanggal_masuk' => $row->tanggal_masuk,
                    'tanggal_resign' => $row->tanggal_resign,
                    'gaji_pokok' => $row->gaji_pokok,
                    'gaji_casual' => $row->gaji_casual,
                    'tunjangan_jabatan' => $row->tunjangan_jabatan,
                    'uang_makan' => $row->uang_makan
                );
                $this->db->where('nik',$data_his['nik']);
                $this->db->where('tanggal_masuk',$data_his['tanggal_masuk']);
                $this->db->delete('tab_history_kontrak_kerja');

                $this->db->insert('tab_history_kontrak_kerja',$data_his);
            }

            $this->db->where('nik',$nik)
                     ->update('tab_kontrak_kerja',$data_kontrak);

            $query_his2 = $this->db->query(
                '
                select * from tab_kontrak_kerja 
                WHERE nik="'.$nik.'"
                '
            );
            foreach ($query_his2->result() as $row) {
                $data_his2 = array(
                    'nik' => $row->nik,
                    'status_kerja' => $row->status_kerja,
                    'tanggal_masuk' => $row->tanggal_masuk,
                    'tanggal_resign' => $row->tanggal_resign,
                    'gaji_pokok' => $row->gaji_pokok,
                    'gaji_casual' => $row->gaji_casual,
                    'tunjangan_jabatan' => $row->tunjangan_jabatan,
                    'uang_makan' => $row->uang_makan
                );
                $this->db->where('nik',$data_his2['nik']);
                $this->db->where('tanggal_masuk',$data_his2['tanggal_masuk']);
                $this->db->delete('tab_history_kontrak_kerja');

                $this->db->insert('tab_history_kontrak_kerja',$data_his2);
            }
            return 1;
        }
    }

	function filterdatapengangkatan($id){
        $baca=$this->db->join('tab_karyawan b','b.nik=d.nik')
                         ->join('tab_cabang c','c.id_cabang=b.cabang')
                         ->join('tab_jabatan s','s.id_jabatan=d.jabatan2')
                         ->join('tab_department f','f.id_department=b.department')
                         ->join('tab_kontrak_kerja e','e.nik=b.nik')
                         ->where('d.id',$id)
                         ->get('tab_pengangkatan d');
        if ($baca>=1) {
            return $baca->row();
        } else {
            return array();
        }
    }

    public function delete($id){
        $this->db->where('id', $id)->delete('tab_pengangkatan');
    }
}