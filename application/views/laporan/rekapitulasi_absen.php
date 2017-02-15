   
<div class="col-sm-12">
    <h4>Rekapitulasi Absensi Karyawan <?php echo $cabang;?></h4>
    <hr>
      <?=$this->session->flashdata('pesan');?>
        <form class="form-horizontal" id="form-periode" method="POST">
            <div class="form-group row">
              <label class="col-sm-2 form-control-label text-center"><b>CABANG</b></label>
            <div class="col-sm-4">
                <select class="form-control" name="cabang">
                    <option value="">All</option>
                    <?php
                        $cb=$this->db->get('tab_cabang')->result();
                        foreach ($cb as $plant) {
                            echo "<option value='$plant->id_cabang'>$plant->cabang</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="col-sm-6 text-left">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </div>
        </form>
      <?=$this->session->flashdata('pesan');?>

          <form method="post" action="<?=base_url('Laporan/ex_absensi')?>" target="new">
            <!--<input type="hidden" name="bln" value="<?=$bln?>">
            <input type="hidden" name="thn" value="<?=$thn?>">-->
            <input type="hidden" name="cabang" value="<?=$cabang_id?>">
            <div class="table-responsive" style="overflow:scroll;">
            <?php
                $this->table->set_heading(array('Nama Perusahaan','Plant','Jumlah Karyawan ','Tindakan'));
                $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                  'thead_open'=>'<thead>',
                  'thead_close'=> '</thead>',
                  'tbody_open'=> '<tbody>',
                  'tbody_close'=> '</tbody>',
                );
                $this->table->set_template($tmp);

                $tgl = date('Y-'.$bln.'-d');
                $tgl_akhir  = date('t', strtotime($tgl));

                $no=1;
                foreach ($data as $tampil) {
                  //$this->table->add_row('CRN',$tampil->field1,intval($tampil->field2/$tgl_akhir),anchor('cetak/'.$bln.'/'.$thn.'/'.$tampil->field0.'/detail-plant-absensi-karyawan','<span class="label label-warning">Detail</span>'));
                  $this->table->add_row('CRN',$tampil->field1,intval($tampil->field2/$tgl_akhir),anchor('cetak/'.$tampil->field0.'/detail-plant-absensi-karyawan','<span class="label label-warning">Detail</span>'));
                  $no++;
                }
                /*foreach ($data as $tampil){
                    $tgl_absen=date('Y-m-d',strtotime($tampil->jam_masuk));
                    $q_jdwal=$this->db->join('tab_jam_kerja b','b.kode_jam=a.kode_jam')
                                      ->where('a.nik',$tampil->nik)
                                      ->where('a.tanggal',date('Y-m-d',strtotime($tgl_absen)))
                                      ->get('tab_jadwal_karyawan a')
                                      ->row();
                    $q_absen=$this->db->join('tab_absensi_keluar b','b.nik=a.nik')
                                      ->where('date(a.jam_masuk)',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('date(b.jam_keluar)',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('a.nik',$tampil->nik)
                                      ->get('tab_absensi_masuk a')
                                      ->row();
                    $q_ekstra=$this->db
                                      ->where('tanggal_ekstra',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('nik',$tampil->nik)
                                      ->get('tab_extra')
                                      ->row();
                    $q_izin=$this->db
                                      ->where('date(tanggal_mulai) <=',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('tanggal_finish >=',date('Y-m-d',strtotime($tgl_absen)))
                                      ->where('nik',$tampil->nik)
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
                    $this->table->add_row('CRN',$tampil->cabang,$tampil->department,$tampil->status_kerja,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$this->format->TanggalIndo($tgl_absen),$q_jdwal->jam_start,$q_jdwal->jam_finish,$q_absen->jam_masuk,$q_absen->jam_keluar,$ktr,$q_izin->alasan,$alpha,$hadir,$q_absen->kd_shift,$q_jdwal->lama,$lama_real,'',$q_ekstra->lama_jam,'','');
                $no++;
                }*/
                $tabel=$this->table->generate();
                echo $tabel;
            ?>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success">Export Excel</button>
          </div>
          </form>
    </div>
   </div>
<script type="text/javascript">
  $( document ).ready(function() {
  });
</script>

