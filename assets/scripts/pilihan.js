checked=false;
function checkedAll(form_data){var aa= document.getElementById('form_data'); if (checked == false)
{
checked = true
}
else
{
checked = false
}for (var i =0; i < aa.elements.length; i++){ aa.elements[i].checked = checked;}
}

function cekall_menu(){
	var aa= document.getElementById('cek_1'); 
	if (checked == false)
	{
		checked = true
	}
	else
	{
	checked = false
	}
	for (var i =0; i < aa.elements.length; i++){ aa.elements[i].checked = checked;}
}

function warning() {
	return confirm('Are You Sure to Delete This Data?');
}
