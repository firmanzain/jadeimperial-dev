<?php
class Model_omset extends CI_Model {

    public function index(){
        $this->db->select('a.*, b.cabang as nama_cabang');
        $this->db->from('tab_omset_standart a');
        $this->db->join('tab_cabang b', 'b.id_cabang = a.cabang', 'inner');
        $this->db->where('b.status', 'Aktif');

        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query;
        else return false;
    }
    
    public function update($where, $data){
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $this->db->where($where['data'][$i]['column'],$where['data'][$i]['param']);
            }
        }
        $this->db->update('tab_omset_standart', $data);
        $error = $this->db->error();
        $result = new stdclass();
        if ($this->db->affected_rows() > 0 or $error['code']==0){
            $result->status = true;
        }
        else{
            $result->status = false;
            $result->output = $error['code'].': '.$error['message'];
        }

        return $result;
    }
	
}
