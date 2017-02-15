<div class="col-md-12">
    <h4>Approval Jam Ekstra Karyawan</h4>
    <hr>
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
        if($tampil->vakasi=='Dibayar' || $tampil->vakasi=='Ekstra Lain') $upah=$this->format->indo($tampil->jumlah_vakasi); else $upah=$tampil->jumlah_vakasi.' Hari';
      $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->cabang,$tampil->jam_mulai.' s/d '.$tampil->jam_finish,$tampil->lama_jam.' Jam',$tampil->vakasi,$upah,$tampil->keterangan,"<button class='label label-warning' type='button' onclick='aprovement(this,$tampil->id,$tampil->jumlah_vakasi)'>Setuju</button> | <button class='label label-danger' type='button' onclick='disapro($tampil->nik,$tampil->id,this)'> Tidak Setuju</button>");
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
    </div>
      <div class="col-md-12" id="dis" hidden>
          <div class="form-group">
            <label>NIK</label>
            <input name="nik" class="form-control" id="nik" readonly/>
            <input type="hidden" name="id" id="idkomisi">
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
  function aprovement(a,b,c) {
    var tabel= document.getElementById('example-2');
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>Aprov/aproveEkstra",
            data : "id="+b+"&upah="+c+"",
            datatype : 'json',
            success: function(msg){
              if (msg=="sukses") {
                tabel.deleteRow(a.parentNode.parentNode.rowIndex);
              }
            }
        });
  }
  function disapro(x,y,z) {
    $('#dis').attr('hidden',false);
    $('#nik').attr('value',x);
    $('#send').attr('value',z.parentNode.parentNode.rowIndex);
    $('#idkomisi').attr('value',y);
    
  }
  function prosesDisapro(a) {
    var tabel= document.getElementById('example-2');
    var id=$('#idkomisi').val();
    var ket=$('#keterangan').val();
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>Aprov/disaproveEkstra",
            data : "id="+id+"&keterangan="+ket+"",
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