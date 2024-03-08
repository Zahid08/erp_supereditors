<?php
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
define('ENVIRONMENT', 'production');

class Email extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Email_modal');
        $this->load->library('Encryption');
    }
    public function index()
    {
        if($this->session->userdata('user_id'))
        {
        
            $email_data = $this->Email_modal->get_email_data($this->session->userdata('user_id'));
            $this->load->view('user/email',['email_data'=>$email_data]);
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function add_email()
    {
        if($this->session->userdata('user_id'))
        {
            $this->load->view('user/add_email');
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function save_email_data()
    {
        if($this->session->userdata('user_id'))
        {
            
            $email_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('email_name'))));
            $email_address = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('email_address'))));
        
            $email_data = array(
                'email' => $email_address,
                'email_name' => $email_name,
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date('Y-m-d')
            );
            
            
            $insert = $this->Email_modal->add_email($email_data,$email_address);
            
            
            
            if($insert)
            {
                echo "<script>alert('Email added successfully');window.location.replace('".base_url()."Email');</script>";
            }
            else
            {
                echo "<script>alert('Failed to add Email... Try again');window.location.replace('".base_url()."Email/add_email');</script>";
            }
            
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function edit_email()
    {
        if($this->session->userdata('user_id'))
        {
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id'))));
        $name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('name'))));
        $email = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('email'))));
        
        $data = array(
            'email_name' =>  $name,
            'email' => $email,
            'updated_by' => $this->session->userdata('user_id'),
            'updated_date' => date('Y-m-d')
            );
            
        $update = $this->Email_modal->update_email($id,$data);
        
        if($update)
        {
            echo '1';
        }
        else
        {
            echo '0';        
        }
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function delete_email()
    {

        if($this->session->userdata('user_id'))
        {
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id'))));
        
        	 $data = array(
	     'is_active' => '0',
	     'updated_by' => $this->session->userdata('user_id'),
	     'updated_date' => date('Y-m-d')
	     );
	     
        $delete = $this->Email_modal->update_email($id,$data);
        
        if($delete)
        {
            echo "1";
        }
        else
        {
            echo '0';
        }
        }
        else
        {
            redirect('Login/logout');
        }
    
    }
}
?>