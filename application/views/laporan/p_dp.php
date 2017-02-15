<style>
  .tabel{
  border-collapse:collapse;
  width:100%;}
  .tabel th{
  background:#BEBEBE;
  color:#000;
  text-align: center;
  border:#000000 solid 1px;
  padding:3px;}
  .tabel td{
  border:#000000 solid 1px;
  padding:3px;
  }
  .tabel td{
    text-align: center;
    align-items: center;
  }
  h4,h5,h3,h2 {
    margin: 0 0 0 0;
    padding: 0 0 0 0;
  }
</style>
<h2 align="center" style='margin-bottom:0px'>Rekapitulasi Saldo DP / Cuti Karyawan </h2>
<?php
if (!empty($cabang)) {
  echo "<h2 align='center' style='margin-top:0px'>Plant $cabang->cabang</h2>";
}
if (!empty($bulan) and !empty($tahun)) {
  echo "<h2 align='center' style='margin-top:0px'> Periode ".$this->format->BulanIndo($bulan)." ".$tahun."</h2>";
}
?>
<hr>
<div style="margin-top: 10px">
   <table class="tabel" id="tabel">
          <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama</th>
            <th colspan="4">DP</th>
            <th colspan="9">Cuti</th>
          </tr>
          <tr>
            <th>Saldo Awal DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
            <th>Jth DP</th>
            <th>Libur</th>
            <th>Saldo Akhir DP <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
            <th>Saldo Cuti <?=$tahun-1?></th>
            <th>Adjusment</th>
            <th>Saldo Cuti Per <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
            <th>Cuti (Minus)</th>
            <th>DP (Minus) <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
            <th>Saldo Cuti Hangus <?=$tahun-1?></th>
            <th>Saldo Akhir Cuti <?=$tahun-1?></th>
            <th>Saldo Akhir Cuti Per <?=$this->format->BulanIndo($bulan).' '.$tahun?></th>
          </tr>
          <?php
          $no=1;
          foreach ($data as $tampil) {
            $cuti=$this->db->where('nik',$tampil->nik)
                     ->where('month(tanggal_mulai)',$tampil->bln)
                     ->select('sum(lama_cuti) as jml_cuti')
                     ->get('tab_cuti')->row();
            $izin=$this->db->where('nik',$tampil->nik)
                     ->where('month(tanggal_mulai)',$tampil->bln)
                     ->where('jenis_izin','Tidak Dapat Masuk')
                     ->select('sum(lama) as jml_izin')
                     ->get('tab_izin')->row();
            $saldo_bln_lalu=$this->db->where('nik',$tampil->nik)
                         ->where("month(bulan)",$tampil->bln-1)
                         ->select("saldo_dp,saldo_cuti")
                         ->get('tab_master_dp')->row();
            $saldo_thn_lalu=$this->db->where('nik',$tampil->nik)
                         ->where('year(bulan)',$tampil->thun-1)
                         ->select("saldo_cuti")
                         ->get('tab_master_dp')->row();
            $jatah_dp=($tampil->saldo_dp+$izin->jml_izin+$cuti->jml_cuti)-$saldo_bln_lalu->saldo_dp;
            if ($saldo_bln_lalu->saldo_dp<0) {
              $adj=abs($saldo_bln_lalu->saldo_dp);
              $dp_min=abs($saldo_bln_lalu->saldo_dp);
            }else{
              $adj=0;
              $dp_min=0;
            }
            if ($saldo_thn_lalu->saldo_cuti<0) {
              $min_cuti=abs($saldo_thn_lalu->saldo_cuti);
              $saldo_hangus=0;
            }else{
              $min_dp=0;
              $saldo_hangus=$saldo_thn_lalu->saldo_cuti;
            }
            $libur=$izin->jml_izin+$cuti->jml_cuti;
            echo "<tr>
                 <td>$no</td>
                 <td align='left'>$tampil->nama_ktp</td>
                 <td >$saldo_bln_lalu->saldo_dp</td>
                 <td align='center'>$jatah_dp</td>
                 <td align='center'>$libur</td>
                 <td align='center'>$tampil->saldo_dp</td>
                 <td align='center'>$saldo_thn_lalu->saldo_cuti</td>
                 <td align='center'>$adj</td>
                 <td align='center'>$tampil->saldo_cuti</td>
                 <td align='center'>$dp_min</td>
                 <td align='center'>$min_dp</td>
                 <td align='center'>$saldo_hangus</td>
                 <td align='center'>0</td>
                 <td align='center'>$tampil->saldo_cuti</td>
              </tr>";
            $no++;
          }
          ?>
        </table>
</div>
<div style="margin-top: 10px">
  <p>Surabaya, <?=$this->format->TanggalIndo(date('Y-m-d'))?></p>
  <p></p>
  <p></p>
  <p></p>
  <p>(..............................)</p>
</div>