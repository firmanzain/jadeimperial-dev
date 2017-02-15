<div class="col-md-12">
    <h3>Approval Gaji Resign Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
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
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <form method="post" action="<?=base_url()?>Aprov/aproveGajiresign">
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil) {

        if ($tampil->field15!="2") {

          if ($tampil->field15=="0") {
            $status = "Belum";
          } else if ($tampil->field15=="1") {
            $status = "Tidak";
          } else if ($tampil->field15=="2") {
            $status = "Ya";
          }

          $this->table->add_row('<input type="hidden" name="iddet[]" id="iddet'.$tampil->id_gaji_karyawan.'"><input type=checkbox name=cb_data[] id="cb_data'.$tampil->id_gaji_karyawan.'" value='.$tampil->id_gaji_karyawan.' onclick="set_id('.$tampil->id_gaji_karyawan.')">',$no,$tampil->field1,$tampil->field2,$tampil->field3,$tampil->field4,$this->format->indo($tampil->field5),$this->format->indo($tampil->field6),$this->format->indo($tampil->field7),$this->format->indo($tampil->field8),$this->format->indo($tampil->field9),$this->format->indo($tampil->field17),$this->format->indo($tampil->field10),$this->format->indo($tampil->field11),$this->format->indo($tampil->field12),$this->format->indo($tampil->field13),$this->format->indo($tampil->field14),$status,$tampil->field16,'<button class="label label-danger" type="button" onclick=disapro('.$tampil->id_gaji_karyawan.')> Tidak Setuju</button>');

          $no++;
        }
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-primary">
        Approve Selected
      </button>
      <?php if ($this->session->userdata('id_level') == 1) { ?>
      <button type="button" class="btn btn-danger" onclick="prosesCancel()">
        Cancel Approve
      </button>
      <?php } ?>
    </div>
    </form>
<div class="col-md-12">
  <div id="flash"></div>
  <div id="dis" hidden>
    <div class="form-group">
      <label>Alasan Tidak Disetujui</label>
      <input type="hidden" name="id" id="id">
      <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <button class="btn btn-default" type="button" onclick="prosesDisapro()" id="send">Send</button>
      <button class="btn btn-danger" type="button" onclick="$('#dis').attr('hidden',true);">Cancel</button>
    </div>
  </div>
</div>
</div>
<script type="text/javascript">
  function set_id(id) {
    if (document.getElementById("cb_data"+id).checked==true) {
      document.getElementById("iddet"+id).value = id;
    }
  }
  function disapro(id) {
    if (document.getElementById("cb_data"+id).checked==true) {
      $('#dis').attr('hidden',false);
      document.getElementById("id").value = id; 
    }
  }
  function prosesDisapro() {
    var id = $('#id').val();
    var ket = $('#keterangan').val();
    $.ajax({
      type: "POST",
      url : "<?php echo base_url(); ?>Aprov/aprov_gajiresign_v2",
      data : "id="+id+"&keterangan="+ket+"",
      success: function(data){
        location.reload();
      }
    });
  }
  function prosesCancel() {
    var bln = document.getElementsByName('bln')[0].value;
    var thn = document.getElementsByName('tahun')[0].value;
    $.ajax({
      type: "POST",
      url : "<?php echo base_url(); ?>Aprov/cancelaproveGajiresign",
      data : "bln="+bln+"&thn="+thn,
      success: function(data){
        alert("Approve Telah Dibatalkan.");
        location.reload();
      }
    });
  }
</script>