<?php
class Jabatan extends CI_Model {
	function deletejabatan($id_jabatan){
        $query = $this->db->query('select * from tab_karyawan where jabatan = '.$id_jabatan);
        if ($query==false) {
            $this->db->where('id_jabatan',$id_jabatan);
            $this->db->delete('tab_jabatan');
        }
    }
 
	function updatejabatan(){
        $id_jabatan = $this->input->post('id_jabatan');
        $jabatan = $this->input->post('jabatan');
        $gaji_pokok= $this->input->post('gaji_pokok');
        $keterangan_jabatan = $this->input->post('keterangan_jabatan');
        $data = array(
				'id_jabatan'=>$id_jabatan,
                'jabatan'=>$jabatan,
                'fungsionalitas'=>$this->input->post('fungsionalitas'),
                'status'=>$this->input->post('status'),
                'keterangan_jabatan'=>$keterangan_jabatan,
                'entry_date' => date('Y-m-d H:i:s'),               
                'entry_user'=>$this->session->userdata('nama')
                );
        $this->db->where('id_jabatan',$id_jabatan);
        $this->db->update('tab_jabatan',$data);
    }
    function filterdata($id_jabatan){
        return $this->db->get_where('tab_jabatan',
                          array('id_jabatan'=>$id_jabatan))->row();
    }
	
     function bacajabatan(){
        $baca = $this->db->get('tab_jabatan');
        if($baca->num_rows() > 0){
            foreach ($baca->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
	
	function tambah(){
        $jabatan = $this->input->post('jabatan');
        $gaji_pokok = $this->input->post('gaji_pokok');
        $keterangan_jabatan = $this->input->post('keterangan_jabatan');
        $data = array(
                'jabatan'=>$jabatan,
                'fungsionalitas'=>$this->input->post('fungsionalitas'),
                'status'=>$this->input->post('status'),
                'keterangan_jabatan'=>$keterangan_jabatan,
                'entry_date' => date('Y-m-d H:i:s'),               
                'entry_user'=>$this->session->userdata('nama')
                );
        $this->db->insert('tab_jabatan',$data);
    }
}
?>