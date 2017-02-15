<!-- ketika button detail diklik -->

    <div class="col-md-12">
    <h4>Detail Gaji Casual Karyawan Plant <?=$cabang?> Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h4>
    <hr>
    <form method="post" action="<?=base_url('Laporan/ex_gaji_casual_detail')?>" target="new">
    <input type="hidden" name="bln" value="<?php echo $bln?>">
    <input type="hidden" name="thn" value="<?php echo $thn?>">
    <input type="hidden" name="cabang" value="<?php echo $cabang?>">
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <?php
      if($data==true){
      $no=1;

      foreach ($data as $tampil){

        if ($tampil->approval=="0") {
          $app = "Belum";
          $cetak = "hidden";
        } else if ($tampil->approval=="1") {
          $app = "Tidak";
          $cetak = "hidden";
        } else if ($tampil->approval=="2") {
          $cetak = " ";
          $app = "Setuju";
        }

        /*$periode1 = 0;
        $tot_absen=$this->model_gaji->count_absen_casual($tampil->field1,$tampil->field17);
        foreach ($tot_absen as $val1){
          //$periode1 = $val1->jml;
          if ($val1->status_masuk!="-"&&$val1->status_masuk!="Libur"&&$val1->status_masuk!="Bolos"&&$val1->status_masuk!=NULL&&$val1->status_masuk!="Masuk Tidak Lengkap"&&$val1->status_masuk2!="Masuk Tidak Lengkap"&&$val1->status_keluar!="Pulang Tidak Lengkap"&&$val1->status_keluar2!="Pulang Tidak Lengkap") {
            if ($val1->kode_jam=="N"||$val1->kode_jam=="O"||$val1->kode_jam=="P"||$val1->kode_jam=="Q"||$val1->kode_jam=="R"||$val1->kode_jam=="X1") {
              $periode1 = $periode1 + 0.5;
            } else {
              $periode1 = $periode1 + 1;
            }
          }
        }
        $periode2 = 0;
        $tot_absen2=$this->model_gaji->count_absen_casual2($tampil->field1,$tampil->field18);
        foreach ($tot_absen2 as $val2){
          //$periode2 = $val2->jml;
          //$periode1 = $val1->jml;
          if ($val2->status_masuk!="-"&&$val2->status_masuk!="Libur"&&$val2->status_masuk!="Bolos"&&$val2->status_masuk!=NULL&&$val2->status_masuk!="Masuk Tidak Lengkap"&&$val2->status_masuk2!="Masuk Tidak Lengkap"&&$val2->status_keluar!="Pulang Tidak Lengkap"&&$val2->status_keluar2!="Pulang Tidak Lengkap") {
            if ($val2->kode_jam=="N"||$val2->kode_jam=="O"||$val2->kode_jam=="P"||$val2->kode_jam=="Q"||$val2->kode_jam=="R"||$val2->kode_jam=="X1") {
              $periode2 = $periode2 + 0.5;
            } else {
              $periode2 = $periode2 + 1;
            }
          }
        }*/

        $this->table->add_row(
          $no,
          $tampil->nik,
          $tampil->nama_ktp,
          $tampil->status_kerja,
          $tampil->no_npwp,
          $tampil->alamat_ktp,
          $tampil->pajak,
          $tampil->nama_rekening,
          $tampil->no_rekening,
          $this->format->indo($tampil->gaji_casual),
          $tampil->jml_hadir,
          $this->format->indo($tampil->uang_makan_real),
          $this->format->indo(($tampil->jml_hadir * $tampil->uang_makan_real) + ($tampil->jml_hadir * $tampil->gaji_casual)),
          $this->format->indo($tampil->gaji_ekstra),
          $this->format->indo(
            (($tampil->jml_hadir * $tampil->uang_makan_real) + ($tampil->jml_hadir * $tampil->gaji_casual)) + $tampil->gaji_ekstra
          ),
          $this->format->indo((round($tampil->jml_hadir, 0, PHP_ROUND_HALF_UP) * $tampil->uang_makan_real)),
          $this->format->indo($tampil->pph),
          $this->format->indo($tampil->gaji_diterima),
          $this->format->indo($tampil->gaji_casual),
          $tampil->jml_hadir2,
          $this->format->indo($tampil->uang_makan_real),
          $this->format->indo(($tampil->jml_hadir2 * $tampil->uang_makan_real) + ($tampil->jml_hadir2 * $tampil->gaji_casual)),
          $this->format->indo($tampil->gaji_ekstra2),
          $this->format->indo(
            (($tampil->jml_hadir2 * $tampil->uang_makan_real) + ($tampil->jml_hadir2 * $tampil->gaji_casual)) + $tampil->gaji_ekstra2
          ),
          $this->format->indo((round($tampil->jml_hadir2, 0, PHP_ROUND_HALF_UP) * $tampil->uang_makan_real)),
          $this->format->indo($tampil->pph2),
          $this->format->indo($tampil->gaji_diterima2),
          $tampil->jml_hadir + $tampil->jml_hadir2,
          $this->format->indo(
            ((($tampil->jml_hadir * $tampil->uang_makan_real) + ($tampil->jml_hadir * $tampil->gaji_casual)) + $tampil->gaji_ekstra) + 
            ((($tampil->jml_hadir2 * $tampil->uang_makan_real) + ($tampil->jml_hadir2 * $tampil->gaji_casual)) + $tampil->gaji_ekstra2)
          ),
          $this->format->indo($tampil->gaji_diterima + $tampil->gaji_diterima2),
          $app);

        $no++;
      }
      
      $tabel=$this->table->generate();
      
      echo $tabel;
      
      } else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
    </div>
    <div class="form-group">
      <button onclick="window.history.go(-1); return false;" class="btn btn-warning" type="button">Kembali</button>
      <button class="btn btn-success" type="submit">Export Excel</button>
    </div>
    </form>
</div>