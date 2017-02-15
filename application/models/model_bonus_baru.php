<?php
class Model_bonus_baru extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function index($bln,$thn){
        $query = $this->db->query('
            SELECT 
                a.id_omset AS id_omset, 
                a.cabang AS id_cabang, 
                b.cabang AS cabang, 
                COUNT(c.id_bonus) AS jml_karyawan, 
                a.omset_standart AS omset_standart, 
                SUM(c.bonus_standart) AS bonus_standart, 
                a.omset_real AS omset_real, 
                SUM(c.bonus_real) AS bonus_real, 
                SUM(c.total_diterima) AS total_diterima, 
                SUM(c.total_kembali) AS total_kembali,
                a.approved as approved,
                a.keterangan as keterangan
            FROM tab_omset_baru a 
            INNER JOIN tab_cabang b ON b.id_cabang = a.cabang
            INNER JOIN tab_bonus_karyawan_baru c ON c.omset = a.id_omset
            WHERE MONTH(a.bulan_bonus) = "'.$bln.'" AND YEAR(a.bulan_bonus) = "'.$thn.'"
            GROUP BY a.id_omset 
        ');

        if($query->num_rows() > 0)
            return $query;
        else return false;
    }

    public function cabang(){
        $query = $this->db->where('status','Aktif')->get('tab_cabang');
        if($query->num_rows() > 0){
            return $query->result();
        }else{
            return array();
        }
    }

    public function omset_standart($cabang){
        $query = $this->db->where('cabang',$cabang)->get('tab_omset_standart');
        if($query->num_rows() > 0){
            return $query;
        } else {
            return array();
        }
    }

    public function insert_omset($data){
        $query = $this->db->insert('tab_omset_baru', $data);
        $result = new stdclass();
        if ($this->db->affected_rows() > 0){
            $result->status = true;
            $result->output = $this->db->insert_id();
        }
        else{
            $result->status = false;
            $result->output = '';
        }

        return $result;
    }
    
    public function bonus($cabang, $bulan){
        $tgl_awal   = date('Y-m-01',strtotime($bulan));
        $tgl_akhir  = date('Y-m-t',strtotime($bulan));
        $query = $this->db->query('
            select a.nik, b.nominal2, c.tanggal_resign, d.tanggal_sp 
            from tab_karyawan a 
            inner join tab_master_bonus b on b.nik = a.nik 
            inner join tab_history_kontrak_kerja c on c.nik = a.nik 
            left join tab_sp d on d.nik = a.nik 
            where (a.cabang = '.$cabang.' or a.cabang = 2) 
            and b.tipe_bonus = 1 
            and (c.tanggal_resign >= "'.$tgl_awal.'" or c.tanggal_resign = "0000-00-00") 
            and c.tanggal_masuk < "'.$tgl_awal.'" 
            group by a.nik 
        ');
        if($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

    public function insert_bonus($data){
        $query = $this->db->insert('tab_bonus_karyawan_baru', $data);
        $result = new stdclass();
        if ($this->db->affected_rows() > 0){
            $result->status = true;
            $result->output = $this->db->insert_id();
        }
        else{
            $result->status = false;
            $result->output = '';
        }

        return $result;
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
    
    public function delete($id, $bln, $thn){
        $query = $this->db->where('cabang', $id)
                      ->where('month(bulan_bonus)', $bln)
                      ->where('year(bulan_bonus)', $thn)
                      ->get('tab_omset_baru');
        foreach ($query->result() as $row) {
            $delete_omset = $this->db->where('cabang', $id)
                                 ->where('month(bulan_bonus)', $bln)
                                 ->where('year(bulan_bonus)', $thn)
                                 ->delete('tab_omset_baru');
            $delete_bonus = $this->db->where('omset', $row->id_omset)
                                 ->delete('tab_bonus_karyawan_baru');
        }

        if ($this->db->affected_rows()){
            $result->status = true;
        }
        else{
            $result->status = false;
        }

        return $result;
    }
    
    public function detail($id, $bln, $thn){
        $query = $this->db->where('cabang', $id)
                      ->where('month(bulan_bonus)', $bln)
                      ->where('year(bulan_bonus)', $thn)
                      ->get('tab_omset_baru');
        foreach ($query->result() as $row) {
            $query_detail = $this->db->query('
                SELECT 
                    a.id_bonus AS id_bonus, 
                    a.nik AS nik, 
                    b.nama_ktp AS nama_ktp,
                    a.bonus_standart AS bonus_standart, 
                    a.bonus_real AS bonus_real, 
                    a.total_diterima as total_diterima,
                    a.total_kembali AS total_kembali, 
                    a.total_bulat_diterima AS total_bulat_diterima, 
                    a.approved AS approved, 
                    a.keterangan AS keterangan 
                FROM tab_bonus_karyawan_baru a 
                INNER JOIN tab_karyawan b ON b.nik = a.nik 
                WHERE a.omset = '.$row->id_omset
            );
        }

        if($query_detail->num_rows() > 0)
            return $query_detail;
        else
            return false;
    }

    public function approve($where, $where2, $data){
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $this->db->where($where['data'][$i]['column'],$where['data'][$i]['param']);
            }
        }
        $this->db->update('tab_omset_baru', $data);
        if ($where2) {
            for ($i=0; $i<sizeof($where2['data']) ; $i++) { 
                $this->db->where($where2['data'][$i]['column'],$where2['data'][$i]['param']);
            }
        }
        $this->db->update('tab_bonus_karyawan_baru', $data);
        $result = new stdclass();
        if ($this->db->affected_rows() > 0){
            $result->status = true;
        }
        else{
            $result->status = false;
        }

        return $result;
    }
	
}
