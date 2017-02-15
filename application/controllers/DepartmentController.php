 <?php
class DepartmentController extends CI_Controller {
	
    public function __construct(){
        parent::__construct();
        $this->auth->restrict();
        $this->load->model('department');

    }

 
    function index(){
        $this->load->model('department');
        $data['hasil'] = $this->department->bacadepartment();
        $data['halaman']=$this->load->view('department/bacadepartment',$data,true);
		$this->load->view('beranda',$data);
    } 

	function tambahdepartment(){
 
        if($this->input->post()){
            $this->department->tambah();
            redirect('DepartmentController/index');
        }
        $data['halaman']=$this->load->view('department/departmentview','',true);
		$this->load->view('beranda',$data);
    }


    function updatedepartment($id_department){
        if($_POST==NULL){
            $data['hasil'] = $this->department->filterdata($id_department);
            $data['halaman'] = $this->load->view('department/updatedepartment',$data,true);
            $this->load->view('beranda',$data);
        }
        else{
            $this->department->updatedepartment();
            redirect('DepartmentController/index');
        }
    }


}
?>