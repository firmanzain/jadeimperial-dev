<div class="col-md-8">
    <h3>Data Draft Surat Penting</h3>
    <hr>
      <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>dokumen/hapus">
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
      $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_doc.'>',$no,$tampil->dokumen,"<label onClick='cetakData(".$tampil->id_doc.")' class='label label-info'>Lihat Isi</label>",anchor('dokumen/'.$tampil->id_doc.'/edit','<span class="label label-warning">Edit</span>'));
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
      <div class="panel-footer">
       <?=anchor('dokumen/add','Buat Dokumen',['class' => 'btn btn-primary'])?>
        <button class="btn btn-danger" value="Hapus" onClick="return warning();">Hapus Data</button>
      </form>
    </div>
</div>
<script>
function cetakData(id) {
  sUrl="<?=base_url()?>dokumen/"+id+"/print"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>