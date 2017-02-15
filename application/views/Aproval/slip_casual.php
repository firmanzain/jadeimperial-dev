<div class="col-md-12">
    <h4>Data ApprovementCasual Ekstra Karyawan</h4>
    <hr>
    <div class="table-responsive" style="overflow: scroll;">
    <?=$this->session->flashdata('pesan');?>
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>Aprov/casual_aprov">
        <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
        //$this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_casual.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->cabang,$tampil->lama,$this->format->indo($tampil->total),"<button class='label label-danger' type='button' onclick='disapro($tampil->nik,$tampil->id_casual,this)'> Tidak Setuju</button>");
        $this->table->add_row('<input type="hidden" name="iddet[]" id="iddet'.$tampil->id_casual.'"><input type=checkbox name=cb_data[] id="cb_data'.$tampil->id_casual.'" value='.$tampil->id_casual.' onclick="set_id('.$tampil->id_casual.')">',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->kepala_department,$tampil->hrd,$tampil->cabang,$tampil->lama,$this->format->indo($tampil->total),$tampil->approved,$tampil->keterangan,$tampil->keterangan_ekstra,"<button class='label label-danger' type='button' onclick='disapro($tampil->id_casual)'> Tidak Setuju</button>");
        $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
        <div class="form-group">
        <button type="submit" class="btn btn-primary">
            Aprove Selected
          </button>
        </div>
      </form>
    </div>
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
  /*function disapro(x,y,z) {
    $('#dis').attr('hidden',false);
    $('#nik').attr('value',x);
    $('#send').attr('value',z.parentNode.parentNode.rowIndex);
    $('#idcasual').attr('value',y);
  }

  function prosesDisapro(a) {
    var tabel= document.getElementById('example-2');
    var id=$('#idcasual').val();
    var ket=$('#keterangan').val();
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>aprov/casual_aprov",
            data : "id_casual="+id+"&keterangan="+ket+"",
            datatype : 'json',
            beforeSend: function(msg){$("#dis").html('Please wait...');},
            success: function(msg){
              if (msg=="sukses") {
                  $('#dis').attr('hidden',true);
                tabel.deleteRow(a);
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
      url : "<?php echo base_url(); ?>Aprov/aprov_ekstra_casual_v2",
      data : "id="+id+"&keterangan="+ket+"",
      success: function(data){
        location.reload();
      }
    });
  }
</script>