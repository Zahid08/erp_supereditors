<?php
//error_reporting(1);
defined('BASEPATH') or exit('No direct script access allowed');

class Transport extends CI_Controller
{
    
     public function __construct()
    {
        parent:: __construct();
        $this->load->model('Transport_model');
        //echo "ok";
    }
     
     
public function index()
    {
       
    if ($this->session->userdata['role'] == 1){
            $this->load->view('user/transport_details');
         }else{
              $this->load->view('basic/login');
         }
        
    }
    public function add_transport()
      {
          //echo "ok";
          
          if ($this->session->userdata['role'] == 1){
            $this->load->view('user/transport');
          }else{
             $this->load->view('basic/login');
          }
      }
      
      
    public function save_trasport_data()
    {
       // print_r($_POST);
                 $data = array(//"transport_id" => $this->input->post('transport_id'), 
                           "transport_name" => $this->input->post('transport_name'),
                           "address" => $this->input->post('address'),
                           "gst" => $this->input->post('gst'),
                           "pan_no" => $this->input->post('pan_no'),
                           "state_id" => $this->input->post('state'),
                           "credit_day" => $this->input->post('credit_day'),
                           "credit_limit" => $this->input->post('credit_limit'),
                           "bank_name" => $this->input->post('bank_name'),
                           "branch" => $this->input->post('branch'),
                           "account_no" => $this->input->post('acount_no'),
                           "ifsc" => $this->input->post('ifsc'),
                           "is_active" => 1,
                           "created_by" => $this->session->userdata['user_id'],
                           "created_date" => date("Y-m-d")
                           );
            $transport_id =  $this->input->post('transport_id'); 
            $transname = $this->input->post('transport_name');
            $companyCount = $this->db->query("SELECT * FROM transport WHERE is_active = 1 AND  transport_name = '$transname' ORDER BY transport_id DESC")->result();
            if(count($companyCount) > 0) {
                
                $this
                    ->session
                    ->set_flashdata('tranport_message', 'Transport Already Exists in the System');
                redirect('Transport/add_transport?transport_id='. $transport_id . '&#transport_section');
            }
                 
       
        //$this->load->model('Transport_model');
        
        $response = $this->Transport_model->save_transport_data($data);
        if ($response == true)
            { 
                 $tranport_id = $this->db->insert_id();
                 $this->session->set_flashdata('tranport_message', 'Transport Data Saved Successfully');
                 redirect(base_url().'Transport/add_transport?transport_id='. $tranport_id);
        
            }
            else
            {
                echo "Insert error !";
            }
      }
      
       public function transport_edit_data(){
           
           $this->load->view('user/edit_trasport');
       }
      
      
     public function save_transport_edit_data(){
        //print_r($_POST);
          $data = array( 
                          "transport_name" => $this->input->post('name'),
                           "address" => $this->input->post('address'),
                           "gst" => $this->input->post('gst'),
                           "pan_no" => $this->input->post('pan_no'),
                           "state_id" => $this->input->post('state'),
                           "credit_day" => $this->input->post('credit_day'),
                           "credit_limit" => $this->input->post('credit_limit'),
                           "bank_name" => $this->input->post('bank_name'),
                           "branch" => $this->input->post('branch'),
                           "account_no" => $this->input->post('acount_no'),
                           "ifsc" => $this->input->post('ifsc'),
                           "updated_by" => $this->session->userdata['user_id'],
                           "updated_date" => date("Y-m-d")
                           );
                           
      $transport_id = $this->input->post('transport_id');
   // echo $transport_id;
    
        
      $response = $this->Transport_model->edit_save_transport_data($data,$transport_id);
             if ($response == true)
            { 
                 
                 $this->session->set_flashdata('tranport_message', 'Transport  Data Updated Successfully');
                redirect('Transport');
            }
            else
            {
                echo "Insert error !";
            }

       
    }
     
     
     
    public function transport_delete_data(){
         
    $transport_id=$this->input->get('transport_id');  

   
               $data = [
            'is_active' => '0'
        ];
    
      $response = $this->Transport_model->delete_transport_data($data,$transport_id);
         
       if($response == true){  
        $this->session->set_flashdata('tranport_message', 'Transport data  Deleted Successfully');
         redirect('Transport');
       
               }
     }
    
     public function save_contact_transport_data()
     {    
        $response=false;
        if (isset($_REQUEST['Contact'])){
            foreach ($_REQUEST['Contact'] as $key=>$requestSingle){
            $data = array(
                "transport_id" => $this->input->post('transport_id') ,
                "contact_name" => $this->input->post('name'),
                "designation" => $this->input->post('designation'),
                "dob" => $this->input->post('dob'),
                "marrige_anniversary" => $this->input->post('marriage_anniversary_date'),
                "phone" =>$requestSingle['mobile_no'],
                "land_line" =>$requestSingle['landline'],
                "email" =>$requestSingle['email'],
                "created_date" => date('Y-m-d') ,
                "created_by" => $this->session->userdata['user_id']
            );
            $this->load->model('Transport_model');
            $response = $this->Transport_model->add_conatct_transport_data($data);
            $response=true;
            }
        }
       if ($response == true)
        {      
            $tranport_id = $this->input->post('transport_id');
            $this->session->set_flashdata('contact_message', 'contact  Data Saved Successfully');
            redirect('Transport/add_transport?transport_id='. $tranport_id . '&#contact_section');     
        }
        else
        {
            echo "Insert error !";
        }
     } 
      
     public function save_edit_contact_trasport_data()
     {
       $response=false;
       $transport_contact_id = $this->input->post('transport_contact_id');  
               if (isset($_REQUEST['Contact'])){
       {
         foreach ($_REQUEST['Contact'] as $key=>$requestSingle){
             $data = array(
                 "transport_contact_id" => $this->input->post('transport_contact_id') ,
                 "contact_name" => $this->input->post('name'),
                 "designation" => $this->input->post('designation'),
                 "phone" => $requestSingle['mobile_no'] ,
                 "land_line" =>$requestSingle['landline'],
                 "email" => $requestSingle['email'] ,
                 "dob" => $this->input->post('dob'),
                 "marrige_anniversary" => $this->input->post('marriage_anniversary_date'),
                 "updated_by" =>  $this->session->userdata['user_id'],
                 "updated_date" => date("Y-m-d")
               );
               $this->load->model('Transport_model');   
               $response = $this->Transport_model->edit_contact_save_transportdata($data,$transport_contact_id);
               $response=true;
           }
       }
         if ($response == true)
         {               
           $transport_id = $this->input->post('transport_id');
           $this->session->set_flashdata('contact_message', 'Contact Data Updated Successfully');
           redirect('Transport/add_transport?transport_id=' . $transport_id . '&#contact_section');
         }
         else
         {
             echo "Insert error !";
         }
       }
     }
      
     
      public function delete_contact_transport_data(){
          //echo"ok";
       $data = [
            'is_active' => '0'
        ];
         $transport_id=$this->input->get('transport_id');
         $transportcontact_id=$this->input->get('transport_contact_id');

       $this->load->model('Transport_model');
       
       $response = $this->Transport_model->delete_contact_transport_data($data,$transportcontact_id);
        
       if($response == true){ 
            
        $this->session->set_flashdata('contact_message', 'Transport contact deleted successfully');
          
           redirect(base_url().'Transport/add_transport/?transport_id=' . $transport_id.'&#contact_section');
         
               
       }
     }
}
?>