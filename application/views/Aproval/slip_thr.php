<div class="col-md-12">
    <h4>Data Approvement Tunjangan THR Karyawan</h4>
    <hr>
    <?=$this->session->flashdata('pesan');?>
        <form name="form_data" method="post" id="form_data" action="<?=base_url()?>Aprov/thr_aprov">
        <div class="table-responsive" style="overflow: scroll;">
          <?php
          if($data==true){
          $no=1;
          foreach ($data as $tampil){
          $pure_thr=$tampil->tarif-$tampil->pph_thr;
          //$this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] tampilue='.$tampil->id_thr.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->cabang,$tampil->nama_rekening,$tampil->no_rekening,$this->format->indo($tampil->tarif),$this->format->indo($tampil->pph_thr),$this->format->indo($pure_thr),$this->format->TanggalIndo($tampil->tanggal_ambil),"<button class='label label-danger' type='button' onclick='disapro($tampil->nik,$tampil->id_thr,this)'> Tidak Setuju</button>");
          $this->table->add_row('<input type="hidden" name="iddet[]" id="iddet'.$tampil->field0.'"><input type=checkbox name=cb_data[] id="cb_data'.$tampil->field0.'" tampilue='.$tampil->field0.' onclick="set_id('.$tampil->field0.')">',$no,$tampil->field1,$tampil->field2,$this->format->indo($tampil->field3),$this->format->indo($tampil->field4),$this->format->indo($tampil->field5),$this->format->TanggalIndo($tampil->field6),$tampil->field7,$tampil->field8,'<button class="label label-danger" type="button" onclick=disapro('.$tampil->field0.')> Tidak Setuju</button>');
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
            Aprove Selected
          </button>
        </div>
      </form>
      <!--<div class="col-md-12" id="dis" hidden>
          <div class="form-group">
            <label>NIK</label>
            <input name="nik" class="form-control" id="nik" readonly/>
            <input type="hidden" name="id" id="idthr">
          </div>
          <div class="form-group">
              <label>Keterangan</label>
              <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
          </div>
          <div class="form-group">
          <button class="btn btn-default" onclick="prosesDisapro(this.tampilue)" id="send">Send</button>
          <button class="btn btn-danger" type="button" onclick="$('#dis').attr('hidden',true);">Cancel</button>
          </div>
      </div>-->

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
    $('#nik').attr('tampilue',x);
    $('#send').attr('tampilue',z.parentNode.parentNode.rowIndex);
    $('#idthr').attr('tampilue',y);
  }

  function prosesDisapro(a) {
    var tabel= document.getElementById('example-2');
    var id=$('#idthr').tampil();
    var ket=$('#keterangan').tampil();
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>Aprov/thr_aprov",
            data : "id_thr="+id+"&keterangan="+ket+"",
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
      url : "<?php echo base_url(); ?>Aprov/aprov_thr_v2",
      data : "id="+id+"&keterangan="+ket+"",
      success: function(data){
        location.reload();
      }
    });
  }
</script>