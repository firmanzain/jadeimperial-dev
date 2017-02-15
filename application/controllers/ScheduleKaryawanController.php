<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ScheduleKaryawanController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_scheduleKaryawan');
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
	}
	
	  public function index()
	  {
	  	$data['error'] = $this->db->select('a.*, b.kode_jam as kode_jadwal')
	  							  ->from('tab_jadwal_karyawan a')
	  							  ->join('tab_jam_kerja b','b.kode_jam=a.kode_jam','left')
	  							  ->get();
        $data['data']=$this->model_scheduleKaryawan->index();
      	$this->table->set_heading(array('NO','NIK','NAMA','Jabatan','PLANT','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('schedule_karyawan/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function detail($nik)
	  {
		/*if ($this->input->post('bln',true)==NULL) {
			$bln = date('m');
			$thn = date('Y');
		} else {
			$bln=$this->input->post('bln',true);
			$thn=$this->input->post('tahun',true); 
		}
		$data['bln'] = $bln;
		$data['thn'] = $thn;*/
        if ($this->input->post('tgl1',true)==NULL) {
          $tgl1 = date('Y-m-01');
          $tgl2 = date('Y-m-t');
        } else {
          $tgl1 = $this->input->post('tgl1',true);
          $tgl2 = $this->input->post('tgl2',true); 
        }
        $data['tgl1'] = $tgl1;
        $data['tgl2'] = $tgl2;
        $data['data']=$this->model_scheduleKaryawan->detail($nik,$tgl1,$tgl2);
      	$data['karyawan']=$this->db->where('nik',$nik)->get('tab_karyawan')->row();
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','TANGGAL','KODE JAM','JAM MASUK 1','JAM KELUAR 1','JAM MASUK 2','JAM KELUAR 2','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('schedule_karyawan/detail',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['halaman']=$this->load->view('schedule_karyawan/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function show_tanggal()
	  {
	      $nik=$this->input->post('nik',true);
	      $bulan=$this->input->post('bulan',true);
	      $tahun=$this->input->post('tahun',true);
	      $kalender=CAL_GREGORIAN;
		  $x=cal_days_in_month($kalender, $bulan, $tahun);
	      $cek=$this->model_scheduleKaryawan->cek($nik,$bulan,$tahun);
	      $this->table->set_heading(array('NO','TANGGAL','KODE JAM'));
	      $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
		        			'thead_open'=>'<thead>',
	        				'thead_close'=> '</thead>',
	        				'tbody_open'=> '<tbody>',
	        				'tbody_close'=> '</tbody>',
	        		);
	      $this->table->set_template($tmp);
	      $tombol='<div class="form-group col-md-12">
						<button type="button" class="btn btn-primary" onclick="saveData()" id="simpan">Simpan</button>
						<button type="button" class="btn btn-warning" onclick="aksiClose()">Cancel</button>
						</div>';
		  $no=1;
		  $detail_nik=$this->db->where('nik',$nik)->get('tab_karyawan')->row();
		  $data['karyawan']="Buat Schedule Kerja Karyawan $detail_nik->nama_ktp";
		  $data['tombol']=$tombol;
		  $isi_kode=$this->db->get('tab_jam_kerja')->result();
		  foreach ($isi_kode as $rs_kode) {
				$array_op[]="<option>$rs_kode->kode_jam</option>";
		  }
     	  $option=str_replace(':', '', implode(':', $array_op))."</select>";
	      if ($cek==false) {
		      $this->table->set_template($tmp);
		      for ($i=1; $i <= $x ; $i++) { 
		      	$tgal=$i.'-'.$bulan.'-'.$tahun;
				$form_tgl=$this->format->tanggalIndo(date("Y-m-d",strtotime($tgal)));
				$kode='<select name="kd_jam['.$i.']" id="kd_jam['.$i.']" class="form-control">';
				$tgl="<input type='hidden' name='tanggal[$i]' value='".date('Y-m-d',strtotime($tgal))."'>";
				$txt_nik="<input type='hidden' name='nik[$i]' value='$nik'>";
				$this->table->add_row($no.$tgl.$txt_nik,$form_tgl,$kode.$option);
				$no++;
		      }
		      $data['tabel']=$this->table->generate();
	      } else {
		      	for ($i=1; $i <= $x ; $i++) { 
			      	$tgal=$i.'-'.$bulan.'-'.$tahun;
					$form_tgl=$this->format->tanggalIndo(date("Y-m-d",strtotime($tgal)));
					$jadwal=$this->db->where('nik',$nik)
									 ->where('tanggal',date("Y-m-d",strtotime($tgal)))
									 ->get('tab_jadwal_karyawan')
									 ->row();
					if (count($jadwal)>=1) {
						$kode='<select name="kd_jam['.$i.']" id="kd_jam['.$i.']" class="form-control"><option selected>'.$jadwal->kode_jam.'</option>';
					}else{
						$kode='<select name="kd_jam['.$i.']" id="kd_jam['.$i.']" class="form-control">';
					}
					$tgl="<input type='hidden' name='tanggal[$i]' value='".date('Y-m-d',strtotime($tgal))."'>";
					$txt_nik="<input type='hidden' name='nik[$i]' value='$nik'>";
					$this->table->add_row($no.$tgl.$txt_nik,$form_tgl,$kode.$option);
					$no++;
			    }
			    $data['tabel']=$this->table->generate();
	      }
	      echo json_encode($data);
	  }

	  public function save(){
	  	$jml_data=count($this->input->post('tanggal'));
	  	for ($i=1; $i <=$jml_data ; $i++) { 
	  		$data = array(
                  'nik' => $this->input->post('nik')[$i],
                  'kode_jam' =>$this->input->post('kd_jam')[$i],
				  'tanggal' =>$this->input->post('tanggal')[$i]
                );
		    $this->model_scheduleKaryawan->add($data);
        	$query = $this->db->query('select * from tab_jam_kerja where kode_jam="'.$data['kode_jam'].'"');
        	if ($query->result()<>false) {
        		foreach ($query->result() as $val) {
        			/*$jam_masuk1 	= $val->jam_start;
        			$jam_keluar1 	= $val->jam_finish;
        			$jam_masuk2 	= $val->jam_start2;
        			$jam_keluar2 	= $val->jam_finish2;*/
            		$jam_masuk1	 = "00:00:00";
            		$jam_keluar1 = "00:00:00";
            		$jam_masuk2	 = "00:00:00";
            		$jam_keluar2 = "00:00:00";
        			/*if ($val->jam_start!="00:00:00"&&$val->jam_start2!="00:00:00") {
        				$shift = 2;
        			} else {
        				$shift = 1;
        			}*/
        			if ($val->jam_start!="00:00:00"&&$val->jam_start2=="00:00:00") {
        				$tipe_shift = "Pagi";
						$status1 	 = "";
						$keterangan1 = "";
						$status2 	 = "";
						$keterangan2 = "";
						$statusk1 	 = "";
						$keterangank1 = "";
						$statusk2 	 = "";
						$keterangank2 = "";
        				$shift = 1;
        			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2!="00:00:00") {
						$tipe_shift = "Sore";
						$status1 	 = "";
						$keterangan1 = "";
						$status2 	 = "";
						$keterangan2 = "";
						$statusk1 	 = "";
						$keterangank1 = "";
						$statusk2 	 = "";
						$keterangank2 = "";
						$shift = 1;
        			} else if ($val->jam_start!="00:00:00"&&$val->jam_start2!="00:00:00") {
						$tipe_shift = "Pagi&Sore";
						$status1 	 = "";
						$keterangan1 = "";
						$status2 	 = "";
						$keterangan2 = "";
						$statusk1 	 = "";
						$keterangank1 = "";
						$statusk2 	 = "";
						$keterangank2 = "";
						$shift = 2;
        			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2=="00:00:00") {
						$tipe_shift  = "Libur";
						$status1 	 = "Libur";
						$keterangan1 = "Libur";
						$status2 	 = "Libur";
						$keterangan2 = "Libur";
						$statusk1 	 = "Libur";
						$keterangank1 = "Libur";
						$statusk2 	 = "Libur";
						$keterangank2 = "Libur";
						$shift = 0;
        			}
        		}
        	} else {
        		$jam_masuk1	 = "00:00:00";
        		$jam_keluar1 = "00:00:00";
        		$jam_masuk2	 = "00:00:00";
        		$jam_keluar2 = "00:00:00";
				$status1 	 = "";
				$keterangan1 = "";
				$status2 	 = "";
				$keterangan2 = "";
				$statusk1 	 = "";
				$keterangank1 = "";
				$statusk2 	 = "";
				$keterangank2 = "";
        		$shift 		 = 0;
        		$tipe_shift	 = "-";
        	}
        	$data2 =  array(
        		'nik' 			=> $data['nik'],
        		'kode_jam'		=> $data['kode_jam'],
        		'kode_shift'	=> $shift,
        		'tipe_shift'	=> $tipe_shift,
        		'tgl_kerja'		=> $data['tanggal'],
        		'jam_masuk1'	=> $jam_masuk1,
        		'jam_keluar1'	=> $jam_keluar1,
        		'status_masuk'		=> $status1,
        		'keterangan_masuk'	=> $keterangan1,
        		'status_keluar'		=> $statusk1,
        		'keterangan_keluar'	=> $keterangank1,
        		'jam_masuk2'	=> $jam_masuk2,
        		'jam_keluar2'	=> $jam_keluar2,
        		'status_masuk2'		=> $status2,
        		'keterangan_masuk2'	=> $keterangan2,
        		'status_keluar2'	=> $statusk2,
        		'keterangan_keluar2'=> $keterangank2,
	            'entry_user'    => $this->session->userdata('username'),
	            'entry_date'    => date('Y-m-d H:i:s')
        	);
        	$this->db->where('nik', $data2['nik']);
        	$this->db->where('tgl_kerja', $data2['tgl_kerja']);
        	$this->db->delete('tab_absensi');

        	$this->db->insert('tab_absensi', $data2);
	  	}
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> 
	    	<span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    echo 1;
	  }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_scheduleKaryawan->find($id);
	         $data['jam_kerja']=$this->db->get('tab_jam_kerja')->result();
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('schedule_karyawan/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'kode_jam' =>$this->input->post('kode_jam'),
				  'tanggal' =>$this->input->post('tanggal')
                );
	    $this->model_scheduleKaryawan->update($id,$data);
    	$query = $this->db->query('select * from tab_jam_kerja where kode_jam="'.$data['kode_jam'].'"');
    	if ($query->result()<>false) {
    		foreach ($query->result() as $val) {
    			/*$jam_masuk1 	= $val->jam_start;
    			$jam_keluar1 	= $val->jam_finish;
    			$jam_masuk2 	= $val->jam_start2;
    			$jam_keluar2 	= $val->jam_finish2;*/
        		$jam_masuk1	 = "00:00:00";
        		$jam_keluar1 = "00:00:00";
        		$jam_masuk2	 = "00:00:00";
        		$jam_keluar2 = "00:00:00";
    			/*if ($val->jam_start!="00:00:00"&&$val->jam_start2!="00:00:00") {
    				$shift = 2;
    			} else {
    				$shift = 1;
    			}*/
    			if ($val->jam_start!="00:00:00"&&$val->jam_start2=="00:00:00") {
    				$tipe_shift = "Pagi";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
    				$shift = 1;
    			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2!="00:00:00") {
					$tipe_shift = "Sore";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
					$shift = 1;
    			} else if ($val->jam_start!="00:00:00"&&$val->jam_start2!="00:00:00") {
					$tipe_shift = "Pagi&Sore";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
					$shift = 2;
    			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2=="00:00:00") {
					$tipe_shift  = "Libur";
					$status1 	 = "Libur";
					$keterangan1 = "Libur";
					$status2 	 = "Libur";
					$keterangan2 = "Libur";
					$statusk1 	 = "Libur";
					$keterangank1 = "Libur";
					$statusk2 	 = "Libur";
					$keterangank2 = "Libur";
					$shift = 0;
    			}
    		}
    	} else {
    		$jam_masuk1	 = "00:00:00";
    		$jam_keluar1 = "00:00:00";
    		$jam_masuk2	 = "00:00:00";
    		$jam_keluar2 = "00:00:00";
			$status1 	 = "";
			$keterangan1 = "";
			$status2 	 = "";
			$keterangan2 = "";
			$statusk1 	 = "";
			$keterangank1 = "";
			$statusk2 	 = "";
			$keterangank2 = "";
    		$shift 		 = 0;
    		$tipe_shift	 = "-";
    	}
    	$data2 =  array(
    		'nik' 			=> $data['nik'],
    		'kode_jam'		=> $data['kode_jam'],
    		'kode_shift'	=> $shift,
    		'tipe_shift'	=> $tipe_shift,
    		'tgl_kerja'		=> date('Y-m-d', strtotime($tgl_param)),
    		/*'jam_masuk1'	=> $jam_masuk1,
    		'jam_keluar1'	=> $jam_keluar1,
    		'status_masuk'		=> $status1,
    		'keterangan_masuk'	=> $keterangan1,
    		'status_keluar'		=> $statusk1,
    		'keterangan_keluar'	=> $keterangank1,
    		'jam_masuk2'	=> $jam_masuk2,
    		'jam_keluar2'	=> $jam_keluar2,
    		'status_masuk2'		=> $status2,
    		'keterangan_masuk2'	=> $keterangan2,
    		'status_keluar2'	=> $statusk2,
    		'keterangan_keluar2'=> $keterangank2,*/
            'entry_user'    => $this->session->userdata('username'),
            'entry_date'    => date('Y-m-d H:i:s')
    	);
    	$this->db->where('nik', $data2['nik']);
    	$this->db->where('tgl_kerja', $data2['tgl_kerja']);
    	$this->db->update('tab_absensi', $data2);

	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    echo 1;
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_scheduleKaryawan->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('shedule-karyawan','refresh');
	}

	public function import_data()
	  {
	      if ($this->input->post()) {
	      	$this->go_import();
	      } else {
	      	$this->load->view('import/import_jadwal_karyawan');
	  	  }
	  }

	public function go_import()
    {
    	/*$config['upload_path'] = './temp_upload/';
  		$config['allowed_types'] = 'xls|xlsx|csv';
         
        $this->load->library('upload');
        $this->upload->initialize($config);

  		if ( ! $this->upload->do_upload('datague')) {
            // jika validasi file gagal, kirim parameter error ke index
            $error = $this->upload->display_errors();
            print $error;
        } else {
  		$upload_data = $this->upload->data();
      // load library Excell_Reader
      	$this->load->library('excel/Excel_reader');
      //tentukan file
      	$this->excel_reader->setOutputEncoding('230787');
      	$file = $upload_data['full_path'];
      	$this->excel_reader->read($file);
      	error_reporting(E_ALL ^ E_NOTICE);
      // array data
      	$data = $this->excel_reader->sheets[0];
      	$dataexcel = Array();
      	$isi=array();
      	$kalender=CAL_GREGORIAN;
      	$bln=$this->input->post('bulan');
		$bulan = date('m',strtotime($bln));
		$tahun= date('Y');
		$awal=date('Y-m-01', strtotime($bln));
		//echo $bulan;
		$jml_hari=cal_days_in_month($kalender, $bulan, $tahun)+2;
		$gagal=0;$sukses=0;
      	for ($i = 1; $i <= $data['numRows']; $i++) {
                   if ($data['cells'][$i][1] == '')
                       break;
                   $dataexcel[$i - 1]['nik'] = $data['cells'][$i][1];
                   for ($x=2; $x <= $jml_hari ; $x++) { 
                   		$isi[$i - 1]['kode_jam'] = $data['cells'][$i][$x];
                   		$y=$x-2;
                   		$masuk=array(
                   					"nik" => $data['cells'][$i][1],
                   					"kode_jam" => $data['cells'][$i][$x],
                   					"tanggal"	=> date('Y-m-d', strtotime('+'.$y.' days', strtotime($awal))),
                   				);
                   		$cek_jadwal=$this->db->where('kode_jam',$data['cells'][$i][$x])->get('tab_jam_kerja')
		                              		 ->num_rows();
		                $cek_karyawan=$this->db->where('nik',$data['cells'][$i][1])->get('tab_karyawan')
		                              		   ->num_rows();
		                if ($cek_jadwal>=1 and $cek_karyawan>=1) {
	                   		//$this->db->insert('tab_jadwal_karyawan',$masuk);
	                   		$sukses++;
		                } else {
		                	$gagal++;
		                	$data_gagal[]=implode(' ', $masuk);
		                }
        			}

              }
        $miss_data=implode('<br>', $data_gagal);
        $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Jumlah Data Tersimpan : $sukses<br>Data Gagal Tersimpan : $gagal </div>");
	   	$file = $upload_data['file_name'];
        $path = './temp_upload/'.$file;
        unlink($path);
	   	echo "<script>window.opener.location.reload();window.close()</script>";
	   }*/
	   
//        set_time_limit(0);
	ini_set('memory_limit', '-1');

		$config['upload_path']   = './temp_upload/';
		$config['allowed_types'] = 'xls|xlsx|csv';

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file'))
		{
			$error = array('error' => $this->upload->display_errors());
			print_r($error);

		}
		else
		{
            $file = $this->upload->data();
            $name = $file["file_name"];
		}

		//Mencari Jml Hari
		$tgl 	= date('d');
	  	$bln 	= $this->input->post('bulan');
	  	$thn 	= date('Y');
	  	$hari_ini 	= $thn.'-'.$bln.'-'.$tgl;
		$tgl_awal 	= date('Y-m-01', strtotime($hari_ini));
		$tgl_akhir	= date('Y-m-t', strtotime($hari_ini));
		$jml_tgl 	= date('d', strtotime($tgl_awal));
		$jml_tgl2 	= date('d', strtotime($tgl_akhir));

		//EXCEL
		$inputFileName = './temp_upload/'.$name;

		$inputFileType = IOFactory::identify($inputFileName);
		$objReader = IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($inputFileName);

		$sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for ($row=2; $row <= ($highestRow-1) ; $row++) {
        	$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

        	for ($i = 1; $i <= $jml_tgl2 ; $i++) {
        	if ($rowData[0][($i+1)]!=NULL||$rowData[0][($i+1)]!="") {
        		$tgl_param = $thn.'-'.$bln.'-'.$i;
	        	$data = array(
	        		'nik' 			=> $rowData[0][1],
	        		'kode_jam'		=> $rowData[0][($i+1)],
	        		'tanggal'		=> date('Y-m-d', strtotime($tgl_param)),
	        		'entry_date'	=> date('Y-m-d H:i:s')
	        	);
            	$this->db->where('nik', $data['nik']);
            	$this->db->where('tanggal', $data['tanggal']);
            	$this->db->delete('tab_jadwal_karyawan');

            	$this->db->insert('tab_jadwal_karyawan', $data);
            	$query = $this->db->query('select * from tab_jam_kerja where kode_jam="'.$data['kode_jam'].'"');
            	if ($query->result()<>false) {
            		foreach ($query->result() as $val) {
            			/*$jam_masuk1 	= $val->jam_start;
            			$jam_keluar1 	= $val->jam_finish;
            			$jam_masuk2 	= $val->jam_start2;
            			$jam_keluar2 	= $val->jam_finish2;*/
	            		$jam_masuk1	 = "00:00:00";
	            		$jam_keluar1 = "00:00:00";
	            		$jam_masuk2	 = "00:00:00";
	            		$jam_keluar2 = "00:00:00";
            			/*if ($val->jam_start!="00:00:00"&&$val->jam_start2!="00:00:00") {
            				$shift = 2;
            			} else {
            				$shift = 1;
            			}*/
            			if ($val->jam_start!="00:00:00"&&$val->jam_start2=="00:00:00") {
            				$tipe_shift = "Pagi";
							$status1 	 = "";
							$keterangan1 = "";
							$status2 	 = "";
							$keterangan2 = "";
							$statusk1 	 = "";
							$keterangank1 = "";
							$statusk2 	 = "";
							$keterangank2 = "";
            				$shift = 1;
            			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2!="00:00:00") {
							$tipe_shift = "Sore";
							$status1 	 = "";
							$keterangan1 = "";
							$status2 	 = "";
							$keterangan2 = "";
							$statusk1 	 = "";
							$keterangank1 = "";
							$statusk2 	 = "";
							$keterangank2 = "";
							$shift = 1;
            			} else if ($val->jam_start!="00:00:00"&&$val->jam_start2!="00:00:00") {
							$tipe_shift = "Pagi&Sore";
							$status1 	 = "";
							$keterangan1 = "";
							$status2 	 = "";
							$keterangan2 = "";
							$statusk1 	 = "";
							$keterangank1 = "";
							$statusk2 	 = "";
							$keterangank2 = "";
							$shift = 2;
            			} else if ($val->jam_start=="00:00:00"&&$val->jam_start2=="00:00:00") {
							$tipe_shift  = "Libur";
							$status1 	 = "Libur";
							$keterangan1 = "Libur";
							$status2 	 = "Libur";
							$keterangan2 = "Libur";
							$statusk1 	 = "Libur";
							$keterangank1 = "Libur";
							$statusk2 	 = "Libur";
							$keterangank2 = "Libur";
							$shift = 0;
            			}
            		}
            	} else {
            		$jam_masuk1	 = "00:00:00";
            		$jam_keluar1 = "00:00:00";
            		$jam_masuk2	 = "00:00:00";
            		$jam_keluar2 = "00:00:00";
					$status1 	 = "";
					$keterangan1 = "";
					$status2 	 = "";
					$keterangan2 = "";
					$statusk1 	 = "";
					$keterangank1 = "";
					$statusk2 	 = "";
					$keterangank2 = "";
            		$shift 		 = 0;
            		$tipe_shift	 = "-";
            	}
            	$data2 =  array(
            		'nik' 			=> $data['nik'],
            		'kode_jam'		=> $data['kode_jam'],
            		'kode_shift'	=> $shift,
            		'tipe_shift'	=> $tipe_shift,
            		'tgl_kerja'		=> date('Y-m-d', strtotime($tgl_param)),
            		'jam_masuk1'	=> $jam_masuk1,
            		'jam_keluar1'	=> $jam_keluar1,
            		'status_masuk'		=> $status1,
            		'keterangan_masuk'	=> $keterangan1,
            		'status_keluar'		=> $statusk1,
            		'keterangan_keluar'	=> $keterangank1,
            		'jam_masuk2'	=> $jam_masuk2,
            		'jam_keluar2'	=> $jam_keluar2,
            		'status_masuk2'		=> $status2,
            		'keterangan_masuk2'	=> $keterangan2,
            		'status_keluar2'	=> $statusk2,
            		'keterangan_keluar2'=> $keterangank2,
		            'entry_user'    => $this->session->userdata('username'),
		            'entry_date'    => date('Y-m-d H:i:s')
            	);
            	$this->db->where('nik', $data2['nik']);
            	$this->db->where('tgl_kerja', $data2['tgl_kerja']);
            	$this->db->delete('tab_absensi');

            	$this->db->insert('tab_absensi', $data2);
        	}
        	} 
        }
        delete_files($file['file_path']);
        echo "<script>window.opener.location.reload();window.close()</script>";
    }
}