    <h4>Data Absensi Karyawan <?=$karyawan->nama_ktp?> <br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
    <hr>
      <?=$this->session->flashdata('pesan');?>
        <form class="form-horizontal" id="form-periode" method="POST">
            <div class="form-group row">
              <label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
                <div class="col-sm-4">
              <div class="input-daterange input-group" id="date-picker1">
                  <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo $tgl1;?>" />
                  <span class="input-group-addon">s/d</span>
                  <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo $tgl2;?>" />
              </div>
                </div>
                <div class="col-sm-6 text-left">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>absensi/hapus">
          <div class="table-responsive" style="overflow:scroll;">
            <?php
                $this->table->set_heading(array('Nama Perusahaan','Plant','Department','Golongan','NIK','Nama Employe','Jabatan','Tanggal Absensi','Kode Shift','Tipe Shift','Jadwal Masuk','Jam Masuk','Status Masuk','Keterangan Masuk','Jadwal Keluar','Jam Keluar','Status Keluar','Keterangan Keluar','Jadwal Masuk 2','Jam Masuk 2','Status Masuk 2','Keterangan Masuk 2','Jadwal Keluar 2','Jam Keluar 2','Status Keluar 2','Keterangan Keluar 2','Tindakan'));
                //'Ket. Izin','Alpha','Masuk','Kode Shift','Lama Kerja STD','Lama Kerja Real','Keterangan Ekstra','Jumlah Ekstra','Real Lembur DP','Keterangan Jam Kerja ',
                $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                  'thead_open'=>'<thead>',
                  'thead_close'=> '</thead>',
                  'tbody_open'=> '<tbody>',
                  'tbody_close'=> '</tbody>',
                );
                $this->table->set_template($tmp);
                $no=1;
                if ($data<>false) {
                  foreach ($data as $val) {

                    if ($val->nik) {
                      $link=anchor('absensi/'.$val->id_absen.'/edit','<i class="fa pencil-square-o"></i><span class="label label-warning">Edit</span>');
                    }else{
                      $link="";
                    }

                    $this->table->add_row('CRN',$val->cabang_real,$val->department_real,$val->status_kerja,$val->nik_real,$val->nama_ktp,$val->jabatan_real,$this->format->TanggalIndo($val->tgl_kerja),$val->kode_jam_real,$val->tipe_shift,$val->jam_start,$val->jam_masuk1,$val->status_masuk,$val->keterangan_masuk,$val->jam_finish,$val->jam_keluar1,$val->status_keluar,$val->keterangan_keluar,$val->jam_start2,$val->jam_masuk2,$val->status_masuk2,$val->keterangan_masuk2,$val->jam_finish2,$val->jam_keluar2,$val->status_keluar2,$val->keterangan_keluar2,$link);
                    //$this->table->add_row('CRN',$karyawan->cabang,$karyawan->department,$karyawan->status_kerja,$karyawan->nik,$karyawan->nama_ktp,$karyawan->jabatan,$this->format->TanggalIndo($tgl_absen),$q_jdwal->jam_start,$q_jdwal->jam_finish,$q_absen->jam_masuk,$q_absen->jam_keluar,$ktr,$q_izin->alasan,$alpha,$hadir,$q_absen->kd_shift,$q_jdwal->lama,$lama_real,'',$q_ekstra->lama_jam,'','',$link);
                    $no++;
                  }
                }
                /*for ($i=1; $i<=$jml_bln; $i++){
                    $tgl_absen=date('Y-m-d',strtotime($bl_th['tahun'].'-'.$bl_th['bulan'].'-'.$i));
                    $q_jdwal=$this->db->join('tab_jam_kerja b','b.kode_jam=a.kode_jam')
                                      ->where('a.nik',$karyawan->nik)
                                      ->where('a.tanggal',date('Y-m-d',strtotime($tgl_absen)))
                                      ->get('tab_jadwal_karyawan a')
                                      ->row();
                    $q_absen=$this->db->join('tab_absensi_keluar b','b.nik=a.nik')
                                      ->where('date(a.jam_masuk)',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('date(b.jam_keluar)',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('a.nik',$karyawan->nik)
                                      ->get('tab_absensi_masuk a')
                                      ->row();
                    $q_ekstra=$this->db
                                      ->where('tanggal_ekstra',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('nik',$karyawan->nik)
                                      ->get('tab_extra')
                                      ->row();
                    $q_izin=$this->db
                                      ->where('date(tanggal_mulai) <=',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('tanggal_finish >=',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('nik',$karyawan->nik)
                                      ->select('alasan')
                                      ->get('tab_izin')
                                      ->row();
                    if(count($q_jdwal)==0) {
                        $ktr="Libur";
                        $alpha=0;
                        $lama_real=0;
                        $hadir=0;
                    }else {
                      if ($q_absen->status=="On Time") {
                        $ktr="Masuk";
                        $alpha=0;
                        $hadir=1;
                        $lama_real=date("H:i:s",strtotime($q_absen->jam_keluar))-date("H:i:s",strtotime($q_absen->jam_masuk));
                      }elseif ($q_absen->status=="Terlambat") {
                        $ktr="Masuk tidak lengkap";
                        $alpha=0;
                        $hadir=1;
                        $lama_real=date("H:i:s",strtotime($q_absen->jam_keluar))-date("H:i:s",strtotime($q_absen->jam_masuk));
                      }elseif(count($q_izin)>=1){
                        $ktr="Izin";
                        $alpha=0;
                        $hadir=0;
                        $lama_real=0;
                      }else{
                        $ktr="Alpha";
                        $alpha=1;
                        $hadir=0;
                        $lama_real=0;
                      }
                    }
                    if (isset($q_absen->nik)) {
                      $link=anchor('absensi/'.$q_absen->id.'/edit','<i class="fa pencil-square-o"></i><span class="label label-warning">Edit</span>');
                    }else{
                      $link="";
                    }
                    $this->table->add_row('CRN',$karyawan->cabang,$karyawan->department,$karyawan->status_kerja,$karyawan->nik,$karyawan->nama_ktp,$karyawan->jabatan,$this->format->TanggalIndo($tgl_absen),$q_jdwal->jam_start,$q_jdwal->jam_finish,$q_absen->jam_masuk,$q_absen->jam_keluar,$ktr,$q_izin->alasan,$alpha,$hadir,$q_absen->kd_shift,$q_jdwal->lama,$lama_real,'',$q_ekstra->lama_jam,'','',$link);
                $no++;
                }*/
                $tabel=$this->table->generate();
                echo $tabel;
            ?>
      </div>
      <div class="panel-footer">
        <!--<button type="button" onclick="importData()" class="btn btn-primary">Import Data</button>-->
        <!--<?=anchor('absensi/'.$karyawan->nik.'/add','Tambah Data',['class' => 'btn btn-success'])?>-->
        <button class="btn btn-warning" type="button" onClick="window.history.go(-1); return false;">Kembali</button>
      </form>
    </div>

<script>
function importData() {
  sUrl="<?=base_url()?>absensi/import"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>
<?php
/*
$jam_ekstra=$this->db->where('nik',$tampil->nik)
                                     ->where('date(entry_date)',date('Y-m-d',strtotime($tampil->jam_masuk)))
                                     ->get('tab_extra')->row();
                if(count($jam_ekstra)>=1) $ekstra=$jam_ekstra->lama_jam.' Jam'; else $ekstra=0;
                $lama_real=date("H:i:s",strtotime($tampil->jam_keluar))-date("H:i:s",strtotime($tampil->jam_masuk));
*/
?>