<div class="col-md-12">
    <h3>Halaman Transaksi Penggajian Casual Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
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
        } else {
          echo "<div class='alert alert-warning'>Silahkan insert pph terlebih dahulu</div>";
        }
          /*if($pph!=0) {
            if ($gaji==true) {
              $no=1;
              foreach ($gaji as $val) {

                $this->table->add_row($no,$val->cabang,$val->field1,$this->format->indo($val->field2),$this->format->indo($val->field3),$this->format->indo($val->field4),$this->format->indo($val->field5),$this->format->indo($val->field6),$this->format->indo($val->field7),$this->format->indo($val->field8),$this->format->indo($val->field9),$this->format->indo($val->field10),$this->format->indo($val->field10),"<a class='label label-warning' href='".base_url()."gaji/".$val->id_cabang."/".str_replace(',', '-', $val->cabang)."/detail'>Detail</a>");

                $no++;
              }
              
              $tabel = $this->table->generate();
              echo $tabel;
            } else {
              echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>"; 
            }
          }
          else
          {
            echo "<div class='alert alert-warning'>Silahkan upload pph terlebih dahulu</div>";
          }*/
        if ($data==true) {
          $no=1;
          foreach ($data as $val) {
            $this->table->add_row($no,$val->cabang,$val->jml,$this->format->indo($val->gaji_netto),$this->format->indo($val->uang_makan_real),$this->format->indo($val->ekstra),$this->format->indo($val->pph),$this->format->indo($val->t_gaji_terima),$this->format->indo($val->gaji_netto2),$this->format->indo($val->uang_makan_real2),$this->format->indo($val->ekstra2),$this->format->indo($val->pph2),$this->format->indo($val->t_gaji_terima2),$this->format->indo($val->t_gaji_terima + $val->t_gaji_terima2),"<a class='label label-warning' href='".base_url()."gaji/".$val->id_cabang."/".str_replace(',', '-', $val->cabang)."/".$bln."/".$thn."/detailcasual'>Detail</a>");
            $no++;
          }
            
          $tabel = $this->table->generate();
          echo $tabel;
        } else {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>"; 
        }
      ?>
    </div>
    <div class="form-group">
      <button type="button" id="btn-pph" class="btn btn-primary">
        Insert PPH
      </button>
      <button type="button" onclick="generateData()" class="btn btn-primary">
        Generate Gaji
      </button>
    </div>
</div>
<script>
  $('#btn-pph').click(function () {
    sUrl = "<?=base_url()?>GajiController/e_casual?bln=<?=$bln?>&thn=<?=$thn?>";
    features = 'toolbar=no, left=0,top=0, ' + 
    'directories=no, status=no, menubar=no, ' + 
    'scrollbars=yes, resizable=yes, width=1000';
    window.open(sUrl,"winChild",features);
  })
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
      url  : '<?php echo base_url();?>GajiController/generateData2/',
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