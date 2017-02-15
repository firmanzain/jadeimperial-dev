<?php
if (!empty($surat->SURAT)) {
?>                                        
    <object data="<?=base_url().'assets/'.$surat->SURAT?>" type="application/pdf" width="100%" height="100%" style="min-height:800px"></object>
<?php
}else{
echo "<div class='alert alert-danger'>Lampiran surat Tidak Ditemukan</div>";
}?>