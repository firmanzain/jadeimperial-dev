<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {
  public function __construct(){
    parent::__construct();
    $this->auth->restrict();
    $this->load->model('model_user');
  }
  
    public function index()
    {
        $data['data']=$this->model_user->index();
        $this->table->set_heading(array('NO','NAMA','USER LEVEL','USERNAME','STATUS','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('user/index',$data,true);
        $this->load->view('beranda',$data);
    }

    public function notifikasi($id)
    {
        if ($this->input->post()) {
            $dt_notif=$this->db->get('tab_notifikasi')->result();
            $i=0;
            foreach ($dt_notif as $rs_notif) {
                if (is_null($this->input->post('cb_data')[$i])) {
                    $tampilan='style="display:none"';
                }else{
                    $tampilan='';
                }
                $data = array(
                            'level' => $id,
                            'notifikasi' => $rs_notif->id,
                            'allowed' => $this->input->post('cb_data')[$i],
                            'visibled' => $tampilan,
                            'entry_user' => $this->session->userdata('username'),
                        );
                $this->model_user->add_notif($data);
                $i++;
            }
            
        }
        $data['level']=$this->db->where('kode',$id)->get('st_level_user')->row();
        $data['data']=$this->model_user->data_notif($id);
        $this->table->set_heading(array('NO','NOTIFIKASI','HAK AKSES'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('user/notifikasi',$data,true);
        $this->load->view('beranda',$data);
    }

    public function user_level()
    {
        $data['data']=$this->model_user->level();
        $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','DESKRIPSI','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                'thead_open'=>'<thead>',
                'thead_close'=> '</thead>',
                'tbody_open'=> '<tbody>',
                'tbody_close'=> '</tbody>',
            );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('user/level_user',$data,true);
        $this->load->view('beranda',$data);
    }

    public function all_menu($kode)
    {
        if ($this->input->post()) {
            $cek_data=$this->db->where('id_level',$kode)->get('tab_akses_mainmenu')->num_rows();
            if ($cek_data>=1) {
                $this->user_aksesUpdate($kode);
            } else {
                $this->user_akses($kode);
            }
        } else {
          $data['level']=$this->db->where('kode',$kode)->get('st_level_user')->row();
          $data['data']=$this->model_user->menu_akses($kode);
          $data['halaman']=$this->load->view('user/menu_user',$data,true);
          $this->load->view('beranda',$data);
        }
    }

    public function user_akses($kode) {
      $jml_menu=$this->db->get('mainmenu')->result();
      $i=0;
      foreach($jml_menu as $idmenu) { 
        $data = array(
                  'id_menu' =>$idmenu->idmenu,
                  'id_level' =>$kode,
                  'c' =>$this->input->post('cb_read_menu')[$i],
                  'r' =>$this->input->post('cb_create_menu')[$i],
                  'u' =>$this->input->post('cb_update_menu')[$i],
                  'd' =>$this->input->post('cb_delete_menu')[$i],
                  'entry_user' => $this->session->userdata('username')
                );
        $this->model_user->insert_aksesmenu($data);
        $i++;
      }
      $jml_sub=$this->db->get('submenu')->result();
      $i=0;
      foreach($jml_sub as $idsub) { 
        $data = array(
                  'id_sub_menu' =>$idsub->id_sub,
                  'id_level' =>$kode,
                  'c' =>$this->input->post('cb_read_sub')[$i],
                  'r' =>$this->input->post('cb_create_sub')[$i],
                  'u' =>$this->input->post('cb_update_sub')[$i],
                  'd' =>$this->input->post('cb_delete_sub')[$i],
                  'entry_user' => $this->session->userdata('username')
                );
        $this->model_user->insert_aksessub($data);
        $i++;
      }
      redirect('User/level');
    }

    public function user_aksesUpdate($kode) {
      $jml_menu=$this->db->get('mainmenu')->result();
      $j=0;
      $i=0;
      foreach($jml_menu as $idmenu) { 
        $data1 = array(
                  'id_menu' =>$idmenu->idmenu,
                  'id_level' =>$kode,
                  'c' =>$this->input->post('cb_read_menu')[$i],
                  'r' =>$this->input->post('cb_create_menu')[$i],
                  'u' =>$this->input->post('cb_update_menu')[$i],
                  'd' =>$this->input->post('cb_delete_menu')[$i],
                  'entry_user' => $this->session->userdata('username')
                );
        $jml_sub=$this->db->where('mainmenu_idmenu',$idmenu->idmenu)->get('submenu')->result();
        foreach($jml_sub as $idsub) { 
          $data2 = array(
                    'id_sub_menu' =>$idsub->id_sub,
                    'id_level' =>$kode,
                    'c' =>$this->input->post('cb_read_sub')[$i][$j],
                    'r' =>$this->input->post('cb_create_sub')[$i][$j],
                    'u' =>$this->input->post('cb_update_sub')[$i][$j],
                    'd' =>$this->input->post('cb_delete_sub')[$i][$j],
                    'entry_user' => $this->session->userdata('username')
                  );
          $cek_sub=$this->db->where('id_sub_menu',$idsub->id_sub)->where('id_level',$kode)->get('tab_akses_submenu')->num_rows();
          if ($cek_sub==1) {
            $this->model_user->update_aksessub($idsub->id_sub,$kode,$data2);
          } else {
            $this->model_user->insert_aksessub($data2);
          }
          $j++;
        }
        $cek_menu=$this->db->where('id_menu',$idmenu->idmenu)->where('id_level',$kode)->get('tab_akses_mainmenu')->num_rows();
        if ($cek_menu==1) {
          $this->model_user->update_aksesmenu($idmenu->idmenu,$kode,$data1);
        } else {
          $this->model_user->insert_aksesmenu($data1);
        }
        $i++;
      }
      redirect('user/level');
    }

    public function create_level()
    {
        if ($this->input->post()) {
          $this->save_level();
        } else {
          $data['halaman']=$this->load->view('user/create_level','',true);
          $this->load->view('beranda',$data);
        }
    }

    public function save_level(){
      $data = array(
                  'deskripsi' =>$this->input->post('deskripsi'),
                );
      $this->model_user->add_level($data);
      $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
      redirect('user/level');
    }

    public function edit_level($id)
    {
       if ($this->input->post()) {
        $this->update_level();
       }else{
         $data['data']=$this->model_user->find_level($id);
         if ($data==true) {
          $data['halaman']=$this->load->view('user/edit_level',$data,true);
          $this->load->view('beranda',$data);
         }else{
          show_404();
         }
     }
    }

    public function update_level(){
      $id=$this->input->post('kode');
      $data = array(
                  'deskripsi' =>$this->input->post('deskripsi'),
                );
      $this->model_user->update_level($id,$data);
      $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
      redirect('User/level');
  }

    public function add()
    {
        if ($this->input->post()) {
          $this->save();
        } else {
          $data['level']=$this->db->get('st_level_user')->result();
          $data['halaman']=$this->load->view('user/create',$data,true);
          $this->load->view('beranda',$data);
        }
    }

    public function save(){
      $data = array(
                  'nama' => $this->input->post('nama'),
                  'id_level' => $this->input->post('level'),
                  'username' => $this->input->post('username'),
                  'view_password' => $this->input->post('password'),
                  'status' => $this->input->post('status'),
                  'password' => md5($this->input->post('password'))
                );
      $this->model_user->add($data);
      $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
      redirect('User');
    }

  public function edit($id)
    {
       if ($this->input->post()) {
        $this->update();
       }else{
         $data['data']=$this->model_user->find($id);
         if ($data==true) {
          $data['level']=$this->db->get('st_level_user')->result();
          $data['level_set']=$this->db->where('kode',$data['data']->id_level)->get('st_level_user')->row();
          $data['halaman']=$this->load->view('user/update',$data,true);
          $this->load->view('beranda',$data);
         }else{
          show_404();
         }
     }
    }

    public function update(){
      $id=$this->input->post('id');
      $data = array(
                  'nama' => $this->input->post('nama'),
                  'id_level' => $this->input->post('level'),
                  'username' => $this->input->post('username'),
                  'status' => $this->input->post('status'),
                  'view_password' => $this->input->post('password'),
                  'password' => md5($this->input->post('password'))
                );
      $this->model_user->update($id,$data);
      $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
      redirect('User');
  }
  public function hapus(){
    if(!empty($_POST['cb_data'])){
      $jml=count($_POST['cb_data']);
      for($i=0;$i<$jml;$i++){
        $id=$_POST['cb_data'][$i];
        $this->model_user->delete($id);
      }
       $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
    }
    redirect('User','refresh');
  }

  public function hapus_level(){
    if(!empty($_POST['cb_data'])){
      $jml=count($_POST['cb_data']);
      for($i=0;$i<$jml;$i++){
        $id=$_POST['cb_data'][$i];
        $this->model_user->delete_level($id);
      }
       $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
    }
    redirect('User/level','refresh');
  }
}