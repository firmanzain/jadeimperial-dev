<?php
class Department extends CI_Model {
	function deletedepartment($id_department){
       
        $this->db->where('id_department',$id_department);
        $this->db->delete('tab_department',$data);
    }
 
	function updatedepartment(){
        $id_department = $this->input->post('id_department');
        $department = $this->input->post('department');
        $keterangan_department = $this->input->post('keterangan_department');
        $data = array(
				'id_department'=>$id_department,
                'department'=>$department,
                'status'=>$this->input->post('status'),
                'keterangan_department'=>$keterangan_department
                );
        $this->db->where('id_department',$id_department);
        $this->db->update('tab_department',$data);
    }
    function filterdata($id_department){
        return $this->db->get_where('tab_department',
                          array('id_department'=>$id_department))->row();
    }
	
     function bacadepartment(){
        $baca = $this->db->get('tab_department');
        if($baca->num_rows() > 0){
            foreach ($baca->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
	
	function tambah(){
        $department = $this->input->post('department');
        $keterangan_department = $this->input->post('keterangan_department');
        $data = array(
                'department'=>$department,
                'status'=>$this->input->post('status'),
                'keterangan_department'=>$keterangan_department,
                'entry_date' => date('Y-m-d H:i:s'),
                'entry_user' => $this->session->userdata('nama')
                );
        $this->db->insert('tab_department',$data);
    }
}
?>