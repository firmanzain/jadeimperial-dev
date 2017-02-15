    <h3>Halaman Perhitungan Pph21 Karyawan By Sistem Bulan <?=$this->format->BUlanIndo(date('m'))?> </h3>
    <hr>
<div class="col-xs-12">
    <div class="bs-nav-tabs nav-tabs-danger">
        <ul class="nav nav-tabs nav-animated-border-from-right">
            <li class="nav-item"> <a ng-href="" class="nav-link active" data-toggle="tab" data-target="#nav-tabs-2-1">Gaji Brutto Karyawan</a> 
            </li>
            <li class="nav-item"> <a ng-href="" class="nav-link" data-toggle="tab" data-target="#nav-tabs-2-2">PPh21</a> 
            </li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane in active" id="nav-tabs-2-1">
                <div class="table-responsive" style="overflow: scroll;">
                    <?php
                    if($data==true){
                    $no=1;
                    foreach ($data as $tampil){
                      $kalender=CAL_GREGORIAN;
                      $bulan = date('m');
                      $tahun= date('Y');
                      $jml_hari=cal_days_in_month($kalender, $bulan, $tahun);
                      $hitungan=$this->model_pph->pph_karyawan($tampil->nik_karyawan,$jml_hari);
                      $jpk=($tampil->gaji_bpjs*$hitungan['jpk'] != 0)? ($tampil->gaji_bpjs*$hitungan['jpk']/100):0;
                      $jht=($tampil->gaji_bpjs*$hitungan['jht'] != 0)? ($tampil->gaji_bpjs*$hitungan['jht']/100):0;
                      $jkk=($tampil->gaji_bpjs*$hitungan['jkk'] != 0)? ($tampil->gaji_bpjs*$hitungan['jkk']/100):0;
                      $jkm=($tampil->gaji_bpjs*$hitungan['jkm'] != 0)? ($tampil->gaji_bpjs*$hitungan['jkm']/100):0;
                      $total_bpjs=$jpk+$jht+$jkk+$jkm;
                      $t_casual=$tampil->gaji_casual+$tampil->uang_makan;
                      $casual1=$t_casual*$hitungan['masuk1'];
                      $casual2=$t_casual*$hitungan['masuk2'];
                      $gaji_bersih=($tampil->gaji_pokok+$hitungan['ekstra']+$total_bpjs+$hitungan['t3']+$casual1+$casual2)-$hitungan['cuti'];
                      $array_gaji[]=$gaji_bersih;
                      $this->table->add_row($no,$tampil->nik,$tampil->nama_ktp,$this->format->TanggalIndo($tampil->tanggal_resign),$this->format->indo($tampil->gaji_pokok),$this->format->indo($t_casual),$this->format->indo($hitungan['t3']),$this->format->indo($casual1),$hitungan['masuk1'],$this->format->indo($casual2),$hitungan['masuk2'],$this->format->indo($hitungan['cuti']),$this->format->indo($hitungan['ekstra']),$this->format->indo($total_bpjs),$this->format->indo($gaji_bersih));
                      $no++;
                    }
                    $tabel=$this->table->generate();
                    echo $tabel;
                    }else {
                      echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
                    }
                    ?>
                </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="nav-tabs-2-2">
                <div class="table-responsive" style="overflow: scroll;">
                    <?php
                      $this->table->set_heading(array('NO','NIK','Nama','Status Perkawinan','Tanggungan','Jenis Kelamin','NO NPWP','Nama NPWP','Status Pajak','Tgl. Resign','Total Gaji','Biaya Jabatan','PTKP','JHT','PKP','PKP Real','PKP Real Tahunan','PTKP','PPH21 Bulanan','PPH21 Program','PPH21 Terlapor'));
                      $tmp=array('table_open'=>'<table id="example-3" class="table table-hover table-striped table-bordered" >',
                                  'thead_open'=>'<thead>',
                                  'thead_close'=> '</thead>',
                                  'tbody_open'=> '<tbody>',
                                  'tbody_close'=> '</tbody>',
                              );
                      $this->table->set_template($tmp);
                      if($data==true){
                          $no=1;$i=0;
                          foreach ($data as $rs) {
                            $bea_jabatan=$array_gaji[$i]*0.05;
                            if ($bea_pb<500000) {
                              $bea_pb=$bea_jabatan;
                            }else{
                              $bea_pb=500000;
                            }
                      $hitungan=$this->model_pph->pph_karyawan($rs->nik_karyawan,$jml_hari);
                      $jht=($hitungan['jht_k']*$rs->gaji_bpjs!=0)?$hitungan['jht_k']*$rs->gaji_bpjs/100:0;
                      $pkp=$array_gaji[$i]-$bea_pb-$jht-$rs->tarif_bulan;
                      if ($pkp>0) {
                          $pkp_tahun=$pkp*12;
                          if ($pkp_tahun<=50000000) {
                              $pph_1=$pkp_tahun*0.05;
                          }elseif ($pkp_tahun<=250000000){
                            $pph_1=(2500000+($pkp_tahun-50000000))*0.15;
                          }elseif ($pkp_tahun<=500000000) {
                            $pph_1=(32500000+($pkp_tahun-250000000))*0.25;
                          }else{
                            $pph_1=(95000000+($pkp_tahun-500000000))*0.3;
                          }
                          $pph_bulan=$pph_1/12;
                      }else{
                        $pph_bulan=0;
                        $pph_1=0;
                        $pkp_tahun=0;
                        $pkp=0;
                      }
                      $hasil=round($pph_bulan/100,0)*100;
                      $this->table->add_row($no,$rs->nik,$rs->nama_ktp,$rs->status_perkawinan,$rs->tanggungan,$rs->jenis_kelamin,$rs->no_npwp,$rs->nama_npwp,$rs->pajak,$this->format->TanggalIndo($rs->tanggal_resign),$this->format->indo($array_gaji[$i]),$this->format->indo($bea_pb),$this->format->indo($rs->tarif_bulan),$this->format->indo($jht),$this->format->indo($pkp),$this->format->indo($pkp_tahun),$this->format->indo($pph_1),$this->format->indo($pph_bulan),$this->format->indo($hasil),$this->format->indo($hasil),$this->format->indo($hasil));
                            $i++;$no++;
                      }
                      
                      $tabel=$this->table->generate();
                      echo $tabel;
                      }else {
                        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
                      }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
