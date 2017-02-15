<h4> Master Omset Standart </h4>
<hr>
<div class="panel panel-default">
    <div class="panel-body">
          <?php
               if($data <> false){
                $no = 1;
                foreach ($data->result() as $row){
                  $this->table->add_row(
                    $no,
                    $row->nama_cabang,
                    '<input class="form-control" type="text" name="nominal_omset[]" id="nominal_omset'.$row->id_omset.'" value="'.$row->nominal_omset.'" data-mask="#.##0" data-mask-reverse="true" data-mask-maxlength="false"/>',
                    '<button type="button" class="btn btn-primary" onclick="editomset('.$row->id_omset.')"> Edit </button>'
                  );
                  $no++;
                }
                $tabel = $this->table->generate();
                echo $tabel;
               } else {
                  echo "<div class='alert alert-danger'> Data Tidak Ditemukan </div>";
               }
          ?>
    </div>
</div>

<script type="text/javascript">
  function editomset(id) {
    $.ajax({
      type : "POST",
      url  : '<?php echo base_url();?>OmsetStandartController/editData/',
      data : { id : id , nominal_omset : $("#nominal_omset"+id).val() },
      dataType : "json",
      success:function(data){
        // if (data.status == '200') {
        //   alert("Data telah tersimpan.");
        // } else if (data.status == '204') {
        //   alert("Data telah tersimpan.");
        // }
      }
    });
    setTimeout(function(){ alert("Data telah tersimpan."); }, 1000);
  }
</script>