<div class="col-md-12">
		<h3>Data Absensi Karyawan</h3>
		<hr>
    <?=$this->session->flashdata('pesan');?>
        <?php
           if($data==true){
            $no=1;
            foreach ($data as $tampil){
              if ($tampil->tanggal_masuk>$tampil->tgl_resign) {
                $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,anchor('absensi/'.$tampil->nik.'/detail','<i class="fa pencil-square-o"></i><span class="label label-info">Lihat Detail</span>'));
                $no++;
              }
            }
            $tabel=$this->table->generate();
            echo $tabel;
           }else {
              echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
           }
        ?>
         <div class="form-group">
              <button type="button" onclick="importData()" class="btn btn-primary">Import Data</button>
        </div>
</div>

<script>
function importData() {
  sUrl="<?=base_url()?>absensi/import"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>