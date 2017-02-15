<div class="row">
  <div class="col-md-12">
  <h4>Data Karyawan Mutasi</h4>
  <hr>
  <form name="form_data" method="post" id="form_hasil" action="">
      <div class="table-responsive" id="show">
        <?php
           if($data==true){
            $no=1;
            foreach ($data as $tampil){
              $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->id_mutasi.'>',$no,$tampil->nama_ktp,$tampil->jabatan1,$tampil->jabatan,$tampil->department1,$tampil->department,$tampil->cabang1,$tampil->cabang,$this->format->TanggalIndo($tampil->tanggal_berlaku),anchor('MutasiController/cetakMutasi/'.$tampil->id_mutasi.'/','<span class="label label-warning"><div class="zmdi zmdi-print zmdi-hc-2x"></div></span>',['target' => 'new']));
              $no++;
            }
            $tabel=$this->table->generate();
            echo $tabel;
           }else {
              echo "<div class='alert alert-danger'>data Tidak Ditemukan</div>";
           }
        ?>
      </div>
       <?=anchor('MutasiController/create','Tambah Data',['class' => 'btn btn-primary'])?>
      <button type="button" class="btn btn-danger" onclick="return warning()" >Hapus Data</button>
    </form>
  </div>
  </div>
</div>
