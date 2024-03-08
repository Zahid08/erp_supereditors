<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
{

    public function index()
    {
      if ($this->session->userdata['role'] == 1){
          $this->load->view('user/supplier_details');
        }else{
            $this->load->view('basic/login');
        }
    }
    public function add_supplier()
    {
      if ($this->session->userdata['role'] == 1){
      $this->load->view('user/supplier');
      }else{
          $this->load->view('basic/login');
      }  
    }
      
    public function save_supplier_data()
    {
      $data=array(
        "supplier_name"=>$this->input->post('supplier_name'),
        "item_type"=>$this->input->post('item_type'),
        "item"=>$this->input->post('item_name'),
        "address" => $this->input->post('address'),
        "gst" => $this->input->post('gst'),
        "pan_no"=>$this->input->post('pan_no'),
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
      $supplier_id =  $this->input->post('supplier_id'); 
      $transname = $this->input->post('supplier_name');
      $companyCount = $this->db->query("SELECT * FROM supplier WHERE is_active = 1 AND  supplier_name = '$transname' ORDER BY supplier_id DESC")->result();
      if(count($companyCount) > 0) {
        $this->session->set_flashdata('supplier_message', 'Supplier Already Exists in the System');
        redirect('Supplier/add_supplier?supplier_id='. $supplier_id . '&#supplier_section');          
      }
      $this->load->model('Supplier_model');  
      $response = $this->Supplier_model->save_supplier_data($data);
      if ($response == true)
        {
          $supplier_id = $this->db->insert_id();
          $this->session->set_flashdata('supplier_message', 'Supplier Data Saved Successfully');
          redirect(base_url().'Supplier/add_supplier?supplier_id='. $supplier_id);
        }
        else
        {
          echo "Insert error !";
        }         
    }
      
      
public function supplier_edit_data(){
    $this->load->view('user/edit_supplier');
}
 
 public function save_edit_supplier_data()
 {
     $data=array(  
      "supplier_id"=>$this->input->post('supplier_id'),
        "supplier_name"=>$this->input->post('name'),
        "address" => $this->input->post('address'),
        "gst" => $this->input->post('gst'),
        "state_id" => $this->input->post('state'),
        "credit_day" => $this->input->post('credit_day'),
        "credit_limit" => $this->input->post('credit_limit'),
        "bank_name" => $this->input->post('bank_name'),
        "branch" => $this->input->post('branch'),
        "account_no" => $this->input->post('acount_no'),
        "ifsc" => $this->input->post('ifsc'),
        "pan_no" => $this->input->post('pan_no'),
        "item_type" => $this->input->post('item_type'),
        "item" => $this->input->post('item_name'),
        "updated_by" => $this->session->userdata['user_id'],
        "updated_date" => date("Y-m-d")
      );
      $supplierid = $this->input->post('supplier_id');
      $this->load->model('Supplier_model');
      $response = $this->Supplier_model->edit_supplier_data($data,$supplierid);
        
     if ($response == true)
            {
              $this->session->set_flashdata('supplier_message', 'Supplier Data Updated Successfully');
              redirect('Supplier');
            }
            else
            {
              echo "Insert error !";
            }   
    }
     public function supplier_delete_data(){
     $supplierid=$this->input->get('supplier_id');   
    //print_r($perchaseid);
     
          $data = [
            'is_active' => '0'
        ];
     $this->load->model('Supplier_model');
     
     $response = $this->Supplier_model->delete_supplier_data($data,$supplierid);
     
          
       if($response == true){
          
        $this->session->set_flashdata('supplier_message', 'Supplier data  Deleted Successfully');
         redirect('Supplier');
               
       }
    }
        
      public function save_contact_data()
      {    
		    $response=false;
			  if (isset($_REQUEST['Contact'])){
          foreach ($_REQUEST['Contact'] as $key=>$requestSingle){
            $data = array(
              "supplier_id" => $this->input->post('supplier_id') ,
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
            $this->load->model('Supplier_model');
            $response = $this->Supplier_model->add_conatct_supplier_data($data);
            $response=true;
          }
        }
        if ($response == true)
            {      
              $supplier_id = $this->input->post('supplier_id');
              $this->session->set_flashdata('contact_message', 'Supplier Contact  Data Saved Successfully');
              redirect('Supplier/add_supplier?supplier_id='. $supplier_id . '&#contact_section');      
            }
            else
            {
              echo "Insert error !";
            }
      }

      public function save_contact_supplier_data()
      {
        $response=false;
        $suppliercontact_id=$this->input->post('supplier_contact_id');
				if (isset($_REQUEST['Contact'])){
        {
          foreach ($_REQUEST['Contact'] as $key=>$requestSingle){
              $data = array(
                "supplier_contact_id" => $this->input->post('supplier_contact_id') ,
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
                $this->load->model('Supplier_model');   
                $response = $this->Supplier_model->edit_contact_save_supplier($data,$suppliercontact_id);
                $response=true;
            }
        }
          if ($response == true)
          {               
            $supplier_id = $this->input->post('supplier_id');
            $this->session->set_flashdata('contact_message', 'Contact Data Updated Successfully');
            redirect('Supplier/add_supplier?supplier_id=' . $supplier_id . '&#contact_section');
          }
          else
          {
              echo "Insert error !";
          }
        }
      }      
 
  public function delete_contact_supplier_data(){
      $suppliercontact_id=$this->input->get('supplier_contact_id');   
   
        $data = [
            'is_active' => '0'
        ]; 
        $supplier_id = $_GET['supplier_id'];
        $this->load->model('Supplier_model');
        $response = $this->Supplier_model->delete_contact_supplier_data($data,$suppliercontact_id);
        if($response == true){  
        $this->session->set_flashdata('contact_message', 'Supplier Contact deleted successfully');
         redirect(base_url().'Supplier/add_supplier/?supplier_id=' . $supplier_id.'&#contact_section');
        }
      
  }
  public function getitemName()
	{
		$item_type_id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_type_id'))));
		$item_name = $this->db->query("SELECT * FROM items WHERE item_type_id='".$item_type_id."'")->result();
		print_r(json_encode($item_name));
		exit();
	} 
 
}
?>