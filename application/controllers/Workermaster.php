<?php
ob_start();
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
define('ENVIRONMENT', 'production');

class Workermaster extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Karigar_model');
    }
    public function index()
    {
        if($this->session->userdata('user_id'))
        {
        
            $karigarData = $this->Karigar_model->get_karigar_Data($this->session->userdata('user_id'));
            $this->load->view('user/workermaster',['karigarData'=>$karigarData]);
        }
        else
        {
            redirect('Login/logout');
        }
    }

    public function add_karigar()
    {
        if($this->session->userdata('user_id'))
        {
            $this->load->view('user/add_karigar');
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function save_karigar_data()
    {
        if($this->session->userdata('user_id'))
        {

            $karigar_type = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('karigar_type'))));
            $name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('name'))));
            $contact_no = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('contact_no'))));
            $id_proof = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id_proof'))));
            $gst_no = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('gst_no'))));
            $state = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('state'))));
            $address = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('address'))));
            $remark = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('remark'))));


            $_FILES['file']['name']       = time().$_FILES['image']['name'];
            $_FILES['file']['type']       = $_FILES['image']['type'];
            $_FILES['file']['tmp_name']   = $_FILES['image']['tmp_name'];
            $_FILES['file']['error']      = $_FILES['image']['error'];
            $_FILES['file']['size']       = $_FILES['image']['size'];


            //upload to a Folder
            $config['upload_path'] = 'assets/karigar_image';
            $config['allowed_types'] = 'jpg|png|pdf|jpeg';

            // Load and initialize upload library
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $fileName = $_FILES['image']['name'];

            // Upload file to server
            if(!$this->upload->do_upload('file')){
                $error = array(
                    'error' => $this->upload->display_errors()
                );
                print_r($error);
                exit;
            }else{
                // Uploaded file data
                $imageData = $this->upload->data();
                $fileName = $imageData['file_name'];
            }

            $karigarData = array(
                'karigar_type' => $karigar_type,
                'image' => $fileName,
                'name' =>$name,
                'contact_no' => $contact_no,
                'id_proof' => $id_proof,
                'gst_no' => $gst_no,
                'state'=>$state,
                'address' => $address,
                'remark' => $remark,
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date('Y-m-d')
            );
            
            
            $insert = $this->Karigar_model->add_karigar_data($karigarData);
            
            
            
            if($insert)
            {
                echo "<script>alert('Karigar added successfully');window.location.replace('".base_url()."Workermaster');</script>";
            }
            else
            {
                echo "<script>alert('Failed to add Karigar... Try again');window.location.replace('".base_url()."Workermaster/add_karigar');</script>";
            }
            
        }
        else
        {
            redirect('Login/logout');
        }
    }

    public function edit_karigar(){
        if ($this->session->userdata['role'] == 1){
            $this->load->view('user/edit_karigar');
        }else{
            $this->load->view('basic/login');
        }
    }


    public function save_edit_karigar_data()
    {
        if($this->session->userdata('user_id'))
        {
            $karigar_type = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('karigar_type'))));
            $name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('name'))));
            $contact_no = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('contact_no'))));
            $id_proof = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id_proof'))));
            $gst_no = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('gst_no'))));
            $address = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('address'))));
            $remark = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('remark'))));

            if ($_FILES['image']['name']) {
                $_FILES['file']['name'] = time() . $_FILES['image']['name'];
                $_FILES['file']['type'] = $_FILES['image']['type'];
                $_FILES['file']['tmp_name'] = $_FILES['image']['tmp_name'];
                $_FILES['file']['error'] = $_FILES['image']['error'];
                $_FILES['file']['size'] = $_FILES['image']['size'];


                //upload to a Folder
                $config['upload_path'] = 'assets/karigar_image';
                $config['allowed_types'] = 'jpg|png|pdf|jpeg';

                // Load and initialize upload library
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                $fileName = $_FILES['image']['name'];

                // Upload file to server
                if (!$this->upload->do_upload('file')) {
                    $error = array(
                        'error' => $this->upload->display_errors()
                    );
                    print_r($error);
                    exit;
                } else {
                    // Uploaded file data
                    $imageData = $this->upload->data();
                    $fileName = $imageData['file_name'];
                }
            }else{
                $fileName= $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('previousFileName'))));
            }

            $karigarData = array(
                'karigar_type' => $karigar_type,
                'image' => $fileName,
                'name' => $name,
                'contact_no' => $contact_no,
                'id_proof' => $id_proof,
                'gst_no' => $gst_no,
                'address' => $address,
                'remark' => $remark,
                'created_by' => $this->session->userdata('user_id'),
                'created_date' => date('Y-m-d')
            );

            $karigar_id = $this->input->post('karigar_id');
            $response = $this->Karigar_model->update_karigar_data($karigar_id,$karigarData);
            if ($response == true)
            {

                echo "<script>alert('Karigar Update successfully');window.location.replace('".base_url()."Workermaster');</script>";
            }
            else
            {
                echo "<script>alert('Failed to Update Karigar... Try again');window.location.replace('".base_url()."Workermaster');</script>";
            }
        }
        else
        {
            redirect('Login/logout');
        }
    }
    public function delete_karigar()
    {

        if($this->session->userdata('user_id'))
        {
            $karigar_id=$this->input->get('karigar_id');

        	 $data = array(
                 'is_active' => '0',
                 'updated_by' => $this->session->userdata('user_id'),
                 'updated_date' => date('Y-m-d')
	         );
	     
           $delete = $this->Karigar_model->update_karigar_data($karigar_id,$data);
        
        if($delete)
        {
            echo "<script>window.location.replace('".base_url()."Workermaster');</script>";
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
}
?>