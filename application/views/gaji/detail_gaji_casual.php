<!-- ketika button detail diklik -->

    <div class="col-md-12">
    <h4>Detail Gaji Casual Karyawan Plant <?=$cabang?></h4>
    <hr>
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <?php
      if($data==true){
      $no=1;
      /*$jamsostek = 0;
      $pokok = 0;
      $tunjangan = 0;
      $ekstra = 0;
      $dp_cuti = 0;
      $pinjaman = 0;
      $pph = 0;
      $jht = 0;
      $jpk = 0;
      $diterima = 0;*/

      foreach ($data as $tampil){

        /*$jamsostek = $jamsostek+$tampil->field5;
        $pokok = $pokok+$tampil->field5;
        $tunjangan = $tunjangan+$tampil->field7;
        $ekstra = $ekstra+$tampil->field8;
        $dp_cuti = $dp_cuti+$tampil->field9;
        $pinjaman = $pinjaman+$tampil->field10;
        $pph = $pph+$tampil->field11;
        $jht = $jht+$tampil->field12;
        $jpk = $jpk+$tampil->field13;
        $diterima = $diterima+$tampil->field14;*/

        // $array_gaji = array(
        //   'nik'         => $tampil->field1,
        //   'nama'        => $tampil->field2
        // );

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

        //$jml = round($periode1, 0, PHP_ROUND_HALF_UP)+round($periode2, 0, PHP_ROUND_HALF_UP);

        // $this->table->add_row($no,$tampil->field1,$tampil->field2,$tampil->field3,$tampil->field4,$tampil->field5,$tampil->field6,$tampil->periode1,$tampil->periode2,$this->format->indo($tampil->field7),$this->format->indo($tampil->field8),$this->format->indo($tampil->field9),$this->format->indo($tampil->field13),$this->format->indo($tampil->field10),$this->format->indo($tampil->field11),$this->format->indo($tampil->field14),$this->format->indo($tampil->field12),$app,$tampil->field16,'<a class="label label-info" href="'.base_url()."GajiController/print_data2/".base64_encode(implode(':', $array_gaji))."".'" target="new"  '.$cetak.'>Cetak Slip</a>');
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
          $app,
          '');

        $no++;
      }

      //$this->table->add_row(array('data'=>''),array('data'=>'Total','colspan'=>4),$this->format->indo($jamsostek),$this->format->indo($pokok),$this->format->indo($tunjangan),$this->format->indo($ekstra),$this->format->indo($dp_cuti),$this->format->indo($pinjaman),$this->format->indo($pph),$this->format->indo($jht),$this->format->indo($jpk),$this->format->indo($diterima),'','','');
      
      $tabel=$this->table->generate();
      
      echo $tabel;
      
      } else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
    </div>
    <div class="form-group">
      <button onclick="window.history.go(-1); return false;" class="btn btn-warning" type="button">Kembali</button>
    </div>
</div>