    <h3>Data Level User Sistem</h3>
    <hr>
      <?=$this->session->flashdata('pesan');?>
<div class="row">
<div class="col-md-8">
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>user/level/hapus">
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
        if ($tampil->kode!=1) {
          //$this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->kode.'>',$no,ucfirst($tampil->deskripsi),anchor('user/level/'.$tampil->kode.'/edit','<span class="label label-warning">Edit</span> | ').anchor('user/level/'.$tampil->kode.'/privillage','<span class="label label-success">Set Permision</span> | ').anchor('user/level/'.$tampil->kode.'/notifikasi','<span class="label label-info">Set Notifikasi</span>'));
          $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->kode.'>',$no,ucfirst($tampil->deskripsi),anchor('user/level/'.$tampil->kode.'/edit','<span class="label label-warning">Edit</span> | ').anchor('user/level/'.$tampil->kode.'/notifikasi','<span class="label label-info">Set Notifikasi</span>'));
          $no++;
        }
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
      <div class="panel-footer">
       <?=anchor('user/level/add','Tambah Data',['class' => 'btn btn-primary'])?>
        <button class="btn btn-danger" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button>
      </form>
    </div>
</div>