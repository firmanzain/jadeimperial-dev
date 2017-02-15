<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CasualEkstra extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_casualEkstra');
	}
	
	  public function index()
	  {
        if ($this->input->post('tgl1',true)==NULL) {
          $tgl1 = date('Y-m-01');
          $tgl2 = date('Y-m-t');
        } else {
          $tgl1 = $this->input->post('tgl1',true);
          $tgl2 = $this->input->post('tgl2',true); 
        }
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;
	    $data['data']=$this->model_casualEkstra->index($tgl1,$tgl2);
	    $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JABATAN','DEPARTMEN','KEPALA DEPARTMEN','HRD','PLANT','TANGGAL EKSTRA','JUMLAH JAM/HARI','JUMLAH UPAH','APPROVEMENT','KETERANGAN','KETERANGAN EKSTRA'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        			'thead_open'=>'<thead>',
    				'thead_close'=> '</thead>',
    				'tbody_open'=> '<tbody>',
    				'tbody_close'=> '</tbody>',
    		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('casual/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['hrd']=$this->db->select('nik,nama_ktp')->get('tab_karyawan')->result();
	      	$data['halaman']=$this->load->view('casual/create',$data,true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$gaji=$this->db->where('nik',$this->input->post('nik'))->get('tab_kontrak_kerja')->row();
	  	if ($this->input->post('jns_ekstra')==1) {
	  		$total=$gaji->gaji_casual*($this->input->post('jml')/8);
	  	} else if ($this->input->post('jns_ekstra')==2) {
	  		$total=$gaji->gaji_casual*$this->input->post('jml');
	  	}
	  	
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'jns_ekstra' => $this->input->post('jns_ekstra'),
                  'lama' =>$this->input->post('jml'),
                  'kepala_department' =>$this->input->post('kepala_department'),
                  'keterangan_ekstra' =>$this->input->post('keterangan'),
                  'hrd' =>$this->input->post('hrd'),
                  'total' => $total,
                  'approved' => 0,
                  'keterangan' => $this->input->post('keterangan'),
				  'entry_user' =>$this->session->userdata('username'),
				  'tgl_ekstra' => $this->input->post('tgl_ekstra')
                );
	    $this->model_casualEkstra->add($data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('CasualEkstra');
	  }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
	      	$data['hrd']=$this->db->select('nik,nama_ktp')->get('tab_karyawan')->result();
		    $data['data']=$this->model_casualEkstra->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('casual/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }
	public function ajax_cari(){
		$nik=$this->input->post('nik');
		$data=$this->db->join('tab_cabang a','a.id_cabang=b.cabang')
                     ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
                     ->join('tab_department d','d.id_department=b.department')
                     ->join('tab_kontrak_kerja f','f.nik=b.nik')
                     ->like('f.status_kerja','Casual')
                     ->where('b.nik',$nik)
                     ->get('tab_karyawan b')
                     ->row();
		$num_data=count($data);
		if ($num_data>=1) {
			echo json_encode($data);
		} else {
			echo "kosong";
		}
	}

	public function popup_karyawan(){
        $this->table->set_heading(array('NO','NIK','NAMA','JENIS KELAMIN','JABATAN','PLANT','AMBIL'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                	);
        $this->table->set_template($tmp);
        $data['data'] = $this->db->join('tab_kontrak_kerja b','b.nik=a.nik')
        						 ->join('tab_jabatan c','c.id_jabatan=a.jabatan')
                        		 ->join('tab_cabang d','d.id_cabang=a.cabang')
                        		 ->join('tab_department e','e.id_department=a.department')
                        		 ->like('b.status_kerja','Casual')
                        		 ->get('tab_karyawan a')
                        		 ->result();
        $this->load->view('karyawan/popup_karyawan',$data);
    }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$gaji=$this->db->where('nik',$this->input->post('nik'))->get('tab_kontrak_kerja')->row();
	  	$total=$gaji->gaji_casual*$this->input->post('jml');
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'lama' =>$this->input->post('jml'),
                  'kepala_department' =>$this->input->post('kepala_department'),
                  'hrd' =>$this->input->post('hrd'),
                  'total' => $total,
				  'entry_user' =>$this->session->userdata('username'),
                );
	    $this->model_casualEkstra->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('CasualEkstra');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_casualEkstra->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('CasualEkstra','refresh');
	}
}