<h4>Data Karyawan</h4>
<hr>
<div class="row">
    <div class="col-md-12">
            <div class="table-responsive" id="show">
              <?php
                 if(count($data)>=1){
                  $no=1;
                  foreach ($data as $tampil){
                    $telp=str_replace(':', ",<br>", $tampil->telepon);
                    $ttl = /*$tampil->tempat.','. */$this->format->TanggalIndo($tampil->tanggal_lahir);
                    
                    // $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->alamat_domisili,$tampil->agama,$telp,$tampil->jabatan,$ttl,$tampil->jenis_kelamin,$tampil->status_perkawinan,anchor('KaryawanController/updatekaryawan/'.$tampil->nik.'/','<span class="label label-warning" >Edit</span> |').anchor('KaryawanController/print_pkwt/'.$tampil->nik.'/','<span class="label label-info" >Print PKWT</span> | ').anchor('KaryawanController/detail/'.$tampil->nik.'/','<span class="label label-success" >Detail</span>'));
                    $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->alamat_domisili,$tampil->agama,$telp,$tampil->jabatan,$ttl,$tampil->jenis_kelamin,$tampil->status_perkawinan,anchor('KaryawanController/updatekaryawan/'.$tampil->nik.'/','<span class="label label-warning" >Edit</span> &nbsp;&nbsp; ').anchor('KaryawanController/detail/'.$tampil->nik.'/','<span class="label label-success" >Detail</span>'));

                  $no++;
                  }
                  $tabel=$this->table->generate();
                  echo $tabel;
                 }else {
                    echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
                 }
              ?>
            </div>
         <?=anchor('KaryawanController/tambahkaryawan','Tambah Data karyawan',['class' => 'btn btn-info'])?>
  </div>
    </form>
</div>
 