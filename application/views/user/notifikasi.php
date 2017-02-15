<h3>Setting Notifikasi Level User : <?= ucfirst($level->deskripsi) ?></h3>
<hr>
<?=$this->session->flashdata('pesan');?>
<div class="row">
<div class="col-md-8">
      <form name="form_data" method="post" id="form_data" action="">
      <?php
      if($data==true){
      $no=1;$i=0;
      foreach ($data as $tampil){
        if ($tampil->allowed==1) $cek_c="checked"; else $cek_c="";
        $this->table->add_row($no,ucfirst($tampil->notifikasi),'<input type=checkbox name=cb_data['.$i.'] id=cb_data['.$i.'] value="1" '.$cek_c.'>');
        $no++;
        $i++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
      <div class="form-group">
        <button class="btn btn-primary">Simpan Data</button>
        <button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Cancel</button>
      </form>
    </div>
</div>
