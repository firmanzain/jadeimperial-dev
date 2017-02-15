<style>
  .tabel{
  border-collapse:collapse;
  width:100%;}
  .tabel th{
  background:#BEBEBE;
  color:#000;
  border:#000000 solid 1px;
  padding:3px;}
  .tabel td{
  border:#000000 solid 1px;
  padding:3px;
  }
  h4,h5,h3 {
    margin: 0 0 0 0;
    padding: 0 0 0 0;
  }
</style>
<h3 align="center">Rekapitulasi Komisi Karyawan </h3>
<?php
if (!empty($cabang)) {
  echo "<h4 align='center'>Plant $cabang->cabang</h4>";
}
if (!empty($tgl1) and !empty($tgl2)) {
  echo "<h5 align='center'> Periode ".$this->format->TanggalIndo($tgl1)." s/d ".$this->format->TanggalIndo($tgl2)."</h5>";
}
?>
<hr>
<div style="margin-top: 10px">
   <?php
      if($data==true){
      $no=1;
      foreach ($data as $tampil){
      $keterangan=$tampil->keterangan;$status=$tampil->approved;
      $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->nama_rekening,$tampil->no_rekening,$tampil->jabatan,$tampil->cabang,$this->format->indo($tampil->omset),$this->format->indo($tampil->komisi),$this->format->BulanIndo($tampil->bulan),$status,$keterangan);
      $no++;
      }
      $tabel=$this->table->generate();
      echo $tabel;
      }else {
      echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
</div>
<div style="margin-top: 10px">
  <p>Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?></p>
  <p></p>
  <p></p>
  <p></p>
  <p>(..............................)</p>
</div>