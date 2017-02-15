<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_dpController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
    	//$this->auto_update->auto_dp();
    	$this->load->helper('timezone');
		$this->load->model('model_dp');
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
		$this->load->library('mpdf');
	}
	
	  public function index()
	  {
	      	$this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','TINDAKAN'));
	        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
	        $this->table->set_template($tmp);
	      	$data['data']=$this->model_dp->index();
			$data['halaman']=$this->load->view('master-dp/awal',$data,true);
			$this->load->view('beranda',$data);
	  }

	  public function detail($nik)
	  {
	      $tahun=$this->input->post('tahun');
	      $bulan=$this->input->post('bulan');
	      $data['karyawan']=$this->db->where('nik',$nik)->get('tab_karyawan')->row();
	      $data['data']=$this->model_dp->detail($nik,$bulan,$tahun);
	      $this->update_dp_cuti($bulan,$tahun);
	      $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','BULAN','TAHUN','SALDO DP','SALDO CUTI','KETERANGAN','TINDAKAN'));
	        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
	        $this->table->set_template($tmp);
			$data['halaman']=$this->load->view('master-dp/index',$data,true);
			$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['halaman']=$this->load->view('master-dp/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){				   
	  	$data = array(
                  'bulan' => date("Y-m-01",strtotime($this->input->post('bulan'))),
                  'tahun' =>$this->input->post('tahun'),
                  'nik' =>$this->input->post('nik'),
                  'saldo_dp' =>$this->add_dp(),
                  'saldo_cuti' =>$this->add_cuti(),
				  'keterangan' =>$this->input->post('keterangan'),
                );
	    $this->model_dp->add($data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('master-dp');
	  }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_dp->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('master-dp/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }
	public function add_dp(){
		$bln_1=date('Y-m-d', strtotime('-1 month', strtotime(date("Y-m-01",strtotime($this->input->post('bulan'))))));
	  	$cek_data=$this->db->where('nik',$this->input->post('nik'))
	  					   ->where('bulan',$bln_1)
	  					   ->select('saldo_dp,saldo_cuti')
	  					   ->get('tab_master_dp')
	  					   ->row();
	  	if ($cek_data==1) {
	  		$saldo_dp=$this->input->post('saldo_dp')+$cek_data->saldo_dp;
	  	} else {
	  		$saldo_dp=$this->input->post('saldo_dp');
	  	}

	  	return $saldo_dp;

	}

	public function add_cuti()
	{
	  	$thn_1=date('Y', strtotime('-1 Years', strtotime(date("Y-m-01",strtotime($this->input->post('bulan'))))));
		$cek_cuti=$this->db->where('nik',$this->input->post('nik'))
	  					   ->where('Year(bulan)',$thn_1)
	  					   ->select('saldo_dp,saldo_cuti')
	  					   ->get('tab_master_dp')
	  					   ->row();
	  	if ($cek_cuti==1) {
	  		$saldo_cuti=$this->input->post('saldo_cuti')+$cek_cuti->saldo_cuti;
	  	} else {
	  		$saldo_cuti=$this->input->post('saldo_cuti');
	  	}

	  	return $saldo_cuti;
	}
  	public function update(){
	  	$id=$this->input->post('id');
	  	$cuti_lama=$this->input->post('saldo_cutiLama');
	  	$dp_lama=$this->input->post('saldo_dpLama');
	  	$saldo_cuti=$this->input->post('saldo_cuti');
	  	$saldo_dp=$this->input->post('saldo_dp');
	  	if($cuti_lama!=$saldo_cuti) $saldo1=$this->add_cuti(); else $saldo1=$saldo_cuti; 
	  	if($dp_lama!=$saldo_dp) $saldo2=$this->add_dp(); else $saldo2=$saldo_dp; 
	  	$data = array(
                  'bulan' => date("Y-m-01",strtotime($this->input->post('bulan'))),
                  'tahun' =>$this->input->post('tahun'),
                  'nik' =>$this->input->post('nik'),
                  'saldo_dp' =>$saldo2,
                  'saldo_cuti' =>$saldo1,
				  'keterangan' =>$this->input->post('keterangan'),
                );
	    $this->model_dp->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('master-dp');
	}
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$this->model_dp->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus</div>");
		}
		redirect('master-dp','refresh');
	}

/**
Report DP Cuti
*/
	// Menu Report Rekap DP dicllck (tampilan per cabang)
	public function rekap_data()
	  {
	      	$this->table->set_heading(array('NO','PLANT','JUMLAH KARYAWAN','TINDAKAN'));
	        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
	        $this->table->set_template($tmp);
	      	$data['data']=$this->model_dp->rekap_data();
			$data['halaman']=$this->load->view('master-dp/rekap',$data,true);
			$this->load->view('beranda',$data);
	  }


	  // Detail dicllck (tampilan detail
	public function detail_rekap($id)
	  {
      	$data['tahun'] 	= $this->input->post('thn');
      	$data['bulan']	= $this->input->post('bln');
      	$data['cabang']	= $id;

      	if (empty($data['tahun']) || empty($data['bulan'])) { // jika data tahun dan bulan kosong
      		$data['tahun']=date('Y'); // jadikan tahun adalah tahun sekarang
      		$data['bulan']=date('m'); // jadikan bulan adalah bulan sekarang
      	}

		$tgl_awal   = date('Y-m-01',strtotime($data['tahun']."-".$data['bulan']));
		$tgl_akhir  = date('Y-m-t',strtotime($data['tahun']."-".$data['bulan']));

      	$data['data']=$this->model_dp->detail_rekap($id,$data['bulan'],$data['tahun']);
	    // print_r($this->db->last_query());
      	// $this->update_dp_cuti($data['bulan'],$data['tahun']);

      	//print_r($this->db->last_query());
		$data['halaman']=$this->load->view('master-dp/view_rekap',$data,true);
		
		$this->load->view('beranda',$data);
	  }




	function cetakData(){
		$tahun=$this->input->post('tahun');
	    $bulan=$this->input->post('bulan');
	    $cb=$this->input->post('cabang');
	    $data['tahun']=$this->input->post('tahun');
	    $data['bulan']=$this->input->post('bulan');
	    $data['cabang']=$this->db->where('id_cabang',$cb)->get('tab_cabang')->row();
	    $data['data']=$this->model_dp->detail_rekap($cb,$bulan,$tahun);
	    $aksi=$this->input->post('btn_aksi');
	    if ($aksi=='cetak') {
	    	$html=$this->load->view('laporan/p_dp',$data,true);
			$this->mpdf=new mPDF('utf-8', 'A4-L', 11, 'Times','5','5','5','5');
			$this->mpdf->WriteHTML($html);
			$name='komisi'.time().'.pdf';
			$this->mpdf->Output();
	    }elseif ($aksi=='excel') {
	    	$tanggal=time();
	        header("Content-type: application/x-msdownload");
	        header("Content-Disposition: attachment; filename=SALDO_DP_KARYAWAN_".$tanggal.".xls");
	        header("Pragma: no-cache");
	        header("Expires: 0");
	    	$tahun=$data['tahun'];
	    	$bulan=$data['bulan'];
	    	$t_lalu=$tahun-1;
	    	echo '<table class="tabel" id="tabel">
		          <tr>
		            <th rowspan="2">No</th>
		            <th rowspan="2">Nama</th>
		            <th colspan="4">DP</th>
		            <th colspan="9">Cuti</th>
		          </tr>
		          <tr>
		            <th>Saldo Awal DP '.$this->format->BulanIndo($bulan).' '.$tahun.'</th>
		            <th>Jth DP</th>
		            <th>Libur</th>
		            <th>Saldo Akhir DP '.$this->format->BulanIndo($bulan).' '.$tahun.'</th>
		            <th>Saldo Cuti <?=$tahun-1?></th>
		            <th>Adjusment</th>
		            <th>Saldo Cuti Per '.$this->format->BulanIndo($bulan).' '.$tahun.'</th>
		            <th>Cuti (Minus)</th>
		            <th>DP (Minus) '.$this->format->BulanIndo($bulan).' '.$tahun.'</th>
		            <th>Saldo Cuti Hangus '.$t_lalu.'</th>
		            <th>Saldo Akhir Cuti '.$t_lalu.'</th>
		            <th>Saldo Akhir Cuti Per '.$this->format->BulanIndo($bulan).' '.$tahun.'</th>
		          </tr>';
		    $no=1;
	          foreach ($data['data'] as $tampil) {
	            $cuti=$this->db->where('nik',$tampil->nik)
	                     ->where('month(tanggal_mulai)',$tampil->bln)
	                     ->select('sum(lama_cuti) as jml_cuti')
	                     ->get('tab_cuti')->row();
	            $izin=$this->db->where('nik',$tampil->nik)
	                     ->where('month(tanggal_mulai)',$tampil->bln)
	                     ->where('jenis_izin','Tidak Dapat Masuk')
	                     ->select('sum(lama) as jml_izin')
	                     ->get('tab_izin')->row();
	            $saldo_bln_lalu=$this->db->where('nik',$tampil->nik)
	                         ->where("month(bulan)",$tampil->bln-1)
	                         ->select("saldo_dp,saldo_cuti")
	                         ->get('tab_master_dp')->row();
	            $saldo_thn_lalu=$this->db->where('nik',$tampil->nik)
	                         ->where('year(bulan)',$tampil->thun-1)
	                         ->select("saldo_cuti")
	                         ->get('tab_master_dp')->row();
	            $jatah_dp=($tampil->saldo_dp+$izin->jml_izin+$cuti->jml_cuti)-$saldo_bln_lalu->saldo_dp;
	            if ($saldo_bln_lalu->saldo_dp<0) {
	              $adj=abs($saldo_bln_lalu->saldo_dp);
	              $dp_min=abs($saldo_bln_lalu->saldo_dp);
	            }else{
	              $adj=0;
	              $dp_min=0;
	            }
	            if ($saldo_thn_lalu->saldo_cuti<0) {
	              $min_cuti=abs($saldo_thn_lalu->saldo_cuti);
	              $saldo_hangus=0;
	            }else{
	              $min_dp=0;
	              $saldo_hangus=$saldo_thn_lalu->saldo_cuti;
	            }
	            $libur=$izin->jml_izin+$cuti->jml_cuti;
	            echo "<tr>
	                 <td>$no</td>
	                 <td align='left'>$tampil->nama_ktp</td>
	                 <td >$saldo_bln_lalu->saldo_dp</td>
	                 <td align='center'>$jatah_dp</td>
	                 <td align='center'>$libur</td>
	                 <td align='center'>$tampil->saldo_dp</td>
	                 <td align='center'>$saldo_thn_lalu->saldo_cuti</td>
	                 <td align='center'>$adj</td>
	                 <td align='center'>$tampil->saldo_cuti</td>
	                 <td align='center'>$dp_min</td>
	                 <td align='center'>$min_dp</td>
	                 <td align='center'>$saldo_hangus</td>
	                 <td align='center'>0</td>
	                 <td align='center'>$tampil->saldo_cuti</td>
	              </tr>";
	            $no++;
	          }
	    }
	    
		exit();        
    }

    public function update_dp_cuti($bln_param,$thn_param){
    	$this->load->model('model_dp');
    	//error_reporting(E_ALL);
    	$data = $this->model_dp->detail_rekap2($bln_param,$thn_param);
    	//print_r($this->db->last_query());
        $no=1;
        foreach ($data as $tampil) {
                  $new_bln = date('Y-'.$tampil->bln.'-d');
                  $bln_fix = date('m',strtotime($new_bln));
                  $thn_fix = date('Y',strtotime($new_bln));
                  $new_bln2 = date('Y-'.($tampil->bln-1).'-d');
                  $bln_fix2 = date('m',strtotime($new_bln2));
                  $thn_fix2 = date('Y',strtotime($new_bln2));
                  $begin_day_unix   = strtotime($new_bln.' 00:00:00');
                  $begin_day_unix2  = strtotime($new_bln2.' 00:00:00');

                  $hari_ini = $thn_param.'-'.$bln_param; // misal 8-2016 (sekarang)
                  $tgl_pertama  = date('Y-m-01', strtotime($hari_ini)); // awal bulan
                  $tgl_terakhir   = date('Y-m-t', strtotime($hari_ini)); // akhir bulan

                  if ($tampil->nik_resign==NULL||$tampil->tanggal_resign<$tampil->tanggal_masuk) {
                  if ($tampil->tanggal_masuk<$tgl_terakhir) {

                  $saldo_bln_lalu=$this->db->where('nik',$tampil->nik)
                               ->where("bulan",$bln_fix2)
                               ->where("tahun",$thn_fix)
                               ->select("*")
                               ->get('tab_master_dp')->row();
                  $total_thun_lalu=$this->db->where('nik',$tampil->nik)
                                           ->where('year(bulan)',$tampil->thun-1)
                                           ->select("sum(saldo_cuti) as total")
                                           ->get('tab_master_dp')->row();

                  //MENCARI JATAH DP
                  // CARI JUMLAH DP
                  $hari_ini = $thn_param.'-'.$bln_param; // misal 8-2016 (sekarang)
                  $tgl_pertama  = date('Y-m-01', strtotime($hari_ini)); // awal bulan
                  $tgl_terakhir   = date('Y-m-t', strtotime($hari_ini)); // akhir bulan

                  $detik = 24 * 3600; // jumlah detik dalam 1 hari

                  $tgl_awal   = strtotime($tgl_pertama);
                  $tgl_akhir  = strtotime($tgl_terakhir);

                  $minggu = 0;

                  if (date('Y-m-d',strtotime($tgl_pertama))<date('Y-m-d',strtotime($tampil->tanggal_masuk))) {
                    // cari jumlah minggu dalam 1 bulan
                    for ($i=strtotime($tampil->tanggal_masuk); $i <= $tgl_akhir; $i += $detik)
                    {
                      if (date("w", $i) == "0"){
                        $minggu++;
                      }
                    }
                    $cari_jml = $this->db->query(
                      '
                      select sum(lama) as jml from tab_hari_libur 
                      where tanggal_mulai>="'.$tampil->tanggal_masuk.'" and tanggal_selesai<="'.$tgl_terakhir.'" and cuti_khusus="Ya"
                      '
                    );
                  } else {
                    // cari jumlah minggu dalam 1 bulan
                    for ($i=$tgl_awal; $i <= $tgl_akhir; $i += $detik)
                    {
                      if (date("w", $i) == "0"){
                        $minggu++;
                      }
                    }
                    $cari_jml = $this->db->query(
                      '
                      select sum(lama) as jml from tab_hari_libur 
                      where tanggal_mulai>="'.$tgl_pertama.'" and tanggal_selesai<="'.$tgl_terakhir.'" and cuti_khusus="Ya"
                      '
                    ); 
                  }

                  if ($cari_jml<>null) // jika ada data
                  {
                    foreach ($cari_jml->result() as $valcari) {
                      $jml_libur = $valcari->jml; // jumlah hari libur non minggu ketemu
                    
                    }
                  } 
                  else 
                  {
                    $jml_libur = 0;
                  }


                  $jatah_dp = $jml_libur+$minggu;
                  //++++++++++++++++//

                  if (date('Y-m-d',strtotime($tgl_pertama))<date('Y-m-d',strtotime($tampil->tanggal_masuk))) {
                    $absen_query = $this->db->select('a.*,b.*')
                                            ->from('tab_absensi a')
                                            ->join('tab_jam_kerja b','b.kode_jam=a.kode_jam','inner')
                                            ->where('a.nik',$tampil->nik)
                                            ->where('a.tgl_kerja >=',date('Y-m-d',strtotime($tampil->tanggal_masuk)))
                                            ->where('a.tgl_kerja <=',$tgl_terakhir)
                                            ->get();
                  } else {
                    $absen_query = $this->db->select('a.*,b.*')
                                            ->from('tab_absensi a')
                                            ->join('tab_jam_kerja b','b.kode_jam=a.kode_jam','inner')
                                            ->where('a.nik',$tampil->nik)
                                            ->where('a.tgl_kerja >=',$tgl_pertama)
                                            ->where('a.tgl_kerja <=',$tgl_terakhir)
                                            ->get();
                  }

                  $jml_absen = 0;
                  if ($absen_query<>false) {
                    foreach ($absen_query->result() as $row) {
                      if ($row->tipe_shift=="Pagi"||$row->tipe_shift=="Sore") {
                        if ($row->status_masuk=="Bolos") {
                          $jml_absen++;
                        } else if ($row->keterangan_keluar=="Pulang Cepat") {
                          $time1    = strtotime($row->jam_masuk1);
                          $time2    = strtotime($row->jam_keluar1);
                          $selisih  = date('H:i:s', ($time2 - ($time1 - $begin_day_unix)));
                          $batas = date('H:i:s', (strtotime("05:00:00")));
                          if ($selisih<$batas) {
                            $jml_absen += 0.5;
                          }

                        }
                      } else if ($row->tipe_shift=="Pagi&Sore") {
                        if ($row->status_masuk=="Bolos") {
                          $jml_absen += 0.5;
                        }

                        if ($row->status_masuk2=="Bolos") {
                          $jml_absen += 0.5;
                        } 

                        if ($row->keterangan_keluar=="Pulang Cepat"||$row->keterangan_keluar2=="Pulang Cepat") {
                          $time1a    = strtotime($row->jam_masuk1);
                          $time2a    = strtotime($row->jam_keluar1);
                          $time1b    = strtotime($row->jam_masuk2);
                          $time2b    = strtotime($row->jam_keluar2);
                          $selisih1  = date('H:i:s', ($time2a - ($time1a - $begin_day_unix)));
                          $selisih2  = date('H:i:s', ($time2b - ($time1b - $begin_day_unix)));
                          if (($selisih1+$selisih2)<$batas) {
                            $jml_absen += 0.5;
                          }
                        }

                      } else if ($row->tipe_shift=="Libur") {
                        if ($row->jam_masuk1!="00:00:00"&&$row->jam_masuk2=="00:00:00") {
                          if ($row->keterangan_masuk=="Libur") {
                            $jml_absen ++;
                          } 
                        } else {
                          if ($row->keterangan_masuk=="Libur") {
                            $jml_absen += 0.5;
                          }
                          if ($row->keterangan_masuk2=="Libur") {
                            $jml_absen += 0.5;
                          } 
                        }
                      }
                    }
                  }

                  
                  if (date('Y-m-d',strtotime($tgl_pertama))<date('Y-m-d',strtotime($tampil->tanggal_masuk))) {
                    $cuti_query = $this->db->select('*')
                                           ->from('tab_cuti')
                                           ->where('nik',$tampil->nik)
                                           ->where('tanggal_mulai >=',date('Y-m-d',strtotime($tampil->tanggal_masuk)))
                                           ->where('tanggal_mulai <=',$tgl_terakhir)
                                           ->where('cuti_khusus','Tidak')
                                           ->get();
                  } else {
                    $cuti_query = $this->db->select('*')
                                           ->from('tab_cuti')
                                           ->where('nik',$tampil->nik)
                                           ->where('tanggal_mulai >=',$tgl_pertama)
                                           ->where('tanggal_mulai <=',$tgl_terakhir)
                                           ->where('cuti_khusus','Tidak')
                                           ->get();
                  }

                  $jml_cuti = 0;
                  if ($cuti_query<>false) {
                    foreach ($cuti_query->result() as $row) {
                      $jml_cuti += $row->lama_cuti;
                    }
                  }

                  
                  if (date('Y-m-d',strtotime($tgl_pertama))<date('Y-m-d',strtotime($tampil->tanggal_masuk))) {
                    $izin_query = $this->db->select('*')
                                         ->from('tab_izin')
                                         ->where('nik',$tampil->nik)
                                         ->where('tanggal_mulai >=',date('Y-m-d',strtotime($tampil->tanggal_masuk)))
                                         ->where('tanggal_mulai <=',$tgl_terakhir)
                                         ->where('id_potong',1)
                                         ->get();
                  } else {
                    $izin_query = $this->db->select('*')
                                         ->from('tab_izin')
                                         ->where('nik',$tampil->nik)
                                         ->where('tanggal_mulai >=',$tgl_pertama)
                                         ->where('tanggal_mulai <=',$tgl_terakhir)
                                         ->where('id_potong',1)
                                         ->get();
                  }

                  $jml_izin = 0;
                  if ($izin_query<>false) {
                    foreach ($izin_query->result() as $row) {
                      $jml_izin += $row->lama;
                    }
                  }

                  $libur = $jml_absen + $jml_cuti + $jml_izin;

                  $dp_bln_lalu_real = $saldo_bln_lalu->saldo_dp;
                  if ($dp_bln_lalu_real!=NULL) {
                    $dp_bln_lalu_real = $dp_bln_lalu_real;
                  } else {
                    $dp_bln_lalu_real = 0;
                  }

                  $ekstra_query = $this->db->select('*')
                                         ->from('tab_extra')
                                         ->where('nik',$tampil->nik)
                                         ->where('tanggal_ekstra >=',$tgl_pertama)
                                         ->where('tanggal_ekstra <=',$tgl_terakhir)
                                         ->where('vakasi','Tambah DP Libur')
                                         ->get();

                  $jml_ekstra = 0;
                  if ($ekstra_query<>false) {
                    foreach ($ekstra_query->result() as $row) {
                      $jml_ekstra += $row->jumlah_vakasi;
                    }
                  }

                  if ($dp_bln_lalu_real>0) {
                    $adj_dp = 0 + $jml_ekstra;
                  } else {
                    $adj_dp = abs($jml_ekstra + $dp_bln_lalu_real);
                  }

                  if ($dp_bln_lalu_real>$libur&&$jatah_dp!=0) {
                    $adj_dp = $adj_dp - ($dp_bln_lalu_real - $libur);
                  }


                  if ($tampil->tanggal_masuk>=$tgl_pertama&&$tampil->tanggal_masuk<=$tgl_terakhir) {
                    $dp_bln_lalu = 0;
                  } else {
                    if ($saldo_bln_lalu->saldo_dp!=NULL) {
                      if ($saldo_bln_lalu->saldo_dp>0) {
                        $dp_bln_lalu = $saldo_bln_lalu->saldo_dp + $adj_dp; 
                      } else if ($adj_dp>$dp_bln_lalu_real) {
                        $dp_bln_lalu = $saldo_bln_lalu->saldo_dp + $adj_dp; 
                      } else {
                        $dp_bln_lalu = 0;
                      }
                    } else {
                      $dp_bln_lalu = 0;
                    }
                  }

                  $dp_bln_sekarang = ($jatah_dp + $dp_bln_lalu) - ($jml_absen + $jml_cuti + $jml_izin);

                  if ($dp_bln_sekarang<0) {
                    $minus_dp = $dp_bln_sekarang;
                  } else {
                    $minus_dp = 0;
                  }

                  if ($saldo_bln_lalu->saldo_cuti!=NULL) {
                    $cuti_bln_lalu = $saldo_bln_lalu->saldo_cuti;
                  } else {
                    $cuti_bln_lalu = 0;
                  }

                  if ($cuti_bln_lalu>0) {
                    $adj_cuti = 0;
                  }else{
                    $adj_cuti = abs($cuti_bln_lalu);
                  }

                  if ($cuti_bln_lalu>0) {
                    $cuti_awal = $tampil->saldo_cuti_awal;
                  } else {
                    $cuti_awal = 0;
                  }

                  $cuti_bln_sekarang = $cuti_awal + $minus_dp;

                  $data_new = array(
                  	'saldo_dp' => $dp_bln_sekarang,
                  	'saldo_cuti' => $cuti_bln_sekarang,
                  );

                  $this->db->where('nik',$tampil->nik);
                  $this->db->where('bulan',$bln_param);
                  $this->db->where('tahun',$thn_param);
                  $this->db->update('tab_master_dp',$data_new);

                  $no++;

		        }//END if
	      	}//END if
        }//END foreach
    }//END function update_dp_cuti
}