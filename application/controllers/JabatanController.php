 <?php
class JabatanController extends CI_Controller {
	public function __construct()
    {
        parent::__construct();
        $this->load->model('jabatan');
        $this->auth->restrict();
    } 

    function deletejabatan($id_jabatan){
            $this->jabatan->deletejabatan($id_jabatan);
            redirect('JabatanController/index');
    }
	
	function updatejabatan($id_jabatan){
        if($_POST==NULL){
            
            $data['hasil'] = $this->jabatan->filterdata($id_jabatan);
            $data['halaman'] = $this->load->view('jabatan/updatejabatan',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            
            $this->jabatan->updatejabatan();
            redirect('JabatanController/index');
        }
    }
 
    function index(){
        $data['hasil'] = $this->jabatan->bacajabatan();
        $data['halaman']=$this->load->view('jabatan/bacajabatan',$data,true);
		$this->load->view('beranda',$data);
    } 

	function tambahjabatan(){
        if($this->input->post()){
            $this->jabatan->tambah();
            redirect('JabatanController/index');
        }
       $data['halaman']= $this->load->view('jabatan/jabatanview','',true);
	   $this->load->view('beranda',$data);
    }
}
?>