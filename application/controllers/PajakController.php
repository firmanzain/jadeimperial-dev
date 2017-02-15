 <?php
class PajakController extends CI_Controller {


	function deletepajak($id_pajak){
 
            $this->load->model('pajak');
            $this->pajak->deletepajak($id_pajak);
            redirect('PajakController/index');
        
    }
	
	function updatePajak($id_pajak){
        if($_POST==NULL){
            $this->load->model('pajak');
            $data['hasil'] = $this->pajak->filterdata($id_pajak);
            $data['halaman'] = $this->load->view('pajak/updatepajak',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            $this->load->model('pajak');
            $this->pajak->updatePajak();
            redirect('PajakController/index');
        }
    }
 
    function index(){
        $this->load->model('pajak');
        $data['hasil'] = $this->pajak->bacapajak();
        $data['halaman']=$this->load->view('pajak/bacapajak',$data,true);
		$this->load->view('beranda',$data);
    } 

	function tambahpajak(){
 
        if($this->input->post()){
            $this->load->model('pajak');
            $this->pajak->tambah();
            redirect('PajakController/index');
        }
       $data['halaman']= $this->load->view('pajak/pajakview','',true);
	   $this->load->view('beranda',$data);
    }
}
?>