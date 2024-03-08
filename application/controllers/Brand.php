<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Brand extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
       // $this->load->model('Brand_model');
       
    }
     public function index()
    {
     
              $this->load->model('Brand_model');
               $brand_name = $this->Brand_model->get_brand_typedata();
               if($brand_name <> 0){
               
              foreach($brand_name as $key => $value)
           {
           
            $brand = $this->Brand_model->get_fabricdata($value['brand_id']);
            $brand_data[$key]['brand_name'] = $value;
           $brand_data[$key]['fabric_name'] = $brand;
           
            }
          
         $this->load->view('user/brand',['brand_data'=>$brand_data]);
          } else{
             $this->load->view('user/brand');
          }
          
          
     
        }
        
    public function add_brand()
      {
           
          if ($this->session->userdata['role'] == 1)
          {
             
            $this->load->view('user/add_brand');
          }else{
             $this->load->view('basic/login');
          }
          
      }

public function save_brand_data(){
    //print_r($_POST);
    $brand_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('brand_name'))));
    $fabric = $this->security->xss_clean($this->input->post('fabric_name'));
    
    
        $brand_type = array(
            'brand_name' => $brand_name,
            'created_by' => $this->session->userdata('user_id'),
            'created_date' => date('Y-m-d')
            );
              //print_r($brand_type);
           
            $this->load->database();
            $insert = $this->db->insert('brand',$brand_type);
            $brand_id = $this->db->insert_id();
           
            if($brand_id)
            {
            foreach($fabric as $key => $value)
            {
            $fabric_type = array(
            'brand_id' => $brand_id,
            'fabric_name' => $value,
            'created_by' => $this->session->userdata('user_id'),
            'created_date' => date('Y-m-d')
            );
           
          
            $insert = $this->db->insert('fabric',$fabric_type);
            $fabric_id = $this->db->insert_id();
        
            }
            }
             if($fabric_id)
            {
               
                $this->session->set_flashdata('brand_message', 'Brand Data Saved Successfully');
                redirect('Brand');
            }
            else
            {
                echo "<script>alert('Failed to add Brands... Try again')</script>";
                redirect('Brand/add_brand');
            }
            
            
            }  
            
     
        public function add_brand_save()
        {
            
            if($this->session->userdata('user_id'))
        {
        $brandid = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('brand_addnameType_id'))));
        $fabricname = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('fabric_add_name'))));
       
        
        $data = array(
            'brand_id'  => $brandid,
            'fabric_name' => $fabricname,
            'created_by' => $this->session->userdata('user_id'),
            'created_date' => date('Y-m-d')
            );
        
        $this->load->database();
        $insert = $this->db->insert('fabric',$data);
        $fabric_id = $this->db->insert_id();
        if($fabric_id)
        {
            echo '1';
        }
        else
        {
            echo '2';
        }
        }
        else
        {
            redirect('Login/logout');
        }
        }
  
  public function delete_type()
    {
       
    if($this->session->userdata('user_id'))
        {
     $brand_id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('type_id'))));
        $data = array(
	     'is_active' => '0',
	     'updated_by' => $this->session->userdata('user_id'),
	     'updated_date' => date('Y-m-d')
	     );
	    $this->load->model('Brand_model');
      $delete = $this->Brand_model->delete_brand($brand_id,$data);
        
        
         if($delete)
        {
            $data1 = array(
	     'is_active' => '0',
	     'updated_by' => $this->session->userdata('user_id'),
	     'updated_date' => date('Y-m-d')
	     );
	     $this->load->model('Brand_model');
        $delete_fabric = $this->Brand_model->delete_all_fabric($brand_id,$data1);
        }
    
           
        if($delete_fabric)
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
      
public function edit_brand(){
    
    if($this->session->userdata('user_id'))
        {
            
        $fabricid = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('fabric_edit_id'))));
        $fabricname = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('fabric_edit_name'))));
        
        $post = array(
            'fabric_name' => $fabricname
            );
            $this->load->model('Brand_model');
        $update = $this->Brand_model->update_fabric($post,$fabricid);
        
        if($update)
        {
            echo "1";
        }
        else
        {
            echo "0";
        }
        }
        else
        {
            redirect('Login/logout');
        }

    
}
public function delete_fabric(){
       if($this->session->userdata('user_id'))
        {
        $fabricid = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('fabric_delete_id'))));
        
        	 $data = array(
	     'is_active' => '0',
	     'updated_by' => $this->session->userdata('user_id'),
	     'updated_date' => date('Y-m-d')
	     );
	       $this->load->model('Brand_model');
        $delete = $this->Brand_model->delete_fabric($fabricid,$data);
        
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