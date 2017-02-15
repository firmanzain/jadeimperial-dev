<div class="col-md-12">
    <h3>Data Approval Tunjangan Karyawan Bulan <?=$this->format->BulanIndo(date('m'))?></h3>
    <hr>
      <?=$this->session->flashdata('pesan');?>
    <form method="post" action="<?=base_url()?>Aprov/tunjangan_aprov">
      <div class="table-responsive" style="overflow: scroll;">
        <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
            $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_tj.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$tampil->nama_tunjangan,$this->format->indo($tampil->tarif),"<button class='label label-danger' type='button' onclick='disapro($tampil->nik,$tampil->id_tj,this)'> Tidak Setuju</button>");
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
    <div class="col-md-12" id="dis" hidden>
          <div class="form-group">
            <label>NIK</label>
            <input name="nik" class="form-control" id="nik" readonly/>
            <input type="hidden" name="id" id="idtunjangan">
          </div>
          <div class="form-group">
              <label>Keterangan</label>
              <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
          </div>
          <div class="form-group">
          <button class="btn btn-default" onclick="prosesDisapro(this.value)" id="send">Send</button>
          <button class="btn btn-danger" type="button" onclick="$('#dis').attr('hidden',true);">Cancel</button>
          </div>
      </div>
</div>
<script type="text/javascript">
  function disapro(x,y,z) {
    $('#dis').attr('hidden',false);
    $('#nik').attr('value',x);
    $('#send').attr('value',z.parentNode.parentNode.rowIndex);
    $('#idtunjangan').attr('value',y);
  }

  function prosesDisapro(a) {
    var tabel= document.getElementById('example-2');
    var id=$('#idtunjangan').val();
    var ket=$('#keterangan').val();
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>Aprov/tunjangan_aprov",
            data : "id_tunjangan="+id+"&keterangan="+ket+"",
            datatype : 'json',
            beforeSend: function(msg){$("#dis").html('Please wait...');},
            success: function(msg){
              if (msg=="sukses") {
                  $('#dis').attr('hidden',true);
                tabel.deleteRow(a);
              }
            }
        });
  }
</script>