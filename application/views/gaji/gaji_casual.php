<div class="col-md-12">
    <h4>Halaman Gaji Karyawan Casual</h4>
    <hr>
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
        /*
        $kalender=CAL_GREGORIAN;
        $bulan = date('m');
        $tahun= date('Y');
        $jml_hari=cal_days_in_month($kalender, $bulan, $tahun);
        */
        $hitungan=$this->model_gaji->keterangan_casual($tampil->nik_karyawan);
        /*
        $total_pph += $tampil->jml_pph;
        $total_ekstra += $hitungan['ekstra'];
        $total_cuti += $hitungan['cuti'];
        $jpk=($tampil->gaji_bpjs*$hitungan['jpk'] != 0)? ($tampil->gaji_bpjs*$hitungan['jpk']/100):0;
        $jht=($tampil->gaji_bpjs*$hitungan['jht'] != 0)? ($tampil->gaji_bpjs*$hitungan['jht']/100):0;
        $total_jht += $jht;
        $total_jpk += $jpk;
        $gaji_bersih=($tampil->gaji_pokok+$hitungan['ekstra'])-$tampil->jml_pph-($jpk+$jht)-$hitungan['cuti']-$hitungan['pinjaman'];
        */
        
        /*
        $total_gaji += $gaji_bersih;
        $total_pokok += $tampil->gaji_pokok;
        $total_bpjs += $tampil->gaji_bpjs;
        $array_gaji=array('nik'=>$tampil->nik_karyawan,
                           'nama'=>$tampil->nama_ktp,
                           'gaji'=>$tampil->gaji_pokok,
                           'extra'=>$hitungan['ekstra'],
                           'pph'=>$tampil->jumlah_pph,
                           'dp_cuti'=>$hitungan['cuti'],
                           'jht'=>$jht,
                           'jpk'=>$jpk,
                           'gaji_terima'=>$gaji_bersih,
                           'no_gaji'=>$tampil->id_gaji_karyawan,
                           'cabang'=>$tampil->cabang,
                           'jabatan'=>$tampil->jabatan,
                           'pinjaman'=>$hitungan['pinjaman']
                           );

        if ($tampil->approval=="2") {
              $cetak="";
        }else {
            $cetak="hidden";
        }
        */
        $pph_casual=$this->db->where('nik',$tampil->nik_karyawan)
                             ->where('month(entry_date)',date('m'))
                             ->get('pph_casual')->row();
        $this->table->add_row($no,$tampil->nik_karyawan,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->nama_rekening,$tampil->no_rekening,$hitungan['masuk1'],$hitungan['masuk2'],$this->format->indo($tampil->gaji_casual),$this->format->indo($tampil->uang_makan),$this->format->indo($pph_casual->pph_1),$this->format->indo($hitungan['gaji_1']-$pph_casual->pph_1),$this->format->indo($pph_casual->pph_2),$this->format->indo($hitungan['gaji_2']-$pph_casual->pph_2));
      $no++;
      }
      //$this->table->add_row(array('data'=>''),array('data'=>'Total','colspan'=>4),$this->format->indo($total_bpjs),$this->format->indo($total_pokok),$this->format->indo($total_ekstra),$this->format->indo(0),$this->format->indo($total_pph),$this->format->indo($total_jht),$this->format->indo($total_jpk),$this->format->indo($total_cuti),$this->format->indo($total_gaji),'');
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
    </div>
    <div class="form-group">
      <button class="btn btn-primary" id="btn-pph">Insert PPH</button>
      <button onclick="window.history.go(-1); return false;" class="btn btn-warning" type="button">Kembali</button>
    </div>
</div>
<script type="text/javascript">
  $('#btn-pph').click(function () {
    sUrl="<?=base_url()?>GajiController/e_casual"; features = 'toolbar=no, left=350,top=100, ' + 
    'directories=no, status=no, menubar=no, ' + 
    'scrollbars=no, resizable=no';
    window.open(sUrl,"winChild",features);
  })
</script>
