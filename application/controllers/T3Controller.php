<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class T3Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_t3');
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		$this->load->library('mpdf');
	}
	
	  public function index()
	  {
        $data['data']=$this->model_t3->index();
      	$this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NAMA','JABATAN','PLANT','TARIF'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        			);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('t3/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function approvement()
	  {
		$tgl 	= date('d');
	    if ($this->input->post('bln',true)==NULL) {
	      $bln = date('m');
	      $thn = date('Y');
	    } else {
	      $bln=$this->input->post('bln',true);
	      $thn=$this->input->post('tahun',true); 
	    }
	    $data['bln'] = $bln;
	    $data['thn'] = $thn;

	  	$hari_ini = $thn.'-'.($bln-1).'-'.$tgl;
		$tgl_awal 	= date('Y-m-01', strtotime($hari_ini));
		$tgl_akhir	= date('Y-m-t', strtotime($hari_ini));

	  	$hari_ini2 = $thn.'-'.$bln.'-'.$tgl;
		$tgl_awal2 	= date('Y-m-01', strtotime($hari_ini2));
		$tgl_akhir2	= date('Y-m-t', strtotime($hari_ini2));

        $data['data']=$this->model_t3->show($tgl_awal2,$tgl_akhir2);
        // print_r($this->db->last_query());
      	$this->table->set_heading(array('NO','NAMA','JABATAN','PLANT','TARIF','JUMLAH HADIR','TOTAL','TOTAL DITERIMA','APPROVEMENT','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        			);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('Aproval/slip_t3',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function show()
	  {
		$tgl 	= date('d');
	    if ($this->input->post('bln',true)==NULL) {
	      $bln = date('m');
	      $thn = date('Y');
	    } else {
	      $bln=$this->input->post('bln',true);
	      $thn=$this->input->post('tahun',true); 
	    }
	    $data['bln'] = $bln;
	    $data['thn'] = $thn;

	  	$hari_ini = $thn.'-'.($bln-1).'-'.$tgl;
		$tgl_awal 	= date('Y-m-01', strtotime($hari_ini));
		$tgl_akhir	= date('Y-m-t', strtotime($hari_ini));

	  	$hari_ini2 = $thn.'-'.$bln.'-'.$tgl;
		$tgl_awal2 	= date('Y-m-01', strtotime($hari_ini2));
		$tgl_akhir2	= date('Y-m-t', strtotime($hari_ini2));

        $data['data']=$this->model_t3->show($tgl_awal2,$tgl_akhir2);
        //print_r($this->db->last_query());
      	$this->table->set_heading(array('NO','BULAN','NIK','NAMA','JABATAN','PLANT','TARIF','JUMLAH HADIR','JUMLAH T3','JUMLAH DITERIMA','APPROVEMENT','KETERANGAN','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        			);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('t3/show',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function show2()
	  {
	  	$tgl 	= date('d');
	  	$bln 	= date('m');
	  	$thn 	= date('Y');
	  	$hari_ini = $thn.'-'.($bln-1).'-'.$tgl;
		$tgl_awal 	= date('Y-m-01', strtotime($hari_ini));
		$tgl_akhir	= date('Y-m-t', strtotime($hari_ini));

	  	echo $tgl_awal.' s/d '.$tgl_akhir;
        //$data['data']=$this->model_t3->show2($tgl_awal,$tgl_akhir);
	  }

	  public function generate_t3()
	  {
		$tgl 	= date('d');
	  	$bln 	= $this->input->post('bln',true);
	  	$thn 	= $this->input->post('thn',true);
	  	$hari_ini = $thn.'-'.($bln-1).'-'.$tgl;
		$tgl_awal 	= date('Y-m-01', strtotime($hari_ini));
		$tgl_akhir	= date('Y-m-t', strtotime($hari_ini));

	  	$hari_ini2 = $thn.'-'.$bln.'-'.$tgl;
		$tgl_awal2 	= date('Y-m-01', strtotime($hari_ini2));
		$tgl_akhir2	= date('Y-m-t', strtotime($hari_ini2));

		$check = $this->model_t3->show($tgl_awal2,$tgl_akhir2);
//$response['check'] = $check;
		if ($check<>false) {
//$response['check2'] = "Onok";
			$query = $this->model_t3->get_show();
			foreach ($query as $val) {
				$query2 = $this->db->query('
					SELECT a.*,b.* 
					FROM tab_absensi a 
					INNER JOIN tab_jam_kerja b ON b.kode_jam = a.kode_jam 
					WHERE a.tgl_kerja>="'.$tgl_awal.'" AND a.tgl_kerja<="'.$tgl_akhir.'" 
					AND a.nik="'.$val->nik.'"
				');

				$query3 = $this->db->query('
					SELECT * 
					FROM tab_t3 
					WHERE tanggal>="'.$tgl_awal2.'" AND tanggal<="'.$tgl_akhir2.'" 
					AND nik="'.$val->nik.'"
				');

				$jml = 0;
				if ($query2->result()<>null) {
					foreach ($query2->result() as $val2) {
						if ($val2->tipe_shift=="Pagi"||$val2->tipe_shift=="Sore") {
							if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk!="Telat") {
								$jml++;
							} else if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk=="Telat") {
								$time1 = strtotime($val2->jam_start);
								$time2 = strtotime($val2->jam_masuk1);
								$jam_telat = date('i', ($time2 - $time1));
	                          	$jam1 = 60;
	                          	$jam2 = 8;
	                          	$nilai_real = 1 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

		                        if ($jam_telat<=30) {
		                        	$jml += $nilai_real;
		                        }
							}
						} else if ($val2->tipe_shift=="Pagi&Sore") {
							if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk!="Telat") {
								$jml += 0.5;
							} else if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk=="Telat") {
								$time1 = strtotime($val2->jam_start1);
								$time2 = strtotime($val2->jam_masuk1);
								$jam_telat = date('i', ($time2 - $time1));
	                          	$jam1 = 60;
	                          	$jam2 = 8;
	                          	$nilai_real = 0.5 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

		                        if ($jam_telat<=30) {
		                        	$jml += $nilai_real;
		                        }
							}
							if ($val2->status_masuk2=="Masuk"||$val2->status_masuk2=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk2!="Telat") {
								$jml += 0.5;
							} else if ($val2->status_masuk2=="Masuk"||$val2->status_masuk2=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk2=="Telat") {
								$time1 = strtotime($val2->jam_start2);
								$time2 = strtotime($val2->jam_masuk2);
								$jam_telat = date('i', ($time2 - $time1));
	                          	$jam1 = 60;
	                          	$jam2 = 8;
	                          	$nilai_real = 0.5 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

		                        if ($jam_telat<=30) {
		                        	$jml += $nilai_real;
		                        }
							}
						}
					}
				}

				foreach ($query3->result() as $val3) {
					if ($val3->approved!="Ya") {
						$data = array(
							'jml_hadir'		=> $jml,
							'total_t3'		=> ($val->tarif_t3*$jml),
							'approved'		=> "Revisi",
							'keterangan'	=> "Auto Generate",
							'entry_user'	=> $this->session->userdata('username'),
							'entry_date' 	=> date('Y-m-d H:i:s')
						);
						$this->db->where('nik', $val3->nik);
						$this->db->update('tab_t3', $data);
					}
				}
			}
			$response['status'] = '204';
		} else {
//$response['check2'] = "Gak Onok";
			$query = $this->model_t3->get_show();
//$response['query'] = $this->db->last_query();
			foreach ($query as $val) {
				$query2 = $this->db->query('
					SELECT a.*,b.*
					FROM tab_absensi a 
					INNER JOIN tab_jam_kerja b ON b.kode_jam = a.kode_jam 
					WHERE a.tgl_kerja>="'.$tgl_awal.'" AND a.tgl_kerja<="'.$tgl_akhir.'" 
					AND a.nik="'.$val->nik.'"
				');

				$jml = 0;
				if ($query2->result()<>null) {
					foreach ($query2->result() as $val2) {
						if ($val2->tipe_shift=="Pagi"||$val2->tipe_shift=="Sore") {
							if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk!="Telat") {
								$jml++;
							} else if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk=="Telat") {
								$time1 = strtotime($val2->jam_start);
								$time2 = strtotime($val2->jam_masuk1);
								$jam_telat = date('i', ($time2 - $time1));
	                          	$jam1 = 60;
	                          	$jam2 = 8;
	                          	$nilai_real = 1 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

		                        if ($jam_telat<=30) {
		                        	$jml += $nilai_real;
		                        }
							}
						} else if ($val2->tipe_shift=="Pagi&Sore") {
							if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk!="Telat") {
								$jml += 0.5;
							} else if ($val2->status_masuk=="Masuk"||$val2->status_masuk=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk=="Telat") {
								$time1 = strtotime($val2->jam_start1);
								$time2 = strtotime($val2->jam_masuk1);
								$jam_telat = date('i', ($time2 - $time1));
	                          	$jam1 = 60;
	                          	$jam2 = 8;
	                          	$nilai_real = 0.5 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

		                        if ($jam_telat<=30) {
		                        	$jml += $nilai_real;
		                        }
							}
							if ($val2->status_masuk2=="Masuk"||$val2->status_masuk2=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk2!="Telat") {
								$jml += 0.5;
							} else if ($val2->status_masuk2=="Masuk"||$val2->status_masuk2=="Masuk Tidak Lengkap"&&$val2->keterangan_masuk2=="Telat") {
								$time1 = strtotime($val2->jam_start2);
								$time2 = strtotime($val2->jam_masuk2);
								$jam_telat = date('i', ($time2 - $time1));
	                          	$jam1 = 60;
	                          	$jam2 = 8;
	                          	$nilai_real = 0.5 - round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_DOWN);

		                        if ($jam_telat<=30) {
		                        	$jml += $nilai_real;
		                        }
							}
						}
					}
				}

				$data = array(
					'tanggal' 		=> $tgl_awal2,
					'nik'			=> $val->nik,
					'jml_hadir'		=> $jml,
					'total_t3'		=> ($val->tarif_t3*$jml),
					'approved'		=> "Belum",
					'keterangan'	=> "Auto Generate",
					'entry_user'	=> $this->session->userdata('username'),
					'entry_date' 	=> date('Y-m-d H:i:s')
				);
				$this->db->insert('tab_t3', $data);
//$response['data'] = $data;
			}
			$response['status'] = '200';
		}

		echo json_encode($response);
	  }

	  public function rekap()
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
        $cabang=$this->input->post('cabang');
        $data['data'] = $this->model_t3->rekapitulasi($tgl1,$tgl2,$cabang);
        $data['cabang']=$this->db->get('tab_cabang')->result();
      	$this->table->set_heading(array('NO','TANGGAL','NIK','NAMA','JABATAN','PLANT','NAMA REKENING','NO REKENING','TARIF','JUMLAH HADIR','JUMLAH T3','JUMLAH DITERIMA','APPROVEMENT','KETERANGAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        			);
        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('laporan/rekap_t3',$data,true);
		$this->load->view('beranda',$data);
	  }

	   public function cetak($dt)
	    {
	      $data['data']=base64_decode($dt);
	      $html=$this->load->view('t3/cetak',$data,true);
	      $this->mpdf=new mPDF('utf-8', 'A6', 10, 'Times','5','5','5','5');
	      $this->mpdf->WriteHTML($html);
	      $name='HRD'.time().'.pdf';
	      $this->mpdf->Output();
	      exit(); 
	    }

	  public function create()
	  {
	      if ($this->input->post('simpan')) {
	      	$this->save();
	      } else {
	      	$cb=$this->input->post('cabang');
	      	$jb=$this->input->post('jabatan');

	      	$data['data']=$this->model_t3->karyawan($cb,$jb);
	      	$data['cabang']=$this->db->get('tab_cabang')->result();
	      	$data['jabatan']=$this->db->get('tab_jabatan')->result();

	      	$data['halaman']=$this->load->view('t3/create',$data,true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$jml_nik=count($this->input->post('nik'));
	  	for ($i=0; $i < $jml_nik; $i++) { 
	  		$data = array(
                  'nik' => $this->input->post('nik')[$i],
				  'tarif' =>str_replace('.', '', $this->input->post('tarif')[$i]),
				  'entry_user' =>$this->session->userdata('username')
                );
	  		$this->model_t3->add($data);
	  	}
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('T3Controller');
	  }

	public function aksi(){
		$button=$this->input->post('tombol');

		if ($button=='edit') {
			$jml_id=count($this->input->post('cb_data'));
			
		     for ($i=0; $i < $jml_id ; $i++) { 
		     	$id=$this->input->post('cb_data')[$i];
		     	$cari[]=$this->model_t3->find($id);
		     }

		     $data['data']=$cari;
		     $data['halaman']=$this->load->view('t3/update',$data,true);
		     $this->load->view('beranda',$data);
		}else if ($button=='Hapus'){
			if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
					$id=$_POST['cb_data'][$i];
					$this->model_t3->delete($id);
			}
		     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
			}
			redirect('T3Controller','refresh');
		}
	}	

  	public function update(){
	  	$jml_id=count($this->input->post('id'));
	  	for ($i=0; $i < $jml_id; $i++) { 
		  	$id=$this->input->post('id')[$i];
	  		$data = array(
				  'tarif' =>str_replace('.', '', $this->input->post('trf')[$i]),
				  'entry_user' =>$this->session->userdata('username')
                );
	    	$this->model_t3->update($id,$data);
	  	}
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('T3Controller');
	}
	function cetakData(){
		$tgl1=$this->input->post('tanggal1');
	    $tgl2=$this->input->post('tanggal2');
	    $cb=$this->input->post('cabang');
	    $data['tgl1']=$this->input->post('tanggal1');
	    $data['tgl2']=$this->input->post('tanggal2');
	    $data['cabang']=$this->db->where('id_cabang',$cb)->get('tab_cabang')->row();
	    $data['data']=$this->model_t3->rekapitulasi($tgl1,$tgl2,$cb);
	    $this->table->set_heading(array('NO','TANGGAL','NIK','NAMA','JABATAN','PLANT','NAMA REKENING','NO REKENING','TARIF','JUMLAH HADIR','JUMLAH T3','JUMLAH DITERIMA','APPROVEMENT','KETERANGAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="tabel" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        			);
        $this->table->set_template($tmp);
        $aksi=$this->input->post('btn_aksi');
        if ($aksi=='cetak') {
        	$html=$this->load->view('laporan/p_t3',$data,true);
			$this->mpdf=new mPDF('utf-8', 'A4-L', 11, 'Times','5','5','5','5');
			$this->mpdf->WriteHTML($html);
			$name='komisi'.time().'.pdf';
			$this->mpdf->Output();
        }elseif ($aksi=='excel') {
        	$tanggal=time();
	        header("Content-type: application/x-msdownload");
	        header("Content-Disposition: attachment; filename=THR_KARYAWAN_".$tanggal.".xls");
	        header("Pragma: no-cache");
	        header("Expires: 0");
	        $no=1;$t_t3=0;$t_hadir=0;$t_terima=0;$t_terima2=0;
	        foreach ($data['data'] as $tampil){
	            if ($tampil->total_t3!=0&&$tampil->jml_hadir!=0) {
	                $t3 = $this->format->indo($tampil->total_t3/$tampil->jml_hadir);   
	            } else {
	                $t3 = 0;
	            }
	          //$t3=$tampil->total_t3/$tampil->jml_hadir;
	          $pembulatan = intval(($tampil->total_t3/1000))*1000;

	          $t_t3 += $t3;
	          $t_terima += $tampil->total_t3;
	          $t_terima2 += $pembulatan;

	        $this->table->add_row($no,$this->format->TanggalIndo($tampil->tanggal),$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$tampil->nama_rekening,$tampil->no_rekening,$t3,number_format($tampil->jml_hadir,2,',','.'),$this->format->indo($tampil->total_t3),$this->format->indo($pembulatan),$tampil->approved,$tampil->keterangan);
	        $no++;
	        }
	        $this->table->add_row('',array('data'=>'Total','colspan'=>7),'','',$this->format->indo($t_terima),$this->format->indo($t_terima2),'','');
	        $tabel=$this->table->generate();
	        echo $tabel;
        }
	    
		exit();        
	}
}