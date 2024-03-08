<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    
    

	public function index()
	{
	    if(!empty($_GET['aptid'])){
	        redirect("Enquiry/confirm_appointment?aptid=".$_GET['aptid']);
	    }
		$this->load->view('basic/login');
	}
	public function register()
	{
		$this->load->view('basic/register');
	}
	public function save_register_data()
	{
	    
		    $data = array(
		        "name" => $this->input->post('name'),
		        "email" => $this->input->post('email'),
		        "mobile" => $this->input->post('mobile'),
		        "password" => md5($this->input->post('password')),
		        "dob" => $this->input->post('dob'),
		        "role" => 2,
		        "created_datetime" => date('Y-m-d H:i:s'),
		        "created_by" => 0 //self
		        );
		        
		    $this->load->model('Login_model');
		    
			$response=$this->Login_model->save_register_data($data);
			
			if($response==true){
			        
			        $this->session->set_flashdata('message', 'Data Saved Successfully');
			        redirect('Login');
			}
			else{
					echo "Insert error !";
			}
	}
	public function checklogin()
	{
	        
		    $data = array(
		        "email" => $this->input->post('email'),
		        "password" => md5($this->input->post('password'))
		        );
		   
		    $this->load->model('Login_model');
			$response=$this->Login_model->checklogin($data);
			
			
			if($response==true){
			    $this->session->set_flashdata('message', 'Login Success');
			    redirect('Dashboard');
			}
			elseif($response==false){
			    $this->session->set_flashdata('message', 'Invalid Credentials/Account Blocked');
					redirect('Login');
			}
	}
	
	
	public function logout()
	{
	        
		    $this->session->unset_userdata('name');
		    $this->session->unset_userdata('user_id');
		    $this->session->unset_userdata('email');
		    $this->session->unset_userdata('role');
		    redirect('Login');

	}
	
}

?>
