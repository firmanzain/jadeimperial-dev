<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pinjaman extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_pinjaman');
	}
	
	  public function index()
	  {
	    $data['data']=$this->model_pinjaman->index();
	    $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JABATAN','DEPARTMEN','MANAGER','HRD','CABANG','JUMLAH Pinjaman','JUMLAH Cicilan','SISA Pinjaman','KETERANGAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        			'thead_open'=>'<thead>',
    				'thead_close'=> '</thead>',
    				'tbody_open'=> '<tbody>',
    				'tbody_close'=> '</tbody>',
    		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('pinjaman/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['manager']=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')->where('b.fungsionalitas','Kepala Department')->select('a.nik,a.nama_ktp')->get('tab_karyawan a')->result();
	      	$data['hrd']=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')->where('b.fungsionalitas','hrd')->select('a.nik,a.nama_ktp')->get('tab_karyawan a')->result();
	      	$data['halaman']=$this->load->view('pinjaman/create',$data,true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'hrd' =>$this->input->post('hrd'),
                  'manager' =>$this->input->post('manager'),
                  'jml_pinjam' =>str_replace('.', '', $this->input->post('jml_pinjam')),
                  'jml_cicilan' =>str_replace('.', '', $this->input->post('jml_cicilan')),
                  'tanggal_pinjam' =>$this->input->post('tanggal_pinjam'),
                  'sisa_pinjam' =>str_replace('.', '', $this->input->post('jml_pinjam')),
                  'sisa_temp' =>str_replace('.', '', $this->input->post('jml_temp')),
                  'keterangan' =>$this->input->post('keterangan'),
				  'entry_user' =>$this->session->userdata('username'),
                );
	    $this->model_pinjaman->add($data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('Pinjaman');
	  }

	public function ajax_cari(){
		$nik=$this->input->post('nik');
		$data=$this->db->join('tab_cabang a','a.id_cabang=b.cabang')
                     ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
                     ->join('tab_department d','d.id_department=b.department')
                     ->join('tab_kontrak_kerja f','f.nik=b.nik')
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
        $this->table->set_heading(array('NO','NIK','NAMA','JENIS KELAMIN','JABATAN','CABANG','AMBIL'));
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
                        		 ->get('tab_karyawan a')
                        		 ->result();
        $this->load->view('karyawan/popup_karyawan',$data);
    }

	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_pinjaman->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('Pinjaman','refresh');
	}

	public function pembayaran()
	{
	    $data['data']=$this->model_pinjaman->index2();
	    $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JABATAN','DEPARTMEN','MANAGER','HRD','CABANG','TANGGAL BAYAR','JUMLAH BAYAR','KETERANGAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
        			'thead_open'=>'<thead>',
    				'thead_close'=> '</thead>',
    				'tbody_open'=> '<tbody>',
    				'tbody_close'=> '</tbody>',
    		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('pinjaman/index2',$data,true);
		$this->load->view('beranda',$data);
	}

	  public function create2()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['manager']=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')->where('b.fungsionalitas','Kepala Department')->select('a.nik,a.nama_ktp')->get('tab_karyawan a')->result();
	      	$data['hrd']=$this->db->join('tab_jabatan b','b.id_jabatan=a.jabatan')->where('b.fungsionalitas','hrd')->select('a.nik,a.nama_ktp')->get('tab_karyawan a')->result();
	      	$data['halaman']=$this->load->view('pinjaman/create2',$data,true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save2(){
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'hrd' =>$this->input->post('hrd'),
                  'manager' =>$this->input->post('manager'),
                  'jml_bayar' =>str_replace('.', '', $this->input->post('jml_bayar')),
                  'tgl_bayar' =>$this->input->post('tgl_bayar'),
                  'keterangan' =>$this->input->post('keterangan'),
				  'entry_user' =>$this->session->userdata('username'),
                );
	    $this->model_pinjaman->add2($data);
	    $this->db->query('update tab_pinjaman set sisa_pinjam=sisa_pinjam-'.$data['jml_bayar'].',sisa_temp=sisa_temp-'.$data['jml_bayar']);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('Pinjaman');
	  }

	public function ajax_cari2(){
		$nik=$this->input->post('nik');
		$data=$this->db->join('tab_cabang a','a.id_cabang=b.cabang')
                     ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
                     ->join('tab_department d','d.id_department=b.department')
                     ->join('tab_kontrak_kerja f','f.nik=b.nik')
                     ->join('tab_pinjaman g','g.nik=b.nik')
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

	public function popup_karyawan2(){
        $this->table->set_heading(array('NO','NIK','NAMA','JENIS KELAMIN','JABATAN','CABANG','AMBIL'));
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
                     			 ->join('tab_pinjaman g','g.nik=b.nik')
                        		 ->get('tab_karyawan a')
                        		 ->result();
        $this->load->view('karyawan/popup_karyawan',$data);
    }

	public function hapus2(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_pinjaman->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('Pinjaman','refresh');
	}
}