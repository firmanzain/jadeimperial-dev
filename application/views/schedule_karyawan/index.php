<h4>Data Schedule Karyawan</h4>
<hr>
<?=$this->session->flashdata('pesan');?>
<?php
  if ($error<>false) {
    $jml = 0;
    $nik = array();
    foreach ($error->result() as $row) {
      if ($row->kode_jam==NULL) {
        array_push($nik,$row->nik);
        $jml++;
      }
    }
    $nik_tmp = implode(" ",array_unique($nik));
    if ($jml>0) {
      echo "
      <div class='alert alert-danger'>
        Terdapat ".sizeof(array_unique($nik))." karyawan yg jadwalnya tidak sesuai master. Yaitu
        ".str_replace(" ", ",", $nik_tmp)."
      </div>";
    }
  }
?>
<div class="col-md-12">
    <div class="table-responsive" id="show">
      <?php
         if($data==true){
          $no=1;
          foreach ($data as $tampil){
          $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,anchor('shedule-karyawan/'.$tampil->nik.'/detail','<span class="label label-info">Lihat Schedule</span>'));
          $no++;
          }
          $tabel=$this->table->generate();
          echo $tabel;
         }else {
            echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
         }
      ?>
    </div>
    <div class="form-group">
        <?=anchor('shedule-karyawan/add','Tambah Data',['class' => 'btn btn-primary'])?>
        <button class="btn btn-info" type="button" onClick="importData()">Import Data</button>
  </div>
</div>

<script>
function importData() {
  sUrl="<?=base_url()?>schedule/import"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>