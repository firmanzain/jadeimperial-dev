<h3>Data Karyawan</h3>
<h5>Cetak Keterangan Kerja</h5>
<div class="panel panel-default">
    <div class="panel-body">
          <form name="form_data" method="post" id="form_hasil" action="">
            <div class="table-responsive" id="show">
              <?php
                 if($data==true){
				 
                  $no=1;
                  foreach ($data as $tampil){
				  echo "<input type='hidden' name='nik' id='nik' value='$tampil->nik'>";
						$bulan1= substr($tampil->tanggal_kerja, 5,2);
						$tgl1= substr($tampil->tanggal_kerja, 8,2);
						$tahun1= substr($tampil->tanggal_kerja, 0,4);
						$bulan2= substr($tampil->tanggal_resign, 5,2);
					if(strtolower($bulan1) == '01'){$bln1 = 'Januari'; }if(strtolower($bulan1) == '02'){$bln1 = 'Februari'; }if(strtolower($bulan1) == '03'){$bln1 = 'Maret'; }if(strtolower($bulan1) == '04'){$bln1 = 'April'; }if(strtolower($bulan1) == '05'){$bln1 = 'Mei'; }if(strtolower($bulan1) == '06'){$bln1 = 'Juni'; }if(strtolower($bulan1) == '07'){$bln1 = 'Juli'; }if(strtolower($bulan1) == '08'){$bln1 = 'Agustus'; }if(strtolower($bulan1) == '09'){$bln1 = 'September'; }if(strtolower($bulan1) == '10'){$bln1 = 'Oktober'; }if(strtolower($bulan1) == '11'){$bln1 = 'November'; }if(strtolower($bulan1) == '12'){$bln1 = 'Desember'; }
				  		$bulan2= substr($tampil->tanggal_resign, 5,2);
						$tgl2= substr($tampil->tanggal_resign, 8,2);
						$tahun2= substr($tampil->tanggal_resign, 0,4);
					if(strtolower($bulan2) == '01'){$bln2 = 'Januari'; }if(strtolower($bulan2) == '02'){$bln2 = 'Februari'; }if(strtolower($bulan2) == '03'){$bln2 = 'Maret'; }if(strtolower($bulan2) == '04'){$bln2 = 'April'; }if(strtolower($bulan2) == '05'){$bln2 = 'Mei'; }if(strtolower($bulan2) == '06'){$bln2 = 'Juni'; }if(strtolower($bulan2) == '07'){$bln2 = 'Juli'; }if(strtolower($bulan2) == '08'){$bln2 = 'Agustus'; }if(strtolower($bulan2) == '09'){$bln2 = 'September'; }if(strtolower($bulan2) == '10'){$bln2 = 'Oktober'; }if(strtolower($bulan2) == '12'){$bln2 = 'November'; }if(strtolower($bulan2) == '12'){$bln2 = 'Desember'; }
                  
			$s=$this->db->where('nik',$tampil->nik);
			$s1=$this->db->get('tab_skk');
			$b=$this->db->where('nik',$tampil->nik);
			$b1=$this->db->get('tab_bpjs');
		  
			if($s1->num_rows == '1'){
			 $a = anchor('skkController/cetakskk/'.$tampil->nik.'/','<span class="label label-warning"><div class="zmdi zmdi-print zmdi-hc-2x"></div>Print</span>');
			}else{
				$a = anchor('SkkController/skkKaryawan/'.$tampil->nik.'/','<span class="btn btn-primary">Resign</span>');
		  }
		  if($b1->num_rows == '1'){
			 $bp= anchor('SkkController/cetakskkb/'.$tampil->nik.'/','<span class="label label-warning"><div class="zmdi zmdi-print zmdi-hc-2x"></div>Print</span>');
			}else{
				$bp = anchor('SkkController/skkbKaryawan/'.$tampil->nik.'/','<span class="btn btn-primary">Ajukan</span>');
		  }
				  $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$tampil->nik,$no,$tampil->nama_ktp,$tgl1.' '.$bln1.' '.$tahun1,$tgl2.' '.$bln2.' '.$tahun2,$tampil->jabatan,$tampil->department,$tampil->cabang,$a,$bp);
                  $no++;
                  }
                  $tabel=$this->table->generate();
                  echo $tabel;
                 }else {
                    echo "<div class='alert alert-danger'>data Tidak Ditemukan</div>";
                 }
              ?>
            </div>
    </div>
    <div class="panel-footer">
        <!--<button class="btn btn-info" type="button" onClick="importdata()">Import data</button>
        <button class="btn btn-danger delete" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus data</button>-->
  </div>
</div>