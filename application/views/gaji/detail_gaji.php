<!-- ketika button detail diklik -->

    <div class="col-md-12">
    <h4>Detail Gaji Karyawan Plant <?=$cabang?></h4>
    <hr>
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <?php
      if($data == true){ ?>
              <table id="example-2" class="table table-hover table-striped table-bordered" style="white-space: nowrap;">
                <thead>
                  <tr>
                    <th>NO</th>
                    <th>NIK</th>
                    <th>NAMA</th>
                    <th>JABATAN</th>
                    <th>DEPARTMENT</th>
                    <th>UPAH JAMSOSTEK</th>
                    <th>GAJI POKOK</th>
                    <th>TUNJANGAN JABATAN</th>
                    <th>EKSTRA</th>
                    <th>DP CUTI</th>
                    <th>PINJ</th>
                    <th>PPH</th>
                    <?php
                    $bpjsid = array();
                    $bpjsiddetail = array();
                    $potongan_bpjs = array();
                    if ($bpjs) {
                      foreach ($bpjs->result() as $row) { 
                        echo '<th>'.$row->nama_potongan.'</th>';
                        array_push($bpjsid, $row->id_bpjs);
                        array_push($bpjsiddetail, $row->id_bpjs_detail);
                        array_push($potongan_bpjs, 0);
                      }
                    }
                    ?>
                    <th>GAJI DITERIMA</th>
                    <th>APPROVAL</th>
                    <th>KETERANGAN</th>
                    <th>CETAK</th>
                  </tr>
                </thead>
                <tbody>
              <?php
              $no = 1;
              $jamsostek = 0;
              $pokok = 0;
              $tunjangan = 0;
              $ekstra = 0;
              $dp_cuti = 0;
              $pinjaman = 0;
              $pph = 0;
              // $jht = 0;
              // $jpk = 0;
              $diterima = 0;

              foreach ($data as $tampil){

                $idbpjs = explode(",", $tampil->field17);
                $idbpjsdetail = explode(",", $tampil->field18);
                $bpjspotongan = explode(",", $tampil->field19);

                $jamsostek += $tampil->field5;
                $pokok += $tampil->field6;
                $tunjangan += $tampil->field7;
                $ekstra += $tampil->field8;
                $dp_cuti += $tampil->field9;
                $pinjaman += $tampil->field10;
                $pph += $tampil->field11;
                // $jht = $jht+$tampil->field12;
                // $jpk = $jpk+$tampil->field13;
                $diterima += $tampil->field14;

                if ($tampil->field15=="0") {
                  $app = "Belum";
                  $cetak = "hidden";
                } else if ($tampil->field15=="1") {
                  $app = "Tidak";
                  $cetak = "hidden";
                } else if ($tampil->field15=="2") {
                  $cetak = " ";
                  $app = "Setuju";
                }

                echo '
                <tr>
                  <td>'.$no.'</td>
                  <td>'.$tampil->field1.'</td>
                  <td>'.$tampil->field2.'</td>
                  <td>'.$tampil->field3.'</td>
                  <td>'.$tampil->field4.'</td>
                  <td>'.$this->format->indo($tampil->field5).'</td>
                  <td>'.$this->format->indo($tampil->field6).'</td>
                  <td>'.$this->format->indo($tampil->field7).'</td>
                  <td>'.$this->format->indo($tampil->field8).'</td>
                  <td>'.$this->format->indo($tampil->field9).'</td>
                  <td>'.$this->format->indo($tampil->field10).'</td>
                  <td>'.$this->format->indo($tampil->field11).'</td>';
                  for ($i = 0; $i < count($bpjsid); $i++) { 
                    for ($j = 0; $j < count($idbpjs); $j++) { 
                      if ($bpjsid[$i] == $idbpjs[$j] && $bpjsiddetail[$i] == $idbpjsdetail[$j]) {
                        echo '<td>'.$this->format->indo($bpjspotongan[$j]).'</td>';
                        $potongan_bpjs[$i] += $bpjspotongan[$j];
                      }
                    }
                  }
                echo'
                  <td>'.$this->format->indo($tampil->field14).'</td>
                  <td>'.$app.'</td>
                  <td>'.$tampil->field16.'</td>
                  <td></td>
                </tr>';

              //   $array_gaji = array(
              //     'nik'         => $tampil->field1,
              //     'nama'        => $tampil->field2,
              //     'gaji'        => $tampil->field6,
              //     'tunjangan'   => $tampil->field7,
              //     'extra'       => $tampil->field8,
              //     'pph'         => $tampil->field11,
              //     'dp_cuti'     => $tampil->field9,
              //     'jht'         => $tampil->field12,
              //     'jpk'         => $tampil->field13,
              //     'gaji_terima' => $tampil->field14,
              //     'no_gaji'     => $tampil->id_gaji_karyawan,
              //     'cabang'      => $tampil->cabang,
              //     'jabatan'     => $tampil->field3,
              //     'pinjaman'    => $tampil->field10
              //   );

              //   $this->table->add_row($no,$tampil->field1,$tampil->field2,$tampil->field3,$tampil->field4,$this->format->indo($tampil->field5),$this->format->indo($tampil->field6),$this->format->indo($tampil->field7),$this->format->indo($tampil->field8),$this->format->indo($tampil->field9),$this->format->indo($tampil->field10),$this->format->indo($tampil->field11),$this->format->indo($tampil->field12),$this->format->indo($tampil->field13),$this->format->indo($tampil->field14),$app,$tampil->field16,'<a class="label label-info" href="'.base_url()."GajiController/print_data/".base64_encode(implode(':', $array_gaji))."".'" target="new"  '.$cetak.'>Cetak Slip</a>');

                $no++;

        /*$kalender=CAL_GREGORIAN;
        $bulan = date('m');
        $tahun= date('Y');
        $jml_hari=cal_days_in_month($kalender, $bulan, $tahun);
        $hitungan=$this->model_gaji->rincian_gaji_karyawan($tampil->nik_karyawan,$jml_hari);
        $total_pph += $tampil->jml_pph;
        $total_ekstra += $hitungan['ekstra'];
        $total_cuti += $hitungan['cuti'];
        $jpk=($tampil->gaji_bpjs*$hitungan['jpk'] != 0)? ($tampil->gaji_bpjs*$hitungan['jpk']/100):0;
        $jht=($tampil->gaji_bpjs*$hitungan['jht'] != 0)? ($tampil->gaji_bpjs*$hitungan['jht']/100):0;
        $total_jht += $jht;
        $total_jpk += $jpk;
        $gaji_bersih=($tampil->gaji_pokok+$hitungan['ekstra']+$tampil->tunjangan_jabatan)-$tampil->jml_pph-($jpk+$jht)-$hitungan['cuti']-$hitungan['pinjaman'];
        $total_gaji += $gaji_bersih;
        $total_pokok += $tampil->gaji_pokok;
        $total_bpjs += $tampil->gaji_bpjs;
        $total_tunjangan += $tampil->tunjangan_jabatan;

        $array_gaji=array('nik'=>$tampil->nik_karyawan,
                           'nama'=>$tampil->nama_ktp,
                           'gaji'=>$tampil->gaji_pokok,
                           'extra'=>$hitungan['ekstra'],
                           'pph'=>$tampil->jumlah_pph,
                           'dp_cuti'=>$hitungan['cuti'],
                           'jht'=>$jht,
                           'jpk'=>$jpk,
                           'gaji_terima'=>$gaji_bersih,
                           'no_gaji'=>$tampil->id_gaji_karyawan,
                           'cabang'=>$tampil->cabang,
                           'jabatan'=>$tampil->jabatan,
                           'pinjaman'=>$hitungan['pinjaman']
                           );

        if ($tampil->approval=="2") {
              $cetak="";
              $app="Setuju";
        }else {
             $app="Tidak";
            $cetak="hidden";
        }

        $this->table->add_row($no,$tampil->nik_karyawan,$tampil->nama_ktp,$tampil->jabatan,$tampil->department,$this->format->indo($tampil->gaji_bpjs),$this->format->indo($tampil->gaji_pokok),$this->format->indo($tampil->tunjangan_jabatan),$this->format->indo($hitungan['ekstra']),$this->format->indo($hitungan['pinjaman']),$this->format->indo($tampil->jml_pph),$this->format->indo($jht),$this->format->indo($jpk),$this->format->indo($hitungan['cuti']),$this->format->indo($gaji_bersih),$app,$tampil->keterangan,'<a class="label label-info" href="'.base_url()."gajiController/print_data/".base64_encode(implode(':', $array_gaji))."".'" target="new"  '.$cetak.'>Cetak Slip</a>'); // fungsionalitas pertama : cetak gaji
      $no++;*/

              }


      //$this->table->add_row(array('data'=>''),array('data'=>'Total','colspan'=>4),$this->format->indo($total_bpjs),$this->format->indo($total_pokok),$this->format->indo($total_tunjangan),$this->format->indo($total_ekstra),$this->format->indo(0),$this->format->indo($total_pph),$this->format->indo($total_jht),$this->format->indo($total_jpk),$this->format->indo($total_cuti),$this->format->indo($total_gaji),'','','');

      // $this->table->add_row(array('data'=>''),array('data'=>'Total','colspan'=>4),$this->format->indo($jamsostek),$this->format->indo($pokok),$this->format->indo($tunjangan),$this->format->indo($ekstra),$this->format->indo($dp_cuti),$this->format->indo($pinjaman),$this->format->indo($pph),$this->format->indo($jht),$this->format->indo($jpk),$this->format->indo($diterima),'','','');
      
      // $tabel=$this->table->generate();
      
      // echo $tabel; ?>

                </tbody>
                <tfoot>
                  <tr>
                    <th colspan="5">Total </th>
                    <th><?php echo $this->format->indo($jamsostek);?></th>
                    <th><?php echo $this->format->indo($pokok);?></th>
                    <th><?php echo $this->format->indo($tunjangan);?></th>
                    <th><?php echo $this->format->indo($ekstra);?></th>
                    <th><?php echo $this->format->indo($dp_cuti);?></th>
                    <th><?php echo $this->format->indo($pinjaman);?></th>
                    <th><?php echo $this->format->indo($pph);?></th>
                    <?php
                      for ($i = 0; $i < count($bpjsid); $i++) {
                        echo '
                        <th>'.$this->format->indo($potongan_bpjs[$i]).'</th>
                        ';
                      }
                    ?>
                    <th><?php echo $this->format->indo($diterima);?></th>
                    <th><?php echo '';?></th>
                    <th><?php echo '';?></th>
                    <th><?php echo '';?></th>
                  </tr>
                </tfoot>
              </table>
      <?php
      } else {
        echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
      }
      ?>
    </div>
    <div class="form-group">
      <button onclick="window.history.go(-1); return false;" class="btn btn-warning" type="button">Kembali</button>
    </div>
</div>