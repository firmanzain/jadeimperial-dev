<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class EkstraController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_ekstra');
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
        $data['data']=$this->model_ekstra->index($tgl1,$tgl2);
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','TANGGAL EKSTRA','JAM EKSTRA','LAMA','VAKASI','JUMLAH','KETERANGAN','APPROVEMENT','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('extra/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['halaman']=$this->load->view('extra/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$jenis 	= $this->input->post('jenis_ekstra');
	  	$tgl1 	= $this->input->post('tanggal_ekstra');
	  	if ($jenis==1) {
	  		//$lama = $this->selisih_hari($this->input->post('jam2'),$this->input->post('jam1'));
	  		$new_bln = date('Y-m-d');
	  		$begin_day_unix   = strtotime($new_bln.' 00:00:00');
	  		$time1 = strtotime($this->input->post('jam1'));
	  		$time2 = strtotime($this->input->post('jam2'));
	  		$lama = date('H:i:s', ($time2 - ($time1 - $begin_day_unix)));
		  	$vee = $this->input->post('vakasi');
		  	if ($vee=="Tambah DP Libur") {
		  		$nik = $this->input->post('nik');
		  		$dp = $lama/8;
		  		$vakasi = round($dp,2,PHP_ROUND_HALF_UP);
		  		/*if ($lama>=1) {
		  			$check = $this->db->query('select * from tab_master_dp where nik="'.$this->input->post('nik').'"');
		  			if ($check->result()<>false) {
			  			foreach ($check->result() as $val) {
				  			$dp_new	= floatval($val->saldo_dp)+$vakasi;
			  			}
						$this->db->query(
							'
							update tab_master_dp set saldo_dp='.$dp_new.'
							where bulan="'.date("m",strtotime($tgl1)).'" and 
							tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
							'
						);
		  			}
		  		}*/
		  	} else {
		  		$vakasi=str_replace('.','',$this->input->post('upah'))*$lama;
		  	}
		  	$data = array(
	            'nik' => $this->input->post('nik'),
	            'hrd' => $this->input->post('hrd'),
	            'jam_mulai' =>$this->input->post('jam1'),
	            'jam_finish' =>$this->input->post('jam2'),
	            'kepala_department' => $this->input->post('kepala_department'),
	            'jenis_ekstra' => $this->input->post('jenis_ekstra'),
              	'keterangan' =>$this->input->post('keterangan'),
			  	'vakasi' =>$this->input->post('vakasi'),
			  	'tanggal_ekstra' => $this->input->post('tanggal_ekstra'),
			  	'entry_user' =>$this->session->userdata('username'),
			  	'jumlah_vakasi' =>$vakasi,
			  	'lama_jam' => $lama
	        );
	  	} else {
	  		$data = array(
	                  'nik' => $this->input->post('nik'),
	                  'hrd' => $this->input->post('hrd'),
	                  'kepala_department' => $this->input->post('kepala_department'),
	                  'jenis_ekstra' => $this->input->post('jenis_ekstra'),
	                  'jam_mulai' =>$this->input->post('jam1'),
					  'jam_finish' =>$this->input->post('jam2'),
					  'keterangan' =>$this->input->post('keterangan'),
					  'entry_user' =>$this->session->userdata('username'),
					  'vakasi' =>'Ekstra Lain',
					  'jumlah_vakasi' =>str_replace('.', '', $this->input->post('nominal_ekstra')),
					  'tanggal_ekstra' => $this->input->post('tanggal_ekstra'),
					  'lama_jam' => 0
	                );
	  	}
	    if ($data['lama_jam']>=0) {
	    	$this->model_ekstra->add($data);
	    	$this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    }else{
	    	$this->session->set_flashdata("pesan", "<div class=\"alert alert-warning\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Jam Ekstra Kurang Dari 1 Jam, Jam Ekstra Tidak Dapat Diproses</div>");
	    }
	    redirect('ekstra');
	  }

	public function selisih_hari($h1,$h2)
	{
		$s1=(strtotime($h1)-strtotime($h2))/3600;
		return $s1;
	}

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_ekstra->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('extra/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$jenis=$this->input->post('jenis_ekstra2');
	  	if ($jenis==1) {
	  		//$lama=$this->selisih_hari($this->input->post('jam2'),$this->input->post('jam1'));
	  		$new_bln = date('Y-m-d');
	  		$begin_day_unix   = strtotime($new_bln.' 00:00:00');
	  		$time1 = strtotime($this->input->post('jam1'));
	  		$time2 = strtotime($this->input->post('jam2'));
	  		$lama = date('H:i:s', ($time2 - ($time1 - $begin_day_unix)));
		  	$vee=$this->input->post('vakasi');
		  	if ($vee=="Tambah DP Libur") {
		  		$lama_2=$this->input->post('lama');
		  		if ($lama != $lama_2) {
			  		$nik=$this->input->post('nik');
			  		$dp=$lama/8;
			  		$vakasi=round($dp,2,PHP_ROUND_HALF_UP);
		  		} else {
			  		$dp2=$lama_2/8;
			  		$vakasi=round($dp2,2,PHP_ROUND_HALF_UP);
		  		}
		  	} else {
		  		$vakasi=str_replace('.','',$this->input->post('upah'))*$lama;
		  	}
		  	$data = array(
	                  'nik' => $this->input->post('nik'),
	                  'hrd' =>$this->input->post('hrd'),
					  'tanggal_ekstra' => $this->input->post('tanggal_ekstra'),
	                  'kepala_department' => $this->input->post('kepala_department'),
	                  'jenis_ekstra' => $this->input->post('jenis_ekstra2'),
	                  'jam_mulai' =>$this->input->post('jam1'),
					  'jam_finish' =>$this->input->post('jam2'),
					  'entry_user' =>$this->session->userdata('username'),
					  'keterangan' =>$this->input->post('keterangan'),
					  'jumlah_vakasi' =>$vakasi,
					  'vakasi' => $this->input->post('vakasi'),
					  'lama_jam' =>$lama
	                );
	  	}else{
	  		$data = array(
	                  'nik' => $this->input->post('nik'),
	                  'hrd' => $this->input->post('hrd'),
	                  'kepala_department' => $this->input->post('kepala_department'),
	                  'jam_mulai' =>$this->input->post('jam1'),
					  'jam_finish' =>$this->input->post('jam2'),
					  'keterangan' =>$this->input->post('keterangan'),
					  'entry_user' =>$this->session->userdata('username'),
					  'vakasi' =>'Ekstra Lain',
					  'jumlah_vakasi' =>str_replace('.', '', $this->input->post('nominal')),
					  'tanggal_ekstra' => $this->input->post('tanggal_ekstra'),
					  'lama_jam' => 0
	                );
	  	}
	    $this->model_ekstra->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('ekstra');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_ekstra->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('ekstra','refresh');
	}
}