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
                        <li class="nav-item active"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-1">Data Pribadi</a> 
                        </li>
                        <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-2">Status Kerja</a> 
                        </li>
                        <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-3">Riwayat Kerja</a> 
                        </li>
                        <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-4">Riwayat Gaji</a> 
                        </li>
                        <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-5">Riwayat Bonus</a> 
                        </li>
                        <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-6">Riwayat T3</a> 
                        </li>
                        <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-7">Riwayat Tunjangan Lain</a> 
                        </li>
                        <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-9">Riwayat SP</a> 
                        </li>
                        <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#vertical-nav-tabs-left-8">Riwayat Status Pajak</a> 
                        </li>
                    </ul>
                </div>
                <div class="col-xs-6 col-lg-10">
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
                                <tr>
                                    <td>Status Pajak</td>
                                    <td>:</td>
                                    <td><?=$data->pajak?></td>
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
                            		<td>Plant</td>
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

                                <!--Anwar-->
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
                        <div role="tabpanel" class="tab-pane" id="vertical-nav-tabs-left-3">
                            <?php
                                $r_kerja=$this->db->where('a.nik',$data->nik)
                                                  ->join('tab_karyawan b','b.nik=a.nik')
                                                  ->join('tab_jabatan c','c.id_jabatan=b.jabatan')
                                                  ->join('tab_department d','d.id_department=b.department')
                                                  ->order_by('a.tanggal_masuk', 'DESC')
                                                  ->get('tab_history_kontrak_kerja a')->result();
                            ?>
                            <table class="table table-hover table-striped table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Status Kerja</th>
                                    <th>Jabatan</th>
                                    <th>Departemen</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                </tr>
                                <?php
                                    $no=1;
                                    foreach ($r_kerja as $v_kerja) {
                                        if ($v_kerja->tanggal_resign=="0000-00-00") {
                                            $akhir = "-";
                                        } else {
                                            $akhir = $this->format->TanggalIndo($v_kerja->tanggal_resign);
                                        }
                                        echo "<tr>
                                                    <td>$no</td>
                                                    <td>$v_kerja->status_kerja</td>
                                                    <td>$v_kerja->jabatan</td>
                                                    <td>$v_kerja->department</td>
                                                    <td>".$this->format->TanggalIndo($v_kerja->tanggal_masuk)."</td>
                                                    <td>".$akhir."</td>
                                            </tr>";
                                    $no++;
                                    }
                                ?>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vertical-nav-tabs-left-4">
                            <?php
                                /*$r_gaji=$this->db->where('nik',$data->nik)
                                                  ->get('tab_gaji_karyawan_new')->result();*/
                                $r_gaji = $this->db->query(
                                    '
                                    select gaji_karyawan as gaji1, tunjangan_jabatan as tunjangan_jabatan, gaji_diterima as gaji2, tanggal_gaji as tgl_gaji 
                                    from tab_gaji_karyawan_new where nik="'.$data->nik.'" 
                                    UNION ALL 
                                    select gaji_casual as gaji1, 0 as tunjangan_jabatan, (gaji_diterima_1 + gaji_diterima_2) as gaji2, tanggal_gaji_2 as tgl_gaji 
                                    from tab_gaji_casual_new where nik="'.$data->nik.'" 
                                    UNION ALL 
                                    select gaji_karyawan as gaji1, tunjangan_jabatan as tunjangan_jabatan, gaji_diterima as gaji2, tanggal_gaji as tgl_gaji 
                                    from tab_gaji_karyawan_resign where nik="'.$data->nik.'" 
                                    order by tgl_gaji desc 
                                    '
                                )->result();
                            ?>
                            <table class="table table-hover table-striped table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Gaji Pokok</th>
                                    <th>Tunjangan Jabatan</th>
                                    <th>Total Gaji</th>
                                    <th>Gaji Diterima</th>
                                    <th>Bulan Gaji</th>
                                </tr>
                                <?php
                                    $no=1;
                                    foreach ($r_gaji as $v_gaji) {
                                        echo "<tr>
                                                    <td>$no</td>
                                                    <td>".$this->format->indo($v_gaji->gaji1)."</td>
                                                    <td>".$this->format->indo($v_gaji->tunjangan_jabatan)."</td>
                                                    <td>".$this->format->indo($v_gaji->gaji1 + $v_gaji->tunjangan_jabatan)."</td>
                                                    <td>".$this->format->indo($v_gaji->gaji2)."</td>
                                                    <td>".$this->format->BulanIndo(date('m',strtotime($v_gaji->tgl_gaji)))."</td>
                                            </tr>";
                                    $no++;
                                    }
                                ?>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vertical-nav-tabs-left-5">
                            <?php
                                $r_bonus=$this->db->where('nik',$data->nik)
                                                  ->get('tab_bonus_karyawan')->result();
                            ?>
                            <table class="table table-hover table-striped table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Bonus Persentase</th>
                                    <th>Bonus Nominal</th>
                                    <th>Bonus Per Point</th>
                                    <th>Bonus Prorata</th>
                                    <th>Total Bonus</th>
                                    <th>Total Bulat</th>
                                    <th>Total Kembali</th>
                                    <th>Total Diterima</th>
                                    <th>Tanggal Bonus</th>
                                </tr>
                                <?php
                                    $no=1;
                                    foreach ($r_bonus as $v_bonus) {
                                        echo "<tr>
                                                    <td>$no</td>
                                                    <td>".$this->format->indo($v_bonus->bonus_prosen)."</td>
                                                    <td>".$this->format->indo($v_bonus->bonus_nominal)."</td>
                                                    <td>".$this->format->indo($v_bonus->bonus_point)."</td>
                                                    <td>".$this->format->indo($v_bonus->bonus_prorata)."</td>
                                                    <td>".$this->format->indo($v_bonus->total_bonus)."</td>
                                                    <td>".$this->format->indo($v_bonus->total_bulat)."</td>
                                                    <td>".$this->format->indo($v_bonus->total_kembali)."</td>
                                                    <td>".$this->format->indo($v_bonus->total_diterima)."</td>
                                                    <td>".$this->format->TanggalIndo($v_bonus->tanggal_bonus)."</td>
                                            </tr>";
                                    $no++;
                                    }
                                ?>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vertical-nav-tabs-left-6">
                            <?php
                                $r_t3=$this->db->where('nik',$data->nik)
                                                  ->get('tab_t3')->result();
                            ?>
                            <table class="table table-hover table-striped table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Nominal T3</th>
                                    <th>Jumlah Hadir</th>
                                    <th>Jumlah T3</th>
                                    <th>Jumlah Diterima</th>
                                    <th>Tanggal Diterima</th>
                                </tr>
                                <?php
                                    $no=1;
                                    foreach ($r_t3 as $v_t3) {
                                        $nominal_t3=$v_t3->total_t3/$v_t3->jml_hadir;
                                        echo "<tr>
                                                    <td>$no</td>
                                                    <td>".$this->format->indo($nominal_t3)."</td>
                                                    <td>$v_t3->jml_hadir</td>
                                                    <td>".$this->format->indo($v_t3->total_t3)."</td>
                                                    <td>".$this->format->indo(intval($v_t3->total_t3/100)*100)."</td>
                                                    <td>".$this->format->TanggalIndo($v_t3->tanggal)."</td>
                                            </tr>";
                                    $no++;
                                    }
                                ?>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vertical-nav-tabs-left-7">
                            <?php
                                $r_tunjangan=$this->db->where('b.nik',$data->nik)
                                               ->join('tab_master_tunjangan a','a.id_tunjangan=b.tunjangan')
                                               ->get('tab_tunjangan_karyawan b')->result();
                            ?>
                            <table class="table table-hover table-striped table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Tunjangan</th>
                                    <th>Nominal</th>
                                    <th>Tanggal Diterima</th>
                                </tr>
                                <?php
                                    $no=1;
                                    foreach ($r_tunjangan as $v_tunjangan) {
                                        echo "<tr>
                                                    <td>$no</td>
                                                    <td>$v_tunjangan->tunjangan</td>
                                                    <td>".$this->format->indo($v_tunjangan->tarif)."</td>
                                                    <td>".$this->format->TanggalIndo($v_tunjangan->entry_date)."</td>
                                            </tr>";
                                    $no++;
                                    }
                                ?>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vertical-nav-tabs-left-9">
                            <?php
                                $r_tunjangan=$this->db->where('nik',$data->nik)
                                               ->get('tab_sp')->result();
                            ?>
                            <table class="table table-hover table-striped table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Keterangan</th>
                                </tr>
                                <?php
                                    $no=1;
                                    foreach ($r_tunjangan as $v_tunjangan) {
                                        echo "<tr>
                                                    <td>$no</td>
                                                    <td>".$this->format->TanggalIndo($v_tunjangan->tanggal_sp)."</td>
                                                    <td>".$this->format->TanggalIndo($v_tunjangan->tanggal_sp_selesai)."</td>
                                                    <td>$v_tunjangan->isi_sp</td>
                                            </tr>";
                                    $no++;
                                    }
                                ?>
                            </table>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="vertical-nav-tabs-left-8">
                            <?php
                                $r_pajak=$this->db->where('b.nik',$data->nik)
                                                       ->join('tab_pajak a','a.id_pajak=b.id_pajak')
                                                       ->order_by('b.entry_date','desc')
                                                       ->get('tab_history_status_pajak b')->result();
                            ?>
                            <table class="table table-hover table-striped table-bordered">
                                <tr>
                                    <th>No</th>
                                    <th>Pajak</th>
                                    <th>Tanggal Pajak</th>
                                </tr>
                                <?php
                                    $no=1;
                                    foreach ($r_pajak as $v_pajak) {
                                        echo "<tr>
                                                    <td>$no</td>
                                                    <td>$v_pajak->pajak</td>
                                                    <td>".$this->format->TanggalIndo($v_pajak->entry_date)."</td>
                                            </tr>";
                                    $no++;
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>