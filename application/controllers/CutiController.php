<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CutiController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_cuti');
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
	      $data['data']=$this->model_cuti->index($tgl1,$tgl2);
	      //$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NAMA','TANGGAL CUTI','LAMA','CUTI KHUSUS','KETERANGAN','HRD','KEPALA DEPARTMENT','MANAGER','TINDAKAN'));
	      $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NAMA','TANGGAL CUTI','LAMA','CUTI KHUSUS','KETERANGAN','HRD','KEPALA DEPARTMENT','MANAGER'));
	        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
	        $this->table->set_template($tmp);
			$data['halaman']=$this->load->view('cuti/index',$data,true);
			$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['halaman']=$this->load->view('cuti/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$jenis_cuti	 = $this->input->post('cuti');
	  	$cuti_khusus = $this->input->post('cuti_khusus');
	  	$lama 		 = $this->selisih_hari($this->input->post('tanggal2'),$this->input->post('tanggal1'))+1;
	  	$tgl1 = date("Y-m-01",strtotime(date("Y-m-d")));
	  	//$tgl1 	= date("2016-05-07");
		$nik 	= $this->input->post('nik');
		$potong_cuti = 0;
	  	if ($jenis_cuti!='Ya') {
	  		$potong_cuti = $lama;
	  			/*$check = $this->db->query('select * from tab_master_dp where nik="'.$nik.'"');
	  			if ($check->result()<>false) {
		  			foreach ($check->result() as $val) {
			  			$cuti_new	= $val->saldo_cuti-$lama;
		  			}
					$this->db->query(
						'
						update tab_master_dp set saldo_cuti='.$cuti_new.'
						where bulan="'.date("m",strtotime($tgl1)).'" and 
						tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
						'
					);
	  			}*/
	  		/*$this->db->query(
	  			'
	  			update tab_master_dp set saldo_cuti=saldo_cuti - '.$lama.' 
	  			where bulan="'.date("m",strtotime($tgl1)).'" and 
				tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'" 
	  		');*/
	  	} else {
	  		/*$jatah_cuti=$this->db->where('id',$cuti_khusus)->select('maximal_lama')->get('tab_cuti_khusus')->row();
	  		if ($jatah_cuti->maximal_lama<$lama) {
	  			$sisa_jatah=$jatah_cuti->maximal_lama-$lama;
	  			$potong_cuti=$sisa_jatah;
	  		} else {
	  			$sisa_jatah="0";
	  			$potong_cuti=$sisa_jatah;
	  		}
	  		$this->db->query("update tab_master_dp set saldo_cuti=saldo_cuti - ".abs($sisa_jatah)." where nik='".$nik."' and bulan='".$tgl."'");*/
	  	}
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'manager' =>$this->input->post('manager'),
                  'hrd' => $this->input->post('hrd'),
                  'kepala_department' => $this->input->post('kabag'),
                  'tanggal_mulai' =>$this->input->post('tanggal1'),
				  'tanggal_finish' =>$this->input->post('tanggal2'),
				  'cuti_khusus' =>$this->input->post('cuti'),
				  'keterangan' =>$this->input->post('keterangan'),
				  'potongan_cuti' =>$potong_cuti,
				  'detail_cuti' =>$this->input->post('cuti_khusus'),
				  'lama_cuti' =>$this->selisih_hari($this->input->post('tanggal2'),$this->input->post('tanggal1'))+1
                );
	    $this->model_cuti->add($data);

    	$data_new = array(
    		'status_masuk'		=> "Cuti",
    		'keterangan_masuk'	=> $data['keterangan'],
    		'status_keluar'		=> "Cuti",
    		'keterangan_keluar'	=> $data['keterangan'],
    		'status_masuk2'			=> "Cuti",
    		'keterangan_masuk2'		=> $data['keterangan'],
    		'status_keluar2'		=> "Cuti",
    		'keterangan_keluar2'	=> $data['keterangan'],
            'entry_user'    => $this->session->userdata('username'),
            'entry_date'    => date('Y-m-d H:i:s')
    	);
		$this->db->where('tgl_kerja >=', date("Y-m-d",strtotime($data['tanggal_mulai'])));
		$this->db->where('tgl_kerja <=', date("Y-m-d",strtotime($data['tanggal_finish'])));
		$this->db->where('tipe_shift !=', 'Libur');
		$this->db->where('nik', $data['nik']);
		$this->db->update('tab_absensi', $data_new);

		print_r($this->db->last_query());

	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('cuti');
	  }

	public function selisih_hari($h1,$h2)
	{
		$s1=((abs(strtotime ($h2) - strtotime ($h1))/(60*60*24)));
		return $s1;
	}

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_cuti->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('cuti/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$tgl1=date("Y-m-01",strtotime(date("Y-m-d")));
	  	//$tgl1 	= date("2016-05-07");
	  	$lama=$this->selisih_hari($this->input->post('tanggal2'),$this->input->post('tanggal1'))+1;
		$nik=$this->input->post('nik');
	  	$data_potongan=$this->input->post('potongan_lama');
	  	if ($jenis_cuti!='Ya') {
	  		if($data_potongan != $lama){
	  			/*$this->db->query("update tab_master_dp set saldo_cuti=saldo_cuti - ".$lama." where nik='".$nik."' and bulan='".$tgl."'");
	  			$potong_cuti=$lama;*/
	  			$check = $this->db->query('select * from tab_master_dp where nik="'.$nik.'"');
	  			if ($check->result()<>false) {
		  			foreach ($check->result() as $val) {
			  			$cuti_new	= $val->saldo_cuti+$data_potongan-$lama;
		  			}
					$this->db->query(
						'
						update tab_master_dp set saldo_cuti='.$cuti_new.'
						where bulan="'.date("m",strtotime($tgl1)).'" and 
						tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
						'
					);
	  			}
	  		} else {
	  			$check = $this->db->query('select * from tab_master_dp where nik="'.$nik.'"');
	  			if ($check->result()<>false) {
		  			foreach ($check->result() as $val) {
			  			$cuti_new	= $val->saldo_cuti+$data_potongan-$lama;
		  			}
					$this->db->query(
						'
						update tab_master_dp set saldo_cuti='.$cuti_new.'
						where bulan="'.date("m",strtotime($tgl1)).'" and 
						tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
						'
					);
	  			}
	  			//$potong_cuti=$data_potongan;
	  		}
	  	} else {
	  		/*if($data_potongan != $lama){
		  		$jatah_cuti=$this->db->where('id',$cuti_khusus)->select('maximal_lama')->get('tab_cuti_khusus')->row();
		  		if ($jatah_cuti->maximal_lama<$lama) {
		  			$sisa_jatah=$jatah_cuti->maximal_lama-$lama;
		  			$potong_cuti=$sisa_jatah;
		  		} else {
		  			$sisa_jatah="0";
		  			$potong_cuti=$sisa_jatah;
		  		}
		  		$sisa_jatah=$jatah_cuti->maximal_lama-$lama;
		  		$this->db->query("update tab_master_dp set saldo_cuti=saldo_cuti - ".abs($sisa_jatah)." where nik='".$nik."' and bulan='".$tgl."'");
		  		$potong_cuti=$sisa_jatah;
		  	} else {
	  			$potong_cuti=$data_potongan;
		  	}*/
	  	}
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'manager' =>$this->input->post('manager'),
                  'hrd' => $this->input->post('hrd'),
                  'kepala_department' => $this->input->post('kabag'),
                  'tanggal_mulai' =>$this->input->post('tanggal1'),
				  'tanggal_finish' =>$this->input->post('tanggal2'),
				  'cuti_khusus' =>$this->input->post('cuti'),
				  'detail_cuti' =>$this->input->post('cuti_khusus'),
				  'keterangan' =>$this->input->post('keterangan'),
				  'potongan_cuti' =>$potong_cuti,
				  'lama_cuti' =>$this->selisih_hari($this->input->post('tanggal2'),$this->input->post('tanggal1'))+1
                );
	    $this->model_cuti->update($id,$data);

    	$data_new = array(
    		'status_masuk'		=> "Cuti",
    		'keterangan_masuk'	=> $data['keterangan'],
    		'status_keluar'		=> "Cuti",
    		'keterangan_keluar'	=> $data['keterangan'],
    		'status_masuk2'			=> "Cuti",
    		'keterangan_masuk2'		=> $data['keterangan'],
    		'status_keluar2'		=> "Cuti",
    		'keterangan_keluar2'	=> $data['keterangan'],
            'entry_user'    => $this->session->userdata('username'),
            'entry_date'    => date('Y-m-d H:i:s')
    	);
		$this->db->where('tgl_kerja >=', date("Y-m-d",strtotime($data['tanggal_mulai'])));
		$this->db->where('tgl_kerja <=', date("Y-m-d",strtotime($data['tanggal_finish'])));
		$this->db->where('tipe_shift !=', 'Libur');
		$this->db->update('tab_absensi', $data_new);
		
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('cuti');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
                $query = $this->db->query('select * from tab_cuti where id='.$id);
                
                foreach ($query->result() as $row) {
                    $nik = $row->nik;
                    $tgl_mulai  = $row->tanggal_mulai;
                    $tgl_finish = $row->tanggal_finish;
                }
                echo $nik;
                $data_absensi = array(
                    'jam_masuk1' => "00:00:00",
                    'jam_keluar1' => "00:00:00",
                    'status_masuk' => "",
                    'keterangan_masuk' => "",
                    'status_keluar' => "",
                    'keterangan_keluar' => "",
                    'jam_masuk2' => "00:00:00",
                    'jam_keluar2' => "00:00:00",
                    'status_masuk2' => "",
                    'keterangan_masuk2' => "",
                    'status_keluar2' => "",
                    'keterangan_keluar2' => ""
                );
                $this->db->where('nik',$nik);
                $this->db->where('tgl_kerja >=',date('Y-m-d',strtotime($tgl_mulai)));
                $this->db->where('tgl_kerja <=',date('Y-m-d',strtotime($tgl_finish)));
                $this->db->update('tab_absensi',$data_absensi);
				$this->model_cuti->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('cuti','refresh');
	}
}