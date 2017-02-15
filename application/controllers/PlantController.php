 <?php
class PlantController extends CI_Controller {
	
    public function __construct(){
        parent::__construct();
        $this->auth->restrict();
        $this->load->model('plant');
    }

    function index(){
        $data['hasil'] = $this->plant->bacaplant();
        $data['halaman']=$this->load->view('plant/bacaCabang',$data,true);
        $this->load->view('beranda',$data);
    } 

	function updateplant($id_plant){
        if($_POST==NULL){
            $data['hasil'] = $this->plant->filterdata($id_plant);
            $data['halaman'] = $this->load->view('plant/updateCabang',$data,true);
			$this->load->view('beranda',$data);
        }
        else{
            $this->plant->updateplant();
            redirect('plant','refresh');
        }
    }
 

	function tambahplant(){
 
        if($this->input->post()){
           $this->form_validation->set_rules('plant', 'plant', 'required');
            if ($this->form_validation->run() == FALSE)
            {
                $data['halaman']= $this->load->view('plant/cabangView','',true);
                $this->load->view('beranda',$data);
            }
            else
            {
                $this->plant->tambah();
                redirect('PlantController/index');
            }
        }
       $data['halaman']= $this->load->view('plant/cabangView','',true);
	   $this->load->view('beranda',$data);
    }
}
?>