<div class="row m-b-20">
    <div class="col-xs-12">
        <h4>
            Profil karyawan <?=ucfirst($data->nama_ktp)?>
        </h4>
        <hr>
    </div>
</div>
<div class="row m-b-20">
	<div class="col-xs-12">
        <div class="bs-nav-tabs nav-tabs-danger">
            <div class="row">
                <div class="col-xs-6 col-lg-2">
                    <ul class="nav nav-tabs nav-stacked nav-border-left">
                        <li class="nav-item"> <a ng-href="" class="nav-link active" data-toggle="tab" data-target="#vertical-nav-tabs-left-1">Data Pribadi</a> 
                        </li>
                        <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-2">Status Kerja</a> 
                        </li>
                    </ul>
                </div>
                <div class="col-xs-6 col-lg-8">
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane in active" id="vertical-nav-tabs-left-1">
                            <table class="table table-hovered">
                            	<tr>
                            		<td width="30%">NIK</td>
                            		<td width="2%">:</td>
                            		<td><?=$data->nik?></td>
                            	</tr>
                            	<tr>
                            		<td>Nama</td>
                            		<td>:</td>
                            		<td><?=$data->nama_ktp?></td>
                            	</tr>
                            	<tr>
                            		<td>Jenis Kelamin</td>
                            		<td>:</td>
                            		<td><?=$data->jenis_kelamin?></td>
                            	</tr>
                            	<tr>
                            		<td>Tanggal Lahir</td>
                            		<td>:</td>
                            		<td><?=$this->format->TanggalIndo($data->tanggal_lahir)?></td>
                            	</tr>
                            	<tr>
                            		<td>Alamat KTP</td>
                            		<td>:</td>
                            		<td><?=$data->alamat_ktp?></td>
                            	</tr>
                            	<tr>
                            		<td>Alamat Domisili</td>
                            		<td>:</td>
                            		<td><?=$data->alamat_domisili?></td>
                            	</tr>
                            	<tr>
                            		<td>Agama</td>
                            		<td>:</td>
                            		<td><?=$data->agama?></td>
                            	</tr>
                            	<tr>
                            		<td>Telepon</td>
                            		<td>:</td>
                            		<td><?=str_replace(':',' / ',$data->telepon)?></td>
                            	</tr>
                            	<tr>
                            		<td>Status Perkawinan</td>
                            		<td>:</td>
                            		<td><?=$data->status_perkawinan?></td>
                            	</tr>
                            	<tr>
                            		<td>Pendidikan Terakhir</td>
                            		<td>:</td>
                            		<td><?=$data->pendidikan_terakhir?></td>
                            	</tr>
                            	<tr>
                            		<td>Nama Rekening</td>
                            		<td>:</td>
                            		<td><?=$data->nama_rekening?></td>
                            	</tr>
                            	<tr>
                            		<td>Nomor Rekening</td>
                            		<td>:</td>
                            		<td><?=$data->no_rekening?></td>
                            	</tr>
                            	<tr>
                            		<td>Tanggungan</td>
                            		<td>:</td>
                            		<td><?=$data->tanggungan?></td>
                            	</tr>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vertical-nav-tabs-left-2">
                            <table class="table table-hovered">
                            	<tr>
                            		<td width="30%">Jabatan</td>
                            		<td width="2%">:</td>
                            		<td><?=$data->jabatan?></td>
                            	</tr>
                            	<tr>
                            		<td>Department</td>
                            		<td>:</td>
                            		<td><?=$data->department?></td>
                            	</tr>
                            	<tr>
                            		<td>PLANT</td>
                            		<td>:</td>
                            		<td><?=$data->cabang?></td>
                            	</tr>
                            	<tr>
                            		<td>Status Kerja</td>
                            		<td>:</td>
                            		<td><?=$data->status_kerja?></td>
                            	</tr>
                            	<tr>
                            		<td>Tanggal Awal Kontrak</td>
                            		<td>:</td>
                            		<td><?=$this->format->TanggalIndo($data->tanggal_masuk)?></td>
                            	</tr>
                            	<tr>
                            		<td>Tanggal Akhir Kontrak</td>
                            		<td>:</td>
                            		<td><?=$this->format->TanggalIndo($data->tanggal_resign)?></td>
                            	</tr>
                            	<tr>
                            		<td>Gaji Pokok</td>
                            		<td>:</td>
                            		<td><?=$this->format->indo($data->gaji_pokok)?></td>
                            	</tr>

                                <tr>
                                    <td>Tunjangan Jabatan</td>
                                    <td>:</td>
                                    <td><?=$this->format->indo($data->tunjangan_jabatan)?></td>
                                </tr>


                            	<tr>
                            		<td>Gaji BPJS</td>
                            		<td>:</td>
                            		<td><?=$this->format->indo($data->gaji_bpjs)?></td>
                            	</tr>
                            	<tr>
                            		<td>Gaji Casual</td>
                            		<td>:</td>
                            		<td><?=$this->format->indo($data->gaji_casual)?></td>
                            	</tr>
                            	<tr>
                            		<td>Uang Makan</td>
                            		<td>:</td>
                            		<td><?=$this->format->indo($data->uang_makan)?></td>
                            	</tr>
                            	<tr>
                            		<td>Standar Hadir</td>
                            		<td>:</td>
                            		<td><?=$data->standard_hadir?></td>
                            	</tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>