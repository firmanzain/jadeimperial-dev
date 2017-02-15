<?php
class Pajak extends CI_Model {
	function deletePajak($id_pajak){
      
        $this->db->where('id_pajak',$id_pajak);
        $this->db->delete('tab_pajak');
    }
 
	function updatePajak(){
        $id_pajak = $this->input->post('id_pajak');
        $pajak = $this->input->post('pajak');
        $gaji = $this->input->post('gaji');
        $keterangan_pajak = $this->input->post('keterangan_pajak');
        $data = array(
				'id_pajak'=>$id_pajak,
                'pajak'=>$pajak,
                'keterangan_pajak'=>$keterangan_pajak,
                'tarif'=>str_replace('.','',$gaji),
                'tarif_bulan'=>str_replace('.','',$this->input->post('gaji_bulan')),
                'entry_date' => date('Y-m-d H:i:s'),
                'entry_user' => $this->session->userdata('nama')
                );
        $this->db->where('id_pajak',$id_pajak);
        $this->db->update('tab_pajak',$data);
    }
    function filterdata($id_pajak){
        return $this->db->get_where('tab_pajak',
                          array('id_pajak'=>$id_pajak))->row();
    }
	
     function bacaPajak(){
        $baca = $this->db->get('tab_pajak');
        if($baca->num_rows() > 0){
            foreach ($baca->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
	
	function tambah(){
        $pajak = $this->input->post('pajak');
        $gaji = $this->input->post('gaji');
        $keterangan_pajak = $this->input->post('keterangan_pajak');
        $data = array(
                'pajak'=>$pajak,
                'tarif'=>str_replace('.','',$gaji),
                'tarif_bulan'=>str_replace('.','',$this->input->post('gaji_bulan')),
                'keterangan_pajak'=>$keterangan_pajak,
                'entry_date' => date('Y-m-d H:i:s'),
                'entry_user' => $this->session->userdata('nama')
                );
        $this->db->insert('tab_pajak',$data);
    }
}
?>