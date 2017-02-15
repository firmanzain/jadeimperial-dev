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
<h3 align="center">Rekapitulasi Tunjangan T3 Karyawan </h3>
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
        $no=1;$t_t3=0;$t_hadir=0;$t_terima=0;
        foreach ($data as $tampil){
          $t3=$tampil->total_t3/$tampil->jml_hadir;
          $t_t3 += $t3;
          $t_hadir += $tampil->jml_hadir;
          $t_terima += $tampil->total_t3;
        $this->table->add_row($no,$this->format->TanggalIndo($tampil->tanggal),$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$tampil->nama_rekening,$tampil->no_rekening,$this->format->indo($tampil->total_t3/$tampil->jml_hadir),$tampil->jml_hadir,$this->format->indo($tampil->total_t3),$tampil->approved,$tampil->keterangan);
        $no++;
        }
        $this->table->add_row('',array('data'=>'Total','colspan'=>7),$this->format->indo($t_t3),$t_hadir,$this->format->indo($t_terima),'','');
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