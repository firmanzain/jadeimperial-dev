    <h3>Data Tunjangan THR Karyawan</h3>
    <hr>
    <?=$this->session->flashdata('pesan');?>
      <form name="form_data" method="post" id="form_data" action="<?=base_url()?>ThrController/hapus">
        <div class="table-responsive" style="overflow: scroll;">
          <?php
           if($data==true){
            $no=1;
            foreach ($data as $tampil){
              if ($tampil->approved=='Ya') {
                $mati='';
                $isi_id=$tampil->id_thr;
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
            $this->table->add_row('<input type=checkbox name=cb_data[] id=cb_data[] value='.$isi_id.' '.$mati.'>',$no,$tampil->nik,$tampil->nama_ktp,$tampil->jabatan,$tampil->cabang,$tampil->jns_thr,$this->format->indo($tampil->tarif),$this->format->indo($tampil->pph_thr),$this->format->indo($pure_thr),$this->format->TanggalIndo($tampil->tanggal_ambil),$tampil->approved,$tampil->keterangan,"<button type='button' onclick=cetak('".base64_encode(implode(':', $data))."') class='label label-success' $mati>Cetak Data</button>");
            $no++;
            }
            $tabel=$this->table->generate();
            echo $tabel;
           }else {
              echo "<div class='alert alert-danger'>Data Tidak Ditemukan</div>";
           }
        ?>
        </div>
        <div class="panel-footer">
           <!--<?=anchor('ThrController/create','Tambah Data',['class' => 'btn btn-primary'])?>-->
            <button class="btn btn-danger" name="tombol" value="Hapus" onClick="return warning();"><i class="fa fa-trash-o"></i> Hapus Data</button>
            <button class="btn btn-success" name="tombol" value="Hapus" type="button" onClick="importData()">Import Pph</button>
        </div>
    </form>
</div>
<script type="text/javascript">
  function cetak(a) {
    sUrl="<?=base_url()?>ThrController/cetak/"+a+""; features = 'toolbar=no, left=350,top=100, ' + 
        'directories=no, status=no, menubar=no, ' + 
        'scrollbars=no, resizable=no';
        window.open(sUrl,"winChild",features);
  }
  function importData() {
  sUrl="<?=base_url()?>ThrController/importData"; features = 'toolbar=no, left=350,top=100, ' + 
  'directories=no, status=no, menubar=no, ' + 
  'scrollbars=no, resizable=no';
  window.open(sUrl,"winChild",features);
}
</script>