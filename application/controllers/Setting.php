<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller 
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Settings_module');
    }
	public function index()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $data = $this->Settings_module->get_setting_data();
	        $this->load->view('user/setting',['data'=>$data]);
	    }else{
	        $this->load->view('basic/login');
	    }
	}
	public function edit_data()
	{
	    $data[] = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('username'))));
	    $data[] = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('token'))));
	    $data[] = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('senderid'))));
	    
	    $update = $this->Settings_module->update($data);
	    
	    if($update)
	    {
	        echo "<script>alert('Successfully data edited')</script>";
	        $data = $this->Settings_module->get_setting_data();
	        $this->load->view('user/setting',['data'=>$data]);
	    }
	    else
	    {
	        echo "<script>alert('unable to update data....Try again')</script>";
	        $data = $this->Settings_module->get_setting_data();
	        $this->load->view('user/setting',['data'=>$data]);
	    }
	}
	public function sms_template()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $data = $this->Settings_module->get_sms_data();
	        $this->load->view('user/sms_template',['data'=>$data]);
	    }else{
	        $this->load->view('basic/login');
	    }
	}

public function add_sms_templates(){
    $data = array(
        "template_code" => $this->input->post('template_name'),
        "template_string" => $this->input->post('template_string'),
        "parameter_count" => $this->input->post('parameter_count'),
        "is_active" => 1,
        "created_by" => $this->session->userdata['user_id'],
        "created_datetime" => date("Y-m-d")
        );
        $response = $this->Settings_module->save_sms_template_data($data);
        if($response == true){
            $this->session->set_flashdata('sms_message', 'SMS Template Added Successfully');
         redirect('Setting/sms_template');
        }
}
public function sms_status_change(){
    
    $template_id=$this->input->get('template_id');   
    $is_active=$this->input->get('is_active');   
    //echo $is_active;
    //echo $template_id;

     if($is_active == '1'){
		$user_status = '0';
	}
	else{
		$user_status = '1';
	}

	$data = array('is_active' => $user_status );
     
     $response = $this->Settings_module->change_status($data,$template_id);
     
          
       if($response == true){
          // echo"ok";
          
        $this->session->set_flashdata('sms_message', 'SMS Status updated Successfully');
         redirect('Setting/sms_template');
               
       
     }
    
}	
}

?>
