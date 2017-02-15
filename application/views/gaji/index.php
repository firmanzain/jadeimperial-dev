<div class="col-md-12">
    <h3>Halaman Transaksi Penggajian Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
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
                    <option value="<?=$thn?>" selected><?=$thn?></option>
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
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <?php
          if($pph!=0) {
          }
          else
          {
            echo "<div class='alert alert-warning'>Silahkan upload pph terlebih dahulu</div>";
          }
          if ($gaji == true) { ?>
              <table id="example-2" class="table table-hover table-striped table-bordered" style="white-space: nowrap;">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>CABANG</th>
                    <th>JUMLAH KARYAWAN</th>
                    <th>GAJI</th>
                    <th>TUNJANGAN JABATAN</th>
                    <th>EKSTRA</th>
                    <th>DP CUTI</th>
                    <th>PINJ</th>
                    <th>PPH</th>
                    <th>TOTAL POTONGAN BPJS</th>
                    <!-- <?php
                    $bpjsid = array();
                    $bpjsiddetail = array();
                    if ($bpjs) {
                      foreach ($bpjs->result() as $row) { 
                        echo '<th>'.$row->nama_potongan.'</th>';
                        array_push($bpjsid, $row->id_bpjs);
                        array_push($bpjsiddetail, $row->id_bpjs_detail);
                      }
                    }
                    ?> -->
                    <th>GAJI DITERIMA</th>
                    <th>PAYROLL</th>
                    <th>TINDAKAN</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $no = 1;
                    foreach ($gaji as $row) {
                      $idbpjs = explode(",", $row->field11);
                      $idbpjsdetail = explode(",", $row->field12);
                      $bpjspotongan = explode(",", $row->field13);
                      echo '
                      <tr>
                        <td>'.$no.'</td>
                        <td>'.$row->cabang.'</td>
                        <td>'.$row->field1.'</td>
                        <td>'.$this->format->indo($row->field2).'</td>
                        <td>'.$this->format->indo($row->field3).'</td>
                        <td>'.$this->format->indo($row->field4).'</td>
                        <td>'.$this->format->indo($row->field5).'</td>
                        <td>'.$this->format->indo($row->field6).'</td>
                        <td>'.$this->format->indo($row->field7).'</td>
                        <td>'.$this->format->indo($row->field14).'</td>
                      ';
                      // for ($i = 0; $i < count($bpjsid); $i++) { 
                      //   for ($j = 0; $j < count($idbpjs); $j++) { 
                      //     if ($bpjsid[$i] == $idbpjs[$j] && $bpjsiddetail[$i] == $idbpjsdetail[$j]) {
                      //       echo '<td>'.$this->format->indo($row->bpjspotongan[$j]).'</td>';
                      //     } else {
                      //       echo '<td>'.$this->format->indo(0).'</td>';
                      //     }
                      //   }
                      // }
                      echo '
                        <td>'.$this->format->indo(round(($row->field10/100),0,PHP_ROUND_HALF_UP)*100).'</td>
                        <td>'.$this->format->indo(round(($row->field10/100),0,PHP_ROUND_HALF_UP)*100).'</td>
                        <td>'."<a class='label label-warning' href='".base_url()."gaji/".$row->id_cabang."/".str_replace(',', '-', $row->cabang)."/".$bln."/".$thn."/detail'>Detail</a>".'</td>
                      </tr>
                      ';
                      $no++;
                    }
                  ?>
                </tbody>
              </table>
      <?php
          } else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>"; 
          }
          // if ($gaji==true) {
          //   $no=1;
          //   foreach ($gaji as $val) {

          //     //$this->table->add_row($no,$val->cabang,$val->field1,$this->format->indo($val->field2),$this->format->indo($val->field3),$this->format->indo($val->field4),$this->format->indo($val->field5),$this->format->indo($val->field6),$this->format->indo($val->field7),$this->format->indo($val->field8),$this->format->indo($val->field9),$this->format->indo(round(($val->field10/100),0,PHP_ROUND_HALF_UP)*100),$this->format->indo(round(($val->field10/100),0,PHP_ROUND_HALF_UP)*100),"<a class='label label-warning' href='".base_url()."gaji/".$val->id_cabang."/".str_replace(',', '-', $val->cabang)."/".$bln."/".$thn."/detail'>Detail</a>");

          //     $potongan_bpjs = explode(",", $val->field12);
          //     $potongan_bpjs_fix = array();
          //     for ($i = 0; $i < sizeof($potongan_bpjs); $i++) { 
          //       array_push($potongan_bpjs_fix, $this->format->indo($potongan_bpjs[$i]),",")
          //     )

          //     $this->table->add_row(
          //       $no,
          //       $val->cabang,
          //       $val->field1,
          //       $this->format->indo($val->field2),
          //       $this->format->indo($val->field3),
          //       $this->format->indo($val->field4),
          //       $this->format->indo($val->field5),
          //       $this->format->indo($val->field6),
          //       $this->format->indo($val->field7),
          //       $this->format->indo($val->field8),
          //       $this->format->indo($val->field9),
          //       $potongan_bpjs_fix
          //       $this->format->indo($val->field10),
          //       $this->format->indo($val->field10),
          //       "<a class='label label-warning' href='".base_url()."gaji/".$val->id_cabang."/".str_replace(',', '-', $val->cabang)."/".$bln."/".$thn."/detail'>Detail</a>"
          //     );

          //     $no++;
          //   }
            
          //   $tabel = $this->table->generate();
          //   echo $tabel;
          //   /*if($data==true){
          //       $no=1;
          //       foreach ($data as $tampil){
          //         $kalender=CAL_GREGORIAN;
          //         $bulan = date('m');
          //         $tahun= date('Y');
          //         $jml_hari=cal_days_in_month($kalender, $bulan, $tahun);
          //         $hitungan=$this->model_gaji->rincian_gaji_cabang($tampil->id_cabang,$jml_hari);
          //         $jht=($hitungan['jht']!=0)?($tampil->gaji_bpjs*$hitungan['jht']/100)*$hitungan['karyawan_jht']:0;
          //         $jpk=($hitungan['jpk']!=0)?($tampil->gaji_bpjs*$hitungan['jpk']/100)*$hitungan['karyawan_jpk']:0;
          //         $gaji_bersih=($tampil->gaji+$tampil->tot_tunjangan+$hitungan['ekstra'])-$tampil->total_pph-($jht+$jpk)-$hitungan['cuti']-$hitungan['pinjaman'];


          //         $this->table->add_row($no,$tampil->cabang,$tampil->jml_karyawan,$this->format->indo($tampil->gaji),$this->format->indo($tampil->tot_tunjangan),$this->format->indo($hitungan['ekstra']),$this->format->indo($hitungan['cuti']),$this->format->indo($hitungan['pinjaman']),$this->format->indo($tampil->total_pph),$this->format->indo($jht),$this->format->indo($jpk),$this->format->indo($gaji_bersih),$this->format->indo($gaji_bersih),"<a class='label label-warning' href='".base_url()."gaji/$tampil->id_cabang/".str_replace(',', '-', $tampil->cabang)."/detail'>Detail</a>"); // button pertama. Pemetaan anchorr di atur di route
                  
          //         $no++;
          //       }

          //       $tabel=$this->table->generate();
          //       echo $tabel;
          //   }
          //   else
          //   {
          //     echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
          //   }*/
          // } else {
          //   echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>"; 
          // }
      ?>
    </div>

    <div class="form-group">
      <!--<button type="button" onclick="importData()" class="btn btn-primary" <?php if ($gaji==true) { echo "disabled"; }?>>-->
      <button type="button" onclick="importData()" class="btn btn-primary">
        Upload PPH
      </button>
      <button type="button" onclick="generateData()" class="btn btn-primary">
        Generate Gaji
      </button>
    </div>
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
      url  : '<?php echo base_url();?>GajiController/generateDataNew/',
      data : 'bln='+document.getElementsByName('bln')[0].value+'&thn='+document.getElementsByName('tahun')[0].value,
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