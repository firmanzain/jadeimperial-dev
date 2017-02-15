<link rel="stylesheet" href="<?=base_url()?>/assets/styles/bootstrap.css" />
<div align="center">
  <img width="100%" src="<?=base_url()?>assets/img/logo.png">
</div>
<div align="center">
<h4 align="center">Data Umum Karyawan</h4>
</div>
<hr>

<table width="100%" class=" table table-bordered">
  <tr>
    <td width="40%" >NIK</td>
    <td><?=$data->nik?></td>
  </tr>
  <tr>
    <td >Nama Lengkap</td>
    <td><?=$data->nama_ktp?></td>
  </tr>
  <tr>
    <td >Jenis Kelamin</td>
    <td><?=$data->jenis_kelamin?></td>
  </tr>
    <tr>
    <td >TTL</td>
    <td><?=$data->tempat.', '.$this->format->TanggalIndo($data->tanggal_lahir)?></td>
  </tr>
  <tr>
    <td >Alamat KTP</td>
    <td><?=$data->alamat_ktp?></td>
  </tr>
  <tr>
    <td >Alamat Domisili</td>
    <td><?=$data->alamat_domisili?></td>
  </tr>
  <tr>
    <td >NO KTP</td>
    <td><?=$data->no_ktp?></td>
  </tr>
   <tr>
    <td >Agama</td>
    <td><?=$data->agama?></td>
  </tr>
  <tr>
    <td >telepon</td>
    <td><?=str_replace(':','<br>',$data->telepon)?></td>
  </tr>
  <tr>
    <td >Status Kawin</td>
    <td><?=$data->status_perkawinan?></td>
  </tr>
    <tr>
    <td >Pendidikan Terakhir</td>
    <td><?=$data->pendidikan_terakhir?></td>
  </tr>
  <tr>
    <td >NO NPWP</td>
    <td><?=$data->no_npwp?></td>
  </tr>
  <tr>
    <td >Jabatan</td>
    <td><?=$data->jabatan?></td>
  </tr>
  <tr>
    <td>Department</td>
    <td><?=$data->department?></td>
  </tr>
  <tr>
    <td>PLANT</td>
    <td><?=$data->cabang?></td>
  </tr>
  <tr>
    <td>Status Kerja</td>
    <td><?=$data->status_kerja?></td>
  </tr>
  <tr>
    <td>Tanggal Masuk</td>
    <td><?=$this->format->TanggalIndo($data->tanggal_masuk)?></td>
  </tr>
  <tr>
    <td>Tanggal Resign</td>
    <td><?=$this->format->TanggalIndo($data->tanggal_resign)?></td>
  </tr>
</table>