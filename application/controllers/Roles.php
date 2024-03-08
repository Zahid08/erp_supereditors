<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Roles extends CI_Controller
{

    public function index()
    {
        if ($this->session->userdata['role'] == (1)){
            $this->load->view('user/roles');
        }else{
            $this->load->view('basic/login');
        }
    }
    public function add_role()
    {
        if ($this->session->userdata['role'] == (1)){
            $this->load->view('user/add_role');
        }else{
            $this->load->view('basic/login');
        }
    }
    public function edit_role()
    {
        if ($this->session->userdata['role'] == (1)){
            $this->load->view('user/edit_role');
        }else{
            $this->load->view('basic/login');
        }
    }
    public function save_role_data()
    {
        $data = array("role_name" => $this->input->post('role_name'),
                        "dashboard" => $this->input->post('dashboard')? $this->input->post('dashboard') : 0,
                        "add_enquiry" =>$this->input->post('add_enquiry')? $this->input->post('add_enquiry') : 0,
                        "enquiry_list" =>$this->input->post('enquiry_list')? $this->input->post('enquiry_list') : 0,
                        "quotation" =>$this->input->post('quotation')? $this->input->post('quotation') : 0,
                        "appointment" =>$this->input->post('appointment')? $this->input->post('appointment') : 0,
                        "customers" =>$this->input->post('customers')? $this->input->post('customers') : 0,
                        "send_email" =>$this->input->post('send_email')? $this->input->post('send_email') : 0,
                        "check_mail_status" =>$this->input->post('check_mail_status')? $this->input->post('check_mail_status') : 0,
                        "bulk_email_report" =>$this->input->post('bulk_email_report')? $this->input->post('bulk_email_report') : 0,
                        "check_sms_status" =>$this->input->post('check_sms_status')? $this->input->post('check_sms_status') : 0,
                        "bulk_sms_report" =>$this->input->post('bulk_sms_report')? $this->input->post('bulk_sms_report') : 0,
                        "check_sms_status" =>$this->input->post('check_sms_status')? $this->input->post('check_sms_status') : 0,
                        "bulk_sms_report" =>$this->input->post('bulk_sms_report')? $this->input->post('bulk_sms_report') : 0,
                        "send_whatsapp_msg" =>$this->input->post('send_whatsapp_msg')? $this->input->post('send_whatsapp_msg') : 0,
                        "check_whatsapp_status" =>$this->input->post('check_whatsapp_status')? $this->input->post('check_whatsapp_status') : 0,
                        "transport" =>$this->input->post('transport')? $this->input->post('transport') : 0,
                        "measure" =>$this->input->post('measure')? $this->input->post('measure') : 0,
                        "supplier" =>$this->input->post('supplier')? $this->input->post('supplier') : 0,
                        "item" =>$this->input->post('item')? $this->input->post('item') : 0,
                        "brand" =>$this->input->post('brand')? $this->input->post('brand') : 0,
                        "add_client_email" =>$this->input->post('add_client_email')? $this->input->post('add_client_email') : 0,
                        "purchase" =>$this->input->post('add_client_email')? $this->input->post('purchase') : 0,
                        "config" =>$this->input->post('config')? $this->input->post('config') : 0,
                        "users" =>$this->input->post('users')? $this->input->post('users') : 0,
                        "roles" =>$this->input->post('roles')? $this->input->post('roles') : 0,
                        "sms_template" =>$this->input->post('sms_template')? $this->input->post('sms_template') : 0,
                        "created_by" =>$this->session->userdata['user_id']);
                        
        
        $this->load->model('Roles_model');
        $response = $this->Roles_model->save_role_data($data);
        
        if ($response == true)
            {
                $this->session->set_flashdata('role_message', 'Role Data Saved Successfully');
                redirect('Roles');
            }
            else
            {
                echo "Insert error !";
            }
    }
    
    public function edit_role_data()
    {
        $data = array("role_name" => $this->input->post('role_name'),
                        "dashboard" => $this->input->post('dashboard')? $this->input->post('dashboard') : 0,
                        "add_enquiry" =>$this->input->post('add_enquiry')? $this->input->post('add_enquiry') : 0,
                        "enquiry_list" =>$this->input->post('enquiry_list')? $this->input->post('enquiry_list') : 0,
                        "quotation" =>$this->input->post('quotation')? $this->input->post('quotation') : 0,
                        "appointment" =>$this->input->post('appointment')? $this->input->post('appointment') : 0,
                        "customers" =>$this->input->post('customers')? $this->input->post('customers') : 0,
                        "send_email" =>$this->input->post('send_email')? $this->input->post('send_email') : 0,
                        "check_mail_status" =>$this->input->post('check_mail_status')? $this->input->post('check_mail_status') : 0,
                        "bulk_email_report" =>$this->input->post('bulk_email_report')? $this->input->post('bulk_email_report') : 0,
                        "check_sms_status" =>$this->input->post('check_sms_status')? $this->input->post('check_sms_status') : 0,
                        "bulk_sms_report" =>$this->input->post('bulk_sms_report')? $this->input->post('bulk_sms_report') : 0,
                        "check_sms_status" =>$this->input->post('check_sms_status')? $this->input->post('check_sms_status') : 0,
                        "bulk_sms_report" =>$this->input->post('bulk_sms_report')? $this->input->post('bulk_sms_report') : 0,
                        "send_whatsapp_msg" =>$this->input->post('send_whatsapp_msg')? $this->input->post('send_whatsapp_msg') : 0,
                        "check_whatsapp_status" =>$this->input->post('check_whatsapp_status')? $this->input->post('check_whatsapp_status') : 0,
                        "transport" =>$this->input->post('transport')? $this->input->post('transport') : 0,
                        "measure" =>$this->input->post('measure')? $this->input->post('measure') : 0,
                        "supplier" =>$this->input->post('supplier')? $this->input->post('supplier') : 0,
                        "item" =>$this->input->post('item')? $this->input->post('item') : 0,
                        "brand" =>$this->input->post('brand')? $this->input->post('brand') : 0,
                        "add_client_email" =>$this->input->post('add_client_email')? $this->input->post('add_client_email') : 0,
                       "purchase" =>$this->input->post('purchase')? $this->input->post('purchase') : 0,
                        "config" =>$this->input->post('config')? $this->input->post('config') : 0,
                        "users" =>$this->input->post('users')? $this->input->post('users') : 0,
                        "roles" =>$this->input->post('roles')? $this->input->post('roles') : 0,
                        "sms_template" =>$this->input->post('sms_template')? $this->input->post('sms_template') : 0,);
                        
        $roleid = $this->input->post('role_id');
        $this->load->model('Roles_model');
        $response = $this->Roles_model->edit_role_data($data,$roleid);
        if ($response == true)
            {
                $this->session->set_flashdata('role_message', 'Role Data Updated Successfully');
                redirect('Roles');
            }
            else
            {
                echo "Insert error !";
            }
    }
   
}

?>
