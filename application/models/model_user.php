<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_user extends CI_Model {

	public function menu_akses($kode)
	{
		$hasil = $this->db->join('mainmenu','mainmenu.idmenu=tab_akses_mainmenu.id_menu','left')->where('id_level',$kode)->get('tab_akses_mainmenu');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			$hasil = $this->db->get('mainmenu');
			if($hasil->num_rows() > 0){
				return $hasil->result();
			} else {
				return array();
			}
		}
	}

	public function index()
	{
		$hasil = $this->db->join('st_level_user','st_level_user.kode=tab_users.id_level')->get('tab_users');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function data_notif($id)
	{
		$hasil = $this->db->join('tab_notifikasi b','b.id=a.notifikasi','left')
						  ->where('a.level',$id)
						  ->select('*, b.id as id_notif')
						  ->get('tab_akses_notifikasi a');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			$hasil = $this->db->select('*, tab_notifikasi.id as id_notif')->get('tab_notifikasi');
			if($hasil->num_rows() > 0){
				return $hasil->result();
			} else {
				return array();
			}
		}
	}

	public function level()
	{
		$hasil = $this->db->get('st_level_user');
		if($hasil->num_rows() > 0){
			return $hasil->result();
		} else {
			return array();
		}
	}

	public function find($id){
		//Query mencari record berdasarkan ID-nya
		$hasil = $this->db->where('id', $id)
						  ->limit(1)
						  ->get('tab_users');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function add($data)
	  {
	      $this->db->insert('tab_users', $data);
	  }
	public function update($id, $data){
		$this->db->where('id', $id)
				 ->update('tab_users', $data);
	}
	public function delete($id){
		$this->db->where('id', $id)
				 ->delete('tab_users');
	}

	public function find_level($id){
		//Query mencari record berdasarkan ID-nya
		$hasil = $this->db->where('kode', $id)
						  ->limit(1)
						  ->get('st_level_user');
		if($hasil->num_rows() > 0){
			return $hasil->row();
		} else {
			return array();
		}
	}
	public function insert_aksesmenu($data)
	  {
	      $this->db->insert('tab_akses_mainmenu', $data);
	  }

	public function insert_aksessub($data)
	  {
	      $this->db->insert('tab_akses_submenu', $data);
	  }

	  public function update_aksesmenu($id,$id2,$data)
	  {
	      $this->db->where('id_menu',$id)->where('id_level',$id2)->update('tab_akses_mainmenu', $data);
	  }

	public function update_aksessub($id,$id2,$data)
	  {
	      $this->db->where('id_sub_menu',$id)->where('id_level',$id2)->update('tab_akses_submenu', $data);
	  }

	public function add_level($data)
	  {
	      $this->db->insert('st_level_user', $data);
	  }

	  public function add_notif($data)
	  {
	      $cek=$this->db->where('level',$data['level'])
	      				->where('notifikasi',$data['notifikasi'])
	      				->get('tab_akses_notifikasi')->row();
	      if (count($cek)==1) {
		      $this->db->where('id',$cek->id)->update('tab_akses_notifikasi', $data);
	      } else {
		      $this->db->insert('tab_akses_notifikasi', $data);
	      }
	  }

	public function update_level($id, $data){
		$this->db->where('kode', $id)
				 ->update('st_level_user', $data);
	}
	public function delete_level($id){
		$this->db->where('kode', $id)
				 ->delete('st_level_user');
	}
}