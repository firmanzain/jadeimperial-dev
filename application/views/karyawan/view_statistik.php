<div class="col-md-12">
    <h3>Statistik Data Per Karyawan</h3>
    <hr>
    <div class="table-responsive" style="overflow: scroll;">
      <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
        $this->table->add_row($no,$tampil->nik_karyawan,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->cabang,anchor('karyawan/'.$tampil->nik.'/statistik','<span class="label label-success">Lihat Statistik</span>'));
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