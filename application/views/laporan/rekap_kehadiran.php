<div class="col-md-12">
    <h4>Rekapitulasi Kehadiran Karyawan <?php echo $cabang;?> <br>Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?></h4>
    <hr>
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
            <div class="col-sm-2">
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
            <div class="col-sm-4 text-left">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
          <div class="table-responsive" style="overflow:scroll;">
            <form method="post" action="<?=base_url('Laporan/ex_hadir')?>">
            <input type="hidden" name="tgl1" value="<?=$this->input->post('tgl1')?>">
            <input type="hidden" name="tgl2" value="<?=$this->input->post('tgl2')?>">
            <input type="hidden" name="cabang" value="<?=$this->input->post('cabang_id')?>">
            <?php
                //$this->table->set_heading(array('Nama Perusahaan','Plant','Department','Golongan','NIK','Nama Employe','Jabatan','Lama Kerja STD','Lama Kerja Real','Jumlah Kehadiran','Cuti','Ijin','Alpha','Sakit','Terlambat','Pulang Mendahului','Jumlah Ekstra','DP','Real Lembur DP'));
            $this->table->set_heading(array('Nama Perusahaan','Plant','Department','Golongan','NIK','Nama Employe','Jabatan','Lama Kerja STD','Lama Kerja Real','Jumlah Kehadiran','Cuti','Ijin','Alpha','Sakit','Terlambat','Pulang Mendahului','Jumlah Ekstra'));
                $tmp=array('table_open'=>'<table id="example-2" class="table table-hover table-striped table-bordered" >',
                  'thead_open'=>'<thead>',
                  'thead_close'=> '</thead>',
                  'tbody_open'=> '<tbody>',
                  'tbody_close'=> '</tbody>',
                );
                $this->table->set_template($tmp);
                $no=1;
                foreach ($data as $tampil){
                    $tgl_absen=date('Y-m-d',strtotime($tampil->jam_masuk));
                    /*$q_jdwal=$this->db->join('tab_jam_kerja b','b.kode_jam=a.kode_jam')
                                      ->where('a.nik',$tampil->nik)
                                      ->where('month(a.tanggal)',$bulan)
                                      ->where('Year(a.tanggal)',$tahun)
                                      ->select('sum(b.lama) as jml_kerja')
                                      ->get('tab_jadwal_karyawan a')
                                      ->row();*/
                    $q_jdwal = $this->db->query(
                      '
                      SELECT a.nik, b.jam_start, b.jam_finish, b.jam_start2, b.jam_finish2 
                      FROM tab_jadwal_karyawan a 
                      JOIN tab_jam_kerja b ON b.kode_jam=a.kode_jam 
                      WHERE a.tanggal >= "'.$tgl1.'" AND a.tanggal <= "'.$tgl2.'" 
                      AND a.nik="'.$tampil->nik.'"
                      '
                    );
                    $lama = 0;
                    if ($q_jdwal<>false) {
                      foreach ($q_jdwal->result() as $val) {
                        $lama = $lama + ((strtotime($val->jam_finish)-strtotime($val->jam_start))/3600)+((strtotime($val->jam_finish2)-strtotime($val->jam_start2))/3600);
                      } 
                    }
                    /*$q_absen=$this->db->join('tab_absensi_keluar b','b.nik=a.nik')
                                      ->where('month(a.jam_masuk)',$bulan)
                                      ->where('Year(a.jam_masuk)',$tahun)
                                      ->where('a.nik',$tampil->nik)
                                      ->select('count(a.nik) as jml_hadir,timediff(b.jam_keluar,a.jam_masuk) as jml_absen',false)
                                      ->get('tab_absensi_masuk a')
                                      ->row();*/
                    $q_absen = $this->db->query(
                      '
                      SELECT a.nik, a.jam_masuk1, a.jam_keluar1, 
                      a.status_masuk, a.keterangan_masuk, 
                      a.status_keluar, a.keterangan_keluar, 
                      a.jam_masuk2, a.jam_keluar2, 
                      a.status_masuk2, a.keterangan_masuk2, 
                      a.status_keluar2, a.keterangan_keluar2
                      FROM tab_absensi a 
                      WHERE a.tgl_kerja >= "'.$tgl1.'" AND a.tgl_kerja <= "'.$tgl2.'" 
                      AND a.nik="'.$tampil->nik.'"
                      '
                    );
                    $lama2 = 0;
                    $jam_lama1 = 0;
                    $jam_lama2 = 0;
                    $jml_hadir = 0;
                    $jml_bolos = 0;
                    foreach ($q_absen->result() as $val) {
                      if ($val->status_masuk!="Masuk Tidak Lengkap"||$val->status_keluar!="Masuk Tidak Lengkap") {
                        $jam_lama1 = ((strtotime($val->jam_keluar1)-strtotime($val->jam_masuk1))/3600);
                      }
                      if ($val->status_masuk2!="Masuk Tidak Lengkap"||$val->status_keluar2!="Masuk Tidak Lengkap") {
                        $jam_lama2 = ((strtotime($val->jam_keluar2)-strtotime($val->jam_masuk2))/3600);
                      }
                      if ($val->status_masuk=="Masuk"||$val->status_masuk=="Masuk Tidak Lengkap"||$val->status_masuk2=="Masuk"||$val->status_masuk2=="Masuk Tidak Lengkap") {
                        $jml_hadir++;
                      }
                      if ($val->status_masuk=="Bolos"||$val->status_masuk2=="Bolos") {
                        $jml_bolos++;
                      }
                      $lama2 += $jam_lama1 + $jam_lama2;
                    }
                    $q_ekstra=$this->db
                                      ->where('tanggal_ekstra >=',$tgl1)
                                      ->where('tanggal_ekstra <=',$tgl2)
                                      ->where('nik',$tampil->nik)
                                      ->select("sum(if(vakasi='Dibayar',jumlah_vakasi,0)) as total_ekstra,sum(if(vakasi='Tambah DP Libur',jumlah_vakasi,0)) as total_dp",false)
                                      ->get('tab_extra')
                                      ->row();
                    $q_izin=$this->db
                                      ->where('tanggal_mulai >=',$tgl1)
                                      ->where('tanggal_mulai <=',$tgl2)
                                      ->where('nik',$tampil->nik)
                                      ->select("sum(if(jenis_izin='Datang Pukul',1,0)) as jml_telat,sum(if(jenis_izin='Pulang Pukul',1,0)) as jml_plg,sum(if(jenis_izin='Tidak Dapat Masuk',lama,0)) as jml_izin,sum(if(alasan like '%sakit%',lama,0)) as jml_sakit",false)
                                      ->get('tab_izin')
                                      ->row();
                    $q_cuti=$this->db
                                      ->where('tanggal_mulai >=',$tgl1)
                                      ->where('tanggal_mulai <=',$tgl2)
                                      ->where('nik',$tampil->nik)
                                      ->select("sum(lama_cuti) as jml_cuti")
                                      ->get('tab_cuti')
                                      ->row();
                    /*if (!empty($q_absen->jml_absen)) {
                        $real=date('H:i',strtotime($q_absen->jml_absen));
                    }else{
                      $real=0;
                    }*/
                    $q_dp=$this->db->where('nik',$tampil->nik)->select('saldo_dp')->get('tab_master_dp')->row();
                    //$this->table->add_row('CRN',$tampil->cabang,$tampil->department,$tampil->status_kerja,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$lama,$lama2,$jml_hadir,$q_cuti->jml_cuti,$q_izin->jml_izin,$jml_bolos,$q_izin->jml_sakit,$q_izin->jml_telat,$q_izin->jml_plg,$q_ekstra->total_ekstra,$q_dp->saldo_dp,$q_ekstra->total_dp);
                    $this->table->add_row('CRN',$tampil->cabang,$tampil->department,$tampil->status_kerja,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$lama,$lama2,$jml_hadir,$q_cuti->jml_cuti,$q_izin->jml_izin,$jml_bolos,$q_izin->jml_sakit,$q_izin->jml_telat,$q_izin->jml_plg,$q_ekstra->total_ekstra);
                $no++;
                }
                $tabel=$this->table->generate();
                echo $tabel;
              ?>
              <div class="form-group">
                <button class="btn btn-success">Export Excel</button>
              </div>
            </form>
      </div>
    </div>

