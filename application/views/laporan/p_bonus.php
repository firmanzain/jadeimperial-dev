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
<h3 align="center">Rekapitulasi Bonus Karyawan </h3>
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
      $total_bonus=$tampil->grade+$tampil->nominal+$tampil->senioritas+$tampil->persentase+$tampil->prota;
      $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$tampil->nama_rekening,$tampil->no_rekening,$this->format->indo($tampil->grade),$this->format->indo($tampil->senioritas),$this->format->indo($tampil->nominal),$this->format->indo($tampil->persentase),$this->format->indo($tampil->prota),$this->format->indo($total_bonus),$tampil->approved,date('d-m-Y',strtotime($tampil->tanggal_bonus)),$tampil->keterangan);
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