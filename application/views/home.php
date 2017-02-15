<div class="row m-b-40">
    <div class="col-xs-12">
        <h4 class="text-widget-7 bg-warning-700 color-white" style="font-family: impact;">
           Selamat Datang <?=ucwords($this->session->userdata('nama'))?>
        </h4>
        <hr>
    </div>
    <div class="col-xs-12">
    	<script src="<?=base_url()?>assets/scripts/Chart.min.js"></script>
		<style type="text/css">
		    .chart-legend li span{
		        display: inline-block;
		        width: 12px;
		        height: 12px;
		        margin-right: 5px;
		        list-style-type: none;
		    }
		    .chart-legend li {
		        list-style-type: none;
		        display: inline;
		        padding-left: 10px;
		    }
		</style>
	    <!--<form class="form-inline" name="formdashboard" method="post" action="">
	          <div class="form-group m-r-20">
	              <label class="m-r-10">Bulan</label>
	              <select class="form-control" name="bln">
	              <option value="<?=$bln?>"><?=$this->format->BulanIndo($bln)?></option>
	                <?php
	          for ($i=1; $i <=12 ; $i++) { 
	            echo "<option value='$i'>".$this->format->BulanIndo($i)."</option>";
	          }
	                ?>
	              </select>
	          </div>
	          <div class="form-group m-r-20">
	              <label class="m-r-10">Tahun</label>
	              <select class="form-control" name="thn">
	                  <option selected><?=date("Y")?></option>
	                <?php
	                  for ($i=2050; $i >= 2000 ; $i--) { 
	                    echo "<option>$i</option>";
	                  }
	                ?>
	              </select>
	          </div>
	          <button type="submit" class="btn btn-warning" id="btn-cetak">Filter Data</button>
	      </form>-->
	        <form class="form-horizontal" id="form-periode0" method="POST">
	            <div class="form-group row">
	            	<label class="col-sm-2 form-control-label text-center"><b>PERIODE</b></label>
	                <div class="col-sm-4">
				        <div class="input-daterange input-group" id="date-picker2">
				            <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo date('Y-m-01');?>" />
				            <span class="input-group-addon">s/d</span>
				            <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo date('Y-m-t');?>" />
				        </div>
	                </div>
	                <div class="col-sm-6 text-left">
	                    <button type="submit" class="btn btn-primary">Filter</button>
	                </div>
	            </div>
	        </form>
	      <br>
		<div class="row m-b-20">
		    <div class="col-xs-12">
		        <h3>
		           Statistik Kehadiran Harian Karyawan Periode <?php echo $this->format->TanggalIndo($tgl1);?> s/d <?php echo $this->format->TanggalIndo($tgl2);?>
		        </h3>
		        <hr>
		    </div>
		</div>
		<div class="row m-b-20" style="margin-top: 30px">
		    <div class="col-md-10">
		        <canvas id="bar-chart" style="width:100%; height: 300px"></canvas>
		        <div id="legend-bar" class="chart-legend"></div>
		    </div>
		</div>
		<script type="text/javascript"> 
		var masuk=<?=$masuk?>;
		var cuti=<?=$cuti?>;
		var izin=<?=$izin?>;
		var absen=<?=$absen?>;
		</script>
		<script src="<?=base_url()?>assets/scripts/absensi_chart.js"></script>
    	<div class="col-xs-3">
    		<div class="text-widget-1">
	            <div class="row">
	                <a href="<?=base_url()?>Aprov/gaji">
	                	<div class="col-xs-4"> <span class="fa-stack fa-stack-2x pull-left">
						<i class="fa fa-circle fa-stack-2x color-success"></i>
						<i class="fa fa fa-usd fa-stack-1x color-white"></i>
						</span> 
		                </div>
		                <div class="col-xs-8 text-left">
		                    <div class="row">
		                        <div class="col-xs-12">
		                            <div class="title">Approvement Gaji</div>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-xs-12">
		                            <div class="numbers">
		                                <div> <span class="amount" count-to-currency="1123.99" value="0" duration="2"><?=$jumlah_notif['gaji']?></span> 
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
	                </a>
	            </div>
	        </div>
    	</div>
    	<div class="col-xs-3">
    		<div class="text-widget-1">
	            <div class="row">
	                <a href="<?=base_url()?>Aprov/komisi">
	                	<div class="col-xs-4"> <span class="fa-stack fa-stack-2x pull-left">
						<i class="fa fa-circle fa-stack-2x color-success"></i>
						<i class="fa fa fa-usd fa-stack-1x color-white"></i>
						</span> 
		                </div>
		                <div class="col-xs-8 text-left">
		                    <div class="row">
		                        <div class="col-xs-12">
		                            <div class="title">Approvement Komisi</div>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-xs-12">
		                            <div class="numbers">
		                                <div> <span class="amount" count-to-currency="1123.99" value="0" duration="2"><?=$jumlah_notif['komisi']?></span> 
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
	                </a>
	            </div>
	        </div>
    	</div>
    	<div class="col-xs-3">
    		<div class="text-widget-1">
	            <div class="row">
	                <a href="<?=base_url()?>Aprov/ekstra">
	                	<div class="col-xs-4"> <span class="fa-stack fa-stack-2x pull-left">
						<i class="fa fa-circle fa-stack-2x color-success"></i>
						<i class="fa fa fa-usd fa-stack-1x color-white"></i>
						</span> 
		                </div>
		                <div class="col-xs-8 text-left">
		                    <div class="row">
		                        <div class="col-xs-12">
		                            <div class="title">Approvement Ekstra</div>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-xs-12">
		                            <div class="numbers">
		                                <div> <span class="amount" count-to-currency="1123.99" value="0" duration="2"><?=$jumlah_notif['ekstra']?></span> 
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
	                </a>
	            </div>
	        </div>
    	</div>
    	<div class="col-xs-3">
    		<div class="text-widget-1">
	            <div class="row">
	                <a href="<?=base_url()?>Aprov/tunjangan">
	                	<div class="col-xs-4"> <span class="fa-stack fa-stack-2x pull-left">
						<i class="fa fa-circle fa-stack-2x color-success"></i>
						<i class="fa fa fa-usd fa-stack-1x color-white"></i>
						</span> 
		                </div>
		                <div class="col-xs-8 text-left">
		                    <div class="row">
		                        <div class="col-xs-12">
		                            <div class="title">Approvement Tunjangan</div>
		                        </div>
		                    </div>
		                    <div class="row">
		                        <div class="col-xs-12">
		                            <div class="numbers">
		                                <div> <span class="amount" count-to-currency="1123.99" value="0" duration="2"><?=$jumlah_notif['tunjangan']?></span> 
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
	                </a>
	            </div>
	        </div>
    	</div>
    	<br><br>
    </div>

    <!--Notifikasi Terdisiplin-->
    <!--<div class="col-xs-12" align="center" <?=$visibel_disiplin->visibled?>>
    <br><br>
    	<hr style="border: 1px solid #000000;">
    	<h3 style="text-transform: uppercase;">Karyawan Paling Terdisipin</h3>
    	<div id="show_disiplin">
    		<div class="form-group" id="filter">
    			<input type="text" id="date-picker2" name="min">
    			<input type="text" id="date-picker6" name="max">
    			<button id="btn-ft">Filter</button>
    		</div>
    		<div class="form-group" align="left">
    			<button class="btn btn-danger" id="btn-filter">Filter</button>
    		</div>
    		<div id="hal-disiplin">
    			<table id="example-2" class="table table-hover table-striped table-bordered">
			    	<thead>
			    		<tr class="bg-warning-700 color-white">
			    			<th>NO</th>
			    			<th>NIK</th>
			    			<th>NAMA</th>
			    			<th>PLANT</th>
			    			<th>JABATAN</th>
			    			<th>DEPARTMENT</th>
			    			<th>TOTAL</th>
			    		</tr>
			    	</thead>
			    	<tbody>
			    		<?php
			    		$no=1;
			    			foreach ($disiplin_data as $view_dis) {
			    				echo "<tr><td>$no</td><td>$view_dis->nik</td><td>$view_dis->nama_ktp</td><td>$view_dis->cabang</td><td>$view_dis->jabatan</td><td>$view_dis->department</td><td>$view_dis->total_masuk</td></tr>";
			    			$no++;
			    			}
			    		?>
			    	</tbody>
		    	</table>
    		</div>
    	</div>
    	<button type="button" class="btn btn-info btn-sm m-r-10 m-b-10" id="btn-disiplin" onclick="showDisiplin(this.value,'disiplin')" value="show">Show</button>
    <hr style="border: 1px solid #000000;">
    </div>

    <!--Notifikasi Terlambat-->
    <!--<div class="col-xs-12" align="center"  <?=$visibel_telat->visibled?>>
    <br><br>
    	<hr style="border: 1px solid #000000;">
    	<h3 style="text-transform: uppercase;">Karyawan Paling Sering Terlambat</h3>
    	<div id="show_telat">
    		<div class="form-group" id="filter_telat">
    			<input type="text" id="date-picker3" name="min">
    			<input type="text" id="date-picker4" name="max">
    			<button id="btn-ft-telat">Filter</button>
    		</div>
    		<div class="form-group" align="left">
    			<button class="btn btn-danger" id="btn-filter-telat">Filter</button>
    		</div>
    		<div id="hal-telat">
    			<table id="example-3" class="table table-hover table-striped table-bordered">
		    		<thead>
			    		<tr class="bg-warning-700 color-white">
			    			<th>NO</th>
			    			<th>NIK</th>
			    			<th>NAMA</th>
			    			<th>PLANT</th>
			    			<th>JABATAN</th>
				    		<th>DEPARTMENT</th>
			    		</tr>
			    	</thead>
			    	<tbody>
		    		<?php
		    		$no=1;
		    			foreach ($terlambat_data as $view_ter) {
		    				echo "<tr><td>$no</td><td>$view_ter->nik</td><td>$view_ter->nama_ktp</td><td>$view_ter->cabang</td><td>$view_ter->jabatan</td><td>$view_ter->department</td></tr>";
		    			$no++;
		    			}
		    		?>
		    		</tbody>
		    	</table>
    		</div>
    	</div>
    	<button type="button" class="btn btn-info btn-sm m-r-10 m-b-10" id="btn-telat" onclick="showDisiplin(this.value,'telat')" value="show">Show</button>
    <hr style="border: 1px solid #000000;">
    </div>-->

    <!--Notifikasi Kontrak Jatuh Tempo-->
    <div class="col-xs-12" align="center"  <?=$visibel_kontrak->visibled?>>
    <br><br>
    	<hr style="border: 1px solid #000000;">
    	<h3 style="text-transform: uppercase;">Notifikasi Karyawan Kontrak Jatuh Tempo</h3>
    	<div id="show_kontrak">
    		<br>
	        <form class="form-horizontal" id="form-periode1" method="POST">
	            <div class="form-group row">
	            	<label class="col-sm-2 form-control-label"><b>PERIODE</b></label>
	                <div class="col-sm-4">
				        <div class="input-daterange input-group" id="date-picker1">
				            <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo date('Y-m-01');?>" />
				            <span class="input-group-addon">s/d</span>
				            <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo date('Y-m-t');?>" />
				        </div>
	                </div>
	                <div class="col-sm-6 text-left">
	                    <button type="submit" class="btn btn-primary">Filter</button>
	                </div>
	            </div>
	        </form>
	        <hr>
	        <div id="tabel-kontrak">
	    		<table id="example-4" class="table table-hover table-striped table-bordered">
		    		<thead>
			    		<tr class="bg-warning-700 color-white">
			    			<th>NO</th>
			    			<th>NIK</th>
			    			<th>NAMA</th>
			    			<th>STATUS KERJA</th>
			    			<th>PLANT</th>
			    			<th>TANGGAL MASUK</th>
			    			<th>TANGGAL RESIGN</th>
			    			<th>AKSI</th>
			    		</tr>
			    	</thead>
			    	<tbody>
		    		<?php
		    		$no=1;
		    			foreach ($data_resign as $view_res) {
		    				$tgl_resign=$this->format->TanggalIndo($view_res->tanggal_resign);
		    				$tgl_masuk=$this->format->TanggalIndo($view_res->tanggal_masuk);
		    				$cek=$this->db->where('id',$view_res->id_kon)
		    							  ->where('notifikasi','resign')
		    							  ->get('tab_notifikasi_aktif')->num_rows();
		    				if ($cek<1) {
		    					echo "<tr><td>$no</td><td>$view_res->nik</td><td>$view_res->nama_ktp</td><td>$view_res->status_kerja</td><td>$view_res->cabang</td><td>$tgl_masuk</td><td>$tgl_resign</td><td><a href='KaryawanController/profil/$view_res->nik'><span class='label label-info'>View Detail</span></a></td></tr>";
		    				}
		    				$no++;
		    			}
		    		?>
		    		</tbody>
		    	</table>
	        </div>
    	</div>
    	<button type="button" class="btn btn-info btn-sm m-r-10 m-b-10" id="btn-kontrak" onclick="showDisiplin(this.value,'kontrak')" value="show">Show</button>
    <hr style="border: 1px solid #000000;">
    </div>

    <!--Notifikasi Perubahan Schedule Karyawan Sebulan Terakhir-->
    <div class="col-xs-12" align="center"  <?=$visibel_schedule->visibled?>>
    <br><br>
    	<hr style="border: 1px solid #000000;">
    	<h3 style="text-transform: uppercase;">Notifikasi Perubahan Schedule Karyawan</h3>
    	<div id="show_jadwal">
    		<br>
	        <form class="form-horizontal" id="form-periode2" method="POST">
	            <div class="form-group row">
	            	<label class="col-sm-2 form-control-label"><b>PERIODE</b></label>
	                <div class="col-sm-4">
				        <div class="input-daterange input-group" id="date-picker2">
				            <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo date('Y-m-01');?>" />
				            <span class="input-group-addon">s/d</span>
				            <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo date('Y-m-t');?>" />
				        </div>
	                </div>
	                <div class="col-sm-6 text-left">
	                    <button type="submit" class="btn btn-primary">Filter</button>
	                </div>
	            </div>
	        </form>
	        <hr>
    		<div id="tabel-jadwal">
    			<table id="example-5" class="table table-hover table-striped table-bordered">
		    		<thead>
			    		<tr class="bg-warning-700 color-white">
			    			<th>NO</th>
			    			<th>NIK</th>
			    			<th>NAMA</th>
			    			<th>PLANT</th>
			    			<th>KODE JAM AWAL</th>
			    			<th>KODE JAM PINDAH</th>
			    			<th>KETERANGAN</th>
			    			<th>TANGGAL PINDAH</th>
			    		</tr>
			    	</thead>
			    	<tbody>
		    		<?php
		    		$no=1;
		    			foreach ($data_schedule as $view_sc) {
		    				$tgl_sc=$this->format->TanggalIndo($view_sc->tanggal_pindah);
		    				echo "<tr><td>$no</td><td>$view_sc->nik</td><td>$view_sc->nama_ktp</td><td>$view_sc->cabang</td><td>$view_sc->kode_jam_asal</td><td>$view_sc->kode_jam_pindah</td><td>$view_sc->keterangan</td><td>$tgl_sc</td></tr>";
		    				$no++;
		    			}
		    		?>
		    		</tbody>
		    	</table>
    		</div>
    	</div>
    	<button type="button" class="btn btn-info btn-sm m-r-10 m-b-10" id="btn-jadwal" onclick="showDisiplin(this.value,'jadwal')" value="show">Show</button>
    <hr style="border: 1px solid #000000;">
    </div>

    <!--Notifikasi BPJS JATUH TEMPO-->
    <div class="col-xs-12" align="center"  <?=$visibel_bpjs->visibled?>>
    <hr><br><br>
    	<hr style="border: 1px solid #000000;">
    	<h3 style="text-transform: uppercase;">Notifikasi BPJS JATUH TEMPO</h3>
    	<hr>
    	<div class="row">
	    	<div class="col-sm-12">
	    		<b>BPJS KESEHATAN</b>
	    		<hr>
	    		<div id="show_kesehatan">
		    	<!--<div class="form-group" id="filter-kesehatan">
					<form class="form-inline" name="formdashboard" method="post" action="">
					  <div class="form-group m-r-20">
					      <label class="m-r-10">Bulan</label>
					      <select class="form-control" name="bln2" id="bln2">
					        <?php
					  for ($i=1; $i <=12 ; $i++) { 
					    echo "<option value='$i'>".$this->format->BulanIndo($i)."</option>";
					  }
					        ?>
					      </select>
					  </div>
					  <div class="form-group m-r-20">
					      <label class="m-r-10">Tahun</label>
					      <select class="form-control" name="thn2" id="thn2">
					          <option selected><?=date("Y")?></option>
					        <?php
					          for ($i=2050; $i >= 2000 ; $i--) { 
					            echo "<option>$i</option>";
					          }
					        ?>
					      </select>
					  </div>
					  <button type="button" id="btn-ft-kesehatan">Filter</button>
					</form>
				</div>
				<div class="form-group" align="left">
					<button class="btn btn-danger" id="btn-filter-kesehatan">Filter</button>
				</div>-->
	    		<br>
		        <form class="form-horizontal" id="form-periode3" method="POST">
		            <div class="form-group row">
		            	<label class="col-sm-2 form-control-label"><b>PERIODE</b></label>
		                <div class="col-sm-4">
					        <div class="input-daterange input-group" id="date-picker3">
					            <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo date('Y-m-01');?>" />
					            <span class="input-group-addon">s/d</span>
					            <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo date('Y-m-t');?>" />
					        </div>
		                </div>
		                <div class="col-sm-6 text-left">
		                    <button type="submit" class="btn btn-primary">Filter</button>
		                </div>
		            </div>
		        </form>
		        <hr>
    			<div id="tabel-kesehatan">
			    	<!--<div class="table-responsive" id="show_kesehatan">-->
			    		<table id="example-6" class="table table-hover table-striped table-bordered">
				    		<thead>
					    		<tr class="bg-warning-700 color-white">
					    			<th>NO</th>
					    			<th>NIK</th>
					    			<th>NAMA</th>
					    			<th>PLANT</th>
					    			<th>TANGGAL DAFTAR</th>
					    		</tr>
					    	</thead>
					    	<tbody>
				    		<?php
				    		$no=1;
				    			foreach ($data_bpjs1 as $view_bpjs1) {
									$tgl_bpjs1=$this->format->TanggalIndo($view_bpjs1->bulan_ambil);
									echo "<tr><td>$no</td><td>$view_bpjs1->nik</td><td>$view_bpjs1->nama_ktp</td><td>$view_bpjs1->cabang</td><td>$tgl_bpjs1</td></tr>";
									$no++;
								}
				    		?>
				    		</tbody>
			    		</table>
			    	<!--</div>-->
			    </div>
			    </div>
		    	<button type="button" class="btn btn-info btn-sm m-r-10 m-b-10" id="btn-kesehatan" onclick="showDisiplin(this.value,'kesehatan')" value="show">Show</button>
	    	</div>

	    	<!--BPJS KETENAGAKERJAAN-->
	    	<div class="col-sm-12" align="center"  <?=$visibel_bpjs->visibled?>>
	    		<b>BPJS KETENAGAKERJAAN</b>
	    		<hr>
	    		<div id="show_tenaga">
		    	<!--<div class="form-group" id="filter-tenaga">
					<form class="form-inline" name="formdashboard" method="post" action="">
					  <div class="form-group m-r-20">
					      <label class="m-r-10">Bulan</label>
					      <select class="form-control" name="bln3" id="bln3">
					        <?php
					  for ($i=1; $i <=12 ; $i++) { 
					    echo "<option value='$i'>".$this->format->BulanIndo($i)."</option>";
					  }
					        ?>
					      </select>
					  </div>
					  <div class="form-group m-r-20">
					      <label class="m-r-10">Tahun</label>
					      <select class="form-control" name="thn3" id="thn3">
					          <option selected><?=date("Y")?></option>
					        <?php
					          for ($i=2050; $i >= 2000 ; $i--) { 
					            echo "<option>$i</option>";
					          }
					        ?>
					      </select>
					  </div>
					  <button type="button" id="btn-ft-tenaga">Filter</button>
					</form>
				</div>
				<div class="form-group" align="left">
					<button class="btn btn-danger" id="btn-filter-tenaga">Filter</button>
				</div>-->
	    		<br>
		        <form class="form-horizontal" id="form-periode4" method="POST">
		            <div class="form-group row">
		            	<label class="col-sm-2 form-control-label"><b>PERIODE</b></label>
		                <div class="col-sm-4">
					        <div class="input-daterange input-group" id="date-picker4">
					            <input type="text" class="input-sm form-control" name="tgl1" value="<?php echo date('Y-m-01');?>" />
					            <span class="input-group-addon">s/d</span>
					            <input type="text" class="input-sm form-control" name="tgl2" value="<?php echo date('Y-m-t');?>" />
					        </div>
		                </div>
		                <div class="col-sm-6 text-left">
		                    <button type="submit" class="btn btn-primary">Filter</button>
		                </div>
		            </div>
		        </form>
		        <hr>
    			<div id="tabel-tenaga">
		    	<!--<div class="table-responsive" id="show_tenaga">-->
			    	<table id="example-7" class="table table-hover table-striped table-bordered" width="100%">
			    		<thead>
				    		<tr class="bg-warning-700 color-white">
				    			<th>NO</th>
				    			<th>NIK</th>
				    			<th>NAMA</th>
				    			<th>PLANT</th>
				    			<th>TANGGAL DAFTAR</th>
				    		</tr>
				    	</thead>
				    	<tbody>
				    	<?php
			    		$no=1;
			    			foreach ($data_bpjs2 as $view_bpjs1) {
			    				$tgl_bpjs2=$this->format->TanggalIndo($view_bpjs1->bulan_ambil);
			    				if ($view_bpjs1->bulan_ambil<>"0000-00-00"||$view_bpjs1->bulan_ambil<>NULL) {
				    				echo "<tr><td>$no</td><td>$view_bpjs1->nik</td><td>$view_bpjs1->nama_ktp</td><td>$view_bpjs1->cabang</td><td>$tgl_bpjs1</td></tr>";
				    				$no++;
			    				}
			    			}
			    		?>
			    		</tbody>
			    	</table>
		    	<!--</div>-->
		    	</div>
			    </div>
		    	<button type="button" class="btn btn-info btn-sm m-r-10 m-b-10" id="btn-tenaga" onclick="showDisiplin(this.value,'tenaga')" value="show">Show</button>
    		<hr style="border: 1px solid #000000;">
	    	</div>
	    </div>
    </div>
</div>
<script type="text/javascript">
	function showDisiplin(a,b) {
		if (a=='hide') {
			$('#show_'+b+'').slideUp();
			$('#btn-'+b+'').attr("value", "show");
			$('#btn-'+b+'').text('Show');
		} else {
			$('#show_'+b+'').slideDown();
			$('#btn-'+b+'').attr("value", "hide");
			$('#btn-'+b+'').text('Hide');
		}
	}
	$('#btn-filter').click(function(){
		 $("#filter").show( "slide", {direction: "left" }, 500 );
		 $('#btn-filter').hide();
	});

	$('#btn-filter-jadwal').click(function(){
		 $("#filter-jadwal").show( "slide", {direction: "left" }, 500 );
		 $('#btn-filter-jadwal').hide();
	});

	$('#btn-filter-telat').click(function(){
		 $("#filter_telat").show( "slide", {direction: "left" }, 500 );
		 $('#btn-filter-telat').hide();
	});

	$('#btn-filter-kesehatan').click(function(){
		 $("#filter-kesehatan").show( "slide", {direction: "left" }, 500 );
		 $('#btn-filter-kesehatan').hide();
	});

	$('#btn-filter-tenaga').click(function(){
		 $("#filter-tenaga").show( "slide", {direction: "left" }, 500 );
		 $('#btn-filter-tenaga').hide();
	});

	$('#btn-ft').click(function(){
		 var pm1=$('#date-picker2').val();
		 var pm2=$('#date-picker6').val();
		 $.ajax({
                type: "POST",
                url : "<?php echo base_url(); ?>Welcome/cari_disiplin",
                data : "tgl1="+pm1+"&tgl2="+pm2+"",
                success: function(msg){
					$('#hal-disiplin').html(msg);
					$("#filter").hide( "slide", {direction: "right" }, 500 );
		 			$('#btn-filter').show();	        
                }
            });
	});

	$('#btn-ft-telat').click(function(){
		 var pm1=$('#date-picker3').val();
		 var pm2=$('#date-picker4').val();
		 $.ajax({
                type: "POST",
                url : "<?php echo base_url(); ?>Welcome/cari_telat",
                data : "tgl1="+pm1+"&tgl2="+pm2+"",
                success: function(msg){
					$('#hal-telat').html(msg);
					$("#filter_telat").hide( "slide", {direction: "right" }, 500 );
		 			$('#btn-filter-telat').show();        
                }
            });
	});

	var table;
	$( document ).ready(function() {
		$('#show_tenaga').slideUp();
		$('#show_telat').slideUp();
		$('#show_disiplin').slideUp();
		$('#show_jadwal').slideUp();
		$('#show_kesehatan').slideUp();
		$('#show_kontrak').slideUp();
		$('#show_tenaga').slideUp();
		$( "#filter" ).hide();
		$( "#filter_telat" ).hide();
		$( "#filter-jadwal" ).hide();
		$( "#filter-kesehatan" ).hide();
		$( "#filter-tenaga" ).hide();
	});
	function delNotif(a,b,c) {
    var tabel= document.getElementById('example-4');
    var id=a.parentNode.parentNode.rowIndex;
	$.ajax({
            type: "POST",
            url : "<?php echo base_url(); ?>Welcome/hapus",
            data : "id="+b+"&notif="+c+"",
            success: function(msg){
              if (msg=="sukses") {
                  tabel.deleteRow(id);
              }
            }
        });
	}


	$("#form-periode1").submit(function(event){
		$.ajax({
		    type: "POST",
		    url : "<?php echo base_url(); ?>Welcome/cari_kontrak",
		    data : $("#form-periode1").serialize(),
		    success: function(msg){
				$('#tabel-kontrak').html(msg);
				$('#example-4').DataTable();
		    }
		});
		return false;
	});
	$("#form-periode2").submit(function(event){
		$.ajax({
		    type: "POST",
		    url : "<?php echo base_url(); ?>Welcome/cari_jadwal",
		    data : $("#form-periode2").serialize(),
		    success: function(msg){
				$('#tabel-jadwal').html(msg);
				$('#example-5').DataTable();
		    }
		});
		return false;
	});
	$("#form-periode3").submit(function(event){
		$.ajax({
		    type: "POST",
		    url : "<?php echo base_url(); ?>Welcome/cari_bpjs_kesehatan",
		    data : $("#form-periode3").serialize(),
		    success: function(msg){
				$('#tabel-kesehatan').html(msg);
				$('#example-6').DataTable();
		    }
		});
		return false;
	});
	$("#form-periode4").submit(function(event){
		$.ajax({
		    type: "POST",
		    url : "<?php echo base_url(); ?>Welcome/cari_bpjs_tenaga",
		    data : $("#form-periode4").serialize(),
		    success: function(msg){
				$('#tabel-tenaga').html(msg);
				$('#example-7').DataTable();
		    }
		});
		return false;
	});
</script>
