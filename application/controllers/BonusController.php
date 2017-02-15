<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class BonusController extends CI_Controller{
    //put your code here
     public function __construct()
    {
        parent::__construct();
    $this->load->model('bonus');
    $this->load->library('PHPExcel');
    $this->load->library('PHPExcel/IOFactory');
    $this->load->library('mpdf');
        $this->auth->restrict();
    } 
    
    // when bonus menu clicked
   function index(){
        if ($this->input->post('bln',true)==NULL) {
          $bln = date('m');
          $thn = date('Y');
        } else {
          $bln=$this->input->post('bln',true);
          $thn=$this->input->post('tahun',true); 
        }
        $data['bln'] = $bln;
        $data['thn'] = $thn;

        $data['data']=$this->bonus->index($bln,$thn);
        $this->table->set_heading(array('NO','PLANT','JUMLAH KARYAWAN','JUMLAH OMSET','BONUS BRUTO','MPD','L&B','BONUS PERSEN','BONUS NOMINAL','BONUS PURE','BONUS PER POINT','BONUS PRORATA','APRROVEMENT','KETERANGAN','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('bonusView/index',$data,true);
        $this->load->view('beranda',$data);
    } 

    // when add button is clicked
   function create(){
    if($_POST==NULL){
            $data['cabang'] = $this->bonus->cabang();
            $data['halaman']=$this->load->view('bonusView/create',$data,true);
        $this->load->view('beranda',$data);
        }
        else{
            $this->proses_bonus();
        }
    }

    // when save button is clicked
    public function proses_bonus()
      {
        //error_reporting(E_ALL);
          $persen_bonus = $this->input->post('bonus_cabang');
          $persen_mpd   = $this->input->post('bonus_mpd');
          $persen_lb    = $this->input->post('bonus_lb');
          $omset        = str_replace('.','',$this->input->post('omset'));
          $cabang       = $this->input->post('cabang');
          $bulan_bonus  = $this->input->post('bulan_bonus');
          //$data_cabang  = $this->bonus->bonus_cabang($this->input->post('cabang'));
          /*if($data_cabang->total_persentase=='0') $jml_persen=0; else $jml_persen=$omset*$data_cabang->total_persentase/100;
          
          $bonus_awal=$omset*$persen_bonus/100;
          $bonus_min_1=($bonus_awal-$data_cabang->total_nominal);
          $bns_mpd=$bonus_awal*$persen_mpd/100;
          $bns_lb=$bonus_awal*$persen_lb/100;
          $pure_bonus=($bonus_min_1-$bns_mpd-$bns_lb)/2;
          $bonus_prosen=$jml_persen;
          $bonus_prota=$pure_bonus/$data_cabang->jml_karyawan;
          $bonus_point=($pure_bonus > 0 && $data_cabang->total_senioritas+$data_cabang->total_grade > 0)?$pure_bonus/(round($data_cabang->total_senioritas+$data_cabang->total_grade,0)):0;
          $data=array( "prosen_mpd" => $bns_mpd,
                       "prosen_point" => $bonus_point,
                       "prosen_lb" => $bns_lb,
                       "prosen_bonus" => $bonus_prosen,
                       "bonus_prota" => $bonus_prota,
                       "brutto_bonus" => $bonus_awal,
                       "omset" => $omset,
                       "cabang" => $this->input->post('cabang'),
                       "entry_user" => $this->session->userdata('username'),
                       "include_pph" => $this->input->post('pph'),
                       "pure_bonus" => $pure_bonus*2,
                    );
          $this->bonus->save_bonusCabang($data);*/
          $check_cabang = $this->db->query(
            'select * from tab_cabang where status="Aktif" and id_cabang!=2'
          );
          $jml_cabang = $check_cabang->num_rows();
          
          if ($cabang==1) {
            $sum_query = $this->db->query('
              select sum(b.persentase) as jml1, sum(b.nominal) as jml2 
              from tab_karyawan a 
              inner join tab_master_bonus b on b.nik = a.nik 
              where a.cabang='.$cabang.' or a.cabang=2 and a.nik!="9200001"
            ');
          } else {
            $sum_query = $this->db->query('
              select sum(b.persentase) as jml1, sum(b.nominal) as jml2 
              from tab_karyawan a 
              inner join tab_master_bonus b on b.nik = a.nik 
              where a.cabang='.$cabang.' or a.cabang=2
            ');
          }
          foreach ($sum_query->result() as $val) {
            $prosen   = $val->jml1;
            $nominal  = $val->jml2; 
          }
          $sum_query2 = $this->db->query('
            select sum(b.persentase) as jml1, sum(b.nominal) as jml2 
            from tab_karyawan a 
            inner join tab_master_bonus b on b.nik = a.nik 
            LEFT JOIN tab_sp e ON e.nik = a.nik 
            where a.cabang=2
          ');
          foreach ($sum_query2->result() as $val) {
            $prosen2   = $val->jml1;
            $nominal2  = $val->jml2; 
          }
          $hari_ini   = date('Y-m-d', strtotime($bulan_bonus));
          $tgl_awal   = date('Y-m-01', strtotime($hari_ini));
          $tgl_akhir  = date('Y-m-t', strtotime($hari_ini));
          $bln        = date('m', strtotime($hari_ini));
          /*echo $tgl_awal;
          echo "<br>";
          echo $tgl_akhir;
          echo "<br>";*/
          $karyawan = $this->db->query(
            'select a.*,a.nik as nik_real,b.*,c.*,d.*,d.nik as nik_resign, e.nik as nik_sp  
            from tab_karyawan a 
            inner join tab_history_kontrak_kerja b on b.nik = a.nik 
            inner join tab_master_bonus c on c.nik = a.nik 
            left join tab_resign d on d.nik = a.nik
            LEFT JOIN tab_sp e ON e.nik = a.nik 
            where 
              a.nik!="9100001" AND (a.cabang='.$cabang.' OR a.cabang=2) and d.nik is null 
              AND b.tanggal_masuk <= "'.$tgl_awal.'"
            or 
              a.nik!="9100001" AND (a.cabang='.$cabang.' OR a.cabang=2) AND b.tanggal_resign >= "'.$tgl_awal.'" 
              AND b.tanggal_masuk < "'.$tgl_awal.'"
            or 
              a.nik!="9100001" AND (a.cabang='.$cabang.' OR a.cabang=2) AND b.tanggal_masuk < "'.$tgl_awal.'" 
              AND b.tanggal_masuk > b.tanggal_resign
            GROUP BY a.nik'
          );
          $jml_karyawan = 0;
          $jml_total_point = 0;
          foreach ($karyawan->result() as $val) {

          //if ($val->nik_resign==NULL||$tgl_awal<$val->tanggal_resign||$val->tanggal_masuk>$tgl_awal&&$val->tanggal_masuk>$tanggal_resign&&$tgl_awal<$val->tanggal_resign) {

        // if ($val->nik_resign==NULL||date('m',strtotime($tgl_awal))<=date('m',strtotime($val->tanggal_resign))||date('m',strtotime($tgl_awal))>date('m',strtotime($val->tanggal_masuk))&&$val->tanggal_masuk>$val->tanggal_resign) {

              if ($val->persentase==0) {
                $jml_karyawan++;
                $jml_grade = 0; $jml_grade_point = 0;
                $jml_grade = $val->grade;
                $jml_grade_point = (($val->grade * 2) + 2);
                //MENCARI SENIORITAS
                if (date_format(new DateTime($val->tanggal_masuk), 'd')>1) {
                  //$tgl_set = date_format(new DateTime($val->tanggal_masuk), 'Y').'-'.(date_format(new DateTime($val->tanggal_masuk), 'm')+1).'-'.date_format(new DateTime($val->tanggal_masuk), 'd');
                  $tgl_set = strtotime($val->tanggal_masuk);
                  $tgl_new = date('Y-m-d', strtotime('+1 month',$tgl_set));
                } else {
                  $tgl_new = $val->tanggal_masuk;
                }
                // echo "Tgl Masuk : ".$val->tanggal_masuk;
                if (date('m', strtotime($tgl_new))>$bln) {
                  $senioritas = $hari_ini - $tgl_new - 1;
                } else {
                  $senioritas = $hari_ini - $tgl_new;
                }
                if ($senioritas<1||$val->status_kerja!="Tetap") {
                  $senioritas = 0;
                }
                //END SENIORITAS
                if ($val->cabang=='2') {
                  $total_point = ((($jml_grade * $jml_grade_point) + $senioritas)/$jml_cabang);
                  $jml_total_point = $jml_total_point + $total_point;
                } else {
                  if ($val->nik_real=="9100069"||$val->nik_real=="9300027"||$val->nik_real=="9100095"||$val->nik_real=="9100099"||$val->nik_real=="9100084"||$val->nik_real=="9100098") {
                    $total_point = ((($jml_grade * $jml_grade_point) + $senioritas)/$jml_cabang);
                    $jml_total_point = $jml_total_point + $total_point;
                  } else {
                    $total_point = (($jml_grade * $jml_grade_point) + $senioritas);
                    $jml_total_point = $jml_total_point + $total_point; 
                  }
                }
                // echo "<br>";
                // echo "Hari ini : ".$hari_ini;
                // echo "<br>";
                // echo "Tgl New : ".$tgl_new;
                // echo "<br>";
                echo $val->nama_ktp;
                echo "<br>";
                // echo "Grade ".$jml_grade;
                // echo "<br>";
                // echo "Point ".$jml_grade_point;
                // echo "<br>";
                // echo "Senioritas ".$senioritas;
                // echo "<br>";
                // echo $total_point;
                // echo "<br>";
                // echo "<hr>";
              }

          // }

          }//END FOREACH
          //JIKA GENERATE GM
          if ($cabang==1) {
            $karyawan2 = $this->db->query(
              'select a.*,a.nik as nik_real,b.*,c.*,d.*,d.nik as nik_resign, e.nik as nik_sp  
              from tab_karyawan a 
              inner join tab_history_kontrak_kerja b on b.nik = a.nik 
              inner join tab_master_bonus c on c.nik = a.nik 
              left join tab_resign d on d.nik = a.nik 
              LEFT JOIN tab_sp e ON e.nik = a.nik 
              where (a.nik="9100069" or a.nik="9300027" or a.nik="9100095" 
              or a.nik="9100099" or a.nik="9100084" or a.nik="9100098")
              GROUP BY a.nik'
            );
            foreach ($karyawan2->result() as $val) {
            //MANUAL IF
            // if ($val->nik_resign==NULL||date('m',strtotime($tgl_awal))<=date('m',strtotime($val->tanggal_resign))||date('m',strtotime($tgl_awal))>date('m',strtotime($val->tanggal_masuk))&&$val->tanggal_masuk>$val->tanggal_resign) {
                if ($val->persentase==0) {
                  $jml_karyawan++;
                  $jml_grade = 0; $jml_grade_point = 0;
                  $jml_grade = $val->grade;
                  $jml_grade_point = (($val->grade * 2) + 2);
                  //MENCARI SENIORITAS
                  if (date_format(new DateTime($val->tanggal_masuk), 'd')>1) {
                    //$tgl_set = date_format(new DateTime($val->tanggal_masuk), 'Y').'-'.(date_format(new DateTime($val->tanggal_masuk), 'm')+1).'-'.date_format(new DateTime($val->tanggal_masuk), 'd');
                    $tgl_set = strtotime($val->tanggal_masuk);
                    $tgl_new = date('Y-m-d', strtotime('+1 month',$tgl_set));
                  } else {
                    $tgl_new = $val->tanggal_masuk;
                  }
                  // echo "Tgl Masuk : ".$val->tanggal_masuk;
                  if (date('m', strtotime($tgl_new))>$bln) {
                    $senioritas = $hari_ini - $tgl_new - 1;
                  } else {
                    $senioritas = $hari_ini - $tgl_new;
                  }
                  if ($senioritas<1||$val->status_kerja!="Tetap") {
                    $senioritas = 0;
                  }
                  //END SENIORITAS
                  $total_point = ((($jml_grade * $jml_grade_point) + $senioritas)/$jml_cabang);
                  $jml_total_point = $jml_total_point + $total_point;
                  // echo "<br>";
                  // echo "Hari ini : ".$hari_ini;
                  // echo "<br>";
                  // echo "Tgl New : ".$tgl_new;
                  // echo "<br>";
                  echo $val->nama_ktp;
                  echo "<br>";
                  // echo "Grade ".$jml_grade;
                  // echo "<br>";
                  // echo "Point ".$jml_grade_point;
                  // echo "<br>";
                  // echo "Senioritas ".$senioritas;
                  // echo "<br>";
                  // echo $total_point;
                  // echo "<br>";
                  // echo "<hr>";
                }
              // }
          }
          }//END FOREACH
          echo "Point : ".$jml_total_point."<br>";
          echo "Karyawan : ".$jml_karyawan."<br>";
          $bruto = intval($omset * $persen_bonus/100);
          $pure = $bruto - (($bruto * $persen_mpd)/100) - (($bruto * $persen_lb)/100) - (($omset * $prosen)/100) - $nominal;
          $data = array(
            'cabang'        => $cabang, 
            'omset'         => $omset,
            'bulan_bonus'   => $bulan_bonus,
            'prosen_bonus'  => $persen_bonus,
            'bruto'         => $bruto,
            'prosen_mpd'    => $persen_mpd,
            'prosen_lb'     => $persen_lb,
            'bonus_prosen'  => ($omset * $prosen)/100,
            'bonus_nominal' => $nominal,
            'bonus_pure'    => $pure,
            'total_point'   => $jml_total_point,
            'bonus_point'   => ($pure/2) / $jml_total_point,
            'bonus_prorata' => ($pure/2) / $jml_karyawan,
            'approved'      => "Belum",
            'keterangan'    => "Auto Generate",
            'include_pph'   => $this->input->post('pph'),
            'entry_user'    => $this->session->userdata('username'),
            'entry_date'    => date('Y-m-d H:i:s')
          );
          // print_r($data);
          //INSERT KE TAB OMSET
          $this->db->insert('tab_omset', $data);
          $id_omset = $this->db->insert_id();
          //INSERT KE JCR
          $check_jcr = $this->db->query(
            'select * from tab_omset 
            where cabang=2 and bulan_bonus>="'.$tgl_awal.'" 
            and bulan_bonus<="'.$tgl_akhir.'"'
          );
          if ($check_jcr->result()<>false) {
            foreach ($check_jcr->result() as $val) {
              $data2 = array(
                'bonus_nominal' => $val->nominal + $nominal2,
                'bonus_point'   => $val->bonus_point + (($pure/2) / $jml_total_point),
                'bonus_prorata' => $val->bonus_prorata + (($pure/2) / $jml_karyawan),
                'approved'      => "Belum",
                'keterangan'    => "Auto Generate",
                'include_pph'   => $this->input->post('pph'),
                'entry_user'    => $this->session->userdata('username'),
                'entry_date'    => date('Y-m-d H:i:s')
              );
              $this->db->where('cabang', $val->cabang);
              $this->db->update('tab_omset', $data2);
              $id_omset2 = $val->id_cabang;
            }
          } else {
            $data2 = array(
              'cabang'        => '2', 
              'omset'         => '0',
              'bulan_bonus'   => $bulan_bonus,
              'prosen_bonus'  => '0',
              'bruto'         => '0',
              'prosen_mpd'    => '0',
              'prosen_lb'     => '0',
              'bonus_prosen'  => '0',
              'bonus_nominal' => $nominal2,
              'bonus_pure'    => '0',
              'total_point'   => '0',
              'bonus_point'   => ($pure/2) / $jml_total_point,
              'bonus_prorata' => ($pure/2) / $jml_karyawan,
              'approved'      => "Belum",
              'keterangan'    => "Auto Generate",
              'include_pph'   => $this->input->post('pph'),
              'entry_user'    => $this->session->userdata('username'),
              'entry_date'    => date('Y-m-d H:i:s')
            );
            $this->db->insert('tab_omset', $data2);
            $id_omset2 = $this->db->insert_id();
          }
          //GET TABEL OMSET
          $query_omset = $this->db->select('*')
                                  ->from('tab_omset')
                                  ->where('cabang',$cabang)
                                  ->get();
          foreach ($query_omset->result() as $row) {
            $nilai_prorata  = $row->bonus_prorata;
            $nilai_point    = $row->bonus_point;
            $total_point    = $row->total_point;
          }
          /*echo "<br>";
          echo $nilai_prorata;
          echo "<br>";
          echo $nilai_point;
          echo "<br>";
          echo $total_point;*/
          //INSERT KE TAB BONUS PER KARYAWAN
          foreach ($karyawan->result() as $val) {
          if ($val->nik_resign==NULL||date('m',strtotime($tgl_awal))<=date('m',strtotime($val->tanggal_resign))||date('m',strtotime($tgl_awal))>date('m',strtotime($val->tanggal_masuk))&&$val->tanggal_masuk>$val->tanggal_resign) {
            $jml_grade2 = 0;
            $jml_grade_point2 = 0;
            $senioritas = 0;
            $jml_total_point2 = 0;
            $bonus_prosen = 0; 
            $bonus_nominal = 0; 
            $bonus_point = 0;
            $bonus_prorata = 0;
            $total_bonus = 0;
            $total_bulat = 0;
            $total_kembali = 0;
            $total_diterima = 0;
            $jml_grade2 = $val->grade;
            $jml_grade_point2 = (($val->grade * 2) + 2);
            //MENCARI SENIORITAS
            if (date_format(new DateTime($val->tanggal_masuk), 'd')>1) {
              //$tgl_set = date_format(new DateTime($val->tanggal_masuk), 'Y').'-'.(date_format(new DateTime($val->tanggal_masuk), 'm')+1).'-'.date_format(new DateTime($val->tanggal_masuk), 'd');
              $tgl_set = strtotime($val->tanggal_masuk);
              $tgl_new = date('Y-m-d', strtotime('+1 month',$tgl_set));
            } else {
              $tgl_new = $val->tanggal_masuk;
            }
            if (date('m', strtotime($tgl_new))>$bln) {
              $senioritas = $hari_ini - $tgl_new - 1;
            } else {
              $senioritas = $hari_ini - $tgl_new;
            }
            if ($senioritas<1||$val->status_kerja!="Tetap") {
              $senioritas = 0;
            }
            //END SENIORITAS
            if ($val->cabang=='2') {
              $jml_total_point2 = ((($jml_grade2 * $jml_grade_point2) + $senioritas)/$jml_cabang);
            } else {
              if ($val->nik_real=="9100069"||$val->nik_real=="9300027"||$val->nik_real=="9100095"||$val->nik_real=="9100099"||$val->nik_real=="9100084"||$val->nik_real=="9100098") {
                $jml_total_point2 = ((($jml_grade2 * $jml_grade_point2) + $senioritas)/$jml_cabang);
              } else {
                $jml_total_point2 = (($jml_grade2 * $jml_grade_point2) + $senioritas);
              }
            }
            
            if ($val->persentase>0) {
              $jml_grade2 = 0;
              $jml_grade_point2 = 0;
              $senioritas = 0;
              $jml_total_point2 = 0;
              $bonus_prosen = ($omset * $val->persentase)/100; 
              $bonus_nominal = 0; 
              $bonus_point = 0;
              $bonus_prorata = 0;
              $total_bonus = $bonus_prosen;
              $total_bulat = intval($total_bonus/1000)*1000;
              $total_kembali = 0;
              $total_diterima = $total_bulat;
            } else if ($val->nominal>0) {
              $jml_grade2 = 0;
              $jml_grade_point2 = 0;
              $senioritas = 0;
              $jml_total_point2 = 0;
              $bonus_prosen = 0; 
              $bonus_nominal = $val->nominal; 
              $bonus_point = 0;
              $bonus_prorata = 0;
              $total_bonus = $bonus_nominal;
              $total_bulat = intval($total_bonus/1000)*1000;
              $total_kembali = 0;
              $total_diterima = $total_bulat;
            } else {
              if ($val->prota==1) {
                $bonus_point = $jml_total_point2 * $nilai_point;
                $bonus_prorata = $nilai_prorata;
                $total_bonus = $bonus_point + $bonus_prorata;
                $total_bulat = intval($total_bonus/1000)*1000;
                $total_kembali = 0;
                $total_diterima = $total_bulat; 
              } else {
                $bonus_point = $jml_total_point2 * $nilai_point;
                $bonus_prorata = $nilai_prorata;
                $total_bonus = $bonus_point + $bonus_prorata;
                $total_bulat = intval($total_bonus/1000)*1000;
                $total_kembali = $total_bulat;
                $total_diterima = 0; 
              }
            }
            if ($cabang==1&&$val->nik_real=="9200001") {
              $jml_grade2 = 0;
              $jml_grade_point2 = 0;
              $senioritas = 0;
              $jml_total_point2 = 0;
              $bonus_prosen = 0; 
              $bonus_nominal = 0; 
              $bonus_point = 0;
              $bonus_prorata = 0;
              $total_bonus = 0;
              $total_bulat = 0;
              $total_kembali = 0;
              $total_diterima = 0;
            }
            if ($val->nik_sp!=NULL) {
              $total_kembali = $total_bulat;
              $total_diterima = 0; 
            }
            if ($val->cabang!='2') {
              if ($val->nik_real=="9100069"||$val->nik_real=="9300027"||$val->nik_real=="9100095"||$val->nik_real=="9100099"||$val->nik_real=="9100084"||$val->nik_real=="9100098") {
                $check_kar = $this->db->query(
                  'select * from tab_bonus_karyawan 
                  where nik="'.$val->nik_real.'" and tanggal_bonus>="'.$tgl_awal.'" 
                  and tanggal_bonus<="'.$tgl_akhir.'"'
                );
                if ($check_kar->result()<>false) {
                  foreach ($check_kar->result() as $val2) {
                    $data = array(
                      'bonus_prosen'  => $val2->bonus_prosen + $bonus_prosen,
                      'bonus_nominal' => $val2->bonus_nominal + $bonus_nominal,
                      'bonus_point'   => $val2->bonus_point + $bonus_point,
                      'bonus_prorata' => $val2->bonus_prorata + $bonus_prorata,
                      'total_bonus'   => $val2->total_bonus + $total_bonus,
                      'total_bulat'   => $val2->total_bulat + $total_bulat,
                      'total_kembali' => $val2->total_kembali + $total_kembali,
                      'total_diterima'=> $val2->total_diterima + $total_diterima,
                      'tanggal_bonus' => $bulan_bonus,
                      'approved'      => "Belum",
                      'keterangan'    => "Auto Generate",
                      'include_pph'   => $this->input->post('pph'),
                      'entry_user'    => $this->session->userdata('username'),
                      'entry_date'    => date('Y-m-d H:i:s')
                    );
                    $this->db->where('nik', $val->nik_real);
                    $this->db->update('tab_bonus_karyawan', $data);
                  }
                } else {
                  $data = array(
                    'id_omset'      => $id_omset, 
                    'nik'           => $val->nik_real,
                    'grade'         => $jml_grade2,
                    'point'         => $jml_grade_point2,
                    'senioritas'    => $senioritas,
                    'total_point'   => $jml_total_point2,
                    'bonus_prosen'  => $bonus_prosen,
                    'bonus_nominal' => $bonus_nominal,
                    'bonus_point'   => $bonus_point,
                    'bonus_prorata' => $bonus_prorata,
                    'total_bonus'   => $total_bonus,
                    'total_bulat'   => $total_bulat,
                    'total_kembali' => $total_kembali,
                    'total_diterima'=> $total_diterima,
                    'tanggal_bonus' => $bulan_bonus,
                    'approved'      => "Belum",
                    'keterangan'    => "Auto Generate",
                    'include_pph'   => $this->input->post('pph'),
                    'entry_user'    => $this->session->userdata('username'),
                    'entry_date'    => date('Y-m-d H:i:s')
                  );
                  $this->db->insert('tab_bonus_karyawan', $data);
                }
              } else {
                $data = array(
                  'id_omset'      => $id_omset, 
                  'nik'           => $val->nik_real,
                  'grade'         => $jml_grade2,
                  'point'         => $jml_grade_point2,
                  'senioritas'    => $senioritas,
                  'total_point'   => $jml_total_point2,
                  'bonus_prosen'  => $bonus_prosen,
                  'bonus_nominal' => $bonus_nominal,
                  'bonus_point'   => $bonus_point,
                  'bonus_prorata' => $bonus_prorata,
                  'total_bonus'   => $total_bonus,
                  'total_bulat'   => $total_bulat,
                  'total_kembali' => $total_kembali,
                  'total_diterima'=> $total_diterima,
                  'tanggal_bonus' => $bulan_bonus,
                  'approved'      => "Belum",
                  'keterangan'    => "Auto Generate",
                  'include_pph'   => $this->input->post('pph'),
                  'entry_user'    => $this->session->userdata('username'),
                  'entry_date'    => date('Y-m-d H:i:s')
                );
                $this->db->insert('tab_bonus_karyawan', $data);
              }
            } else {
              $check_kar = $this->db->query(
                'select * from tab_bonus_karyawan 
                where nik="'.$val->nik_real.'" and tanggal_bonus>="'.$tgl_awal.'" 
                and tanggal_bonus<="'.$tgl_akhir.'"'
              );
              if ($check_kar->result()<>false) {
                foreach ($check_kar->result() as $val2) {
                  $data = array(
                    'bonus_prosen'  => $val2->bonus_prosen + $bonus_prosen,
                    'bonus_nominal' => $val2->bonus_nominal + $bonus_nominal,
                    'bonus_point'   => $val2->bonus_point + $bonus_point,
                    'bonus_prorata' => $val2->bonus_prorata + $bonus_prorata,
                    'total_bonus'   => $val2->total_bonus + $total_bonus,
                    'total_bulat'   => $val2->total_bulat + $total_bulat,
                    'total_kembali' => $val2->total_kembali + $total_kembali,
                    'total_diterima'=> $val2->total_diterima + $total_diterima,
                    'tanggal_bonus' => $bulan_bonus,
                    'approved'      => "Belum",
                    'keterangan'    => "Auto Generate",
                    'include_pph'   => $this->input->post('pph'),
                    'entry_user'    => $this->session->userdata('username'),
                    'entry_date'    => date('Y-m-d H:i:s')
                  );
                  $this->db->where('nik', $val->nik_real);
                  $this->db->update('tab_bonus_karyawan', $data);
                }
              } else {
                $data = array(
                  'id_omset'      => $id_omset, 
                  'nik'           => $val->nik_real,
                  'grade'         => $jml_grade2,
                  'point'         => $jml_grade_point2,
                  'senioritas'    => $senioritas,
                  'total_point'   => $jml_total_point2,
                  'bonus_prosen'  => $bonus_prosen,
                  'bonus_nominal' => $bonus_nominal,
                  'bonus_point'   => $bonus_point,
                  'bonus_prorata' => $bonus_prorata,
                  'total_bonus'   => $total_bonus,
                  'total_bulat'   => $total_bulat,
                  'total_kembali' => $total_kembali,
                  'total_diterima'=> $total_diterima,
                  'tanggal_bonus' => $bulan_bonus,
                  'approved'      => "Belum",
                  'keterangan'    => "Auto Generate",
                  'include_pph'   => $this->input->post('pph'),
                  'entry_user'    => $this->session->userdata('username'),
                  'entry_date'    => date('Y-m-d H:i:s')
                );
                $this->db->insert('tab_bonus_karyawan', $data);
              }
            }
          }//END IF
          }//END FOREACH
          //JIKA GENERATE GM
          if ($cabang==1) {
            $karyawan2 = $this->db->query(
              'select a.*,a.nik as nik_real,b.*,c.*,d.*,d.nik as nik_resign, e.nik as nik_sp 
              from tab_karyawan a 
              inner join tab_history_kontrak_kerja b on b.nik = a.nik 
              inner join tab_master_bonus c on c.nik = a.nik 
              left join tab_resign d on d.nik = a.nik
              LEFT JOIN tab_sp e ON e.nik = a.nik 
              where (a.nik="9100069" or a.nik="9300027" or a.nik="9100095" 
              or a.nik="9100099" or a.nik="9100084" or a.nik="9100098")
              GROUP BY a.nik'
            );
            foreach ($karyawan2->result() as $val) {
            //MANUAL IF
            // if ($val->nik_resign==NULL||date('m',strtotime($tgl_awal))<=date('m',strtotime($val->tanggal_resign))||date('m',strtotime($tgl_awal))>date('m',strtotime($val->tanggal_masuk))&&$val->tanggal_masuk>$val->tanggal_resign) {
                if ($val->persentase==0) {
                  $jml_grade2 = 0;
                  $jml_grade_point2 = 0;
                  $senioritas = 0;
                  $jml_total_point2 = 0;
                  $bonus_prosen = 0; 
                  $bonus_nominal = 0; 
                  $bonus_point = 0;
                  $bonus_prorata = 0;
                  $total_bonus = 0;
                  $total_bulat = 0;
                  $total_kembali = 0;
                  $total_diterima = 0;
                  $jml_karyawan++;
                  $jml_grade = 0; $jml_grade_point = 0;
                  $jml_grade = $val->grade;
                  $jml_grade_point = (($val->grade * 2) + 2);
                  //MENCARI SENIORITAS
                  if (date_format(new DateTime($val->tanggal_masuk), 'd')>1) {
                    //$tgl_set = date_format(new DateTime($val->tanggal_masuk), 'Y').'-'.(date_format(new DateTime($val->tanggal_masuk), 'm')+1).'-'.date_format(new DateTime($val->tanggal_masuk), 'd');
                    $tgl_set = strtotime($val->tanggal_masuk);
                    $tgl_new = date('Y-m-d', strtotime('+1 month',$tgl_set));
                  } else {
                    $tgl_new = $val->tanggal_masuk;
                  }
                  // echo "Tgl Masuk : ".$val->tanggal_masuk;
                  if (date('m', strtotime($tgl_new))>$bln) {
                    $senioritas = $hari_ini - $tgl_new - 1;
                  } else {
                    $senioritas = $hari_ini - $tgl_new;
                  }
                  if ($senioritas<1||$val->status_kerja!="Tetap") {
                    $senioritas = 0;
                  }
                  //END SENIORITAS
                  $total_point = ((($jml_grade * $jml_grade_point) + $senioritas)/$jml_cabang);
                  $jml_total_point2 = $jml_total_point2 + $total_point;
            
                  if ($val->persentase>0) {
                    $jml_grade2 = 0;
                    $jml_grade_point2 = 0;
                    $senioritas = 0;
                    $jml_total_point2 = 0;
                    $bonus_prosen = ($omset * $val->persentase)/100; 
                    $bonus_nominal = 0; 
                    $bonus_point = 0;
                    $bonus_prorata = 0;
                    $total_bonus = $bonus_prosen;
                    $total_bulat = intval($total_bonus/1000)*1000;
                    $total_kembali = 0;
                    $total_diterima = $total_bulat;
                  } else if ($val->nominal>0) {
                    $jml_grade2 = 0;
                    $jml_grade_point2 = 0;
                    $senioritas = 0;
                    $jml_total_point2 = 0;
                    $bonus_prosen = 0; 
                    $bonus_nominal = $val->nominal; 
                    $bonus_point = 0;
                    $bonus_prorata = 0;
                    $total_bonus = $bonus_nominal;
                    $total_bulat = intval($total_bonus/1000)*1000;
                    $total_kembali = 0;
                    $total_diterima = $total_bulat;
                  } else {
                    if ($val->prota==1) {
                      $bonus_point = $jml_total_point2 * $nilai_point;
                      $bonus_prorata = $nilai_prorata;
                      $total_bonus = $bonus_point + $bonus_prorata;
                      $total_bulat = intval($total_bonus/1000)*1000;
                      $total_kembali = 0;
                      $total_diterima = $total_bulat; 
                    } else {
                      $bonus_point = $jml_total_point2 * $nilai_point;
                      $bonus_prorata = $nilai_prorata;
                      $total_bonus = $bonus_point + $bonus_prorata;
                      $total_bulat = intval($total_bonus/1000)*1000;
                      $total_kembali = $total_bulat;
                      $total_diterima = 0; 
                    }
                  }
                  if ($val->cabang!='2') {
                    $data = array(
                      'id_omset'      => $id_omset, 
                      'nik'           => $val->nik_real,
                      'grade'         => $jml_grade2,
                      'point'         => $jml_grade_point2,
                      'senioritas'    => $senioritas,
                      'total_point'   => $jml_total_point2,
                      'bonus_prosen'  => ($omset * $val->persentase)/100,
                      'bonus_nominal' => $val->nominal,
                      'bonus_point'   => $bonus_point,
                      'bonus_prorata' => $bonus_prorata,
                      'total_bonus'   => $total_bonus,
                      'total_bulat'   => $total_bulat,
                      'total_kembali' => $total_kembali,
                      'total_diterima'=> $total_diterima,
                      'tanggal_bonus' => $bulan_bonus,
                      'approved'      => "Belum",
                      'keterangan'    => "Auto Generate",
                      'include_pph'   => $this->input->post('pph'),
                      'entry_user'    => $this->session->userdata('username'),
                      'entry_date'    => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('tab_bonus_karyawan', $data);
                  }
                }
              // }
          }//END FOREACH
          }//END JIKA GENERATE GM
          
          redirect('bonus');
          
      }

    // when detail button is clicked    
   function detail_bonus($id,$bln,$thn){
        $data['data'] = $this->bonus->detail($id,$bln,$thn);
        $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','GRADE','POINT','SENIORITAS','TOTAL POINT','BONUS PERSEN','BONUS NOMINAL','BONUS PER POINT','BONUS PRORATA','TOTAL BONUS','TOTAL BULAT','TOTAL KEMBALI','TOTAL DITERIMA'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['cabang'] = $id;
        $data['bln'] = $bln;
        $data['thn'] = $thn;
        $data['halaman']=$this->load->view('bonusView/detail_bonus',$data,true);
    $this->load->view('beranda',$data);
    }

   function delete_bonus($id,$bln,$thn){
        $query = $this->db->query('
          select * from tab_omset where cabang = '.$id);
        if ($query<>false) {
          foreach ($query->result() as $row) {
            $this->db->query('delete from tab_bonus_karyawan where month(tanggal_bonus)='.$bln.' and year(tanggal_bonus)='.$thn.' and id_omset='.$row->id_omset);
            $this->db->query('delete from tab_omset where id_omset='.$row->id_omset);
          }
        }
        redirect('bonus');
    }

    // when rekap bonus menu is clicked
    function rekap_bonus(){
        if ($this->input->post('bln',true)==NULL) {
          $bln = date('m');
          $thn = date('Y');
        } else {
          $bln=$this->input->post('bln',true);
          $thn=$this->input->post('tahun',true); 
        }
        $data['bln'] = $bln;
        $data['thn'] = $thn;
        /*$tgl1=$this->input->post('tanggal1');
        $tgl2=$this->input->post('tanggal2');
        $cb=$this->input->post('cabang');
        $data['data'] = $this->bonus->rekapitulasi($tgl1,$tgl2,$cb);*/
        /*$data['cabang']=$this->db->get('tab_cabang')->result();
        $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','PLANT','NAMA REKENING','NO REKENING','BONUS GRADE','BONUS SENIORITAS','BONUS NOMINAL','BONUS PERSEN','BONUS PROTA','TOTAL BONUS','APPROVED','TANGGAL BAGI','KETERANGAN','TINDAKAN'));*/
        //$data['data']=$this->bonus->index($bln,$thn);
        //$this->table->set_heading(array('NO','PLANT','JUMLAH KARYAWAN','JUMLAH OMSET','BONUS BRUTO','MPD','L&B','BONUS PERSEN','BONUS NOMINAL','BONUS PURE','BONUS PER POINT','BONUS PRORATA','APRROVEMENT','KETERANGAN','TINDAKAN'));
        $data['data'] = $this->bonus->index($bln,$thn);
        $this->table->set_heading(array('NO','PLANT','JUMLAH OMSET','MPD','L&B','TOTAL BONUS','TOTAL BULAT','SELISIH PEMBULATAN','BONUS DIBAGI','BONUS TIDAK DIBAGI','APPROVEMENT','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('laporan/rekap_bonus',$data,true);
        $this->load->view('beranda',$data);
    }

   function detail_rekap_bonus($id,$bln,$thn){
        $data['data'] = $this->bonus->detail($id,$bln,$thn);
        $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','GRADE','POINT','SENIORITAS','TOTAL POINT','BONUS PERSEN','BONUS NOMINAL','BONUS PER POINT','BONUS PRORATA','TOTAL BONUS','TOTAL BULAT','TOTAL KEMBALI','TOTAL DITERIMA'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['cabang'] = $id;
        $data['bln'] = $bln;
        $data['thn'] = $thn;
        $data['halaman']=$this->load->view('bonusView/detail_rekap_bonus',$data,true);
    $this->load->view('beranda',$data);
    }

  function rekap_omset(){
        $tgl1=$this->input->post('tanggal1');
        $tgl2=$this->input->post('tanggal2');
        $cb=$this->input->post('cabang');
        $data['data'] = $this->bonus->rekapitulasi_omset($tgl1,$tgl2,$cb);
        $data['cabang']=$this->db->get('tab_cabang')->result();
        $this->table->set_heading(array('NO','PLANT','JUMLAH KARYAWAN','BULAN','OMSET','MPD','L&B','TOTAL BONUS','BONUS TERBAGI','BONUS TIDAK DIBAGI','SELISIH'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('laporan/rekap_omset',$data,true);
        $this->load->view('beranda',$data);
    }  

  function cetakbonus($id){
    $data['data'] = $this->bonus->filter($id);
    $html=$this->load->view('bonusView/cetak',$data,true);
    $this->mpdf=new mPDF('utf-8', 'A5', 10, 'Times','5','5','5','5');
    $this->mpdf->WriteHTML($html);
    $name='bonus'.time().'.pdf';
    $this->mpdf->Output();
    exit();        
  }

  public function cetak_all()
  {
    $tgl1=$this->input->post('tanggal1');
    $tgl2=$this->input->post('tanggal2');
    $cb=$this->input->post('cabang');
    $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','PLANT','NAMA REKENING','NO REKENING','BONUS GRADE','BONUS SENIORITAS','BONUS NOMINAL','BONUS PERSEN','BONUS PROTA','TOTAL BONUS','APPROVED','TANGGAL BAGI','KETERANGAN'));
    $tmp=array('table_open'=>'<table id="example-2" class="tabel" >',
                    'thead_open'=>'<thead>',
                    'thead_close'=> '</thead>',
                    'tbody_open'=> '<tbody>',
                    'tbody_close'=> '</tbody>',
            );
    $this->table->set_template($tmp);
    $data['data'] = $this->bonus->rekapitulasi($tgl1,$tgl2,$cb);
    $data['tgl1']=$this->input->post('tanggal1');
    $data['tgl2']=$this->input->post('tanggal2');
    $data['cabang']=$this->db->where('id_cabang',$cb)->get('tab_cabang')->row();
    $aksi=$this->input->post('btn_aksi');
    if ($aksi=='cetak') {
      $this->mpdf=new mPDF('utf-8', 'A4-L', 11, 'Times','5','5','5','5');
      $html=$this->load->view('laporan/p_bonus',$data,true); 
      $this->mpdf->WriteHTML($html);
      $name='bonus'.time().'.pdf';
      $this->mpdf->Output();
    }elseif ($aksi=='excel') {
      $tanggal=time();
      header("Content-type: application/x-msdownload");
      header("Content-Disposition: attachment; filename=DATA_BONUS_KARYAWAN_".$tanggal.".xls");
      header("Pragma: no-cache");
      header("Expires: 0");
      if($data==true){
        $no=1;
        foreach ($data['data'] as $tampil){
          $total_bonus=$tampil->grade+$tampil->nominal+$tampil->senioritas+$tampil->persentase+$tampil->prota;
          $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$tampil->nama_rekening,$tampil->no_rekening,$this->format->indo($tampil->grade),$this->format->indo($tampil->senioritas),$this->format->indo($tampil->nominal),$this->format->indo($tampil->persentase),$this->format->indo($tampil->prota),$this->format->indo($total_bonus),$tampil->approved,date('d-m-Y',strtotime($tampil->tanggal_bonus)),$tampil->keterangan);
          $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
    }
    exit(); 
  }

  public function test()
  {
    $cabang = '1';

          $karyawan = $this->db->query(
            'select a.*,b.*,c.* 
            from tab_karyawan a 
            inner join tab_kontrak_kerja b on b.nik = a.nik 
            inner join tab_master_bonus c on c.nik = a.nik 
            where a.cabang='.$cabang.' or a.cabang=2'
          );
          $jml_karyawan = $karyawan->num_rows();

          echo $jml_karyawan;
  }
}
