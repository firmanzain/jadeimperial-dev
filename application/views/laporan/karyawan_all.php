<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div class='row'>
<div class="col-md-12">
<div align="center">
	<img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<h4 align="center" style='margin:0px;'>Rekap Data Karyawan</h4>
<?php
if (isset($cabang)) {
	echo "<h5 align='center' style='margin:0px;'>Plant : $cabang->cabang</h5>";
}
?>
<hr>
<?php
  if($data==true){
  $no=1;
  foreach ($data as $tampil){
    $keluarga=$this->db->where('nik',$tampil->nik_karyawan)->get('tab_keluarga')->result();
    foreach ($keluarga as $rs_kel) {
      $telp[]=$rs_kel->nomor_telp;
      $hub[]=$rs_kel->hubungan;
    }
    $tel_kel=implode("<br>", $telp);
    $hubungan=implode('<br>', $hub);
  $this->table->add_row($no,$tampil->nik_karyawan,$tampil->nama_ktp,$tampil->no_ktp,$tampil->alamat_ktp,$tampil->alamat_domisili,str_replace(':', '<br>', $tampil->telepon),$tel_kel,$hubungan,$this->format->TanggalIndo($tampil->tanggal_lahir),$tampil->status_perkawinan,$tampil->tanggungan,$tampil->jenis_kelamin,$tampil->no_rekening,date('d-m-Y',strtotime($tampil->tanggal_masuk)),$tampil->jabatan,$tampil->no_npwp,$tampil->status_kerja);
  $no++; 
  }
  $tabel=$this->table->generate();
  echo $tabel;
  }else {
    echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
  }
  ?>