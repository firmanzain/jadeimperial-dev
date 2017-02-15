<div class="col-md-12">
    <h3>Detail Gaji Resign Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
    <hr>
      <form class="form-horizontal" id="form-periode" method="POST">
          <div class="form-group row">
            <label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
              <div class="col-sm-4">
                <select class="form-control" name="bln">
                  <option value="<?=$bln?>"><?=$this->format->BulanIndo($bln)?></option>
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
                <select class="form-control" name="tahun">
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
    <hr>
    <form method="post" action="<?=base_url('Laporan/ex_gaji_resign')?>" target="new">
      <input type="hidden" name="bln" value="<?php echo $bln?>">
      <input type="hidden" name="thn" value="<?php echo $thn?>">
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <?php
      if($data==true){
      $no=1;
      $jamsostek = 0;
      $pokok = 0;
      $tunjangan = 0;
      $ekstra = 0;
      $dp_cuti = 0;
      $pinjaman = 0;
      $pph = 0;
      $jht = 0;
      $jpk = 0;
      $diterima = 0;

      foreach ($data as $tampil){

        $jamsostek = $jamsostek+$tampil->field5;
        $pokok = $pokok+$tampil->field5;
        $tunjangan = $tunjangan+$tampil->field7;
        $ekstra = $ekstra+$tampil->field8;
        $dp_cuti = $dp_cuti+$tampil->field9;
        $pinjaman = $pinjaman+$tampil->field10;
        $pph = $pph+$tampil->field11;
        $jht = $jht+$tampil->field12;
        $jpk = $jpk+$tampil->field13;
        $diterima = $diterima+$tampil->field14;

        $array_gaji = array(
          'nik'         => $tampil->field1,
          'nama'        => $tampil->field2,
          'gaji'        => $tampil->field6,
          'extra'       => $tampil->field8,
          'pph'         => $tampil->field11,
          'dp_cuti'     => $tampil->field9,
          'jht'         => $tampil->field12,
          'jpk'         => $tampil->field13,
          'gaji_terima' => $tampil->field14,
          'no_gaji'     => $tampil->id_gaji_karyawan,
          'cabang'      => $tampil->cabang,
          'jabatan'     => $tampil->field3,
          'pinjaman'    => $tampil->field10
        );

        if ($tampil->field15=="0") {
          $app = "Belum";
          $cetak = "hidden";
        } else if ($tampil->field15=="1") {
          $app = "Tidak";
          $cetak = "hidden";
        } else if ($tampil->field15=="2") {
          $cetak = " ";
          $app = "Setuju";
        }

        $this->table->add_row($no,$tampil->field1,$tampil->field2,$tampil->field3,$tampil->field4,$this->format->indo($tampil->field5),$this->format->indo($tampil->field6),$this->format->indo($tampil->field7),$this->format->indo($tampil->field8),$this->format->indo($tampil->field9),$this->format->indo($tampil->field17),$this->format->indo($tampil->field10),$this->format->indo($tampil->field11),$this->format->indo($tampil->field12),$this->format->indo($tampil->field13),$this->format->indo($tampil->field14),$app,$tampil->field16,'<a class="label label-info" href="'.base_url()."GajiController/print_data/".base64_encode(implode(':', $array_gaji))."".'" target="new"  '.$cetak.'>Cetak Slip</a>');

        $no++;
      }

//      $this->table->add_row(array('data'=>''),array('data'=>'Total','colspan'=>4),$this->format->indo($jamsostek),$this->format->indo($pokok),$this->format->indo($tunjangan),$this->format->indo($ekstra),$this->format->indo($dp_cuti),$this->format->indo($pinjaman),$this->format->indo($pph),$this->format->indo($jht),$this->format->indo($jpk),$this->format->indo($diterima),'','','');
      
      $tabel=$this->table->generate();
      
      echo $tabel;
      
      } else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
    </div>
    <div class="form-group">
      <button onclick="window.history.go(-1); return false;" class="btn btn-warning" type="button">Kembali</button>
      <button type="button" onclick="importData()" class="btn btn-primary">
        Upload PPH
      </button>
      <button class="btn btn-success" type="submit">Export Excel</button>
      <!--<button type="button" onclick="generateData()" class="btn btn-primary">
        Generate Gaji
      </button>-->
    </div>
    </form>
</div>
<script>
function importData() {
  sUrl="<?=base_url()?>gaji/import"; features = 'toolbar=no, left=350,top=100, ' +  // // button kedua. langsung ke controller gaji, method import.
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
function generateData() {
  var r = confirm("Apakah anda ingin mengenerate gaji?");
  if (r == true) {
    $.ajax({
      type : "POST",
      url  : '<?php echo base_url();?>GajiController/generateDataresign/',
      //data : ,
      dataType : "json",
      success:function(data){
        if(data.status=='200'){
          alert("Gaji telah tergenerate.");
          location.reload();
        }
      }
    });
  }
}
</script>