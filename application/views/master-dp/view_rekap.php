<style type="text/css">
  #tabel th{
    text-align: center;
  }
</style>
<div class="row">
    <div class="col-md-12">
      <h4>Rekapitulasi Saldo DP / Cuti Karyawan Bulan <?=$this->format->BulanIndo($bulan)?> Tahun <?=$tahun?></h4>
      <hr>
    </div>
</div>

      <!--<form class="form-inline" name="formPrint" method="post" action="" style="margin-bottom: 30px;">
          <div class="form-group m-r-20">
              <label class="m-r-10">Bulan</label>
              <select class="form-control" name="bulan">
                <option selected value="<?=date('m')?>"><?=$this->format->BulanIndo(date('m'))?></option>
                <?php
                  for ($i=1; $i <=12 ; $i++) { 
                    echo "<option value='$i'>".$this->format->BulanIndo($i)."</option>";
                  }
                ?>
              </select>
          </div>
          <div class="form-group m-r-20">
              <label class="m-r-10">Tahun</label>
              <select class="form-control" name="tahun">
                  <option selected><?=date("Y")?></option>
                <?php
                  for ($i=2050; $i >= 2000 ; $i--) { 
                    echo "<option>$i</option>";
                  }
                ?>
              </select>
          </div>
          <button type="submit" class="btn btn-info" id="btn-cetak" >Filter Data</button>
      </form>-->


      <form class="form-horizontal" id="form-periode" method="POST">
          <div class="form-group row">
            <label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
              <div class="col-sm-4">
                <select class="form-control" name="bln">
                  <option value="<?=$bulan?>"><?=$this->format->BulanIndo($bulan)?></option>
                  <?php 
                  $arr_bln = "Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember";
                  // explode is used to explode string into array based on the delimiter
                  $bln1 = explode(",", $arr_bln);
                  for ($i=1; $i <=12 ; $i++) {
                    echo '<option value="'.$i.'">'.$bln1[$i-1].'</option>'; 
                  }
                  ?>
                </select>
              </div>
              <div class="col-sm-4">
                <select class="form-control" name="thn">
                    <option value="<?=date("Y")?>" selected><?=date("Y")?></option>
                  <?php
                    for ($i=2050; $i >= 2000 ; $i--) { 
                      echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                  ?>
                </select>
              </div>
              <div class="col-sm-2 text-left">
                  <button type="submit" class="btn btn-primary">Filter</button>
              </div>
          </div>
      </form>

<div class="row">
  <div class="col-sm-12">
      <form method="post" action="<?=base_url('Laporan/ex_dpcuti')?>" target="new">
          <input type="hidden" name="bulan" value="<?=$bulan?>">
          <input type="hidden" name="tahun" value="<?=$tahun?>">
          <input type="hidden" name="cabang" value="<?=$cabang?>">
          <div class="table-responsive" style="overflow: scroll;">
              <table class="table table-hover table-striped table-bordered" id="tabel">
                <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2">NIK</th>
                  <th rowspan="2">Nama</th>
                  <th colspan="6">DP</th>
                  <th colspan="5">Cuti</th>
                </tr>
                <tr>
                <?php
                  if ($bulan == '1' || $bulan == '01') {
                ?>
                  <th>Saldo Akhir DP <?=$this->format->BulanIndo('12').' '.($tahun-1)?></th>
                  <th>Adjusment</th>
                  <th>Saldo Awal DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Jth DP</th>
                  <th>Libur</th>
                  <th>Saldo Akhir DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Saldo Akhir Cuti <?=$this->format->BulanIndo('12').' '.($tahun-1)?></th>
                  <th>Adjusment</th>
                  <!--<th>Cuti (Minus)</th>-->
                  <th>Saldo Awal Cuti <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Minus DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <!--<th>Saldo Cuti Hangus <?=$this->format->BulanIndo($bulan).' '.($tahun-1)?></th>-->
                  <!--<th>Saldo Akhir Cuti <?=$tahun-1?></th>-->
                  <th>Saldo Akhir Cuti <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                <?php
                  } else {
                ?>
                  <th>Saldo Akhir DP <?=$this->format->BulanIndo($bulan-1).' '.$tahun?></th>
                  <th>Adjusment</th>
                  <th>Saldo Awal DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Jth DP</th>
                  <th>Libur</th>
                  <th>Saldo Akhir DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Saldo Akhir Cuti <?=$this->format->BulanIndo($bulan-1).' '.$tahun?></th>
                  <th>Adjusment</th>
                  <!--<th>Cuti (Minus)</th>-->
                  <th>Saldo Awal Cuti <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <th>Minus DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                  <!--<th>Saldo Cuti Hangus <?=$this->format->BulanIndo($bulan).' '.($tahun-1)?></th>-->
                  <!--<th>Saldo Akhir Cuti <?=$tahun-1?></th>-->
                  <th>Saldo Akhir Cuti <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
                <?php
                  }
                ?>
                </tr>
                <?php
                $no=1;
                foreach ($data as $tampil) {
                  $new_bln = date($tahun.'-'.$tampil->bln.'-d');
                  $bln_fix = date('m',strtotime($new_bln));
                  $thn_fix = date('Y',strtotime($new_bln));
                  
                  if ($bln_fix == '1' || $bln_fix == '01') {
                    $new_bln2 = date(($thn_fix-1).'-'.(12).'-d');
                    $bln_fix2 = date('m',strtotime($new_bln2));
                    $thn_fix2 = date('Y',strtotime($new_bln2));
                  } else {
                    $new_bln2 = date($thn_fix.'-'.($tampil->bln-1).'-d');
                    $bln_fix2 = date('m',strtotime($new_bln2));
                    $thn_fix2 = date('Y',strtotime($new_bln2));
                  }

                  $begin_day_unix   = strtotime($new_bln.' 00:00:00');
                  $begin_day_unix2  = strtotime($new_bln2.' 00:00:00');

                  $hari_ini = $tahun.'-'.$bulan; // misal 8-2016 (sekarang)
                  $tgl_pertama  = date('Y-m-01', strtotime($hari_ini)); // awal bulan
                  $tgl_terakhir   = date('Y-m-t', strtotime($hari_ini)); // akhir bulan

                  // if ($tampil->nik_resign==NULL||$tampil->tanggal_resign>$tgl_pertama) {
                  /*if ($tampil->nik_resign==NULL||$tampil->tanggal_resign<$tampil->tanggal_masuk||$tampil->tanggal_masuk<$tgl_terakhir) {
                  if ($tampil->tanggal_masuk<$tgl_terakhir) {*/

                  /*$cuti=$this->db->where('nik',$tampil->nik)
                           ->where('month(tanggal_mulai)',$bln_fix)
                           ->where('cuti_khusus','Tidak')
                           ->select('sum(lama_cuti) as jml_cuti')
                           ->get('tab_cuti')->row();*/
                  /*$izin=$this->db->where('nik',$tampil->nik)
                           ->where('month(tanggal_mulai)',$bln_fix)
                           ->where('jenis_izin','Tidak Dapat Masuk')
                           ->select('sum(lama) as jml_izin')
                           ->get('tab_izin')->row();*/
                  $saldo_bln_lalu=$this->db->where('nik',$tampil->nik)
                               ->where("bulan",$bln_fix2)
                               ->where("tahun",$thn_fix2)
                               ->select("*")
                               ->get('tab_master_dp')->row();
                  /*$saldo_thn_lalu=$this->db->where('nik',$tampil->nik)
                               ->where('bulan',$tampil->bln)
                               ->where('tahun',$tampil->thun-1)
                               ->select("saldo_cuti")
                               ->get('tab_master_dp')->row();*/
                  $total_thun_lalu=$this->db->where('nik',$tampil->nik)
                                           ->where('year(bulan)',$tampil->thun-1)
                                           ->select("sum(saldo_cuti) as total")
                                           ->get('tab_master_dp')->row();

                  //MENCARI JATAH DP
                  // CARI JUMLAH DP
                  $hari_ini = $tahun.'-'.$bulan; // misal 8-2016 (sekarang)
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

                  /*if ($saldo_bln_lalu->saldo_dp<0) {
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
                  }*/

                  //$libur=$izin->jml_izin+$cuti->jml_cuti;
                  if (date('Y-m-d',strtotime($tgl_pertama))<date('Y-m-d',strtotime($tampil->tanggal_masuk))) {
                    $absen_query = $this->db->select('a.*,a.kode_jam as kode_jam_fix,b.*')
                                            ->from('tab_absensi a')
                                            ->join('tab_jam_kerja b','b.kode_jam=a.kode_jam','inner')
                                            ->where('a.nik',$tampil->nik)
                                            ->where('a.tgl_kerja >=',date('Y-m-d',strtotime($tampil->tanggal_masuk)))
                                            ->where('a.tgl_kerja <=',$tgl_terakhir)
                                            ->get();
                  } else {
                    $absen_query = $this->db->select('a.*,a.kode_jam as kode_jam_fix,b.*')
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

                          // if ($tampil->nik=="9300061") {
                          //   echo $selisih1." ".$selisih2;
                          // }

                          if ($selisih<$batas) {
                            $jml_absen += 0.5;
                          }
                          // $time1    = strtotime($row->jam_masuk1);
                          // $time2    = strtotime($row->jam_keluar1);
                          // $selisih  = date('H:i:s', ($time2 - ($time1 - $begin_day_unix)));
                          // $batas = date('H:i:s', (strtotime("05:00:00"));
                          // if ($selisih<$batas) {
                          //   $jml_absen += 0.5;
                          // }
                        } else if ($row->keterangan_masuk=="Telat") {
                          $jam_telat = date('i', strtotime($row->jam_masuk1));
                          $jam1 = 60;
                          $jam2 = 8;

                          if ($jam_telat) {
                            $jml_absen += round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_UP);
                          }

                        } 

                        if ($row->status_masuk!="Bolos") {
                          if ($row->kode_jam_fix=="N"||$row->kode_jam_fix=="O"||$row->kode_jam_fix=="P"||$row->kode_jam_fix=="Q"||$row->kode_jam_fix=="R") {
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
                        
                        if ($row->keterangan_masuk=="Telat") {
                          $jam_telat = date('i', strtotime($row->jam_masuk1));
                          $jam1 = 60;
                          $jam2 = 8;

                          if ($jam_telat) {
                            $jml_absen += round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_UP);
                          }
                        } 
                        
                        if ($row->keterangan_masuk2=="Telat") {
                          $jam_telat = date('i', strtotime($row->jam_masuk2));
                          $jam1 = 60;
                          $jam2 = 8;

                          if ($jam_telat) {
                            $jml_absen += round($jam_telat/$jam1/$jam2,2,PHP_ROUND_HALF_UP);
                          }
                        }

                        if ($row->status_masuk!="Bolos") {
                          if ($row->kode_jam_fix=="N"||$row->kode_jam_fix=="O"||$row->kode_jam_fix=="P"||$row->kode_jam_fix=="Q"||$row->kode_jam_fix=="R") {
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

                        if ($row->kode_jam_fix=="N"||$row->kode_jam_fix=="O"||$row->kode_jam_fix=="P"||$row->kode_jam_fix=="Q"||$row->kode_jam_fix=="R") {
                          $jml_absen += 0.5;
                        }
                      }
                    }
                  }
                        // if ($tampil->nik=="9300045") {
                        //   echo $row->tgl_kerja;
                        // }

                  
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
                  /*echo "<tr>
                       <td>$no</td>
                       <td>$tampil->nama_ktp</td>
                       <td>$saldo_bln_lalu->saldo_dp</td>
                       <td>$jatah_dp</td>
                       <td>$libur</td>
                       <td>$tampil->saldo_dp</td>
                       <td>$total_thun_lalu->total</td>
                       <td>$adj</td>
                       <td>$tampil->saldo_cuti</td>
                       <td>$dp_min</td>
                       <td>$min_dp</td>
                       <td>$saldo_hangus</td>
                       <td>0</td>
                       <td>$tampil->saldo_cuti</td>
                    </tr>";*/
                  if ($tampil->tanggal_masuk>=$tgl_pertama&&$tampil->tanggal_masuk<=$tgl_terakhir) {
                    $dp_bln_lalu_real = $saldo_bln_lalu->saldo_dp;
                    if ($tampil->status_kerja=="Kontrak 1") {
                      $dp_bln_lalu_real = 0;
                    } else if ($tampil->status_kerja=="Kontrak 2") {
                      if ($dp_bln_lalu_real!=NULL) {
                        $dp_bln_lalu_real = $dp_bln_lalu_real;
                      } else {
                        $dp_bln_lalu_real = 0;
                      } 
                    }
                  } else {
                    $dp_bln_lalu_real = $saldo_bln_lalu->saldo_dp;
                    if ($dp_bln_lalu_real!=NULL) {
                      $dp_bln_lalu_real = $dp_bln_lalu_real;
                    } else {
                      $dp_bln_lalu_real = 0;
                    } 
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
                    $adj_dp = $jml_ekstra + abs($dp_bln_lalu_real);
                  }

                  if ($dp_bln_lalu_real>$libur&&$jatah_dp!=0) {
                    $adj_dp = $adj_dp - ($dp_bln_lalu_real - $libur);
                  }


                  if ($tampil->tanggal_masuk>=$tgl_pertama&&$tampil->tanggal_masuk<=$tgl_terakhir) {
                    $dp_bln_lalu = $saldo_bln_lalu->saldo_dp + $adj_dp;
                    if ($tampil->status_kerja=="Kontrak 1") {
                      $dp_bln_lalu = 0;
                    } else if ($tampil->status_kerja=="Kontrak 2") {
                      if ($dp_bln_lalu_real!=NULL) {
                        $dp_bln_lalu = $dp_bln_lalu;
                      } else {
                        $dp_bln_lalu = 0;
                      } 
                    }
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

                  if ($tampil->status_kerja=="Kontrak 1") {
                    $cuti_bln_lalu = 0;
                    $adj_cuti = 0;
                    $cuti_awal = 0;
                  } else {
                    if ($saldo_bln_lalu->saldo_cuti!=NULL) {
                      $cuti_bln_lalu = $saldo_bln_lalu->saldo_cuti;
                    }

                    if ($cuti_bln_lalu>0) {
                      $adj_cuti = 0;
                    } else {
                      $adj_cuti = abs($cuti_bln_lalu);
                    }

                    if ($cuti_bln_lalu>0) {
                      $cuti_awal = $cuti_bln_lalu;
                    } else {
                      $cuti_awal = 0;
                    }
                  }

                  $cuti_bln_sekarang = $cuti_awal + $minus_dp; 

                  if ($tgl_pertama==$tampil->tanggal_masuk&&$tampil->status_kerja!="Kontrak 1") {
                    $adj_cuti = 12;
                    $cuti_awal = 12;
                    $cuti_bln_sekarang = 12;
                  }

                  if ($bln_fix == '1' || $bln_fix == '01') {
                    if ($tampil->status_kerja == "Tetap") {
                      $adj_cuti = $cuti_bln_lalu + 12;
                      $cuti_awal = $adj_cuti;
                      $cuti_bln_sekarang = $cuti_awal + $minus_dp;
                    }
                  }

                  // if ($tampil->nik=="9300081") {
                  //   // echo $jml_absen." ".$jml_cuti." ".$jml_izin;
                  //   echo $tgl_pertama." ".$tampil->tanggal_masuk." ".$tampil->status_kerja;
                  //   // echo $cuti_bln_lalu;
                  // }

                  echo "<tr>
                       <td>$no</td>
                       <td>$tampil->nik</td>
                       <td>$tampil->nama_ktp</td>
                       <td>$dp_bln_lalu_real</td>
                       <td>$adj_dp</td>
                       <td>$dp_bln_lalu</td>
                       <td>$jatah_dp</td>
                       <td>$libur</td>
                       <td>$dp_bln_sekarang</td>
                       <td>$cuti_bln_lalu</td>
                       <td>$adj_cuti</td>
                       <td>$cuti_awal</td>
                       <td>$minus_dp</td>
                       <td>$cuti_bln_sekarang</td>
                    </tr>";
                  $no++;
                  $data_new = array(
                    'saldo_dp' => $dp_bln_sekarang,
                    'saldo_cuti' => $cuti_bln_sekarang,
                  );

                  $this->db->where('nik',$tampil->nik);
                  $this->db->where('bulan',$bln_fix);
                  $this->db->where('tahun',$thn_fix);
                  $this->db->update('tab_master_dp',$data_new);
                  //}
                  // }
                }
                ?>
              </table>
            </div>
          <div class="form-group">
            <!--<button type="submit" name="btn_aksi" value="cetak" class="btn btn-primary">
              Print All Data
            </button>-->
            <button type="submit" name="btn_aksi" value="excel" class="btn btn-success">
              Export Excel
            </button>
          </div>  
      </form>

  </div>
<div>
<script type="text/javascript">
  $('#filter').click(function(){
    $("#form-filter").show( "slide", {direction: "left" }, 500 );
  })
  $( document ).ready(function() {
          $('#form-filter').hide();
  });
</script>