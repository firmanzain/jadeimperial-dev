<div class="col-md-12">
    <h3>Data Akun User Sistem</h3>
    <hr>
      <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>User/hapus">
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
        if ($tampil->id!=0) {
          $this->table->add_row($no,$tampil->nama,$tampil->deskripsi,$tampil->username,$tampil->view_password,$tampil->status,anchor('user/'.$tampil->id.'/edit','<span class="label label-warning">Edit</span>'));
        }
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
      <div class="panel-footer">
       <?=anchor('User/add','Tambah Data',['class' => 'btn btn-primary'])?>
      </form>
    </div>
</div>