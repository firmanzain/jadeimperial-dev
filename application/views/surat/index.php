<div class="col-md-12">
    <h3>Data Persuratan Karyawan</h3>
    <hr>
      <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>surat/hapus">
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
      $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_surat.'>',$no,$tampil->no_surat,$this->format->TanggalIndo($tampil->tanggal_surat),$tampil->jenis_surat,$tampil->perihal,$tampil->lampiran,$tampil->kepada,"<label onClick='cetakData(".$tampil->id_surat.")' class='label label-info'>Lihat Isi</label>",anchor('surat/'.$tampil->id_surat.'/edit','<span class="label label-warning">Edit</span>'));
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
      <div class="panel-footer">
       <?=anchor('surat/add','Buat Surat',['class' => 'btn btn-primary'])?>
        <button class="btn btn-danger" value="Hapus" onClick="return warning();">Hapus Data</button>
      </form>
    </div>
</div>
<script>
function cetakData(id) {
  sUrl="<?=base_url()?>surat/"+id+"/print"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>