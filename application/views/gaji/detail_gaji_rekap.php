<!-- ketika button detail diklik -->

    <div class="col-md-12">
    <h4>Detail Gaji Karyawan Plant <?=$cabang?> Bulan <?=$this->format->BulanIndo($bln)?> Tahun <?=$thn?></h4>
    <hr>
    <form method="post" action="<?=base_url('Laporan/ex_gaji_detail')?>" target="new">
    <input type="hidden" name="bln" value="<?php echo $bln?>">
    <input type="hidden" name="thn" value="<?php echo $thn?>">
    <input type="hidden" name="id_cabang" value="<?php echo $id_cabang?>">
    <div class="table-responsive" style="overflow: scroll;">
      <?=$this->session->flashdata('pesan');?>
      <?php
      if($data==true){ ?>
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
                </tr>';

                $no++;

              } ?>

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
      <button class="btn btn-success" type="submit">Export Excel</button>
    </div>
    </form>
</div>