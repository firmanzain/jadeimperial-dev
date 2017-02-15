<h4>Halaman Input Komisi Karyawan</h4>
<hr>
<div class="row">
	<div class="col-md-12">
		<form action="" method="post">

			<table class="table table-bordered" id="tabel">
            	<tr>
            		<th bgcolor="#F5DEB3" width="5%">NO</th>
            		<th bgcolor="#F5DEB3">NAMA</th>
            		<th bgcolor="#F5DEB3">NIK</th>
            		<th bgcolor="#F5DEB3">OMSET</th>
            		<th bgcolor="#F5DEB3">TGL BAGI KOMISI</th>
            		<th bgcolor="#F5DEB3">PERSENTASE KOMISI</th>
            		<th bgcolor="#F5DEB3">KOMISI</th>
            		<th bgcolor="#F5DEB3">INCLUDE PPH</th>
            	</tr>
	         </table>

			<div class="form-group">
				<button type="button" class="btn btn-default" onclick="addKomisi()">Add</button>
				<button type="submit" class="btn btn-primary" id="cek" disabled>Simpan Data</button>
			</div>

		</form>
	</div>
</div>



<?php
	function ambil_nama(){
	  $nama='';
	  
	  $sql_nama = mysql_query("select * from tab_karyawan");

	  while($data_nama = mysql_fetch_array($sql_nama)){
		  //$nama.='"'.stripslashes($data_nama['nik']).'",';
		  $nama.='"'.stripslashes($data_nama['nama_ktp']).'",';
	  }
	  return(strrev(substr(strrev($nama),1))); // what for ?
	}
?>


<script type="text/javascript">
var br=1;
var baris1=1;
addKomisi();


	function addKomisi() {
		var tbl = document.getElementById('tabel');

		// rows.length is used to find the amount of tr element
		// insertRow(x) is used to add new row at x index position
		var row = tbl.insertRow(tbl.rows.length);
		

		var num = document.createTextNode(br); // baris ke-

		row.id 	= 't1'+baris1;

		var td1	= document.createElement("td");
		var td2	= document.createElement("td");
		var td3	= document.createElement("td");
		var td4	= document.createElement("td");
		var td5	= document.createElement("td");
		var td6	= document.createElement("td");
		var td7	= document.createElement("td");
		var td8	= document.createElement("td");

		// This is a function. Create element input
		td1.appendChild(num);
		td2.appendChild(nama(br));
		td3.appendChild(nik(br));
		td4.appendChild(omset(br)); // id txt_omset
		td5.appendChild(tgl(br));
		td6.appendChild(persentase(br)); // id txt_persentase
		td7.appendChild(hasil_komisi(br)); // id txt_hasil
		td8.appendChild(pph(br));

		row.appendChild(td1);
		row.appendChild(td2);
		row.appendChild(td3);
		row.appendChild(td4);
		row.appendChild(td5);
		row.appendChild(td6);
		row.appendChild(td7);
		row.appendChild(td8);



		baris1=br;

		document.getElementById("txt_nama"+baris1+"").setAttribute('class','form-control');
		document.getElementById("txt_nama"+baris1+"").setAttribute('onchange','cari_nik('+br+')');


		document.getElementById("txt_nik"+baris1+"").setAttribute('class','form-control');
		document.getElementById("txt_nik"+baris1+"").setAttribute('readonly',true);


		document.getElementById("txt_omset["+br+"]").setAttribute('class','form-control');
		document.getElementById("txt_omset["+br+"]").setAttribute('data-mask','#.##0');
		document.getElementById("txt_omset["+br+"]").setAttribute('data-mask-reverse',true);
		document.getElementById("txt_omset["+br+"]").setAttribute('data-mask-maxlength',false);
		document.getElementById('txt_omset['+br+']').setAttribute('onKeyUp','hitung('+br+')');

		document.getElementById("date-picker"+br+"").setAttribute('class','form-control');

		document.getElementById("txt_persentase["+br+"]").setAttribute('class','form-control');
		document.getElementById('txt_persentase['+br+']').setAttribute('onKeyUp','hitung('+br+')');


		document.getElementById("txt_hasil["+br+"]").setAttribute('class','form-control number');
		document.getElementById("txt_hasil["+br+"]").setAttribute('readonly',true);



		document.getElementById("cek_pph["+br+"]").setAttribute('class','form-control');


		$(function() {
		    var DaftarNama = [<?php echo ambil_nama();?> ];
		    $('#txt_nama'+baris1+'').autocomplete({
		      source: DaftarNama
		    });
		  });

		$(function() {
	        $("#date-picker"+br+"").datepicker({
	            orientation: 'bottom left',
	            format: 'yyyy-mm-dd'
	        });
		});

		br++;
	}
	

/**
This sectioon is used to create element input
*/

	function nama(index){
		var nm= document.createElement("input");
		nm.type="text";
		nm.name="txt_nama["+index+"]";
		nm.id='txt_nama'+index+'';
		return nm;
	}
	

	function nik(index){
		var nk= document.createElement("input");
		nk.type="text";
		nk.name="txt_nik["+index+"]";
		nk.id='txt_nik'+index+'';
		return nk;
	}

	function omset(index){
		var oms= document.createElement("input");
		oms.type="text";
		oms.name="txt_omset["+index+"]";
		oms.id="txt_omset["+index+"]";
		oms.value="0";
		return oms;
	}

	function tgl(index){
		var tgl= document.createElement("input");
		tgl.type="text";
		tgl.name="bulan["+index+"]";
		tgl.id="date-picker"+index;
		tgl.value="";
		return tgl;
	}

	function persentase(index){
		var pers= document.createElement("input");
		pers.type="text";
		pers.name="txt_persentase["+index+"]";
		pers.id="txt_persentase["+index+"]";
		pers.value="1";
		return pers;
	}

	function hasil_komisi(index){
		var hsl= document.createElement("input");
		hsl.type="text";
		hsl.name="txt_hasil["+index+"]";
		hsl.id="txt_hasil["+index+"]";
		return hsl;
	}

	function pph(index){
		var hsl= document.createElement("input");
		hsl.type="checkbox";
		hsl.name="cek_pph["+index+"]";
		hsl.id="cek_pph["+index+"]";
		hsl.value="1";
		return hsl;
	}

	function hitung(a){

		var x = document.getElementById('txt_omset['+a+']');
		var y = document.getElementById('txt_persentase['+a+']').value;
		
		z = parseInt(x.value.replace('.','').replace('.','').replace('.',''));

		var hasil = 0;

		hasil = parseInt(((z*y)/100)/1000);

		document.getElementById("txt_hasil["+a+"]").value=hasil*1000;

		$('.number').number( true, 0, ',', '.' ); // class of hasil komisi
		$('#cek').prop('disabled', false); // button simpan
	}



// This is used to assign nik based on the name that has been inputed at nama field
	function cari_nik(a) {
  		if (document.getElementById('txt_nama'+a).value!="") {
	  		$.ajax({
	            type : "POST",
	            url  : '<?php echo base_url();?>TunjanganKaryawan/copy_nama/',
	            //data : "nik="+document.getElementById('nik').value,
	            data : "nama="+document.getElementById('txt_nama'+a).value,
	            dataType : "json",
	            success:function(data){
	            	document.getElementById('txt_nik'+a).value = data.nik;
	            }
	  		});	
  		} else {
  			document.getElementById('txt_nik'+a).value = "";
  		}
	}

</script>