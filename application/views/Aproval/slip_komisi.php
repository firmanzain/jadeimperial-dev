<div class="col-md-12">
		<h3>Data Komisi Karyawan Karyawan</h3>
		<hr>
    <?=$this->session->flashdata('pesan');?>
        <?php
           if($data==true){
            $no=1;
            foreach ($data as $tampil){
            $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->cabang,$tampil->department,$this->format->indo($tampil->komisi),$this->format->indo($tampil->omset),"<button class='label label-warning' type='button' onclick='aprovement(this,$tampil->id_komisi)'>Setuju</button> | <button class='label label-danger' type='button' onclick='disapro($tampil->nik,$tampil->id_komisi,this)'> Tidak Setuju</button>");
            $no++;
            }
            $tabel=$this->table->generate();
            echo $tabel;
           }else {
              echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
           }
        ?>
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
  function aprovement(a,b) {
    var tabel= document.getElementById('example-2');
    $.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>Aprov/goAprove",
            data : "id="+b+"",
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
            url : "<?php echo base_url(); ?>Aprov/disAprove",
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