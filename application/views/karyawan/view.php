<div class="col-md-12">
    <h3>Halaman Rekapitulasi Data Karyawan</h3>
    <hr>
    <form class="form-inline" name="formPrint" method="post" action="<?=base_url()?>cetak/karyawan">
          <div class="form-group m-r-20">
              <label class="m-r-10">Plant</label>
              <select class="form-control" name="cabang">
              <option value="">All</option>
                <?php
                  $cb=$this->db->get('tab_cabang')->result();
                  foreach ($cb as $cabang) {
                    echo "<option value='$cabang->id_cabang'>$cabang->cabang</option>";
                  }
                ?>
              </select>
          </div>
          <button type="submit" class="btn btn-warning" id="btn-cetak" >Filter Data</button>
      </form>
    <div class="table-responsive" style="overflow: scroll; max-height: 1000px; margin-top: 10px;">
      <table class="table table-hover table-striped table-bordered">
        <tr>
          <th rowspan="2">No</th>
          <th rowspan="2">NIK</th>
          <th rowspan="2">Nama</th>
          <th rowspan="2">Alamat KTP</th>
          <th rowspan="2">Alamat Domsisili</th>
          <th rowspan="2">Pendidikan Terakhir</th>
          <th rowspan="2">Telp</th>
          <th rowspan="2">Telp Emergency</th>
          <th rowspan="2">Status Hubungan</th>
          <th rowspan="2">Tanggal Lahir</th>
          <th rowspan="2">Status Perkawinan</th>
          <th rowspan="2">Tanggungan</th>
          <th rowspan="2">Jenis Kelamin</th>
          <th rowspan="2">BPJS Keketenaga Kerjaan</th>
          <th rowspan="2">BPJS Keketenaga Kesehatan</th>
          <th rowspan="2">Nama Rekening</th>
          <th rowspan="2">No Rekening</th>
          <th rowspan="2">Tanggal Awal Masuk</th>
          <th rowspan="2">Jabatan</th>
          <th rowspan="2">NO NPWP</th>
          <th rowspan="2">Nama NPWP</th>
          <th rowspan="2">Alamat NPWP</th>
          <th rowspan="2">Status Pajak</th>
          <th rowspan="2">Status</th>
          <th colspan="2">Tanggal Status</th>
          <th rowspan="2">Tanggal Resign</th>
          <th colspan="1">Asuransi</th>
          <th colspan="2">Bonus</th>
          <th colspan="3">T3 <?=date('Y')?></th>
          <th colspan="1">Komisi</th>
          <th rowspan="2">Gaji Pokok</th>
          <th rowspan="2">Tunjangan Jabatan</th>
          <th rowspan="2">Standar Hadir</th>
          <th rowspan="2">Uang Makan</th>
          <th rowspan="2">Gaji BPJS</th>
          <th colspan="2">JHT</th>
          <th colspan="1">JKK</th>
          <th colspan="1">JKM</th>
          <th colspan="2">BPJS Kesehatan</th>
          <th colspan="1">Total BPJS</th>
          <th rowspan="2">JPK, JKM,JKK Beban Perusahaan</th>
        </tr>
        <tr>
          <th>Awal</th>
          <th>Akhir</th>
          <!--<th>Vendor</th>
          <th>Asuransi</th>
          <th>No Premi</th>-->
          <th>Tarif</th>
          <th>Grade</th>
          <th>Bonus Terkini</th>
          <!--<th>Rata-rata</th>-->
          <th>Hari</th>
          <th>Tarif/Hari</th>
          <th>Total T3</th>
          <!--<th>Rata-rata</th>-->
          <th>Komisi Terkini</th>
          <!--<th>Rata-rata</th>-->
          <th><?=$ketenaga->jht_1?>%</th>
          <th><?=$ketenaga->jht_2?>%</th>
          <th><?=$ketenaga->jkk?>%</th>
          <th><?=$ketenaga->jkm?>%</th>
          <th><?=$kesehatan->jpk_1?>%</th>
          <th><?=$kesehatan->jpk_2?>%</th>
          <th>Biaya BPJS Perusahaan</th>
        </tr>
      <?php
      if($data==true){
        $no=1;
        foreach ($data as $tampil){
          $total_tanggungan=($ketenaga->jht_1/100*$tampil->gaji_bpjs)+($ketenaga->jkk/100*$tampil->gaji_bpjs)+($ketenaga->jkm/100*$tampil->gaji_bpjs)+($kesehatan->jpk_1/100*$tampil->gaji_bpjs);
          $keluarga=$this->db->where('nik',$tampil->nik_karyawan)->get('tab_keluarga')->result();
          $tenaga=$this->db->where('nik',$tampil->nik_karyawan)->where('id_bpjs',1)->get('tab_bpjs_karyawan')->row();
          $ks=$this->db->where('nik',$tampil->nik_karyawan)->where('id_bpjs',2)->get('tab_bpjs_karyawan')->row();
          $komisi=$this->db->where('nik',$tampil->nik_karyawan)->where('month(bulan)',date('m'))->select('sum(komisi) as jml_komisi')->get('tab_komisi')->row();
          $t3=$this->db->where('nik',$tampil->nik_karyawan)->where('month(tanggal)',date('m'))->get('tab_t3')->row();
          $bonus=$this->db->where('nik',$tampil->nik_karyawan)->where('month(tanggal_bonus)',date('m'))->select('sum(bonus_nominal+senioritas+grade+bonus_prosen+bonus_prorata) as jml_bonus')->get('tab_bonus_karyawan')->row();
          $telp=array();
          $hub=array();
          foreach ($keluarga as $rs_kel) {
            $telp[]=$rs_kel->nomor_telp;
            $hub[]=$rs_kel->hubungan;
          }
          $tel_kel=implode("<br>", $telp);
          $hubungan=implode('<br>', $hub);
          $tarif_t3=($t3->total_t3!=0) ? $t3->total_t3/$t3->jml_hadir:0;
          $total2=($ketenaga->jkk/100*$tampil->gaji_bpjs)+($ketenaga->jkm/100*$tampil->gaji_bpjs)+($kesehatan->jpk_1/100*$tampil->gaji_bpjs);

          //hitung rata bonus
          $all_bonus=$this->db->where('nik',$tampil->nik_karyawan)->select('sum(bonus_nominal+senioritas+grade+bonus_prosen+bonus_prorata) as jml_bonus,count(nik) as kali')->get('tab_bonus_karyawan');
          $rata_bonus=($all_bonus->jml_bonus!= 0)?$all_bonus->jml_bonus/$all_bonus->kali:0;

          //hitung rata t3
          $all_t3=$this->db->where('nik',$tampil->nik_karyawan)->select('sum(total_t3) as jml_t3,count(nik) as kali')->get('tab_t3');
          $rata_t3=($all_t3->jml_t3 != 0)?$all_t3->jml_t3/$all_t3->kali:0;

          //hitung komisi
          $all_komisi=$this->db->where('nik',$tampil->nik_karyawan)->select('sum(komisi) as jml_komisi,count(nik) as kali')->get('tab_komisi');
          $rata_komisi=( $all_komisi->jml_komisi !=0)?$all_komisi->jml_komisi/$all_komisi->kali:0;        
          echo "<tr>
                    <td>$no</td>
                    <td>$tampil->nik_karyawan</td>
                    <td>$tampil->nama_ktp</td>
                    <td>$tampil->alamat_ktp</td>
                    <td>$tampil->alamat_domisili</td>
                    <td>$tampil->pendidikan_terakhir</td>
                    <td>".str_replace(':', '<br>', $tampil->telepon)."</td>
                    <td>$tel_kel</td>
                    <td>$hubungan</td>
                    <td>".$this->format->TanggalIndo($tampil->tanggal_lahir)."</td>
                    <td>$tampil->status_perkawinan</td>
                    <td>$tampil->tanggungan</td>
                    <td>$tampil->jenis_kelamin</td>
                    <td>$tenaga->no_bpjs</td>
                    <td>$ks->no_bpjs</td>
                    <td>$tampil->nama_rekening</td>
                    <td>$tampil->no_rekening</td>
                    <td>".date('d-m-Y',strtotime($tampil->tanggal_awal))."</td>
                    <td>$tampil->jabatan</td>
                    <td>$tampil->no_npwp</td>
                    <td>$tampil->nama_npwp</td>
                    <td>$tampil->alamat_npwp</td>
                    <td>$tampil->pajak</td>
                    <td>$tampil->status_kerja</td>
                    <td>".$this->format->TanggalIndo($tampil->tanggal_masuk)."</td>
                    <td>".$this->format->TanggalIndo($tampil->tanggal_resign)."</td>
                    <td>".$this->format->TanggalIndo($tampil->tanggal_resign)."</td>
                    <td>".$this->format->indo($tampil->nominal_asuransi)."</td>
                    <td>$tampil->grade</td>
                    <td>".$this->format->indo($bonus->jml_bonus)."</td>
                    <td>$t3->jml_hadir</td>
                    <td>".$this->format->indo($tarif_t3)."</td>
                    <td>".$this->format->indo($t3->total_t3)."</td>
                    <td>".$this->format->indo($komisi->jml_komisi)."</td>
                    <td>".$this->format->indo($tampil->gaji_pokok)."</td>
                    <td>".$this->format->indo($tampil->tunjangan_jabatan)."</td>
                    <td>$tampil->standard_hadir</td>
                    <td>".$this->format->indo($tampil->uang_makan)."</td>
                    <td>".$this->format->indo($tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($ketenaga->jht_1/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($ketenaga->jht_2/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($ketenaga->jkk/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($ketenaga->jkm/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($kesehatan->jpk_1/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($kesehatan->jpk_2/100*$tampil->gaji_bpjs)."</td>
                    <td>".$this->format->indo($total_tanggungan)."</td>
                    <td>".$this->format->indo($total2)."</td>
                    </tr>";
        $no++; 
        }
        echo "</table>";
        }else {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
      </div>
      <div class="col-xs-12 col-lg-4">
            <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapse-example-1" aria-expanded="false" aria-controls="collapse-example-1">
        Cetak ALL
            </button>
            <a href="<?=base_url('Laporan/ex_karyawan')?>" class="btn btn-warning" target="new">Export Excel</a>
        <div class="collapse" id="collapse-example-1">
            <div class="card card-block">
            <form method="post" action="<?=site_url()?>karyawan/print/all" target="new">
                  <div class="form-group">
                      <label>PLANT</label>
                      <select name="cabang" class="form-control">
                            <option value="0">All</option>
                            <?php
                              $cab=$this->db->get('tab_cabang')->result();
                              foreach ($cab as $rs_cabang) {
                                echo "<option value='$rs_cabang->id_cabang'>$rs_cabang->cabang</option>";
                              }
                            ?>
                      </select>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-default">Cetak</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>