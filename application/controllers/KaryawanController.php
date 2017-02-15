 <?php
class KaryawanController extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->auth->restrict();
        $this->load->model('karyawan');
        $this->load->library('mpdf');
    }

    
    function deletekaryawan($id_karyawan){
 
            $this->karyawan->deletekaryawan($id_karyawan);
            redirect('KaryawanController/index');
        
    }

    function profil($nik){
        $data['data']=$this->karyawan->find($nik);
        $data['halaman']=$this->load->view('karyawan/profil_karyawan',$data,true);
        $this->load->view('beranda',$data);
    }

    function detail($nik){
        $data['data']=$this->karyawan->find($nik);
        $data['halaman']=$this->load->view('karyawan/detail_karyawan',$data,true);
        $this->load->view('beranda',$data);
    }


    function print_pkwt($nik){
        $data['data']=$this->karyawan->find($nik);
        if ($data['data']->id_karyawan<10) {
            $data['id_kontrak']='00'.$data['data']->id_karyawan;
        }elseif ($data['data']->id_karyawan>=10 && $data['data']->id_karyawan<100) {
            $data['id_kontrak']='0'.$data['data']->id_karyawan;
        }else{
            $data['id_kontrak']=$data['data']->id_karyawan;
        }
        $data['halaman']=$this->load->view('karyawan/print_pkwt',$data,true);
        $this->load->view('beranda',$data);
    }
    
    function updatekaryawan($nik){
        if($_POST==NULL){ // jika dari button adit dari baca karyawan
            $data['data'] = $this->karyawan->find($nik);
            $data['keluarga'] = $this->karyawan->findKeluarga($nik);
            $data['halaman'] = $this->load->view('karyawan/updatekaryawan',$data,true);
            $this->load->view('beranda',$data);
        }
        else
        {
            $jml_telp=count($this->input->post('telp'));
            for ($i=1; $i <= $jml_telp; $i++) { 
                $telp[$i]=$this->input->post('telp')[$i];
            }
            $nik=$this->input->post('nik');
            $datakaryawan = array(
                'nik'=>$this->input->post('nik'),
                'nama_ktp'=>$this->input->post('nama'),
                'no_ktp'=>$this->input->post('noktp'),
                'alamat_ktp'=>$this->input->post('alamatktp'),
                'alamat_domisili'=>$this->input->post('alamatd'),
                'agama'=>$this->input->post('agama'),
                'telepon'=>implode(":", $telp),
                'tempat'=>$this->input->post('tempat'),
                'tanggal_lahir'=>$this->input->post('tanggal_lahir'),
                'status_perkawinan'=>$this->input->post('kawin'),
                'jenis_kelamin'=>$this->input->post('jenkel'),
                'pendidikan_terakhir'=>$this->input->post('penter'),
                'nama_rekening'=>$this->input->post('nama_rekening'),
                'no_rekening'=>$this->input->post('no_rekening'),
                'jabatan'=>$this->input->post('jabatan'),
                'department'=>$this->input->post('department'),
                'cabang'=>$this->input->post('cabang'),
                'tanggungan'=>$this->input->post('tanggungan'),
                'asuransi'=>$this->input->post('asuransi'),
                'npwp'=>$this->input->post('cek_npwp'),
                'status_pajak'=>$this->input->post('pajak'),
                'tanggal_awal'=>$this->input->post('tanggal_awal'),
                'email'=>$this->input->post('email'),
                'gaji_bpjs'=> str_replace('.', '', $this->input->post('gaji_bpjs')),
                );
            $this->karyawan->update_karyawan($nik,$datakaryawan);
            $jml_keluarga=count($this->input->post('keluarga'));
            for ($i=1; $i <= $jml_keluarga ; $i++) { 
                $data= array(
                            'nik'=> $this->input->post('nik'),
                            'hubungan'=> $this->input->post('keluarga')[$i],
                            'nomor_telp'=> $this->input->post('telpKlg')[$i],
                        );
                $this->karyawan->update_keluarga($nik,$data);
            }
            $jml_bpjs=count($this->input->post('idbpjs'));
            for ($i=0; $i < $jml_bpjs ; $i++) {
                $data= array(
                            'id_bpjs'=> $this->input->post('idbpjs')[$i],
                            'nik'=> $this->input->post('nik'),
                            'no_bpjs'=> $this->input->post('no_bpjs')[$i],
                            'status'=> $this->input->post('status')[$i],
                            'bulan_ambil'=> $this->input->post('tgl_bpjs')[$i],
                        );
                $this->karyawan->update_bpjs($nik,$data);
            }

            if ($this->input->post('cek_npwp')=='Punya') {
                $data= array(
                            'nik'=> $this->input->post('nik'),
                            'no_npwp'=> $this->input->post('no_npwp'),
                            'nama_npwp'=> $this->input->post('nama_npwp'),
                            'alamat_npwp'=> $this->input->post('alamat_npwp'),
                            'tanggal_npwp'=> $this->input->post('tanggal_npwp')
                        );
               $this->karyawan->update_npwp($nik,$data);
            }

            $datakerja = array(
                            'nik'=> $this->input->post('nik'),
                            'status_kerja'=> $this->input->post('status_kerja'),
                            'tanggal_masuk'=> $this->input->post('tgl_masuk'),
                            'tanggal_resign'=> $this->input->post('tgl_resign'),
                            'standard_hadir'=> $this->input->post('standar_hadir'),
                            'uang_makan'=> str_replace('.', '', $this->input->post('uangmakan')),
                            'gaji_pokok'=> str_replace('.', '', $this->input->post('gaji')),
                            'tunjangan_jabatan'=> str_replace('.', '', $this->input->post('tunjangan_jabatan')),
                            'gaji_casual'=> str_replace('.', '', $this->input->post('gajicasual'))
                        );
            $this->db->query('UPDATE tab_kontrak_kerja SET status_kerja2=status_kerja, tanggal_masuk2=tanggal_masuk, tanggal_resign2=tanggal_resign, gaji_pokok2=gaji_pokok, gaji_casual2=gaji_casual, tunjangan_jabatan2=tunjangan_jabatan, uang_makan2=uang_makan WHERE nik='.$nik);
            $this->karyawan->update_kontrak($nik,$datakerja);
            //INSERT HISTORY
            $query3 = $this->db->query(
                '
                select * from tab_kontrak_kerja 
                WHERE nik="'.$datakerja['nik'].'"'
            );
            foreach ($query3->result() as $row) {
                $data3 = array(
                    'nik' => $row->nik,
                    'status_kerja' => $row->status_kerja,
                    'tanggal_masuk' => $row->tanggal_masuk,
                    'tanggal_resign' => $row->tanggal_resign,
                    'gaji_pokok' => $row->gaji_pokok,
                    'gaji_casual' => $row->gaji_casual,
                    'tunjangan_jabatan' => $row->tunjangan_jabatan,
                    'uang_makan' => $row->uang_makan
                );
                $this->db->where('nik',$data3['nik']);
                $this->db->where('tanggal_masuk',$data3['tanggal_masuk']);
                $this->db->delete('tab_history_kontrak_kerja');

                $this->db->insert('tab_history_kontrak_kerja',$data3);
            }
            
            $datapajak = array(
                            'nik'=> $this->input->post('nik'),
                            'id_pajak'=> $this->input->post('pajak'),
                            'entry_user'=> $this->session->userdata('username')
                        );
            $this->karyawan->input_pajak($datapajak);

            $databonus = array(
                            'nik'=> $this->input->post('nik'),
                            'tipe_bonus'=> $this->input->post('tipe_bonus'),
                            'grade'=> $this->input->post('grade'),
                            'prota'=> $this->input->post('cek_prota'),
                            'nominal'=> str_replace(array('.'), array(''), $this->input->post('nominal')),
                            'persentase'=> $this->input->post('persentase'),
                            'tarif_t3'=> str_replace(array('.'), array(''), $this->input->post('tarif_t3')),
                            'nominal2'=> str_replace(array('.'), array(''), $this->input->post('nominal2'))
                        );
            $this->karyawan->update_bonus($nik,$databonus);
            $dataasuransi = array(
                            'nik'=> $this->input->post('nik'),
                            'asuransi'=> $this->input->post('asuransi'),
                            'nominal_asuransi   '=> str_replace('.', '', $this->input->post('nominal_premi')),
                            'tanggal_premi'=> $this->input->post('tanggal_premi'),
                            'nomor_premi'=> $this->input->post('no_premi')
                        );
            $this->karyawan->update_asuransi($nik,$dataasuransi);
            $ktr_npwp=$this->input->post('ket_npwp');
            $this->db->update('npwp',array("keterangan" => $ktr_npwp));
            redirect('KaryawanController/index');
        }
    }
    
   function index(){
        $data['data']=$this->karyawan->index();
        $this->table->set_heading(array('NO','NIK','Nama','Alamat','Agama','Telepon','Jabatan','Tgl Lahir','Jenis Kelamin','Status Kawin','Edit'));
        $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['halaman']=$this->load->view('karyawan/bacakaryawan',$data,true);
        $this->load->view('beranda',$data);
    } 

    function tambahkaryawan(){
 
        if($this->input->post('submit')){
            $jml_telp=count($this->input->post('telp'));
            for ($i=1; $i <= $jml_telp; $i++) { 
                $telp[$i]=$this->input->post('telp')[$i];
            }
             $datakaryawan = array(
                'nik'=>$this->input->post('nik'),
                'nama_ktp'=>$this->input->post('nama'),
                'no_ktp'=>$this->input->post('noktp'),
                'alamat_ktp'=>$this->input->post('alamatktp'),
                'alamat_domisili'=>$this->input->post('alamatd'),
                'agama'=>$this->input->post('agama'),
                'telepon'=>implode(":", $telp),
                'tempat'=>$this->input->post('tempat'),
                'tanggal_lahir'=>$this->input->post('tanggal_lahir'),
                'status_perkawinan'=>$this->input->post('kawin'),
                'jenis_kelamin'=>$this->input->post('jenkel'),
                'pendidikan_terakhir'=>$this->input->post('penter'),
                'nama_rekening'=>$this->input->post('nama_rekening'),
                'no_rekening'=>$this->input->post('no_rekening'),
                'tanggungan'=>$this->input->post('tanggungan'),
                'jabatan'=>$this->input->post('jabatan'),
                'department'=>$this->input->post('department'),
                'cabang'=>$this->input->post('cabang'),
                'asuransi'=>$this->input->post('asuransi'),
                'tanggal_awal'=>$this->input->post('tanggal_awal'),
                'npwp'=>$this->input->post('cek_npwp'),
                'status_pajak'=>$this->input->post('pajak'),
                'email'=>$this->input->post('email'),
                'gaji_bpjs'=> str_replace('.', '', $this->input->post('gaji_bpjs')),
                );
            $this->karyawan->input_karyawan($datakaryawan);
            $jml_keluarga=count($this->input->post('keluarga'));
            for ($i=1; $i <= $jml_keluarga ; $i++) { 
                $data= array(
                            'nik'=> $this->input->post('nik'),
                            'hubungan'=> $this->input->post('keluarga')[$i],
                            'nomor_telp'=> $this->input->post('telpKlg')[$i],
                        );
                $this->karyawan->input_keluarga($data);
            }
            $jml_bpjs=count($this->input->post('idbpjs'));
            for ($i=0; $i < $jml_bpjs ; $i++) {
                $data= array(
                            'id_bpjs'=> $this->input->post('idbpjs')[$i],
                            'nik'=> $this->input->post('nik'),
                            'no_bpjs'=> $this->input->post('no_bpjs')[$i],
                            'status'=> $this->input->post('status')[$i],
                            'bulan_ambil'=> $this->input->post('tgl_bpjs')[$i],
                        );
                $this->karyawan->input_bpjs($data);
            }

            if ($this->input->post('cek_npwp')=='Punya') {
                $data= array(
                            'nik'=> $this->input->post('nik'),
                            'no_npwp'=> $this->input->post('no_npwp'),
                            'nama_npwp'=> $this->input->post('nama_npwp'),
                            'alamat_npwp'=> $this->input->post('alamat_npwp'),
                            'tanggal_npwp'=> $this->input->post('tanggal_npwp')
                        );
               $this->karyawan->input_npwp($data);
            }

            $datakerja = array(
                            'nik'=> $this->input->post('nik'),
                            'status_kerja'=> $this->input->post('status_kerja'),
                            'tanggal_masuk'=> $this->input->post('tgl_masuk'),
                            'tanggal_resign'=> $this->input->post('tgl_resign'),
                            'standard_hadir'=> $this->input->post('standar_hadir'),
                            'tunjangan_jabatan'=> str_replace('.', '', $this->input->post('tunjangan_jabatan')),
                            'uang_makan'=> str_replace('.', '', $this->input->post('uangmakan')),
                            'gaji_pokok'=> str_replace('.', '', $this->input->post('gaji')),
                            'gaji_casual'=> str_replace('.', '', $this->input->post('gajicasual'))
                        );
            $this->karyawan->input_kontrak($datakerja);
            $ktr_npwp=$this->input->post('ket_npwp');
            $this->db->update('npwp',array("keterangan" => $ktr_npwp));
            $dataasuransi = array(
                            'nik'=> $this->input->post('nik'),
                            'asuransi'=> $this->input->post('asuransi'),
                            'nominal_asuransi   '=> str_replace('.', '', $this->input->post('nominal_premi')),
                            'tanggal_premi'=> $this->input->post('tanggal_premi'),
                            'nomor_premi'=> $this->input->post('no_premi')
                        );
            $this->karyawan->input_asuransi($dataasuransi);

            $databonus = array(
                            'nik'=> $this->input->post('nik'),
                            'grade'=> $this->input->post('grade'),
                            'prota'=> $this->input->post('cek_prota'),
                            'nominal'=> str_replace('.', '', $this->input->post('nominal')),
                            'persentase'=> $this->input->post('persentase'),
                            'tarif_t3'=> str_replace(array('.'), array(''), $this->input->post('tarif_t3')),
                            'nominal2'=> str_replace(array('.'), array(''), $this->input->post('nominal2'))
                        );
            $this->karyawan->input_bonus($databonus); 

            $datapajak = array(
                            'nik'=> $this->input->post('nik'),
                            'id_pajak'=> $this->input->post('pajak'),
                            'entry_user'=> $this->session->userdata('username')
                        );
            $this->karyawan->input_pajak($datapajak);
            $this->karyawan->input_history_pajak($datapajak,0);
            redirect('KaryawanController/index');
        }
        $data['halaman'] = $this->load->view('karyawan/karyawanview','',true);
        $this->load->view('beranda',$data);
    }

    function view_print(){
        $id_cabang=$this->input->post('cabang');
        $data['data'] = $this->karyawan->karyawan_show($id_cabang);
        $data['ketenaga'] = $this->db->where('id_bpjs','1')->get('tab_master_bpjs')->row();
        $data['kesehatan'] = $this->db->where('id_bpjs',2)->get('tab_master_bpjs')->row();
        $data['halaman']=$this->load->view('karyawan/view',$data,true);
        $this->load->view('beranda',$data);
    }

    function view_statistik(){
        $this->table->set_heading(array('NO','NIK','NAMA','JABATAN','DEPARTMENT','PLANT','TINDAKAN'));
        $tmp=array('table_open'=>'<table id="example-3" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $data['data'] = $this->karyawan->karyawan_show($id_cabang=NULL);
        $data['cabang'] = $this->db->get('tab_cabang')->result();
        $data['halaman']=$this->load->view('karyawan/view_statistik',$data,true);
        $this->load->view('beranda',$data);
    }

    public function cetak_karyawan($nik)
      {
        $data['data']=$this->karyawan->find($nik);
        $data['status_kerja']=$this->karyawan->find_data_status($nik);
        $html=$this->load->view('laporan/biodata_karyawan',$data,true);
        $html2=$this->load->view('laporan/histori_status_kerja',$data,true);
        $this->mpdf=new mPDF('utf-8', 'A4', 11, 'arial','5','5','5','5');
        $this->mpdf->WriteHTML($html);
        $this->mpdf->SetFooter('{PAGENO}');
        $this->mpdf->addPage();
        $this->mpdf->WriteHTML($html2);
        $this->mpdf->SetFooter('{PAGENO}');
        $name='HRD'.time().'.pdf';
        $this->mpdf->Output();
        exit();
      }
    public function cetak_all()
      {
        $id_cabang=$this->input->post('cabang');
        if (isset($id_cabang) && $id_cabang != 0) {
            $data['cabang']=$this->db->where('id_cabang',$id_cabang)->get('tab_cabang')->row();
        }
        $data['data'] = $this->karyawan->karyawan_show($id_cabang);
        $this->table->set_heading(array('NO','NIK','NAMA','NO KTP','ALAMAT KTP','ALAMAT DOMISILI','TELP','TELP EMERGENCY','STATUS HUBUNGAN','TANGGAL LAHIR','STATUS PERKAWINAN','TANGGUNGAN','JENIS KELAMIN','NO REKENING','TANGGAL MASUK','JABATAN','NO NPWP','STATUS KERJA'));
        $tmp=array('table_open'=>'<table id="example-3" class="table table-hover table-striped table-bordered" >',
                        'thead_open'=>'<thead>',
                        'thead_close'=> '</thead>',
                        'tbody_open'=> '<tbody>',
                        'tbody_close'=> '</tbody>',
                );
        $this->table->set_template($tmp);
        $html=$this->load->view('laporan/karyawan_all',$data,true);
        $this->mpdf=new mPDF('utf-8', 'A4-L', 11, 'arial','5','5','5','5');
        $this->mpdf->WriteHTML($html);
        $this->mpdf->SetFooter('{PAGENO}');
        $name='HRD'.time().'.pdf';
        $this->mpdf->Output();
        exit();
      }
    public function statistik($nik)
    {
        $bulan=$this->db->select("jam_masuk")->group_by('month(jam_masuk)')->get("tab_absensi_masuk")->result();
        foreach ($bulan as $rs_bln) {
            $nama_bln[]=date('F',strtotime($rs_bln->jam_masuk));
            $query_nilai=$this->db->query("select sum(if(status='Terlambat',1,0)) as jml_terlambat from tab_absensi_masuk where nik='".$nik."' and month(jam_masuk)=month('".$rs_bln->jam_masuk."')")->row();
            $nilai[]=$query_nilai->jml_terlambat;
            $queri_izin=$this->db->query("select sum(if(jenis_izin='Tidak Dapat Masuk',lama,0)) as jml_absen, sum(if(jenis_izin='Datang Pukul',1,0)) as jml_telat,sum(if(jenis_izin='Pulang Pukul',1,0)) as jml_dulu from tab_izin where nik='".$nik."' and (month(tanggal_mulai)=month('".$rs_bln->jam_masuk."') or month(tanggal_finish)=month('".$rs_bln->jam_masuk."'))")->row();
            $queri_izin=$this->db->query("select sum(if(jenis_izin='Tidak Dapat Masuk',lama,0)) as jml_absen, sum(if(jenis_izin='Datang Pukul',1,0)) as jml_telat,sum(if(jenis_izin='Pulang Pukul',1,0)) as jml_dulu from tab_izin where nik='".$nik."' and (month(tanggal_mulai)=month('".$rs_bln->jam_masuk."') or month(tanggal_finish)=month('".$rs_bln->jam_masuk."'))")->row();
            $queri_cuti=$this->db->query("select SUM(IF(cuti_khusus='Ya',lama_cuti,0)) as khusus,SUM(IF(cuti_khusus='Tidak',lama_cuti,0)) as biasa from tab_cuti where nik='".$nik."' and (month(tanggal_mulai)=month('".$rs_bln->jam_masuk."'))")->row();
            $izin[]=$queri_izin->jml_absen;
            $datang[]=$queri_izin->jml_telat;
            $pulang[]=$queri_izin->jml_dulu;
            $cuti_biasa[]=$queri_cuti->biasa;
            $cuti_khusus[]=$queri_cuti->khusus;
        }
        $gaji_karyawan=$this->db->where('nik',$nik)->select("gaji_karyawan,month(tanggal_gaji) as bln")->group_by('month(tanggal_gaji)')->get("tab_gaji_karyawan")->result();
        foreach ($gaji_karyawan as $rs_gaji) {
            $bulan_gaji[]=$this->format->BulanIndo($rs_gaji->bln);
            $jumlah_gaji[]=$rs_gaji->gaji_karyawan;
        }
        $komisi=$this->db->where('nik',$nik)->select("komisi,month(bulan) as bln")->group_by('month(bulan)')->get("tab_komisi")->result();
        foreach ($komisi as $rs_komisi) {
            $bulan_komisi[]=$this->format->BulanIndo($rs_komisi->bln);
            $jumlah_komisi[]=$rs_komisi->komisi;
        }
        $ekstra=$this->db->where('nik',$nik)
                         ->where('vakasi','Dibayar')
                         ->where('approved','ya')
                         ->select("sum(jumlah_vakasi) as jml_ekstra,month(entry_date) as bln")
                         ->group_by('month(entry_date)')
                         ->get("tab_extra")
                         ->result();
        foreach ($ekstra as $rs_ekstra) {
            $bulan_ekstra[]=$this->format->BulanIndo($rs_ekstra->bln);
            $jumlah_ekstra[]=$rs_ekstra->jml_ekstra;
        }
        $tunjangan=$this->db->where('nik',$nik)
                             ->where('approved','Ya')
                             ->select("sum(total_t3) as jml_tunjangan,month(tanggal) as bln")
                             ->group_by('month(tanggal)')
                             ->get("tab_t3")
                             ->result();
        foreach ($tunjangan as $rs_tj) {
            $bulan_tj[]=$this->format->BulanIndo($rs_tj->bln);
            $jumlah_tj[]=$rs_tj->jml_tunjangan;
        }
        $data['js_nilai']=json_encode($nilai);
        $data['js_izin']=json_encode($izin);
        $data['js_bulan_tj']=json_encode($bulan_tj);
        $data['js_tj']=json_encode($jumlah_tj);
        $data['js_bulan_ekstra']=json_encode($bulan_ekstra);
        $data['js_ekstra']=json_encode($jumlah_ekstra);
        $data['js_bulan_komisi']=json_encode($bulan_komisi);
        $data['js_komisi']=json_encode($jumlah_komisi);
        $data['js_biasa']=json_encode($cuti_biasa);
        $data['js_khusus']=json_encode($cuti_khusus);
        $data['js_pulang']=json_encode($pulang);
        $data['js_datang']=json_encode($datang);
        $data['js_bulan']=json_encode($nama_bln);
        $data['js_bulan_gaji']=json_encode($bulan_gaji);
        $data['js_gaji']=json_encode($jumlah_gaji);
        $data['halaman']=$this->load->view('dashboard/statistik_karyawan',$data,true);
        $this->load->view('beranda',$data);
    }


    public function get_nik(){
        $cb = $this->input->get("cb");
        if ($cb=='1') {
            $check2 = $this->db->query(
                'SELECT MID(nik, 1, 2) as awal, MID(nik, 3, 5) AS nik FROM tab_karyawan 
                WHERE cabang = '.$cb.'
                ORDER BY nik DESC LIMIT 1'
            );
        } else if ($cb=='2') {
            $check2 = $this->db->query(
                'SELECT MID(nik, 1, 2) as awal, MID(nik, 3, 5) AS nik FROM tab_karyawan 
                WHERE cabang = '.$cb.' or cabang = 3
                ORDER BY nik DESC LIMIT 1'
            );
        } else if ($cb=='3') {
            $check2 = $this->db->query(
                'SELECT MID(nik, 1, 2) as awal, MID(nik, 3, 5) AS nik FROM tab_karyawan 
                WHERE cabang = '.$cb.' or cabang = 2
                ORDER BY nik DESC LIMIT 1'
            );
        }
        if ($check2->num_rows()>0) {
            foreach ($check2->result() as $row) {
                $urut = intval($row->nik);
                $awal = intval($row->awal);
                $urut++;
                $urut = sprintf("%05d",$urut);
            }
        } else if ($check2->num_rows()==null) {
            $urut = 1;
            $urut = sprintf("%05d",$urut);
        }

        $response['newid'] = $awal.$urut;
        $response['status'] = '200';

        echo json_encode($response);
    }
}
?>