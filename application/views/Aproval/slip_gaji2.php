  <div class="col-md-12">
    <h3>Approval Gaji Casual Karyawan Periode Bulan <?=$this->format->BulanIndo(date($bln))?> Tahun <?=$thn?></h3>
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
      <form method="post" action="<?=base_url()?>Aprov/aproveGajicasualCabang">
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $val) {

        if ($val->approval=="0") {
          $status = "Belum";
        } else if ($val->approval=="1") {
          $status = "Tidak";
        } else if ($val->approval=="2") {
          $status = "Ya";
        }

        // $this->table->add_row('<input type="hidden" name="iddet[]" id="iddet'.$val->id_cabang.'"><input type=checkbox name=cb_data[] id="cb_data'.$val->id_cabang.'" value='.$val->id_cabang.' onclick="set_id('.$val->id_cabang.')">',$no,$val->cabang,$val->field1,$this->format->indo($val->field2),$this->format->indo($val->field3),$this->format->indo($val->field8),$this->format->indo($val->field4),$this->format->indo($val->field5),$this->format->indo($val->field9),$this->format->indo($val->field6),$this->format->indo($val->field7),$status,'<button class="label label-danger" type="button" onclick=disapro('.$val->id_cabang.')> Tidak Setuju</button>');

        $this->table->add_row('<input type="hidden" name="iddet[]" id="iddet'.$val->id_cabang.'"><input type=checkbox name=cb_data[] id="cb_data'.$val->id_cabang.'" value='.$val->id_cabang.' onclick="set_id('.$val->id_cabang.')">',$no,$val->cabang,$val->jml,$this->format->indo($val->gaji_netto),$this->format->indo($val->uang_makan_real),$this->format->indo($val->ekstra),$this->format->indo($val->pph),$this->format->indo($val->t_gaji_terima),$this->format->indo($val->gaji_netto2),$this->format->indo($val->uang_makan_real2),$this->format->indo($val->ekstra2),$this->format->indo($val->pph2),$this->format->indo($val->t_gaji_terima2),$this->format->indo($val->t_gaji_terima + $val->t_gaji_terima2),$status,'<button class="label label-danger" type="button" onclick=disapro('.$val->id_cabang.')> Tidak Setuju</button>');

        $no++;
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
  /*function disapro(x,y) {
    $('#dis').attr('hidden',false);
    $('#send').attr('value',y.parentNode.parentNode.rowIndex);
    $('#idcabang').attr('value',x);
    $('#keterangan').attr('value','');
    
  }
  function prosesDisapro(a) {
    var tabel= document.getElementById('example-2');
    var id=$('#idcabang').val();
    var ket=$('#keterangan').val();
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>aprov/aproveGajiCabang",
            data : "id="+id+"&keterangan="+ket+"",
            beforeSend: function(msg){$('#flash').attr('hidden',false);$("#flash").html('Please wait...');$('#dis').attr('hidden',true);},
            success: function(msg){
              if (msg=="sukses") {
                  $('#flash').attr('hidden',true);
                  tabel.deleteRow(a);
              } else {
                  $('#dis').attr('hidden',false);
                  $('#flash').attr('hidden',true);
              }
            }
        });
  }*/
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
      url : "<?php echo base_url(); ?>Aprov/aprov_gajicasual",
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
      url : "<?php echo base_url(); ?>Aprov/cancelaproveGajicasualCabang",
      data : "bln="+bln+"&thn="+thn,
      success: function(data){
        alert("Approve Telah Dibatalkan.");
        location.reload();
      }
    });
  }
</script>