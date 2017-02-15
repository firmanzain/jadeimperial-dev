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
<h3 align="center">Rekapitulasi Tunjangan THR Karyawan </h3>
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
    $no=1;$t_thr=0;$t_terima=0;$t_pph=0;
    foreach ($data as $tampil){
    $pure_thr=$tampil->tarif-$tampil->pph_thr;
    $t_thr += $tampil->tarif;
    $t_pph += $tampil->pph_thr;
    $t_terima += $pure_thr;
    $this->table->add_row($no,$this->format->TanggalIndo($tampil->tanggal_ambil),$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$tampil->cabang,$tampil->nama_rekening,$tampil->no_rekening,$this->format->indo($tampil->tarif),$this->format->indo($tampil->pph_thr),$this->format->indo($pure_thr),$tampil->approved,$tampil->keterangan);
    $no++;
    }
    $this->table->add_row('',array('data'=>'Total','colspan'=>8),$this->format->indo($t_thr),$this->format->indo($t_pph),$this->format->indo($t_terima),'','');
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