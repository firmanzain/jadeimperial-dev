<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class IzinController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_izin');
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
	      $data['data']=$this->model_izin->index($tgl1,$tgl2);
	      $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JENIS IZIN','TANGGAL IZIN','LAMA','ALASAN','LAMPIRAN','PUKUL'));
	      // $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','NIK','NAMA','JENIS IZIN','TANGGAL IZIN','LAMA','ALASAN','LAMPIRAN','PUKUL','TINDAKAN'));
	        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
	        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('izin/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['halaman']=$this->load->view('izin/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
		$config['upload_path'] = './lampiran/izin/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['file_name'] = $nmfile; //nama yang terupload nantinya
		$this->upload->initialize($config);
	    if($_FILES['lampiran']['name'])
	        {
	            if ($this->upload->do_upload('lampiran'))
	            {
	                $gbr = $this->upload->data();
	            	$lampiran='lampiran/izin/'.$gbr['file_name'];
	            }else{
	                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
	                $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\">".$this->upload->display_errors() ."!!</div>");
	                redirect('perizinan/add'); //jika gagal maka akan ditampilkan form upload
	            }
	        }
		else {
			$lampiran='';
		}
        $lama 	= $this->selisih_hari($this->input->post('tanggal2'),$this->input->post('tanggal1'))+1;
	  	$cek 	= $this->input->post('cek');
		$jenis 	= $this->input->post('jenis');
		$tgl 	= date("Y-m-01",strtotime(date("Y-m-d")));
		$nik 	= $this->input->post('nik');
		$dp 	= 0;
        if ($jenis=='Tidak Dapat Masuk') { 
            $tgl1   = $this->input->post('tanggal1');
            $dp     = $lama;
        } else {
            $tgl1 = $this->input->post('tanggal0');
            $dp     = $this->input->post('potongan');
        }
		/*if ($jenis=='Tidak Dapat Masuk') { 
			$tgl1 	= $this->input->post('tanggal1');
			//$tgl1 	= date("2016-05-04");
			$dp 	= $lama;
	  		//if($cek==1)	$this->db->query("update tab_master_dp set saldo_dp=IF(saldo_dp<>0,saldo_dp - ".$lama.",saldo_dp),saldo_cuti=IF(saldo_dp=0,saldo_cuti - ".$lama.",saldo_cuti) where nik='".$nik."' and bulan='".$tgl."'");
	  		if ($cek==1) {
	  			$check = $this->db->query('select * from tab_master_dp where nik="'.$nik.'"');
	  			if ($check->result()<>false) {
		  			foreach ($check->result() as $val) {
		  				if ($val->saldo_dp>$dp) {
			  				$dp_new		= $val->saldo_dp-$dp;
			  				$cuti_new	= $val->saldo_cuti;
		  				} else {
			  				$dp_new		= 0;
			  				$cuti_new	= $val->saldo_cuti+$val->saldo_dp-$dp;
		  				}
		  			}
					$this->db->query(
						'
						update tab_master_dp set saldo_dp='.$dp_new.', saldo_cuti='.$cuti_new.'
						where bulan="'.date("m",strtotime($tgl1)).'" and 
						tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
						'
					);
	  			}
	  		}
		} else { 
			//$tgl1 	= date("2016-05-04");
			$tgl1 = $this->input->post('tanggal0');
			$dp 	= $this->input->post('potongan');
	  		//if($cek==1) $this->db->query("update tab_master_dp set saldo_dp=IF(saldo_dp<>0,saldo_dp - ".$dp.",saldo_dp),saldo_cuti=IF(saldo_dp=0,saldo_cuti - ".$dp.",saldo_cuti) where nik='".$nik."' and bulan='".$tgl."'");
	  		if ($cek==1) {
	  			$check = $this->db->query('select * from tab_master_dp where nik="'.$nik.'"');
	  			if ($check->result()<>false) {
		  			foreach ($check->result() as $val) {
		  				if ($val->saldo_dp>$dp) {
			  				$dp_new		= $val->saldo_dp-$dp;
			  				$cuti_new	= $val->saldo_cuti;
		  				} else {
			  				$dp_new		= 0;
			  				$cuti_new	= $val->saldo_cuti+$val->saldo_dp-$dp;
		  				}
		  			}
					$this->db->query(
						'
						update tab_master_dp set saldo_dp='.$dp_new.', saldo_cuti='.$cuti_new.'
						where bulan="'.date("m",strtotime($tgl1)).'" and 
						tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
						'
					);
	  			}
	  		}
		}*/
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  'kepala_department' => $this->input->post('kabag'),
                  'hrd' => $this->input->post('hrd'),                                    
                  'manager' =>$this->input->post('manager'),
                  'tanggal_mulai' =>$tgl1,
				  'tanggal_finish' =>$this->input->post('tanggal2'),
				  'jenis_izin' =>$this->input->post('jenis'),
				  'alasan' =>$this->input->post('alasan'),
				  'lampiran' =>$lampiran,
				  'pukul' =>$this->input->post('pukul'),
				  'potong_dp' =>$dp,
				  'id_potong' => $cek,
                  'entry_user' =>$this->session->userdata('username'),
				  'lama' => $dp
                );
	    $this->model_izin->add($data);
        
                //UPDATE ABSENSI
                if ($data['jenis_izin']!="Tidak Dapat Masuk") {
                    $query_cari = $this->db->query(
                        '
                        select a.*,a.id as id_absen,b.* from tab_absensi a 
                        inner join tab_jam_kerja b on b.kode_jam=a.kode_jam
                        where nik="'.$data['nik'].'" 
                        and tgl_kerja="'.date("Y-m-d",strtotime($data['tanggal_mulai'])).'"
                        '
                    );  
                } else if ($data['jenis_izin']=="Tidak Dapat Masuk") {
                    $query_cari = $this->db->query(
                        '
                        select a.*,b.* from tab_absensi a 
                        inner join tab_jam_kerja b on b.kode_jam=a.kode_jam
                        where a.nik="'.$data['nik'].'" 
                        and a.tgl_kerja>="'.date("Y-m-d",strtotime($data['tanggal_mulai'])).'" 
                        and a.tgl_kerja<="'.date("Y-m-d",strtotime($data['tanggal_finish'])).'"
                        '
                    );
                }

                //print_r($this->db->last_query());

                if ($query_cari->result()<>false) {
                    echo "Onok";
                    foreach ($query_cari->result() as $val) {
                        $id_absen    = $val->id_absen;
                        $nik         = $val->nik;
                        $tipe        = $val->tipe_shift;
                        $jam_masuk1  = $val->jam_start;
                        $jam_keluar1 = $val->jam_finish;
                        $jam_masuk2  = $val->jam_start2;
                        $jam_keluar2 = $val->jam_finish2;
                        /*echo "<br>".$id_absen;
                        echo "<br>".$data['pukul']."<br>";
                        echo "<br>".$jam_masuk1;
                        echo "<br>".$jam_keluar1;
                        echo "<br>".$jam_masuk2;
                        echo "<br>".$jam_keluar2;*/

                        if ($tipe=="Pagi"||$tipe=="Sore") {
                            if ($data['jenis_izin']=="Datang Pukul") {
                                $data_new = array(
                                    'jam_masuk1'        => $data['pukul'],
                                    'status_masuk'      => "Masuk",
                                    'keterangan_masuk'  => $data['jenis_izin'],
                                    'entry_user'    => $this->session->userdata('username'),
                                    'entry_date'    => date('Y-m-d H:i:s')
                                );
                                $this->db->where('id', $id_absen);
                                $this->db->update('tab_absensi', $data_new);
                            } else if ($data['jenis_izin']=="Pulang Pukul") {
                                $data_new = array(
                                    'jam_keluar1'       => $data['pukul'],
                                    'status_keluar'     => "Pulang",
                                    'keterangan_keluar' => $data['jenis_izin'],
                                    'entry_user'    => $this->session->userdata('username'),
                                    'entry_date'    => date('Y-m-d H:i:s')
                                );
                                $this->db->where('id', $id_absen);
                                $this->db->update('tab_absensi', $data_new);
                            } else if ($data['jenis_izin']=="Tidak Dapat Masuk") {
                                $data_new = array(
                                    'status_masuk'      => "Izin",
                                    'keterangan_masuk'  => $data['jenis_izin'],
                                    'status_keluar'     => "Izin",
                                    'keterangan_keluar' => $data['jenis_izin'],
                                    'entry_user'    => $this->session->userdata('username'),
                                    'entry_date'    => date('Y-m-d H:i:s')
                                );
                                $this->db->where('tgl_kerja >=', date("Y-m-d",strtotime($data['tanggal_mulai'])));
                                $this->db->where('tgl_kerja <=', date("Y-m-d",strtotime($data['tanggal_finish'])));
                                $this->db->where('nik', $nik);
                                $this->db->update('tab_absensi', $data_new);
                            }
                        } else if ($tipe=="Pagi&Sore") {
                            if ($data['jenis_izin']=="Datang Pukul") {
                                if ($data['pukul']>$jam_masuk1&&$data['pukul']<$jam_keluar1&&$data['pukul']<$jam_masuk2) {
                                    $data_new = array(
                                        'jam_masuk1'        => $data['pukul'],
                                        'status_masuk'      => "Masuk",
                                        'keterangan_masuk'  => $data['jenis_izin'],
                                        'entry_user'    => $this->session->userdata('username'),
                                        'entry_date'    => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('id', $id_absen);
                                    $this->db->update('tab_absensi', $data_new);
                                } else if ($data['pukul']<$jam_masuk1) {
                                    $data_new = array(
                                        'jam_masuk1'        => $data['pukul'],
                                        'status_masuk'      => "Masuk",
                                        'keterangan_masuk'  => $data['jenis_izin'],
                                        'entry_user'    => $this->session->userdata('username'),
                                        'entry_date'    => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('id', $id_absen);
                                    $this->db->update('tab_absensi', $data_new);
                                } else if ($data['pukul']>$jam_masuk2) {
                                    $data_new = array(
                                        'jam_masuk2'        => $data['pukul'],
                                        'status_masuk2'     => "Masuk",
                                        'keterangan_masuk2' => $data['jenis_izin'],
                                        'entry_user'    => $this->session->userdata('username'),
                                        'entry_date'    => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('id', $id_absen);
                                    $this->db->update('tab_absensi', $data_new);
                                } else if ($data['pukul']>$jam_keluar1&&$data['pukul']<$jam_masuk2) {
                                    $data_new = array(
                                        'jam_masuk2'        => $data['pukul'],
                                        'status_masuk2'     => "Masuk",
                                        'keterangan_masuk2' => $data['jenis_izin'],
                                        'entry_user'    => $this->session->userdata('username'),
                                        'entry_date'    => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('id', $id_absen);
                                    $this->db->update('tab_absensi', $data_new);
                                }
                            } else if ($data['jenis_izin']=="Pulang Pukul") {
                                if ($data['pukul']>$jam_masuk1&&$data['pukul']<$jam_keluar1&&$data['pukul']<$jam_masuk2&&$data['pukul']<$jam_keluar2) {
                                    $data_new = array(
                                        'jam_keluar1'       => $data['pukul'],
                                        'status_keluar'     => "Pulang",
                                        'keterangan_keluar' => $data['jenis_izin'],
                                        'entry_user'    => $this->session->userdata('username'),
                                        'entry_date'    => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('id', $id_absen);
                                    $this->db->update('tab_absensi', $data_new);
                                } else if ($data['pukul']>$jam_masuk1&&$data['pukul']>$jam_keluar1&&$data['pukul']<$jam_masuk2&&$data['pukul']<$jam_keluar2) {
                                    $data_new = array(
                                        'jam_keluar1'       => $data['pukul'],
                                        'status_keluar'     => "Pulang",
                                        'keterangan_keluar' => $data['jenis_izin'],
                                        'entry_user'    => $this->session->userdata('username'),
                                        'entry_date'    => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('id', $id_absen);
                                    $this->db->update('tab_absensi', $data_new);
                                } else if ($data['pukul']>$jam_masuk1&&$data['pukul']>$jam_keluar1&&$data['pukul']>$jam_masuk2&&$data['pukul']<$jam_keluar2) {
                                    $data_new = array(
                                        'jam_keluar12'      => $data['pukul'],
                                        'status_keluar2'        => "Pulang",
                                        'keterangan_keluar2'    => $data['jenis_izin'],
                                        'entry_user'    => $this->session->userdata('username'),
                                        'entry_date'    => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('id', $id_absen);
                                    $this->db->update('tab_absensi', $data_new);
                                } else if ($data['pukul']>$jam_masuk1&&$data['pukul']>$jam_keluar1&&$data['pukul']>$jam_masuk2&&$data['pukul']>$jam_keluar2) {
                                    $data_new = array(
                                        'jam_keluar12'      => $data['pukul'],
                                        'status_keluar2'        => "Pulang",
                                        'keterangan_keluar2'    => $data['jenis_izin'],
                                        'entry_user'    => $this->session->userdata('username'),
                                        'entry_date'    => date('Y-m-d H:i:s')
                                    );
                                    $this->db->where('id', $id_absen);
                                    $this->db->update('tab_absensi', $data_new);
                                }
                            } else if ($data['jenis_izin']=="Tidak Dapat Masuk") {
                                $data_new = array(
                                    'status_masuk'      => "Izin",
                                    'keterangan_masuk'  => $data['jenis_izin'],
                                    'status_keluar'     => "Izin",
                                    'keterangan_keluar' => $data['jenis_izin'],
                                    'status_masuk2'         => "Izin",
                                    'keterangan_masuk2'     => $data['jenis_izin'],
                                    'status_keluar2'        => "Izin",
                                    'keterangan_keluar2'    => $data['jenis_izin'],
                                    'entry_user'    => $this->session->userdata('username'),
                                    'entry_date'    => date('Y-m-d H:i:s')
                                );
                                $this->db->where('tgl_kerja >=', date("Y-m-d",strtotime($data['tanggal_mulai'])));
                                $this->db->where('tgl_kerja <=', date("Y-m-d",strtotime($data['tanggal_finish'])));
                                $this->db->where('nik', $nik);
                                $this->db->update('tab_absensi', $data_new);
                            }
                        }
				//var_dump($data_new);
		    }
	    } else {
	    	echo "Gak Onok";
	    }

	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('perizinan');
	  }

	public function selisih_hari($h1,$h2)
	{
		$s1=((abs(strtotime ($h2) - strtotime ($h1))/(60*60*24)));
		return $s1;
	}

	public function selisih_jam($jam1,$jam2)
	{
		$s1=(strtotime($jam1)-strtotime($jam2))/3600;
		return $s1;
	}

	public function ajax_cari(){
		$nik=$this->input->post('nik');
		$data=$this->db->where('nik',$nik)->get('tab_karyawan')->row();
		$num_data=count($data);
		if ($num_data>=1) {
			echo "Data Valid : ".$data->nama_ktp;
		} else {
			echo "Data Tidak Valid";
		}
	}

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_izin->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('izin/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$nmfile = "file_".time(); //nama file saya beri nama langsung dan diikuti fungsi time
		$config['upload_path'] = './lampiran/izin/'; //path folder
		$config['allowed_types'] = 'gif|jpg|png|jpeg|bmp'; //type yang dapat diakses bisa anda sesuaikan
		$config['file_name'] = $nmfile; //nama yang terupload nantinya
		$this->upload->initialize($config);
	    if($_FILES['lampiran']['name'])
	        {
	            if ($this->upload->do_upload('lampiran'))
	            {
	                $gbr = $this->upload->data();
	            	$lampiran='lampiran/izin/'.$gbr['file_name'];
	            }else{
	                //pesan yang muncul jika terdapat error dimasukkan pada session flashdata
	                $this->session->set_flashdata("pesan", "<div class=\"alert alert-danger\" id=\"alert\">".$this->upload->display_errors() ."!!</div>");
	                redirect('perizinan/add'); //jika gagal maka akan ditampilkan form upload
	            }
	        }
		else {
		$lampiran=$this->input->post('lamp');
		}
		$lama=$this->selisih_hari($this->input->post('tanggal2'),$this->input->post('tanggal1'))+1;
	  	$cek=$this->input->post('cek');
		$jenis=$this->input->post('jenis');
		$tgl=date("Y-m-01",strtotime(date("Y-m-d")));
		$nik=$this->input->post('nik');
		$dp=0;
		$lama2=$this->input->post('potongan_lama');
		if ($jenis=='Tidak Dapat Masuk') { 
			$tgl1=$this->input->post('tanggal1');
			$dp=$lama;
	  		if ($lama2!=$dp) {
	  			//if($cek==1)	$this->db->query("update tab_master_dp set saldo_dp=IF(saldo_dp<>0,saldo_dp+".$lama2."-".$dp.",saldo_dp),saldo_cuti=IF(saldo_dp=0,saldo_cuti +".$lama2."-".$dp.",saldo_cuti) where nik='".$nik."' and bulan='".$tgl."'");
		  		if ($cek==1) {
		  			$check = $this->db->query('select * from tab_master_dp where nik="'.$nik.'"');
		  			if ($check->result()<>false) {
			  			foreach ($check->result() as $val) {
			  				if ($val->saldo_dp>$dp) {
				  				$dp_new		= $val->saldo_dp+$lama2-$dp;
				  				$cuti_new	= $val->saldo_cuti;
			  				} else {
				  				$dp_new		= 0;
				  				$cuti_new	= $val->saldo_cuti+$val->saldo_dp+$lama2-$dp;
			  				}
			  			}
						$this->db->query(
							'
							update tab_master_dp set saldo_dp='.$dp_new.', saldo_cuti='.$cuti_new.'
							where bulan="'.date("m",strtotime($tgl1)).'" and 
							tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
							'
						);
		  			}
		  		} else {
					$this->db->query(
						'
						update tab_master_dp set saldo_dp=saldo_dp+'.$lama2.' 
						where bulan="'.date("m",strtotime($tgl1)).'" and 
						tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
						'
					);
		  		}
	  		}
		} else { 
			$tgl1=$this->input->post('tanggal0');
			//$tgl1 	= date("2016-05-07");
			$dp=$this->input->post('potongan');
	  		if ($lama2!=$dp) {
	  			//if($cek==1) $this->db->query("update tab_master_dp set saldo_dp=IF(saldo_dp<>0,saldo_dp+".$lama2."-".$dp.",saldo_dp),saldo_cuti=IF(saldo_dp=0,saldo_cuti +".$lama2."-".$dp.",saldo_cuti) where nik='".$nik."' and bulan='".$tgl."'");
		  		if ($cek==1) {
		  			$check = $this->db->query('select * from tab_master_dp where nik="'.$nik.'"');
		  			if ($check->result()<>false) {
			  			foreach ($check->result() as $val) {
			  				if ($val->saldo_dp>$dp) {
				  				$dp_new		= $val->saldo_dp+$lama2-$dp;
				  				$cuti_new	= $val->saldo_cuti;
			  				} else {
				  				$dp_new		= 0;
				  				$cuti_new	= $val->saldo_cuti+$val->saldo_dp+$lama2-$dp;
			  				}
			  			}
						$this->db->query(
							'
							update tab_master_dp set saldo_dp='.$dp_new.', saldo_cuti='.$cuti_new.'
							where bulan="'.date("m",strtotime($tgl1)).'" and 
							tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
							'
						);
		  			}
		  		} else {
					$this->db->query(
						'
						update tab_master_dp set saldo_dp=saldo_dp+'.$lama2.' 
						where bulan="'.date("m",strtotime($tgl1)).'" and 
						tahun="'.date("Y",strtotime($tgl1)).'" and nik="'.$nik.'"
						'
					);
		  		}
	  		}
		}
	  	$data = array(
                  'nik' => $this->input->post('nik'),
                  /*
                  'manager' =>$this->input->post('hrd'),
                  'kabag' =>$this->input->post('kabag'),
                  */
                  'kepala_department' => $this->input->post('kabag'),
                  'hrd' => $this->input->post('hrd'),                                    
                  'manager' =>$this->input->post('manager'),
                  'tanggal_mulai' =>$tgl1,
				  'tanggal_finish' =>$this->input->post('tanggal2'),
				  'jenis_izin' =>$this->input->post('jenis'),
				  'alasan' =>$this->input->post('alasan'),
				  'lampiran' =>$lampiran,
				  'pukul' =>$this->input->post('pukul'),
				  'potong_dp' =>$dp,
                  'entry_user' =>$this->session->userdata('username'),
				  'lama' => $lama
                );
	    $this->model_izin->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Diupdate</div>");
	    redirect('perizinan');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
                $query = $this->db->query('select * from tab_izin where id='.$id);
                foreach ($query->result() as $row) {
                    $nik = $row->nik;
                    $jenis_izin = $row->jenis_izin;
                    $tgl_mulai  = $row->tanggal_mulai;
                    $tgl_finish = $row->tanggal_finish;
                }
                if ($jenis_izin=="Tidak Dapat Masuk") {
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
                } else {
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
                    $this->db->where('tgl_kerja',date('Y-m-d',strtotime($tgl_mulai)));
                    $this->db->update('tab_absensi',$data_absensi);
                }
				$this->model_izin->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span> 
            </button> Data Berhasil Dihapus</div>");
		}
		redirect('perizinan','refresh');
	}

    public function reset()
    {
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
    }
}