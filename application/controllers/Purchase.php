<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Purchase extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Purchase_model');
        $this->load->library('Encryption');
    }
    public function index()
    {
        if ($this->session->userdata['role'] == 1){
            $this->load->view('user/purchase');
         }else{
              $this->load->view('basic/login');
         }
    }
    public function transportlisting()
    {
        if ($this->session->userdata['role'] == 1){
            $this->load->view('user/transportlisting');
         }else{
              $this->load->view('basic/login');
         }
    }
    public function add_purchase()
    {
        if ($this->session->userdata['role'] == 1){
            
            $this->load->view('user/add_purchase');
         }else{
              $this->load->view('basic/login');
         }
       
    }
    public function view_purchase()
    {
        if ($this->session->userdata['role'] == 1){
            
            $this->load->view('user/view_purchase',['inward_no'=>'']);
         }else{
              $this->load->view('basic/login');
         }
    }
    public function add_transport()
    {
        if ($this->session->userdata['role'] == 1){
            
            $this->load->view('user/add_transport',['inward_no'=>'']);
         }else{
              $this->load->view('basic/login');
         }
    }
    public function edit_transport()
    {
        if ($this->session->userdata['role'] == 1){
            
            $this->load->view('user/edit_transport',['inward_no'=>'']);
         }else{
              $this->load->view('basic/login');
         }
       
    }
    public function save_purchase_supplier_data()
    {
        $companyname = $this->input->post('company_name');
        if($companyname == 'SuperEditors'){
            $max = $this->Purchase_model->get_super_maxid();
            $maxid = count($max)+1;
            $inward_no = 'SE'.date('Y').'/'.sprintf("%05d", $maxid);
        }else if ($companyname == 'MannaMenswear'){
           $max = $this->Purchase_model->get_manna_maxid();
            $maxid = count($max)+1;
            $inward_no = 'MN'.date('Y').'/'.sprintf("%05d", $maxid); 
        }
         $data1 = array( 
                "inward_no" => $inward_no,
                "supplier_id" => $this->input->post('supplier_name'),
                "company_name" => $this->input->post('company_name'),
                "showroom_name" => $this->input->post('showroom_name'),
                "challan_no" => $this->input->post('challan_number'),
                "inward_date" => $this->input->post('inword_date'),
                "is_active" => 1,
                "created_by" => $this->session->userdata['user_id'],
                "created_date" => date("Y-m-d")
                );
                 
            $this->load->model('Purchase_model');
            $purchase_supplier_id =  $this->input->post('purchase_supplier_id'); 
            $response1 = $this->Purchase_model->save_perchase_supplier_data1($data1);
            $item_type_id = $this->db->insert_id();
        if ($response1 == true)
            {
              //echo"ok";
               $purchase_supplier_id = $this->db->insert_id();
                 $this->session->set_flashdata('purchase_message', 'Purcahse Data Saved Successfully with Inward#: '.$inward_no);
                redirect('Purchase/add_purchase?purchase_supplier_id='. $purchase_supplier_id);
            }
            else
            {
                echo "Insert error !";
            }
    }
    public function save_purchase_item_data()
    {
        $formData = $this->input->post();
        $data = array(
            "inward_date"=>$this->input->post('inword_date'),
            "challan_no"=>$this->input->post('challan_number'),
            "company_name"=>$this->input->post('company_name'),
            "transport_name"=>$this->input->post('transport_name'),
            "supplier_id"=>$this->input->post('supplier_name'),
            "lr_no"=>$this->input->post('lr_no'),
            "lr_amount"=>$this->input->post('lr_amt'),
            "transport"=>$this->input->post('transport'),
            "lr_quantity"=>$this->input->post('lr_qty'),
            "lr_date"=>$this->input->post('lr_date'),
            "shaowroom_name"=>$this->input->post('showroom_name'),
            "addition_amount"=>$this->input->post('anyadd'),
            "gst_tpt"=>$this->input->post('gst'),
            "any_deduction"=>$this->input->post('disamt'),
            "igst_tpt"=>$this->input->post('igst_tpt'),
            "cgst_tpt"=>$this->input->post('cgst_tpt'),
            "sgst_tpt"=>$this->input->post('sgst_tpt'),
            "recieved_by"=>$this->input->post('receivedby'),
            "item_type_id" =>$this->input->post('item_type'),
            "item_id" => $this->input->post('item_name'),
            "measure_id" => $this->input->post('size'),
            "size" => $this->input->post('measurement'),
            "color" =>$this->input->post('color'),
            "no_of_packs" => $this->input->post('no_packs'),
            "stock_qty" =>$this->input->post('Stock_qty'),
            "billing_qty" =>$this->input->post('billing_qty'),
            "qty_per_pack" => $this->input->post('Qty_per_pack'),
            "rate" =>$this->input->post('rate'),
            "mrp" => $this->input->post('mrp'),
            "amount" =>$this->input->post('amount'),
            "tax_per" =>$this->input->post('tax'),
            "totalbillqty"=>$this->input->post('totbillqty'),
            "totalstkqty"=>$this->input->post('totstkqty'),
            "tax_type" => $this->input->post('tax_type'),
            "is_active" => 1,
            "created_by" => $this->session->userdata['user_id'],
            "created_date" => date("Y-m-d")
            );
        $this->load->model('Purchase_model');
        $response = $this->Purchase_model->save_purchase_item_data($data);
        if ($response)
        {
           $sql="SELECT p.*,i.item_name as item_name,m.measure_name as measure_name FROM purchase_item_entry p LEFT JOIN items i on i.item_id = p.item_id LEFT JOIN measure m on m.measure_id  = p.measure_id WHERE purchase_item_entry_id = $response";
           $getItemData = $this->db->query($sql)->result();
           if ($getItemData){
               print_r(json_encode($getItemData));
               exit(); 
            } 
        }   
    }
    public function total_item_data()
    {
        $id = $_GET['id'];
        $sql = "SELECT * FROM purchase_item_entry WHERE purchase_item_entry_id = $id";
        $result = $this->db->query($sql)->row();
        if ($result) {
            print_r(json_encode($result));
            exit(); 
        } else {
            echo json_encode(array());
        }
    }
public function save_purchase_item_entry_data()
{
    $data = $this->input->post();

    if (isset($data['tableData']) && is_array($data['tableData'])) 
    {
        $this->db->flush_cache();
        $itemsDataArray = array();
        $lastNumber = $this->db
            ->select('inward_no')
            ->where('company_name', $data['formData']['company_name'])
            ->order_by('inward_no', 'DESC')
            ->limit(1)
            ->get('purchase_item_entry')
            ->row();

        $lastCount = 1;
        if ($lastNumber) {
            preg_match('/(\d+)$/', $lastNumber->inward_no, $matches);
            $lastCount = $matches ? intval($matches[0]) + 1 : 1;
        }

        $countStr = str_pad($lastCount, 2, '0', STR_PAD_LEFT);
        $companyName = $data['formData']['company_name'];
        $prefix = ($companyName === 'SuperEditors') ? 'SE' : (($companyName === 'MannaMenswear') ? 'MW' : '');
        $purchase_inward_no = $prefix . '-' . $countStr;

        foreach ($data['tableData'] as $rowIndex => $rowData) 
        {
            $itemId = isset($rowData[0]['id']) ? $rowData[0]['id'] : null;
            $itemsDataArray[] = $itemId;
            $this->db->set("inward_no", $purchase_inward_no);
            $this->db->where("purchase_item_entry_id", $itemId);
            $this->db->update("purchase_item_entry");
            $affected_rows = $this->db->affected_rows();
        }
        
        $id = implode(",", $itemsDataArray);

        $itemData = array(
            'purchase_item_entry_id' => $id,
            'gst' => $data['formData']['gst'],
            'igst_tpt' => $data['formData']['igst_tpt'],
            'cgst_tpt' => $data['formData']['cgst_tpt'],
            'sgst_tpt' => $data['formData']['sgst_tpt'],
            'company_name' => $data['formData']['company_name'],
            'totstkqty' => $data['formData']['totstkqty'],
            'totbillqty' => $data['formData']['totbillqty'],
            'totamount' => $data['formData']['totamount'],
            'total_tax' => $data['formData']['tax_per'],
            'total_igst' => $data['formData']['total_igst'],
            'total_cgst' => $data['formData']['total_cgst'],
            'total_sgst' => $data['formData']['total_sgst'],
            'total_transport' => $data['formData']['total_transport'],
            'anyadd' => $data['formData']['anyadd'],
            'discount' => $data['formData']['disamt'],
            'receivedby' => $data['formData']['receivedby'],
            'netamt' => $data['formData']['netamt'],
            'discountamount'=>$data['formData']['discountamount'],
            'created_by' => $this->session->userdata['user_id'],
            'purchase_supplier_id'=>$data['formData']['supplier_name'],
            'created_date' => date("Y-m-d")
        );

        $this->db->insert('purchase_item', $itemData);
        $insert_id = $this->db->insert_id();

        $this->db->flush_cache(); 
        $lastInwardNumber = $this->db
            ->select('inward_no')
            ->where('p.company_name',$data['formData']['company_name'])
            ->join('purchase_item as p','p.purchase_item_id = t.purchase_item_id','left')
            ->order_by('t.purchase_transport_id', 'DESC')
            ->limit(1)
            ->get('purchase_transport as t')
            ->row();
    
        $lastInwardCount = 1;
        if ($lastInwardNumber) {
            preg_match('/(\d+)$/', $lastInwardNumber->inward_no, $matches);
            $lastInwardCount = $matches ? intval($matches[0]) + 1 : 1;
        }
        $countStr = str_pad($lastInwardCount, 2, '0', STR_PAD_LEFT);
        $companyName = $data['formData']['company_name'];
        $prefix = ($companyName === 'SuperEditors') ? 'TSE' : (($companyName === 'MannaMenswear') ? 'TMW' : '');
        $transport_inward_no = $prefix . '-' . $countStr;

        $transportData = array(
            'purchase_item_id' => $insert_id,
            'lr_no' => $data['formData']['lr_no'],
            'transport_id' => $data['formData']['transport_name'],
            'transport_date' => $data['formData']['lr_date'],
            'lr_qty' => $data['formData']['lr_qty'],
            'lr_amount' => $data['formData']['lr_amt'],
            'inward_no' => $transport_inward_no,
            'supplier_id'=>$data['formData']['supplier_name'],
            'lrper_amout' => $data['formData']['total_transport'],
            'created_by' => $this->session->userdata['user_id'],
            "is_active"=>1,
            'created_date' => date("Y-m-d")
        );
        $this->db->insert('purchase_transport', $transportData);
        $transport_id = $this->db->insert_id();

        if (!empty($insert_id) && !empty($transport_id) && !empty($affected_rows)) {
            echo json_encode(array(
                'success' => true,
                'purchase_inward_no' => $purchase_inward_no,
                'transport_inward_no' => $transport_inward_no
            ));
        } else {
            $db_error = $this->db->error();
            error_log('Database error: ' . $db_error['message']);
            echo json_encode(array('success' => false));
        }
    } else {
        echo json_encode(array('success' => false));
    }
}

public function delete_purchase_item_data($purchaseItemId)
{
    $this->load->model('Purchase_model');
    $result = $this->Purchase_model->delete_purchase_item_data($purchaseItemId);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error deleting records']);
    }
}
public function delete_selected_purchase_items() {
    $csrfToken = $this->input->post('csrf_token');
    $purchaseItemId = $this->input->post('purchase_item_id');
    if (!empty($purchaseItemId)) {
        $this->Purchase_model->delete_selected_purchase_items($purchaseItemId);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No items selected for deletion']);
    }
}

public function save_purchase_transport_data()
{
    $id = $this->input->post('purchase_transport_id');
    $data2 = array(
        "purchase_item_id" => $this->input->post('purchase_item_id'),
        "transport_id" => $this->input->post('transport_Name'),
        "transport_date" => $this->input->post('lr_date'),
        "lr_no" => $this->input->post('lr_no'),
        "lrper_amout" => $this->input->post('lrper_amout'),
        "lr_qty" => $this->input->post('lrqty_amout'),
        "lr_amount" => $this->input->post('lr_amout'),
        "pick_up_location" => $this->input->post('pick_up_location'),
        "gst_tpt" => $this->input->post('gst_tpt'),
        "igst_tpt" => $this->input->post('igst_tpt'),
        "cgst_tpt" => $this->input->post('cgst_tpt'),
        "sgst_tpt" => $this->input->post('sgst_tpt'),
        "total_tpt_tax" => $this->input->post('total_tpt_tax'),
        "Received_by" => $this->input->post('Received_by'),
        "net_amount" => $this->input->post('net_amount'),
        "is_active" => 1,
        "created_by" => $this->session->userdata['user_id'],
        "created_date" => date("Y-m-d")
        );    
        $purchase_item_id =  $this->input->post('purchase_item_id'); 
        $this->load->model('Purchase_model');
        if(!empty($id) || $id !=0)
        {
            $response2 = $this->Purchase_model->update_purchase_transport_data($data2,$id);
        }else{
            $response2 = $this->Purchase_model->save_purchase_transport_data($data2);
        }
        if ($response2 == true)
        {
            $purchase_item_id = $this->input->post('purchase_item_id');
            $this->session->set_flashdata('purchase_message2', 'Purcahse Data Saved Successfully');
            redirect('Purchase/transportlisting');
        }
        else
        {
            echo "Insert error !";
        }
            
}
public function checkLrnoAndChallanno() {
    $lr_no = $this->input->post('lr_no');
    $supplier_id = $this->input->post('supplier_id');
    $challan_number = $this->input->post('challan_number');
    if ($lr_no) {
        $this->db->where('lr_no', $lr_no);
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get('purchase_item_entry');
        $lr_rows = $query->num_rows() > 0;
        if($lr_rows)
        {
            echo 1;
        }else{
            echo 0;
        }
    } else {
        $this->db->where('challan_no', $challan_number);
        $this->db->where('supplier_id', $supplier_id);
        $query = $this->db->get('purchase_item_entry');
        $challan_rows = $query->num_rows() > 0;
        if($challan_rows)
        {
            echo 1;
        }else{
            echo 0;
        }
    }
}
   
public function save_edited_purchase_item_data()
{
    $editedData = $this->input->post();
    
    $amount = $editedData['editStockQty'] * $editedData['editRate'];
    $editid = $editedData['editId'];
    $igst = array_key_exists('editIgst', $editedData) ? $editedData['editIgst'] : 0;
    $sgst = array_key_exists('editSgst', $editedData) ? $editedData['editSgst'] : 0;
    $cgst = array_key_exists('editCgst', $editedData) ? $editedData['editCgst'] : 0;

    $data = array( 
        "stock_qty" => $editedData['editStockQty'],
        "billing_qty" => $editedData['editBillingQty'],
        "rate" => $editedData['editRate'],
        "cgst_tpt" => $cgst,
        "gst_tpt" => $editedData['editGst'],
        "sgst_tpt" => $sgst,
        "igst_tpt" => $igst,
        "amount" => $amount,
        "updated_date" => date("Y-m-d")
    );

    $this->load->model('Purchase_model');
    $result = $this->Purchase_model->update_item_data($data, $editid);

    if ($result) {
        $sql = "SELECT * FROM purchase_item_entry p WHERE purchase_item_entry_id = $editid";
        $getItemData = $this->db->query($sql)->result();
        
        if ($getItemData) {
            print_r(json_encode($getItemData));
        } 
    } else {
        echo 0;
    }
}

public function delete_item_data(){
   
     $purchase_supplier_id = $this->input->get('purchase_supplier_id');
       $purchase_item_id = $this->input->get('purchase_item_id');
       //print_r($purchase_item_id);
      $data = [
            'is_active' => '0'
        ];
     $this->load->model('Purchase_model');
         $response = $this->Purchase_model->delete_item_data($data,$purchase_item_id);
         if($response == true){ 
            
            $this->session->set_flashdata('purchase_delete_item_messege', 'Purchase Data Deleted Successfully');
          
           redirect('Purchase/add_purchase?purchase_supplier_id='. $purchase_supplier_id );      
       }
}

public function edit_item_data(){
    if ($this->session->userdata['role'] == 1){
            $this->load->view('user/edit_item_purchase');
         }else{
              $this->load->view('basic/login');
         }
}
public function edit_purchase_item_data(){
   //print_r($_POST);
    $data = array(
        "measure_id" => $this->input->post('size'),
        "shade_no"=>$this->input->post('shade_no'),
        "no_of_packs" => $this->input->post('no_packs'),
        "stock_quntitiy" =>$this->input->post('Stock_qty'),
        "billing_quntity" =>$this->input->post('billing_qty'),
        "quantitiy_per_pack" => $this->input->post('Qty_per_pack'),
        "rate" =>$this->input->post('rate'),
        "mrp" => $this->input->post('mrp'),
        "discount" => $this->input->post('discount'),
        "amount" =>$this->input->post('amount'),
        "tax_per" =>$this->input->post('tax_per'),
        "igst" =>$this->input->post('total_igst'),
        "cgst" => $this->input->post('total_cgst'),
        "sgst" =>$this->input->post('total_sgst'),
        "total_tax" => $this->input->post('total_tax'),
        "netamount" => $this->input->post('netamount'),
        "updated_by" =>  $this->session->userdata['user_id'],
        "updated_date" => date("Y-m-d")
        );       
  
     $purchase_item_id = $this->input->post('purchase_item_id');
      $this->load->model('Purchase_model');
     $response = $this->Purchase_model->edit_item_purchase_data($data,$purchase_item_id);
     
      if ($response == true)
            {               
               $purchase_supplier_id = $this->input->post('purchase_supplier_id');
                 $this->session->set_flashdata('purchase_message', 'Purcahse Data Eddited Successfully');
                  redirect('Purchase/add_purchase?purchase_supplier_id=' . $purchase_supplier_id);
            }
            else
            {
                echo "Insert error !";
            }
     
}
public function item_barcode()
{
    if ($this->session->userdata['role'] == 1){
            
            $this->load->view('user/barcodes');
         }else{
              $this->load->view('basic/login');
         }
}
    public  function delte_perchase_data()
    {
        $perchaseid=$this->input->get('purchase_item_entry_id');   
        //print_r($perchaseid);
        
            $data = [
                'is_active' => '0'
            ];
        $this->load->model('Purchase_model');
        
        $response = $this->Purchase_model->delete_purchase_data($data,$perchaseid);
       
       if($response == true){
          
        $this->session->set_flashdata('purchase_message', 'Purchase data Deleted Successfully');
         redirect('Purchase');
               
       }
      
    }
    public function get_edit_gst()
    {
      $supplier_id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('supplier_id'))));  
      
       $gst = $this->Purchase_model->get_edit_gst($supplier_id);
        $result = $gst;
        echo json_encode($result);
    }
    public function get_itemname()
    {
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id'))));
        $item_name = $this->Purchase_model->get_itemname($id);
        $result = $item_name;
        echo json_encode($result);
    }
    public function getTax()
    {
        $item = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('itemValue'))));
        $supplier = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('supplierValue'))));
        $result = $this->Purchase_model->get_tax($item, $supplier);
        echo json_encode($result);
    }
    public function get_brandname(){
         $id1 = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id1'))));
        $brand_name = $this->Purchase_model->get_brandname($id1);
        $result = $brand_name;
        echo json_encode($result);
    }
    public function get_gst()
    {
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id'))));
        $sup_name = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('sup_name'))));
        $gst = $this->Purchase_model->get_gst($sup_name);
        $gst_val = $this->Purchase_model->get_gstval($id);
        $result[] = $gst[0]['state_id'];
        $result[] = $gst_val[0];
        echo json_encode($result);
    }
    public function get_transport_gst()
    {
        $id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('id'))));
        $transport_data = $this->Purchase_model->get_transport_data($id);
        echo json_encode($transport_data);
    }
    public function getitemName()
	{
		$item_type_id = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('item_type_id'))));
		$item_name = $this->db->query("SELECT * FROM items WHERE item_type_id='".$item_type_id."'")->result();
		print_r(json_encode($item_name));
		exit();
	}
    public function getTaxType()
	{
		$supplierId = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('supplierId')))); 
        if (!empty($supplierId)) {
            $supplierValue = $this->db->query("SELECT * FROM supplier WHERE supplier_id = $supplierId")->result();
            if (!empty($supplierValue)){
                $gst= $supplierValue[0]->gst;
                if (substr($gst, 0, 2) === "27"){
                    $taxType ='C&SGST';
                } else{
                    $taxType ='IGST';
                }
                echo $taxType;
            }
        } else {
            echo 0;
        }
	}
    public function getCompanyWiseCustomer()
	{
		$companyname = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('companyname'))));
		$customerName = $this->db->query("SELECT * FROM enquiry WHERE company_name='".$companyname."'")->result();
		print_r(json_encode($customerName));
		exit();
	}
}
?>