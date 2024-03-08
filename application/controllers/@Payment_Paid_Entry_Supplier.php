<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_Paid_Entry_Supplier extends CI_Controller
{
public function index()
    {
         if ($this->session->userdata['role'] == 1){
             
             
             $InitialPayments = $this->db->query("SELECT p.purchase_supplier_id,SUM(netamount) as total_purchase_amount,s.created_by,s.created_date FROM purchase_supplier s
                                                INNER JOIN purchase_item p ON p.purchase_supplier_id = s.purchase_supplier_id
                                                WHERE p.purchase_supplier_id NOT IN (SELECT purchase_supplier_id FROM purchase_supplier_payment)
                                                GROUP BY p.purchase_supplier_id")->result();
                
                foreach($InitialPayments as $getInitialPayments){ 
                    $initialPaymentData = array(
                        "purchase_supplier_id"=>$getInitialPayments->purchase_supplier_id,
                        "total_purchase_amount"=>$getInitialPayments->total_purchase_amount,
                        "balance"=>$getInitialPayments->total_purchase_amount,
                        "created_date" =>$getInitialPayments->created_date,
                        "created_by" =>$getInitialPayments->created_by,
                        );
                        
                    $this->load->model(Purchase_model);
                    $response = $this->Purchase_model->save_purchase_suppplier_payment($initialPaymentData);
                        
                }
             
            $this->load->view('user/purchase_paid_entry_supplier');
        
         }else{
              $this->load->view('basic/login');
         }
        
   
    }
    
    public function payment_update(){
       
            $voucher_no = $this->input->get('vc'); 
            $supplier = $this->input->get('supplier'); 
            $purchase_supplier_payment_id = $this->input->post('purchase_supplier_payment_id');
            
            $getAmount = $this->db->query("SELECT * FROM purchase_supplier_payment where purchase_supplier_payment_id = $purchase_supplier_payment_id ")->result();
                
                foreach($getAmount as $getAmountValue){ 
                    $total_purchase_amount = $getAmountValue->total_purchase_amount;
                }
            
        
        $data = array(
            "amount_paid"=> $this->input->post('total_amount_paid'),
            "advance_adjusted"=> $this->input->post('total_adv_adjusted'),
            "bank_details" => $this->input->post('bank_details'),
            "tds_deduction" => $this->input->post('total_tds_deducted'),
            "payment_mode" => $this->input->post('payment_mode'),
            "payment_date" => $this->input->post('payment_date'),
            "chq_no" => $this->input->post('chq_no'),
            "paid_by" => $this->input->post('paid_by'),
            "balance"=> ($total_purchase_amount - ($this->input->post('total_amount_paid') + $this->input->post('total_adv_adjusted') + $this->input->post('total_tds_deducted'))),
            );
            
             $this->load->model(Purchase_model);
     $response = $this->Purchase_model->payment_update($data,$purchase_supplier_payment_id);
     if($response == true){
         
         
         $response = $this->Purchase_model->advance_payment_update($voucher_no,$supplier,$this->input->post('total_adv_adjusted'));
         
         $this->session->set_flashdata('purchase_message', 'Amount Adjusted Successfully');
          redirect(base_url().'Payment_Paid_Entry_Supplier?vc='.$voucher_no.'&supplier='.$supplier);    
     }
   
    }
    
    public function status_update(){
            $purchase_supplier_id=$this->input->get('purchase_supplier_id'); 
            $voucher_no = $this->input->get('vc'); 
            $supplier = $this->input->get('supplier'); 
    $stock_received=$this->input->get('stock_received');   
     if($stock_received == '1'){
		$stock_status = '0';
	}
	else{
		$stock_status = '1';
	}

	$data = array('stock_received' => $stock_status );
      $this->load->model(Purchase_model);
     $response = $this->Purchase_model->stock_status_change($data,$purchase_supplier_id);
     
          
       if($response == true){
        $this->session->set_flashdata('purchase_message', 'Status Updated Successfully');
        redirect(base_url().'Payment_Paid_Entry_Supplier?vc='.$voucher_no.'&supplier='.$supplier);
               
       }

    } 
   
}