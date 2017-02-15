<div class="row">
  <div class="col-md-12">
  <h4>Halaman Master DP Cuti Karyawan</h4>
  <hr>
        <?=$this->session->flashdata('pesan');?>
        <?php
        if($data==true){
        $no=1;
        foreach ($data as $tampil){
        $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,anchor('master-dp/'.$tampil->nik.'/detail','<span class="label label-info">Detail</span>'));
        $no++;
        }
        $tabel=$this->table->generate();
        echo $tabel;
        }else {
          echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
        }
        ?>
  </div>
</div>