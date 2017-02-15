    <h3>Data Tunjangan THR Karyawan</h3>
    <hr>
    <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url('Laporan/ex_thr_detail')?>" target="new">
        <div class="table-responsive" style="overflow: scroll;">
        <input type="hidden" name="cabang" value="<?=$cabang?>">
          <?php
           if($data==true){
            $no=1;
            foreach ($data as $tampil){
              if ($tampil->approved=='Ya') {
                $mati='';
                $isi_id="";
              }else{
                $isi_id=$tampil->id_thr;
                $mati="disabled";
              }
              $pure_thr=$tampil->tarif-$tampil->pph_thr;
              $data=array(
                      "id" => $tampil->id,
                      "nik" => $tampil->nik,
                      "nama" => $tampil->nama_ktp,
                      "bln" => $this->format->BulanIndo(date('m',strtotime($tampil->tanggal_ambil))),
                      "cabang" => $tampil->cabang,
                      "jabatan" => $tampil->jabatan,
                      "tarif" => $this->format->indo($tampil->tarif),
                      "pph_thr" => $this->format->indo($tampil->pph_thr),
                      "thr_terima" => $this->format->indo($pure_thr),
                      "bulan " => $this->format->BulanIndo(date('m',strtotime($tampil->tanggal_ambil))).' '.date('Y',strtotime($tampil->tanggal_ambil)),
                      "tahun" => $tampil->tanggal_ambil
                      );
            $this->table->add_row('',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$tampil->jns_thr,$this->format->indo($tampil->tarif),$this->format->indo($tampil->pph_thr),$this->format->indo($pure_thr),$this->format->TanggalIndo($tampil->tanggal_ambil),$tampil->approved,$tampil->keterangan,"<button type='button' onclick=cetak('".base64_encode(implode(':', $data))."') class='label label-success' $mati>Cetak Data</button>");
            $no++;
            }
            $tabel=$this->table->generate();
            echo $tabel;
           }else {
              echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
           }
        ?>
        </div>
        <div class="form-group">
          <button onclick="window.history.go(-1); return false;" class="btn btn-warning" type="button">Kembali</button>
          <button type="submit" name="btn_aksi" value="excel" class="btn btn-success">
            Export Excel
          </button>
        </div>
    </form>
</div>
<script type="text/javascript">
</script>