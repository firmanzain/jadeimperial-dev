<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LiburController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
		$this->load->model('model_libur');
		$this->load->library('PHPExcel');
		$this->load->library('PHPExcel/IOFactory');
	}
	
	  public function index()
	  {
        /*if ($this->input->post('bln',true)==NULL) {
          $bln = date('m');
          $thn = date('Y');
        } else {
          $bln = $this->input->post('bln',true);
          $thn = $this->input->post('thn',true); 
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

	      $data['data']=$this->model_libur->index($tgl1,$tgl2);
	      $this->table->set_heading(array('<input type=checkbox name=cekall id=cekall onclick="return checkedAll(form_data);">','NO','TANGGAL','HARI','KETERANGAN','MENAMBAH DP','LAMA','TANGGAL INPUT','TINDAKAN'));
	      $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
	        			'thead_open'=>'<thead>',
        				'thead_close'=> '</thead>',
        				'tbody_open'=> '<tbody>',
        				'tbody_close'=> '</tbody>',
        		);
	        $this->table->set_template($tmp);
		$data['halaman']=$this->load->view('liburan/index',$data,true);
		$this->load->view('beranda',$data);
	  }

	  public function create()
	  {
	      if ($this->input->post()) {
	      	$this->save();
	      } else {
	      	$data['halaman']=$this->load->view('liburan/create','',true);
	      	$this->load->view('beranda',$data);
	  	  }
	  }

	  public function save(){
	  	$data = array(
                  'tanggal_mulai' => date(('Y-m-d'),strtotime($this->input->post('tanggal1'))),
                  'tanggal_selesai' =>$this->input->post('tanggal2'),
                  'cuti_khusus' =>$this->input->post('cuti'),
				  'keterangan' =>$this->input->post('keterangan'),
				  'lama' =>$this->selisih_hari($this->input->post('tanggal2'),$this->input->post('tanggal1')),
                'entry_date' => date('Y-m-d H:i:s'),
                'entry_user' => $this->session->userdata('nama')				  
                );
	    $this->model_libur->add($data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('liburan');
	  }

	public function selisih_hari($h1,$h2)
	{
		$s1=(((abs(strtotime ($h2) - strtotime ($h1)))/(60*60*24))+1);
		return $s1;
	}

	public function import_data()
	  {
	      if ($this->input->post()) {
	      	$this->go_import();
	      } else {
	      	$this->load->view('import/import_liburan');
	  	  }
	  }

	  public function go_import()
    {
    	$config['upload_path'] = './temp_upload/';
  		$config['allowed_types'] = 'xls';
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
      	for ($i = 1; $i <= $data['numRows']; $i++) {
                   if ($data['cells'][$i][1] == '')
                       break;
                   $dataexcel[$i - 1]['tanggal_mulai'] = $data['cells'][$i][1];
                   $dataexcel[$i - 1]['tanggal_selesai'] = $data['cells'][$i][2];
                   $dataexcel[$i - 1]['cuti_khusus'] = $data['cells'][$i][3];
                   $dataexcel[$i - 1]['keterangan'] = $data['cells'][$i][5];
                   $dataexcel[$i - 1]['lama'] = $data['cells'][$i][6];
              }
        $this->model_libur->import_data($dataexcel);
		//    jika kosongkan data dicentang jalankan kode berikut
	   	$file = $upload_data['file_name'];
        $path = './temp_upload/'.$file;
        unlink($path);
	   	echo "<script>window.opener.location.reload();window.close()</script>";
    	}
    }

	public function edit($id)
	  {
	     if ($this->input->post()) {
	     	$this->update();
	     }else{
		     $data['data']=$this->model_libur->find($id);
		     if ($data==true) {
		     	$data['halaman']=$this->load->view('liburan/update',$data,true);
		     	$this->load->view('beranda',$data);
		     }else{
		     	show_404();
		     }
		 }
	  }

  	public function update(){
	  	$id=$this->input->post('id');
	  	$data = array(
                  'tanggal_mulai' => $this->input->post('tanggal1'),
                  'tanggal_selesai' =>$this->input->post('tanggal2'),
                  'cuti_khusus' =>$this->input->post('cuti'),
				  'keterangan' =>$this->input->post('keterangan'),
				  'lama' =>$this->selisih_hari($this->input->post('tanggal2'),$this->input->post('tanggal1'))
                );
	    $this->model_libur->update($id,$data);
	    $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Disimpan</div>");
	    redirect('liburan');
	}
	
	public function hapus(){
		if(!empty($_POST['cb_data'])){
			$jml=count($_POST['cb_data']);
			for($i=0;$i<$jml;$i++){
				$id=$_POST['cb_data'][$i];
				$query_cari = $this->db->query(
					'select * from tab_hari_libur 
					where id='.$id.' and cuti_khusus="Ya"'
				);
				if ($query_cari->result()<>false) {
					foreach ($query_cari as $val) {
						$query_update = $this->db->query(
							'update tab_master_dp set saldo_dp=saldo_dp+'.$val->lama.'
							where bulan='.date('m',strtotime($val->tanggal_mulai)).' 
							and tahun='.date('Y',strtotime($val->tanggal_mulai))
						);
					}
				}

				$hapus=$this->model_libur->delete($id);
			}
	     $this->session->set_flashdata("pesan", "<div class=\"alert alert-success\" role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'> <span aria-hidden='true'>×</span>  <span class='sr-only'>Close</span></button> Data Berhasil Dihapus Sebanyak $hapus</div>");
		}
		redirect('liburan','refresh');
	}

/*
1. Tentukan tujuannya
2. Susun alghoritma
3. Buat logicnya
*/

	public function generate_dp(){
		$bln = $this->input->post("bulan"); // option bulan
		$thn = $this->input->post("tahun"); // option tahun

		// CARI JUMLAH DP
		$hari_ini = $thn.'-'.$bln; // misal 8-2016 (sekarang)
		$tgl_pertama 	= date('Y-m-01', strtotime($hari_ini)); // awal bulan
		$tgl_terakhir 	= date('Y-m-t', strtotime($hari_ini)); // akhir bulan

		$detik = 24 * 3600; // jumlah detik dalam 1 hari

		$tgl_awal 	= strtotime($tgl_pertama);
		$tgl_akhir 	= strtotime($tgl_terakhir);

		$minggu = 0;
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
			where tanggal_mulai>="'.$tgl_pertama.'" and tanggal_selesai<="'.$tgl_terakhir.'" 
			and cuti_khusus="Ya" and id_generate=0
			'
		);


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


		$dp_new = $jml_libur+$minggu;

		$response['jml'] = $dp_new;
		//END CARI JUMLAH DP



		$check = $this->db->query(
			'
			select * from tab_master_dp where bulan='.$bln.' 
			and tahun='.$thn.'
			'
		);

		if ($check->result()<>null) { // jika data ditemukan

			$response['info'] = "Update";

			foreach ($check->result() as $val) {

				$karyawan = $this->db->query(
					'
					SELECT a.* 
					FROM tab_karyawan a 
					INNER JOIN tab_jadwal_karyawan b 
					ON b.nik=a.nik 
					GROUP BY a.nik
					'
				);
				
				foreach ($karyawan->result() as $val2) {
					if ($val2->nik==$val->nik) {
						$dp_old = $val->saldo_dp;
						$data = array (
							'saldo_dp' => $dp_old+$jml_libur
						);

						$this->db->where('bulan', $bln);
						$this->db->where('tahun', $thn);
						$this->db->where('nik', $val2->nik);
						$this->db->update('tab_master_dp', $data);
					}
				}
			}
			

			$data2 = array(
			    'id_generate' => '1'
			);

			$this->db->where('tanggal_mulai >=', $tgl_pertama);
			$this->db->where('tanggal_selesai <=', $tgl_terakhir);
			$this->db->update('tab_hari_libur', $data2);
		} else {
			$response['info'] = "Insert";
			$karyawan = $this->db->query(
				'
				SELECT a.* 
				FROM tab_karyawan a 
				INNER JOIN tab_jadwal_karyawan b 
				ON b.nik=a.nik 
				GROUP BY a.nik
				'
			);
			foreach ($karyawan->result() as $val) {

				if ($bln == 1) {
					$thn = $thn - 1;
					$bln = 13;
				}

				$check2 = $this->db->query(
					'
					select * from tab_master_dp where bulan='.($bln-1).' 
					and tahun='.$thn.' and nik="'.$val->nik.'"
					'
				);

				if ($check2) {
					foreach ($check2->result() as $val2) {
						$dp_old = $val2->saldo_dp;
						$cuti_old = $val2->saldo_cuti;
					}
				} else {
					$dp_old = $val2->saldo_dp;
					$cuti_old = 12;
				}

				$bln = $this->input->post("bulan"); // option bulan
				$thn = $this->input->post("tahun"); // option tahun

				if ($bln == 1) {
					$cuti_old += 12;
				}
				if ($bln == 4 && $cuti_old > 12) {
					$cuti_old = 12;
				}

				$data = array(
					'nik' 				=> $val->nik,
					'bulan' 			=> $bln,
					'tahun' 			=> $thn,
					'saldo_dp_awal'		=> $dp_old+$dp_new,
					'saldo_cuti_awal' 	=> $cuti_old,
					'saldo_dp' 			=> $dp_old+$dp_new,
					'saldo_cuti' 		=> $cuti_old,
					'keterangan'		=> "Auto Generate",
					'entry_date' 		=> date('Y-m-d H:i:s'),
					'entry_user' 		=> $this->session->userdata('nama')
				);
				$this->db->insert('tab_master_dp', $data);
			}
			
			$data2 = array(
			    'id_generate' => '1'
			);

			$this->db->where('tanggal_mulai >=', $tgl_pertama);
			$this->db->where('tanggal_selesai <=', $tgl_terakhir);
			$this->db->update('tab_hari_libur', $data2);
		}

		// $response['data'] = $data;
		$response['status'] = '200';
		echo json_encode($response);
	}
}