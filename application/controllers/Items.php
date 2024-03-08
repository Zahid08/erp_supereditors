<?php
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
define('ENVIRONMENT', 'production');

class Items extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Items_model');
        $this->load->library('Encryption');
    }
    public function index()
    {
        if($this->session->userdata('user_id'))
        {
        $item_type = $this->Items_model->get_item_typedata();
        
        foreach($item_type as $key => $value)
        {
            $item = $this->Items_model->get_itemdata($value['item_type_id']);
            $item_data[$key]['type'] = $value;
            $item_data[$key]['name'] = $item;
        }
        
        $this->load->view('user/items',['item_data'=>$item_data]);
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function add_item()
    {
        if($this->session->userdata('user_id'))
        {
            $item_type = $this->Items_model->get_type();
            $brand = $this->Items_model->get_brand();
            $this->load->view('user/add_items',['item_type'=>$item_type,'brand'=>$brand]);
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function save_item_data()
    {
        if($this->session->userdata('user_id'))
        {
            
        $item_type = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_type'))));
        if($item_type == '3')
        {
            $brand_name = $this->security->xss_clean($this->input->post('brand'));
        }
        else
        {
            $brand_name = '';
        }
        $hsn_code = $this->security->xss_clean($this->input->post('hsn_code'));
        $igst = $this->security->xss_clean($this->input->post('igst'));
        $cgst = $this->security->xss_clean($this->input->post('cgst'));
        $sgst = $this->security->xss_clean($this->input->post('sgst'));
        $item_name = $this->security->xss_clean($this->input->post('item_name'));
        
        /*$item_type = array(
            'item_type' => $item_type,
            'created_by' => $this->session->userdata('user_id'),
            'created_date' => date('Y-m-d')
            );
            
            $this->load->database();
            $insert = $this->db->insert('item_type',$item_type);
            $item_type_id = $this->db->insert_id();*/
            
           /* if($item_type_id)
            {*/
            for($i = 0;$i<sizeof($item_name);$i++)
            {
                
        $item = array(
            'item_type_id' => $item_type,
            'item_name' => $item_name[$i],
            'brand_name' => $brand_name[$i],
            'hsn_code' => $hsn_code[$i],
            'igst' => $igst[$i],
            'cgst' => $cgst[$i],
            'sgst' => $sgst[$i],
            'total_gst' => $igst[$i],
            'created_by' => $this->session->userdata('user_id'),
            'created_date' => date('Y-m-d')
            );
            
            $insert = $this->db->insert('items',$item);
            $item_id = $this->db->insert_id();
            
            }
            /*}*/
            
            if($item_id)
            {
                
                 $this->session->set_flashdata('item_message', 'Item Data Saved Successfully');
                redirect('Items');
            }
            else
            {
                echo "<script>alert('Failed to add Item... Try again')</script>";
                redirect('Items/add_item');
            }
            
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function edit_item()
    {
        if($this->session->userdata('user_id'))
        {
            
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_edit_id'))));
        $name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_edit_name'))));
         $hsn_code = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_edit_hsn1'))));
          $igst= $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_edit_igst'))));
         $cgst= $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_edit_cgst'))));
         $sgst = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_edit_sgst'))));
        
        $post = array(
            'item_name' => $name,
            'hsn_code' => $hsn_code,
            'igst' => $igst,
            'cgst' => $cgst,
            'sgst' => $sgst,
            );
            
        $update = $this->Items_model->update_item($post,$id);
        
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
    public function delete_item()
    {
        if($this->session->userdata('user_id'))
        {
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_edit_id'))));
        
        	 $data = array(
	     'is_active' => '0',
	     'updated_by' => $this->session->userdata('user_id'),
	     'updated_date' => date('Y-m-d')
	     );
	     
        $delete = $this->Items_model->delete_item($id,$data);
        
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
    public function delete_type()
    {
        if($this->session->userdata('user_id'))
        {
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('type_id'))));
        
         $data = array(
	     'is_active' => '0',
	     'updated_by' => $this->session->userdata('user_id'),
	     'updated_date' => date('Y-m-d')
	     );
	     
        $delete = $this->Items_model->delete_type($id,$data);
        
        if($delete)
        {
            $data1 = array(
	     'is_active' => '0',
	     'updated_by' => $this->session->userdata('user_id'),
	     'updated_date' => date('Y-m-d')
	     );
	     
            $delete_item = $this->Items_model->delete_all_items($id,$data1);
        }
        
        if($delete_item)
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
    public function add_name_item()
    {
        if($this->session->userdata('user_id'))
        {
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_addnameType_id'))));
        $name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_add_name'))));
         $hsn_code = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_hsn_code'))));
         $igst = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_igst'))));
         $cgst = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_cgst'))));
         $sgst = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_sgst'))));
        
        $data = array(
            'item_type_id'  => $id,
            'item_name' => $name,
            'hsn_code' => $hsn_code,
            'igst' => $igst,
            'cgst' => $cgst,
            'sgst' => $sgst,
            'created_by' => $this->session->userdata('user_id'),
            'created_date' => date('Y-m-d')
            );
            
        $this->load->database();
        $insert = $this->db->insert('items',$data);
        $item_id = $this->db->insert_id();
        if($item_id)
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
    public function getitem_name()
    {
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id'))));
        $item_name = $this->Items_model->get_itemname($id);
        echo json_encode($item_name);
    }
}
?>