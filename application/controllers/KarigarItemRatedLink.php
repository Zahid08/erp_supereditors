<?php
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
define('ENVIRONMENT', 'production');

class KarigarItemRatedLink extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Karigar_Item_Rated_Link_model');
    }

    public function index()
    {
        if($this->session->userdata('user_id'))
        {
        
            $karigarItemRatedData = $this->Karigar_Item_Rated_Link_model->get_karigar_item_rated_Data($this->session->userdata('user_id'));
            $this->load->view('user/karigar_item_rate_list',['karigarItemRatedData'=>$karigarItemRatedData]);
        }
        else
        {
            redirect('Login/logout');
        }
    }

    public function add_karigar_item_rate_link()
    {
        if($this->session->userdata('user_id'))
        {
            $this->load->view('user/add_karigar_item_rate');
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function save_karigar_item_rated_data()
    {
        if($this->session->userdata('user_id'))
        {

            $karigar_type = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('karigar_type'))));
            $karigar_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('karigar_name'))));
            $item_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_name'))));
            $company_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('company_name'))));
            $customer_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('customer_name'))));
            $rate_with_cutting = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('rate_with_cutting'))));
            $rate_without_cutting = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('rate_without_cutting'))));
            $pressing = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('pressing'))));
            $finishing_kaj_button = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('finishing_kaj_button'))));
            $embroidery_per_piece = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('embroidery_per_piece'))));
            $embroidery_developing = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('embroidery_developing'))));

            $karigarItemRatedData = array(
                'karigar_type' => $karigar_type,
                'karigar_name' => $karigar_name,
                'item_name' => $item_name,
                'company_name' => $company_name,
                'customer_name' => $customer_name,
                'rate_with_cutting' => $rate_with_cutting,
                'rate_without_cutting' => $rate_without_cutting,
                'pressing' => $pressing,
                'finishing_kaj_button' => $finishing_kaj_button,
                'embroidery_per_piece' => $embroidery_per_piece,
                'embroidery_developing' => $embroidery_developing,
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date('Y-m-d')
            );
            
            
            $insert = $this->Karigar_Item_Rated_Link_model->add_karigar_Item_Rate_data($karigarItemRatedData);

            if($insert)
            {
                echo "<script>alert('Karigar-Item Rate Linking Master added successfully');window.location.replace('".base_url()."KarigarItemRatedLink');</script>";
            }
            else
            {
                echo "<script>alert('Failed to add Karigar-Item Rate Linking Master... Try again');window.location.replace('".base_url()."KarigarItemRatedLink/add_karigar_item_rate_link');</script>";
            }
            
        }
        else
        {
            redirect('Login/logout');
        }
    }

    public function edit_karigar_item_rated(){
        if ($this->session->userdata['role'] == 1){
            $this->load->view('user/edit_karigar_item_rate');
        }else{
            $this->load->view('basic/login');
        }
    }


    public function save_edit_karigar_item_rate_data()
    {
        if($this->session->userdata('user_id'))
        {
            $karigar_type = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('karigar_type'))));
            $karigar_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('karigar_name'))));
            $item_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_name'))));
            $company_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('company_name'))));
            $customer_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('customer_name'))));
            $rate_with_cutting = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('rate_with_cutting'))));
            $rate_without_cutting = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('rate_without_cutting'))));
            $pressing = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('pressing'))));
            $finishing_kaj_button = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('finishing_kaj_button'))));
            $embroidery_per_piece = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('embroidery_per_piece'))));
            $embroidery_developing = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('embroidery_developing'))));

            $karigarItemRatedData = array(
                'karigar_type' => $karigar_type,
                'karigar_name' => $karigar_name,
                'item_name' => $item_name,
                'company_name' => $company_name,
                'customer_name' => $customer_name,
                'rate_with_cutting' => $rate_with_cutting,
                'rate_without_cutting' => $rate_without_cutting,
                'pressing' => $pressing,
                'finishing_kaj_button' => $finishing_kaj_button,
                'embroidery_per_piece' => $embroidery_per_piece,
                'embroidery_developing' => $embroidery_developing,
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date('Y-m-d')
            );

            $karigar_id = $this->input->post('karigar_item_rate_id');
            $response = $this->Karigar_Item_Rated_Link_model->update_karigar_item_rated_data($karigar_id,$karigarItemRatedData);
            if ($response == true)
            {

                echo "<script>alert('Karigar-Item Rate Linking Master Update successfully');window.location.replace('".base_url()."KarigarItemRatedLink');</script>";
            }
            else
            {
                echo "<script>alert('Failed to Update Karigar-Item Rate Linking Master... Try again');window.location.replace('".base_url()."KarigarItemRatedLink');</script>";
            }
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function delete_karigar_item_rated()
    {

        if($this->session->userdata('user_id'))
        {
            $karigar_id=$this->input->get('karigar_id');

        	 $data = array(
                 'is_active' => '0',
                 'updated_by' => $this->session->userdata('user_id'),
                 'updated_date' => date('Y-m-d')
	         );
	     
           $delete = $this->Karigar_Item_Rated_Link_model->update_karigar_item_rated_data($karigar_id,$data);
        
        if($delete)
        {
            echo "<script>window.location.replace('".base_url()."KarigarItemRatedLink');</script>";
        }
        else
        {
            echo "<script>alert('Failed to Delete Karigar... Try again');window.location.replace('".base_url()."Workermaster');</script>";
        }
        }
        else
        {
            redirect('Login/logout');
        }
    
    }
    
    
      public function get_karigar_list_by_type(){
        if ($_REQUEST['karigar_type']){
            $karigarType = $this->db->query("SELECT * FROM karigar_master e where karigar_type='".$_REQUEST['karigar_type']."'")->result();
            $result = $karigarType;
            echo json_encode($result);
        }
    }
}
?>