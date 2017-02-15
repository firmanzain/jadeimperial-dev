<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class BonusBaruController extends CI_Controller {
	public function __construct(){
		parent::__construct();
    	$this->auth->restrict();
    	error_reporting(E_ALL);
		$this->load->model('model_omset');
		$this->load->model('model_bonus_baru');
	}
	
	public function index(){
        if ($this->input->post('bln',true) == NULL) {
          $bln = date('m');
          $thn = date('Y');
        } else {
          $bln=$this->input->post('bln',true);
          $thn=$this->input->post('tahun',true); 
        }
        $data['bln'] = $bln;
        $data['thn'] = $thn;

	    $data['data'] = $this->model_bonus_baru->index($bln,$thn);
        $this->table->set_heading(array('NO', 'CABANG', 'JML KARYAWAN', 'OMSET STANDART', 'BONUS STANDART', 'OMSET REAL', 'TOTAL BONUS', 'BONUS DIBAGI', 'BONUS KEMBALI', 'APPROVEMENT', 'KETERANGAN', 'TINDAKAN'));
        $tmp=array('table_open'		=> '<table id="example-2" class="table table-hover table-striped table-bordered" >',
                   'thead_open'		=> '<thead>',
                   'thead_close'	=> '</thead>',
                   'tbody_open'		=> '<tbody>',
                   'tbody_close'	=> '</tbody>',
        );
        $this->table->set_template($tmp);
		$data['halaman'] = $this->load->view('bonusbaru/index', $data, true);
		$this->load->view('beranda',$data);
	}

    public function addData(){
    	if($_POST == NULL) {
            $data['cabang'] = $this->model_bonus_baru->cabang();
            $data['halaman']=$this->load->view('bonusbaru/create', $data, true);
        	$this->load->view('beranda',$data);
        } else {
            $this->proses_bonus();
        }
    }

    public function proses_bonus(){
      $omset        = str_replace(array('.'), array(''), $this->input->post('omset_real'));
      $cabang       = $this->input->post('cabang');
      $bulan_bonus  = $this->input->post('bulan_bonus');

      $query_omset_standart = $this->model_bonus_baru->omset_standart($cabang);
      foreach ($query_omset_standart->result() as $row) {
      	$omset_standart = $row->nominal_omset;
      }

      $data_omset = array(
      	'cabang' 			=> $cabang,
      	'omset_standart'	=> $omset_standart,
      	'omset_real' 		=> $omset,
      	'bulan_bonus' 		=> $bulan_bonus,
      	'approved' 			=> 0,
      	'keterangan' 		=> "",
      );
      $insert_omset = $this->model_bonus_baru->insert_omset($data_omset);

      $query_bonus = $this->model_bonus_baru->bonus($cabang,$bulan_bonus);
      if ($query_bonus <> false) {
      	foreach ($query_bonus->result() as $row) {
      		$bonus_real = $data_omset['omset_real'] * $row->nominal2 / $data_omset['omset_standart'];
      		if (date('Y-m-d',strtotime($row->tanggal_resign)) == NULL || date('Y-m-d',strtotime($row->tanggal_resign)) >= $data_omset['bulan_bonus'] && date('Y-m-d',strtotime($row->tanggal_sp)) == NULL || date('m',strtotime($row->tanggal_sp)) != (date('m',strtotime($data_omset['bulan_bonus'])) - 1) && date('Y',strtotime($row->tanggal_sp)) != (date('Y',strtotime($data_omset['bulan_bonus'])))) {
      			$total_kembali = 0;
      		} else {
      			$total_kembali = $bonus_real;
      		}

      		if ($total_kembali == 0) {
      			$total_diterima = $bonus_real;
      		} else {
      			$total_diterima = 0;
      		}
      		
      		$data_bonus = array(
      			'nik' 					=> $row->nik,
      			'omset' 				=> $insert_omset->output,
      			'bonus_standart' 		=> $row->nominal2,
      			'bonus_real' 			=> $bonus_real,
      			'total_kembali' 		=> $total_kembali,
      			'total_diterima' 		=> $total_diterima,
      			'total_bulat_diterima' 	=> intval($total_diterima / 1000) * 1000,
	            'entry_user'    		=> $this->session->userdata('username'),
	            'entry_date'    		=> date('Y-m-d H:i:s'),
      		);
      		// print_r($data_bonus);
      		$insert_bonus = $this->model_bonus_baru->insert_bonus($data_bonus);
      	}
      }

      redirect('BonusBaru');
    }

  public function deleteData($id,$bln,$thn){
      $query = $this->model_bonus_baru->delete($id, $bln, $thn);
      redirect('BonusBaru');
  }  

  public function detailData($id,$bln,$thn){
    $data['data'] = $this->model_bonus_baru->detail($id, $bln, $thn);
    $this->table->set_heading(array('NO', 'NIK', 'NAMA', 'BONUS STANDART', 'BONUS REAL', 'BONUS DIBAGI', 'BONUS KEMBALI', 'BONUS BULAT DITERIMA', 'APPROVEMENT', 'KETERANGAN'));
    $tmp = array('table_open' => '<table id="example-2" class="table table-hover table-striped table-bordered" >',
               'thead_open'   => '<thead>',
               'thead_close'  => '</thead>',
               'tbody_open'   => '<tbody>',
               'tbody_close'  => '</tbody>',
            );
    $this->table->set_template($tmp);
    $query_cabang = $this->db->where('id_cabang',$id)->get('tab_cabang');
    foreach ($query_cabang->result() as $row) {
      $data['cabang'] = $row->cabang; 
    }
    $data['bln'] = $bln;
    $data['thn'] = $thn;
    $data['halaman'] = $this->load->view('bonusbaru/detail', $data, true);
    $this->load->view('beranda',$data);
  }

  public function approvIndex(){
    if ($this->input->post('bln',true) == NULL) {
      $bln = date('m');
      $thn = date('Y');
    } else {
      $bln=$this->input->post('bln',true);
      $thn=$this->input->post('tahun',true); 
    }
    $data['bln'] = $bln;
    $data['thn'] = $thn;

  $data['data'] = $this->model_bonus_baru->index($bln,$thn);
    $this->table->set_heading(array('NO', 'CABANG', 'JML KARYAWAN', 'OMSET STANDART', 'BONUS STANDART', 'OMSET REAL', 'TOTAL BONUS', 'BONUS DIBAGI', 'BONUS KEMBALI', 'APPROVEMENT', 'KETERANGAN', 'TINDAKAN'));
    $tmp=array('table_open'   => '<table id="example-2" class="table table-hover table-striped table-bordered" >',
               'thead_open'   => '<thead>',
               'thead_close'  => '</thead>',
               'tbody_open'   => '<tbody>',
               'tbody_close'  => '</tbody>',
    );
    $this->table->set_template($tmp);
    $data['halaman'] = $this->load->view('bonusbaru/approve', $data, true);
    $this->load->view('beranda',$data);
  }

  public function approveData($type){
    if ($type == 2) {
      for($i=0; $i<sizeof($this->input->post('iddet', TRUE)); $i++){
        $where['data'][] = array(
          'column' => 'id_omset',
          'param'  => $_POST['iddet'][$i]
        );
        $where2['data'][] = array(
          'column' => 'omset',
          'param'  => $_POST['iddet'][$i]
        );
        $data = array(
          'approved'    => 2,
          'keterangan'  => "Disetujui",
          "entry_user"  => $this->session->userdata('username'),
          'entry_date'  => date('Y-m-d H:i:s')
        );
        $approve = $this->model_bonus_baru->approve($where,$where2,$data);
      }
    } else if ($type == 1) {
      $id = $this->input->post('id');
      $ket = $this->input->post('keterangan');
      $where['data'][] = array(
        'column' => 'id_omset',
        'param'  => $id
      );
      $where2['data'][] = array(
        'column' => 'omset',
        'param'  => $id
      );
      $data = array(
        'approved'    => 1,
        'keterangan'  => "Tidak Disetujui",
        "entry_user"  => $this->session->userdata('username'),
        'entry_date'  => date('Y-m-d H:i:s')
      );
      $approve = $this->model_bonus_baru->approve($where,$where2,$data);
    }
    redirect('Aprov/BonusBaru');
  }

  public function cancelapproveData(){

    $data = array(
      'approved'  => 0,
      'keterangan' => "Cancel Approve",
      "entry_user" => $this->session->userdata('username'),
      'entry_date' => date('Y-m-d H:i:s')
    );
    $this->db->where('month(bulan_bonus)', $_POST['bln']);
    $this->db->where('year(bulan_bonus)', $_POST['thn']);
    $this->db->update('tab_omset_baru', $data);
    $this->db->where('omset', $this->db->insert_id());
    $this->db->update('tab_bonus_karyawan_baru', $data);

    redirect('Aprov/BonusBaru');
  }

  public function rekapIndex(){
    if ($this->input->post('bln',true) == NULL) {
      $bln = date('m');
      $thn = date('Y');
    } else {
      $bln=$this->input->post('bln',true);
      $thn=$this->input->post('tahun',true); 
    }
    $data['bln'] = $bln;
    $data['thn'] = $thn;

  $data['data'] = $this->model_bonus_baru->index($bln,$thn);
    $this->table->set_heading(array('NO', 'CABANG', 'JML KARYAWAN', 'OMSET STANDART', 'BONUS STANDART', 'OMSET REAL', 'TOTAL BONUS', 'BONUS DIBAGI', 'BONUS KEMBALI', 'APPROVEMENT', 'KETERANGAN', 'TINDAKAN'));
    $tmp=array('table_open'   => '<table id="example-2" class="table table-hover table-striped table-bordered" >',
               'thead_open'   => '<thead>',
               'thead_close'  => '</thead>',
               'tbody_open'   => '<tbody>',
               'tbody_close'  => '</tbody>',
    );
    $this->table->set_template($tmp);
    $data['halaman'] = $this->load->view('bonusbaru/rekap', $data, true);
    $this->load->view('beranda',$data);
  }

  public function rekapData(){

    if ($this->input->post('bln',true) == NULL) {
      $bln = date('m');
      $thn = date('Y');
    } else {
      $bln=$this->input->post('bln',true);
      $thn=$this->input->post('thn',true); 
    }

    header("Content-type: application/x-msdownload");
    header("Content-Disposition: attachment; filename=DATA_BONUS_KARYAWAN_".$this->format->BulanIndo($bln).".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $data = $this->model_bonus_baru->index($bln,$thn);
    $this->table->set_heading(array('NO', 'CABANG', 'JML KARYAWAN', 'OMSET STANDART', 'BONUS STANDART', 'OMSET REAL', 'TOTAL BONUS', 'BONUS DIBAGI', 'BONUS KEMBALI', 'APPROVEMENT', 'KETERANGAN'));
    $tmp=array('table_open'   => '<table id="example-2" class="table table-hover table-striped table-bordered" >',
               'thead_open'   => '<thead>',
               'thead_close'  => '</thead>',
               'tbody_open'   => '<tbody>',
               'tbody_close'  => '</tbody>',
    );
    $this->table->set_template($tmp);

    if($data == true){
        $no=1;

        foreach ($data->result() as $tampil){
          if ($tampil->approved == 0) {
            $approved = "Belum";
            $delete_btn = "";
          } else if ($tampil->approved == 1) {
            $approved = "Tidak Disetujui";
            $delete_btn = "disabled";
          } else if ($tampil->approved == 2) {
            $approved = "Disetujui";
            $delete_btn = "disabled";
          }

          $this->table->add_row($no,$tampil->cabang,$tampil->jml_karyawan,$this->format->indo($tampil->omset_standart),$this->format->indo($tampil->bonus_standart),$this->format->indo($tampil->omset_real),$this->format->indo($tampil->bonus_real),$this->format->indo($tampil->total_diterima),$this->format->indo($tampil->total_kembali),$approved,$tampil->keterangan);
          $no++;
        }

        $tabel=$this->table->generate();
        echo $tabel;
    }
    else 
    {
      echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
    }
      exit();
  } 

  public function detailDataRekap($id,$bln,$thn){
    $data['data'] = $this->model_bonus_baru->detail($id, $bln, $thn);
    $this->table->set_heading(array('NO', 'NIK', 'NAMA', 'BONUS STANDART', 'BONUS REAL', 'BONUS DIBAGI', 'BONUS KEMBALI', 'BONUS BULAT DITERIMA', 'APPROVEMENT', 'KETERANGAN'));
    $tmp = array('table_open' => '<table id="example-2" class="table table-hover table-striped table-bordered" >',
               'thead_open'   => '<thead>',
               'thead_close'  => '</thead>',
               'tbody_open'   => '<tbody>',
               'tbody_close'  => '</tbody>',
            );
    $this->table->set_template($tmp);
    $query_cabang = $this->db->where('id_cabang',$id)->get('tab_cabang');
    foreach ($query_cabang->result() as $row) {
      $data['cabang'] = $row->cabang; 
    }
    $data['bln'] = $bln;
    $data['thn'] = $thn;
    $data['id_cabang'] = $id; 
    $data['halaman'] = $this->load->view('bonusbaru/detailRekap', $data, true);
    $this->load->view('beranda',$data);
  }

  public function rekapDataDetail(){

    $bln=$this->input->post('bln',true);
    $thn=$this->input->post('thn',true); 
    $cabang=$this->input->post('cabang',true);

    header("Content-type: application/x-msdownload");
    header("Content-Disposition: attachment; filename=DATA_BONUS_KARYAWAN_DETAIL_".$this->format->BulanIndo($bln).".xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $data = $this->model_bonus_baru->detail($cabang, $bln, $thn);
    $this->table->set_heading(array('NO', 'NIK', 'NAMA', 'BONUS STANDART', 'BONUS REAL', 'BONUS DIBAGI', 'BONUS KEMBALI', 'BONUS BULAT DITERIMA', 'APPROVEMENT', 'KETERANGAN'));
    $tmp = array('table_open' => '<table id="example-2" class="table table-hover table-striped table-bordered" >',
               'thead_open'   => '<thead>',
               'thead_close'  => '</thead>',
               'tbody_open'   => '<tbody>',
               'tbody_close'  => '</tbody>',
            );
    $this->table->set_template($tmp);

    if($data == true){
        $no=1;
        $sum_bonus_standart = 0;
        $sum_bonus_real = 0;
        $sum_total_diterima = 0;
        $sum_total_kembali = 0;
        $sum_total_bulat_diterima = 0;

        foreach ($data->result() as $tampil){
          if ($tampil->nik!=NULL) {
          if ($tampil->approved == 0) {
            $approved = "Belum";
            $delete_btn = "";
          } else if ($tampil->approved == 1) {
            $approved = "Tidak Disetujui";
            $delete_btn = "disabled";
          } else if ($tampil->approved == 2) {
            $approved = "Disetujui";
            $delete_btn = "disabled";
          }

          //SUM
          $sum_bonus_standart += $tampil->bonus_standart;
          $sum_bonus_real += $tampil->bonus_real;
          $sum_total_diterima += $tampil->total_diterima;
          $sum_total_kembali += $tampil->total_kembali;
          $sum_total_bulat_diterima += $tampil->total_bulat_diterima;

          $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$this->format->indo($tampil->bonus_standart),$this->format->indo($tampil->bonus_real),$this->format->indo($tampil->total_diterima),$this->format->indo($tampil->total_kembali),$this->format->indo($tampil->total_bulat_diterima),$approved,$tampil->keterangan);
          $no++;
          }
        }
        $this->table->add_row('',array('data'=>'<b>Total</b>','colspan'=>'2'),$this->format->indo($sum_bonus_standart),$this->format->indo($sum_bonus_real),$this->format->indo($sum_total_diterima),$this->format->indo($sum_total_kembali),$this->format->indo($sum_total_bulat_diterima),'','');
        $tabel=$this->table->generate();
        echo $tabel;
    }
    else 
    {
      echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
    }
      exit();
  } 

}