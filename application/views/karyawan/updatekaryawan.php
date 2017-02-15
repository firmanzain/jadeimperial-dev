<div class="row m-b-20">
    <div class="col-xs-12">
        <h4>
            Update Data Karyawan
        </h4>
    </div>
</div>
<form action="" id="bootstrap-validator-form"  role="form" novalidate method="post">
<div class="form-group col-md-12" align="right">
	<button type="button" class="btn btn-warning" onclick="window.history.go(-1); return false;">Cancel</button>
	<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Simpan Data">
</div>
<div class="row m-b-20">
    <div class="col-xs-12">
        <div class="bs-nav-tabs nav-pills-warning">
            <ul class="nav nav-tabs nav-pills nav-pills-squared">
                <li class="nav-item active"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#nav-pills-squared-1">Data Umum</a> 
                </li>
                <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#nav-pills-squared-2">Keluarga</a> 
                </li>
                <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#nav-pills-squared-4">BPJS</a> 
                </li>
                <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#nav-pills-squared-10">Asuransi</a> 
                </li>
                <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#nav-pills-squared-5">NPWP</a> 
                </li>
                <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#nav-pills-squared-7">Kontrak Kerja</a> 
                </li>
				<li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#nav-pills-squared-8">Bonus</a> 
                </li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane in active" id="nav-pills-squared-1">
						<div class="form-group col-md-2">
							<label>NIK :</label>
							<input type="text" class="form-control" name="nik" value="<?=$data->nik_real?>" id="nik" readonly/>
						</div>
						<div class="form-group col-md-4">
							<label>No. KTP :</label>
							<input type="text" class="form-control" value="<?=$data->no_ktp?>" name="noktp" id="noktp" required/>
						</div>
						<div class="form-group col-md-6">
							<label>Nama Lengkap :</label>
							<input type="text" class="form-control" name="nama" value="<?=$data->nama_ktp?>" maxlength="30" id="nama" required/>
						</div>
						<div class="form-group col-md-4">
							<label>Email :</label>
							<input type="text" name="email" id="email" value="<?=$data->email?>" data-error="Please enter a valid email" placeholder="Enter your email" class="form-control">
							<div class="help-block with-errors"></div>
						</div>
						<div class="form-group col-md-4">
							<label>Jenis Kelamin :</label>
							<select name="jenkel" class="form-control" id="jenis" required>
								<option selected><?=$data->jenis_kelamin?></option>
								<option>Laki-laki</option>
								<option>Perempuan</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label>Agama :</label>
							<select name="agama" class="form-control" id="agama" required>
								<option><?=$data->agama?></option>
								<option value="Islam">Islam</option>
								<option value="Katolik">Katolik</option>
								<option value="Protestan">Protestan</option>
								<option value="Hindu">Hindu</option>
								<option value="Budha">Budha</option>
								<option value="Konghucu">Konghucu</option>
								<option value="Other">Other</option>
							</select>
						</div>
						<div class="col-md-12">
							<div class="row">
								<div class="form-group col-md-6">
									<label>Alamat KTP :</label>
									<textarea name="alamatktp" class="form-control" rows="3" required><?=$data->alamat_ktp?></textarea>
								</div>
								<div class="form-group col-md-6">
									<label>Alamat Domisili :</label>
									<textarea name="alamatd" class="form-control" rows="3" required><?=$data->alamat_domisili?></textarea>
								</div>
							</div>
						</div>
						<div class="form-group col-md-3">
							<label>Tempat Lahir :</label>
							<input type="text" class="form-control" name="tempat" id="tempat" value="<?=$data->tempat?>" required/>
						</div>
						<div class="form-group col-md-3">
							<label>Tanggal Lahir :</label>
							<div class="input-group date" id="date-picker5">
		                        <input type="text" name="tanggal_lahir" value="<?=$data->tanggal_lahir?>" class="form-control">
		                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
		                    </div>
						</div>
						<div class="form-group col-md-3">
							<label>Nomor Rekening :</label>
							<input type="text" class="form-control" name="no_rekening" id="no_rekening" value="<?=$data->no_rekening?>" />
						</div>
						<div class="form-group col-md-3">
							<label>Nama Rekening :</label>
							<input type="text" class="form-control" name="nama_rekening" id="nama_rekening" value="<?=$data->nama_rekening?>" />
						</div>
						<div class="form-group col-md-4">
							<label>Pendidikan Terakhir :</label>
							<select name="penter" id="penter" class="form-control" required>
								<option><?=$data->pendidikan_terakhir?></option>
								<option value="SD">SD</option>
								<option value="SMP">SMP</option>
								<option value="SMA/SMK">SMA/SMK</option>
								<option value="D1">D1</option>
								<option value="D3">D3</option>
								<option value="S1">S1</option>
								<option value="S2">S2</option>
								<option value="S3">S3</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label>Status Perkawinan :</label>
							<select name="kawin" class="form-control">
								<option><?=$data->status_perkawinan?></option>
								<option value="Lajang">Lajang</option>
								<option value="Menikah">Menikah</option>
								<option value="Cerai Hidup">Cerai Hidup</option>
							</select>
						</div>
						<div class="form-group col-md-4">
							<label>Status Pajak :</label>
							<select name="pajak" class="form-control">
								<option selected value="<?=$data->id_pajak?>"><?=$data->pajak?></option>
								<option value="">Pilih Option</option>
								<?php $pajak = $this->db->get('tab_pajak')->result();
								foreach($pajak as $hasilp){?>
									<option value="<?= $hasilp->id_pajak?>"><?=$hasilp->pajak?></option>
								<?php } ?>
							</select>
						</div>
						<div class="form-group col-md-6">
							<label>Jumlah Tanggungan :</label>
							<input type="text" class="form-control" name="tanggungan" id="tanggungan" pattern="[0-9.]+" value="<?=$data->tanggungan?>" required/>
						</div>
						<div class="from-group col-md-6">
							<label>PLANT :</label>
							<select name="cabang" class="form-control">
								<option value="">Pilih Option</option>
								<option selected value="<?=$data->id_cabang?>"><?=$data->cabang?></option>
								<?php $cabang = $this->db->get('tab_cabang')->result();
								foreach($cabang as $hasilp){?>
									<?php if ($hasilp->status=="Aktif") { ?>
										<option value="<?= $hasilp->id_cabang?>"><?= $hasilp->cabang?></option>
									<?php } 
								}?>
							</select>
						</div>
						<div class="col-xs-12">
							<div class="row">
								<div class="form-group col-md-6">
									<label>Nomor Telepon :</label>
									<div id="telp_div"></div>
									<button class="btn btn-success" type="button" id="btn-telp" onclick="addTelp()" style="margin-bottom:10%;">Add</button>
								</div>
								<div class="form-group col-md-6">
									<label>Tanggal Masuk :</label>
									<div class="input-group date" id="date-picker8">
				                        <input type="text" name="tanggal_awal" value="<?=$data->tanggal_awal?>" class="form-control">
				                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
				                    </div>
								</div>
							</div>
						</div>
                </div>
                <div role="tabpanel" class="tab-pane" id="nav-pills-squared-2">
                    <table class="table table-bordered" id="tabel">
                    	<tr>
                    		<th bgcolor="#F5DEB3" width="5%">NO</th>
                    		<th bgcolor="#F5DEB3">Status Hubungan</th>
                    		<th bgcolor="#F5DEB3">No Telp</th>
                    	</tr>
                    </table>
                	<button id="addkel" type="button" onclick="addKeluarga()" style="margin-top: 10px;" class="btn btn-warning">Add</button>
                </div>
                <div role="tabpanel" class="tab-pane" id="nav-pills-squared-4">
                	<div>
                		<label>Gaji BPJS</label>
                		<input class="form-control" type="text" name="gaji_bpjs" id="gaji_bpjs" value="<?=$data->gaji_bpjs?>" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false" required/>
                	</div>
				   <table class="table table-bordered">
                    	<tr>
                    		<th bgcolor="#F5DEB3">BPJS</th>
                    		<th bgcolor="#F5DEB3">STATUS</th>
                    		<th bgcolor="#F5DEB3">No. BPJS</th>
                    		<th bgcolor="#F5DEB3">Tanggal Daftar BPJS</th>
                    	</tr>
						<?php
							$i=1;
							$data_bpjs=$this->db->join('tab_master_bpjs b','b.id_bpjs=a.id_bpjs')->where('a.nik',$data->nik_real)->get('tab_bpjs_karyawan a')->result();
							//echo $this->db->last_query();
							foreach ($data_bpjs as $rs_bpjs) {
						?>
						<tr>
							<td><span class="c-input-text"> <?=$rs_bpjs->bpjs?> </span> 
        						<input type="hidden" name="idbpjs[]" value="<?=$rs_bpjs->id_bpjs?>">
        					</td>
        					<td>
        						<?php if($rs_bpjs->id_bpjs==1) {?>
        							<select name="status[]" onchange="aksiBpjs(this.value,1)" class="form-control" style="width: 100%;">
        								<option selected><?=$rs_bpjs->status?></option>
        								<option>---</option>
        								<option>Sudah Ada</option>
        								<option>Sudah Ada (Perlu Daftar)</option>
        								<option>Belum Punya (Perlu Daftar)</option>
        								<option>Tidak Dapat (Keterangan Menyusul)</option>
        							</select>
        						<?php } else { ?>
        							<select name="status[]" onchange="aksiBpjs(this.value,2)" class="form-control" style="width: 100%;">
        								<option selected><?=$rs_bpjs->status?></option>
        								<option>---</option>
        								<option value="Tidak Ikut">Tidak Ikut (dengan surat pernyataan)</option>
        								<option>Sudah Ada</option>
        								<option>Sudah Ada (Perlu Daftar)</option>
        								<option>Belum Punya (Perlu Daftar)</option>
        								<option>Tidak Dapat</option>
        							</select>
        						<?php } ?>
        					</td>
							<td><input type="text" name="no_bpjs[]" id="no_bpjs<?=$i?>" class="form-control" value="<?=$rs_bpjs->no_bpjs?>" placeholder="No BPJS"></td>
							<td><input type="date" name="tgl_bpjs[]" value="<?=$rs_bpjs->bulan_ambil?>" class="form-control" id="date-picker<?=$i?>"></td>
						<?php
							$i++;
							}
						?>
                    </table>
                </div>
				 <div role="tabpanel" class="tab-pane" id="nav-pills-squared-10">
					<div class="form-group col-md-6">
						<label>Vendor :</label>
						<select name="asuransi" class="form-control" style="width: 100%;">
							<option value="<?=$data->id_vend?>"><?=$data->vendor?></option>
							<?php $asuransi=$this->db->get('tab_asuransi')->result();
								foreach ($asuransi as $as) {
									if ($as->status=="Aktif") {
										echo "<option value='$as->id'>$as->vendor</option>";
									}
									
								}
							?>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label>No Premi :</label>
						<input type="text" name="no_premi" value="<?=$data->nomor_premi?>" class="form-control" />
					</div>
					<div class="form-group col-md-6">
						<label>Tanggal Premi :</label>
						<input type="text" name="tanggal_premi" value="<?=$data->tanggal_premi?>" id="date-picker7" class="form-control" />
					</div>
					<div class="form-group col-md-6">
						<label>Nominal :</label>
						<input type="text" name="nominal_premi" value="<?=$data->nominal_asuransi?>" class="form-control" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
					</div>
                </div>
                <div role="tabpanel" class="tab-pane" id="nav-pills-squared-5">
                	<div class="form-group col-md-4">
                		<label>Kepemilikan NPWP</label>
                		<select class="form-control" name="cek_npwp" id="cek_npwp" style="width: 100%;" required>
                			<option><?=$data->npwp?></option>
                			<option value="">---</option>
                			<option>Punya</option>
                			<option>Tidak</option>
                		</select>
                	</div>
                     <table class="table table-bordered" id="tab_npwp" hidden>
                    	<tr>
                    		<th bgcolor="#F5DEB3">No. NPWP</th>
                    		<th bgcolor="#F5DEB3">Nama NPWP</th>
                    		<th bgcolor="#F5DEB3">Tanggal NPWP</th>
                    		<th bgcolor="#F5DEB3">Alamat NPWP</th>
                    		<th bgcolor="#F5DEB3" width="40%">Keterangan</th>
                    	</tr>
						<tr>
							<td><input type="text" name="no_npwp" value="<?=$data->no_npwp?>" id="no_npwp" class="form-control"  /></td>
							<td><input type="text" name="nama_npwp" id="nama_npwp" value="<?=$data->nama_npwp?>" class="form-control"  /></td>
							<td><input type="date" name="tanggal_npwp" id="date-picker6" value="<?=$data->tanggal_npwp?>" class="form-control"  /></td>
							<td><input type="text" name="alamat_npwp" id="alamat_npwp" value="<?=$data->alamat_npwp?>" class="form-control"  /></td>
							<td><label id="lbl_keterangan"><?php $ket=$this->db->get('npwp')->row(); echo $ket->keterangan;?></label><textarea name="ket_npwp" id="ket_npwp" rows="6"></textarea><button type="button" class="btn btn-info btn-circle m-r-5" onclick="editNpwp()" id="btn_edit"><i class="fa fa-edit"></i> 
            				</button></td>
						</tr>
					</table>
                </div>
                <div role="tabpanel" class="tab-pane" id="nav-pills-squared-7">
                    <div class="from-group col-md-3">
                    	<label>Status Kerja :</label>
                    	<select name="status_kerja" class="form-control" id="status_kerja" style="width: 100%;" required>
                    		<option selected><?=$data->status_kerja?></option>
                    		<option value="">Pilih Option</option>
                    		<?php
                    			$st=$this->db->select('status_kerja')->group_by('status_kerja')->get('tab_kontrak_kerja')->result;
                    			if (count($st)>=1) {
                    				foreach ($st as $rs_st) {
                    					echo "<option>$st->status_kerja</option>";
                    				}
                    			}else{
                    				echo "<option>Casual Lepas</option>
                 						  <option>Casual Tetap</option>
                    					  <option>Kontrak 1</option>
                    					  <option>Kontrak 2</option>
                    					  <option>Tetap</option>";
                    			}
                    		?>
                    		<option>Lainnya</option>
                    	</select>
					</div>
					<div class="from-group col-md-3">
                    	<label>Jabatan :</label>
                    	 <select name="jabatan" id="jabatan" class="form-control" style="width: 100%;" required>
						 	<option value="<?=$data->id_jabatan?>"><?=$data->jabatan?></option>
						 	<option value="">Pilih Option</option>
							<?php $jabatan = $this->db->get('tab_jabatan')->result();
							foreach($jabatan as $hasil){
								if ($hasil->status=="Aktif") { ?>
									<option value="<?= $hasil->id_jabatan?>"><?= $hasil->jabatan?></option>
								<?php } 
							}?>
						</select>
					</div>
					<div class="from-group col-md-3">
						<label>Department :</label>
						<select class="form-control" name="department" id="department" style="width: 100%;" reqiured>
							<option selected value="<?=$data->id_department?>"><?=$data->department?></option>
							<option value="">Pilih Option</option>
							<?php $department = $this->db->get('tab_department')->result();
							foreach($department as $hasild){
								if ($hasild->status=="Aktif") { ?>
									<option value="<?= $hasild->id_department?>"><?= $hasild->department?></option>
								<?php } 
							}?>
						</select>
                    </div>
                    <div class="form-group col-md-3">
                    	<label>Tunjangan Jabatan :</label>
                    	<input class="form-control" type="text" name="tunjangan_jabatan" value="<?=$data->tunjangan_jabatan?>" id="tunjangan_jabatan" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
                    </div>
					<div class="form-group col-md-4">
						<label>Tanggal Mulai :</label>
                    	<div class="input-group date" id="date-picker3" reqiured>
	                        <input type="text" name="tgl_masuk" value="<?=$data->tanggal_masuk?>" class="form-control">
	                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
	                    </div>
                    	<label>Standard Hadir :</label>
                    	<input type="number" name="standar_hadir" value="<?=$data->standard_hadir?>" max="31"  class="form-control" required/>
					</div>
					<div class="form-group col-md-4">
						<label>Tanggal Selesai :</label>
                    	<div class="input-group date" id="date-picker4">
	                        <input type="text" class="form-control" name="tgl_resign" value="<?=$data->tanggal_resign?>" id="tgl_resign">
	                        <span class="input-group-addon"><i class="fa fa-th"></i></span>
	                    </div>
                    	<label>Uang Makan :</label>
                    	<input class="form-control" type="text" value="<?=$data->uang_makan?>" name="uangmakan" id="uangmakan" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
					</div>
                    <div class="form-group col-md-4">
                    	<label>Gaji Pokok :</label>
                    	<input class="form-control" type="text" name="gaji" id="gaji" value="<?=$data->gaji_pokok?>" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
                    	<label>Tarif Casual :</label>
						<input class="form-control" type="text" name="gajicasual" id="gajicasual" value="<?=$data->gaji_casual?>" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
                    </div>
                </div>
				<div role="tabpanel" class="tab-pane" id="nav-pills-squared-8">
					<div class="form-group col-md-12">
						<label> Tipe Bonus : </label>
						<?php 
							$tipe_bonus = ($data->tipe_bonus == 0) ? 'Bonus Lama' : 'Bonus Baru' ;
						?>
						<select name="tipe_bonus" id="tipe_bonus" class="form-control" style="width: 50%;">
							<option value="">Pilih Option</option>
							<option value="<?=$data->tipe_bonus?>" selected><?=$tipe_bonus?></option>
							<option value="0">Bonus Lama</option>
							<option value="1">Bonus Baru</option>
						</select>
					</div>
					<div class="form-group col-md-12">
						<hr>
						<h3> Bonus Lama </h3>
						<hr>
					</div>
					<div class="from-group col-md-3">
						<label>Grade :</label>
						<select name="grade" id="grade" class="form-control" style="width: 100%;">
							<option value="">Pilih Option</option>
							<option selected><?=$data->grade?></option>
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
						</select>
					</div>
					<div class="col-md-3">
						<label class="c-input c-checkbox">
							<?php
								if($data->prota=='1') $cek="checked"; else $cek="";
							?>
				            <input type="checkbox" name="cek_prota" value="1" <?=$cek?>> <span class="c-indicator c-indicator-warning"></span><span class="c-input-text"> Bonus Prorata </span> 
				        </label>
					</div>
					<div class="form-group col-md-3" id="div_persen">
						<label>Persentase (%):</label>
						<input type="number" name="persentase" id="persentase" value="<?=$data->persentase?>" max="100" class="form-control" >
					</div>
					<div class="form-group col-md-3" id="div_nominal">
						<label>Nominal :</label>
						<input class="form-control" type="text" name="nominal" id="nominal" value="<?=$data->nominal?>" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
					</div>
					<div class="form-group col-md-12">
						<hr>
						<h3> Bonus Baru </h3>
						<hr>
					</div>
					<div class="form-group col-md-6">
						<label>Nominal Bonus Standart :</label>
						<input class="form-control" type="text" name="nominal2" id="nominal2" value="<?=$data->nominal2?>" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
					</div>
					<div class="form-group col-md-12">
						<hr>
						<h3> Tarif T3 </h3>
						<hr>
					</div>
					<div class="form-group col-md-3">
						<label>Tarif T3 :</label>
						<input class="form-control" type="text" name="tarif_t3" id="tarif_t3" value="<?=$data->tarif_t3?>"  data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>
					</div>

				</div>
				</div>
			</div>
        </div>
 </div>
</form>
<?php 
	$array_telp=explode(":", $data->telepon);
	$js_telp=json_encode($array_telp);
	$array_keluarga=$keluarga;
	$js_klg=json_encode($array_keluarga);
?>
<script type="text/javascript">
var br=1;
var xb=1;
var baris1=1;
var js_klg=JSON.parse('<?=$js_klg?>');
addTelp();
addKeluarga();
function addTelp() {
	var js_telp=JSON.parse('<?=$js_telp?>');
	for (var baris1 = 1; baris1 <= js_telp.length; baris1++) {
		var node = document.createElement("input");
		node.name="telp["+baris1+"]";
		node.id="telp["+baris1+"]";
		node.value= js_telp[baris1-1];
		node.type="text";
		document.getElementById("telp_div").appendChild(node);
		document.getElementById("telp["+baris1+"]").setAttribute('class','form-control');
		document.getElementById("telp["+baris1+"]").setAttribute('style',"margin-top:5px;margin-bottom:5px;");
		document.getElementById("telp["+baris1+"]").setAttribute('placeholder',"No telepon karyawan "+baris1+"");
	}
	if(baris1 == '4'){
		document.getElementById("btn-telp").style.display='none';
	}
}
	function addKeluarga() {
		for (var br = 1; br <= js_klg.length ; br++) {
			var tbl=document.getElementById('tabel');
			var row= tbl.insertRow(tbl.rows.length);
			var num = document.createTextNode(br);
			row.id = 't1'+br;
			var td1=document.createElement("td");
			var td2=document.createElement("td");
			var td3=document.createElement("td");
			td1.appendChild(num);
			td2.appendChild(keluarga(br));
			td3.appendChild(telpKlg(br));
			row.appendChild(td1);
			row.appendChild(td2);
			row.appendChild(td3);
			document.getElementById("telpKlg["+br+"]").setAttribute('placeholder',"No Telepon ");
			document.getElementById("telpKlg["+br+"]").setAttribute('class','form-control');
			document.getElementById("telpKlg["+br+"]").value=js_klg[br-1].nomor_telp;
			document.getElementById("keluarga["+br+"]").setAttribute('placeholder',"Anak/Istri/Orang Tua/Adik/Kakak");
			document.getElementById("keluarga["+br+"]").setAttribute('class','form-control');
			document.getElementById("keluarga["+br+"]").value=js_klg[br-1].hubungan;
		}

		if(br == '4'){
			document.getElementById("addkel").style.display='none';
		}
	}
	function keluarga(index){
		var klg= document.createElement("input");
		klg.type="text";
		klg.name="keluarga["+index+"]";
		klg.id="keluarga["+index+"]";
		return klg;
	}
	function telpKlg(index){
		var telp= document.createElement("input");
		telp.type="text";
		telp.name="telpKlg["+index+"]";
		telp.id="telpKlg["+index+"]";
		return telp;
	}
	function aksiBpjs(a,b) {
		if (a=="Sudah Ada" || a=="Ikut Sudah Ada") {
			document.getElementById("date-picker"+b+"").setAttribute("disabled",true);
			document.getElementById("no_bpjs"+b+"").removeAttribute("disabled");
			document.getElementById("no_bpjs"+b+"").focus();
		}else if (a=="Belum Ada" || a=="Ikut Belum Ada" || a=="Sudah Ada (Perlu Daftar)" ) {
			document.getElementById("no_bpjs"+b+"").setAttribute("disabled",true);
			document.getElementById("date-picker"+b+"").removeAttribute("disabled");
			document.getElementById("date-picker"+b+"").focus();
		}else if (a=="Tidak Ikut"){
			document.getElementById("no_bpjs"+b+"").setAttribute("disabled",true);
			document.getElementById("date-picker"+b+"").setAttribute("disabled",true);
			alert("Minta Karyawan Buat Surat Pernyataan!");
		}else{
			document.getElementById("no_bpjs"+b+"").setAttribute("disabled",true);
			document.getElementById("date-picker"+b+"").setAttribute("disabled",true);

		}
	}
	$('#cek_npwp').change(function(){
		var a=$('#cek_npwp').val();
		if (a=="Punya") {
			$('#tab_npwp').attr('hidden',false);
			$('#no_npwp').focus();
		} else {
			$('#tab_npwp').attr('hidden',true);
			$('#date-picker6').val('');
			$('#no_npwp').val('');
		}
	});
	$('#bonus').change(function(){
		var a=$('#bonus').val();
		if (a=="Persentase") {
			$('#div_persen').attr('hidden',false);
			$('#div_nominal').attr('hidden',true);
			$('#persentase').focus();
			$('#nominal').val('');
			$('#persentase').val(<?=$data->persentase?>);
		} else if(a=="Nominal"){
			$('#div_persen').attr('hidden',true);
			$('#div_nominal').attr('hidden',false);
			$('#nominal').focus();
			$('#nominal').val(<?=$data->nominal_bonus?>);
			$('#persentase').val('');
		} else {
			$('#div_persen').attr('hidden',true);
			$('#div_nominal').attr('hidden',true);
			$('#nominal').val('');
			$('#persentase').val('');
		}
	});
	$('#status_kerja').change(function(){
		var a=$('#status_kerja').val();
		if (a=="Casual Lepas" || a=="Casual Tetap") {
			document.getElementById("gaji").setAttribute("disabled",true);
			document.getElementById("gajicasual").removeAttribute("disabled");
			document.getElementById("tgl_resign").removeAttribute("disabled");
			document.getElementById("uangmakan").removeAttribute("disabled");
		}else if (a.replace(/[0-9]/g, '')=="Kontrak" || a.replace(/[0-9]/g, '')=="Kontrak ") {
			document.getElementById("uangmakan").setAttribute("disabled",true);
			document.getElementById("gajicasual").setAttribute("disabled",true);
			document.getElementById("gaji").removeAttribute("disabled");
			document.getElementById("tgl_resign").removeAttribute("disabled");
		}else if (a=="Tetap") {
			document.getElementById("gajicasual").setAttribute("disabled",true);
			document.getElementById("uangmakan").setAttribute("disabled",true);
			document.getElementById("tgl_resign").setAttribute("disabled",true);
			document.getElementById("gaji").removeAttribute("disabled");
		}else if (a=="Lainnya") {
			$("#st_kerja").html("<input type='text' name='status_kerja' class='form-control'>");
			document.getElementById("gajicasual").removeAttribute("disabled");
			document.getElementById("uangmakan").removeAttribute("disabled");
			document.getElementById("tgl_resign").removeAttribute("disabled");
			document.getElementById("gaji").removeAttribute("disabled");
		}
	});
function editNpwp() {
	var ktr = $('#lbl_keterangan').text();
	$('#ket_npwp').show();
	$('#lbl_keterangan').hide();
	$('#btn_edit').hide();
}
$( document ).ready(function() {
	var ktr = $('#lbl_keterangan').text();
	$('#ket_npwp').text(ktr);
	$('#ket_npwp').hide();
	$('#status_kerja').trigger("change");
	$('#bonus').trigger("change");
	$('#cek_npwp').trigger("change");
});
</script>