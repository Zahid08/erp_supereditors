<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata['role'] == (1)){
            $this->load->view('user/user');
        }else{
            $this->load->view('basic/login');
        }
    }
    public function add_user()
    {
        if ($this->session->userdata['role'] == (1)){
            $this->load->view('user/add_user');
        }else{
            $this->load->view('basic/login');
        }
    }
    public function edit_user()
    {
        if ($this->session->userdata['role'] == (1)){
            $this->load->view('user/edit_user');
        }else{
            $this->load->view('basic/login');
        }
    }
    public function bulktransfer_user()
    {
        if ($this->session->userdata['role'] == (1)){
            $this->load->view('user/bulktransfer_user');
        }else{
            $this->load->view('basic/login');
        }
    }
    public function bulktransfer_user_data()
    {
        $CurrentAgentdata = array("user_id" => $this->input->post('user_id'),
                        "end_date" => $this->input->post('end_date'),
                        "updated_by" => $this->session->userdata['user_id'],
                        "updated_datetime" => date("Y-m-d H:i:s"));
                        
                        
        $TransferAgentdata = array("user_id" => $this->input->post('transfer_agent_id'),
                        "start_date" => $this->input->post('start_date_transfer'),
                        "end_date" => $this->input->post('end_date_transfer'),
                        "created_by" => $this->session->userdata['user_id'],
                        "created_datetime" => date("Y-m-d H:i:s"));
                        
        $userid = $this->input->post('user_id');                
        $this->load->model('User_model');
        
        $response = $this->User_model->bulktransfer_user_data($CurrentAgentdata,$TransferAgentdata,$userid);
        if ($response == true)
            {
                $this->session->set_flashdata('user_message', 'Date Saved Successfully');
                redirect('User');
            }
            else
            {
                echo "Insert error !";
            }
    }
    
    
    
   public function save_user_data()
    {
        
        $data = array("name" => $this->input->post('name'),
                        "email" => $this->input->post('email'),
                        "mobile" => $this->input->post('mobile'),
                        "password" => md5($this->input->post('password')),
                        "isactive" => 1,
                        "role" => $this->input->post('role'),
                        "created_by" => $this->session->userdata['user_id'],
                        "created_datetime" => date("Y-m-d H:i:s"));
            /*Start
            Created by-nikita auti
            purpose-checking for user is exist
            Date-04/12/2021
            */
            
        $name = $this->input->post('name');
        $password = $this->input->post('password');
        $email = $this->input->post('email');
                  
                  
         $userData = $this
            ->db
            ->query("SELECT * FROM user WHERE email='$email'")
            ->result();
            if(count($userData)>0)
            { 
                $this->session->set_flashdata('user_message', 'User Already Exist.');
               redirect('User/add_user');
            }
            else{
                
                /* End
                Created by-nikita auti
                purpose-checking for user is exist
                Date-04/12/2021
                */
                    
        $this->load->model('User_model');
        $response = $this->User_model->save_user_data($data);
       
        if ($response == true)
            {
                
                /*start 
                Created by-nikita auti
                Purpose-Sending Login Credential In Email
                Date-04/12/2021
                */
                 //Load email library
                $this->load->library('email');
 
                //SMTP & mail configuration
                $config = array(
                    'protocol'  => 'smtp',
                    'smtp_host' => 'smtp.mailgun.org',
                    'smtp_port' => 587,
                    'smtp_user' => 'postmaster@supereditors.in',
                    'smtp_pass' => 'db96c0db1b5d97134e8ef7bf629987ae-156db0f1-549f6847',
                    'mailtype'  => 'html',
                    'charset'   => 'iso-8859-1'
                ); 
          
                       $this
                    ->email
                    ->set_mailtype('html');



                $message = "<html>   
			                    <p>Dear ".$name."</p>
			                    <p>Welcome to SuperEditors.<br>Now you can login to our CRM portal by using following Info</p>
			                    <br>
			                    <p>CRM URL:". base_url() ."</p>
			                    <p>Email:".$email."</p>
			                    <p>Password:".$password."</p>
			               </html>";

                $this
                    ->email
                    ->from('admin@supereditors.in', 'SUPEREDITORS');
                $this
                    ->email
                    ->to($email);
                $this
                    ->email
                    ->cc('info@supereditors.in');
                $this
                    ->email
                    ->bcc('iambommanakavya@gmail.com','keshriedutech@gmail.com');

                $this
                    ->email
                    ->subject('Welcome to Super Editors - Login Credentials');
                $this
                    ->email
                    ->message($message);

                if($this->email->send())
                  /*  echo 'sent';
                    else
                    echo 'fail';
                    echo $this->email->print_debugger();*/
                    // exit;

                    //send mail --end
                    
                 /*end 
                Created by-nikita auti
                Purpose-Sending Login Credential In Email
                Date-04/12/2021
                */
                $this->session->set_flashdata('user_message', 'User data saved Successfully and Login Credentials has been sent.');
               
               
                redirect('User/add_user');
            }
            else
            {
                echo "Insert error !";
            }
            }  
            
    }
  
   public function edit_user_data()
    {
        $data = array("name" => $this->input->post('name'),
                        "email" => $this->input->post('email'),
                        "mobile" => $this->input->post('mobile'),
                        //"password" => md5($this->input->post('password')),
                        "isactive" => $this->input->post('isactive'),
                        "role" => $this->input->post('role'),
                        "updated_by" => $this->session->userdata['user_id'],
                        "updated_datetime" => date("Y-m-d H:i:s"));
        $userid = $this->input->post('user_id');
        $this->load->model('User_model');
        
        $response = $this->User_model->edit_user_data($data,$userid);
        if ($response == true)
            {
                $this->session->set_flashdata('user_message', 'User Data Saved Successfully');
                redirect('User');
            }
            else
            {
                echo "Insert error !";
            }
    }
   
    public function delete_user()
    {
        $user_id=$this->input->get('userid');
        $this->db->where("user_id =", $user_id);
        $this->db->delete("user");
        $delete = $this->db->affected_rows();
        if($delete)
        {
            echo "<script>window.location.replace('".base_url()."User');</script>";
        }
        else
        {
            echo "<script>alert('Failed to Delete user... Try again');window.location.replace('".base_url()."User');</script>";
        }
    }
    public function inactive_user()
    {
        $user_id=$this->input->get('userid');
        $this->db->set('isactive','2');
        $this->db->where("user_id =", $user_id);
        $this->db->update("user");
        $status = $this->db->affected_rows();
        if($status)
        {
            echo "<script>window.location.replace('".base_url()."User');</script>";
        }
        else
        {
            echo "<script>alert('This user is already inactive');window.location.replace('".base_url()."User');</script>";
        }
    }
    public function active_user()
    {
        $user_id=$this->input->get('userid');
        $this->db->set('isactive','1');
        $this->db->where("user_id =", $user_id);
        $this->db->update("user");
        $status = $this->db->affected_rows();
        if($status)
        {
            echo "<script>window.location.replace('".base_url()."User');</script>";
        }
        else
        {
            echo "<script>alert('This user is already active');window.location.replace('".base_url()."User');</script>";
        }       
    }
}
?>
