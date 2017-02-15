<?php
class Plant extends CI_Model {
	function deleteplant($id_cabang){
      
        $this->db->where('id_cabang',$id_cabang);
        $this->db->delete('tab_cabang');
    }
 
	function updateplant(){
        $id_cabang = $this->input->post('id_plant');
        $plant = $this->input->post('plant');
        $keterangan_plant = $this->input->post('keterangan_plant');
        $data = array(
				'id_cabang'=>$id_cabang,
                'cabang'=>$plant,
                'status'=>$this->input->post('status'),
                'keterangan_cabang'=>$keterangan_plant
                );
        $this->db->where('id_cabang',$id_cabang);
        $this->db->update('tab_cabang',$data);
    }
    function filterdata($id_cabang){
        return $this->db->get_where('tab_cabang',
                          array('id_cabang'=>$id_cabang))->row();
    }
	
     function bacaplant(){
        $baca = $this->db->get('tab_cabang');
        if($baca->num_rows() > 0){
            foreach ($baca->result() as $data){
                $hasil[] = $data;
            }

            return $hasil;
        }
    }
	
	function tambah(){
        $plant = $this->input->post('plant');
        $keterangan_plant = $this->input->post('keterangan_plant');
        $data = array(
                    'cabang'=>$plant,
                    'status'=>$this->input->post('status'),
                    'keterangan_cabang'=>$keterangan_plant,
                    'entry_date' => date('Y-m-d H:i:s'),
                    'entry_user' => $this->session->userdata('nama')
                );
        $this->db->insert('tab_cabang',$data);
    }
}
?>