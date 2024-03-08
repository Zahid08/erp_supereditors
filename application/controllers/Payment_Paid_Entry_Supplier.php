<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment_Paid_Entry_Supplier extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
        $this->load->model('Purchase_model');
    }

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
            $purchaseSupplerPaymentList = $_REQUEST['PurchasePaymentId'];

            foreach ($purchaseSupplerPaymentList as $key=>$item) {
                if (isset($item['purchase_supplier_payment_id'])) {
                    $purchase_supplier_payment_id = $item['purchase_supplier_payment_id'];
                    $getAmount = $this->db->query("SELECT * FROM purchase_supplier_payment where purchase_supplier_payment_id = $purchase_supplier_payment_id ")->result();

                    $balance=0;
                    foreach ($getAmount as $getAmountValue) {
                        $balance = $getAmountValue->balance;
                    }

                    $data = array(
                        "amount_paid" => 0,
                        "tds_deduction" => 0,
                        "other_deduction" =>0,
                        "advance_adjusted" =>0,
                        "bank_details" => $this->input->post('bank_details'),
                        "payment_mode" => $this->input->post('payment_mode'),
                        "payment_date" => $this->input->post('payment_date'),
                        "chq_no" => $this->input->post('chq_no'),
                        "paid_by" => $this->input->post('paid_by'),
                        "balance" => ($balance - ($item['amount_paid'] + $item['tds_deduction'] + $item['other_deduction']+$item['advance_adjusted'])),
                    );
                    $this->Purchase_model->payment_update($data, $purchase_supplier_payment_id);
                }
            }

            $this->load->model('Supplier_Payment_model');
            $max = $this->Supplier_Payment_model->get_voucher_maxid();
            $maxid = $max+1;
            $voucher_no = str_pad($maxid, 5, '0', STR_PAD_LEFT);
            
            
            $supplierDetailsValue = $this->db->query("SELECT * FROM supplier s INNER JOIN 
               supplier_contact_details sd ON sd.supplier_id = s.supplier_id
               WHERE s.is_active = 1 and s.supplier_id = $supplier")->row();
            
            $data=array( "voucher_no"=>$voucher_no,
                "payment_date"=>$this->input->post('payment_date'),
                "company_name"=>$this->input->post('companyName'),
                "supplier_id" =>$supplier,
                "amount_paid"=>$this->input->post('total_amount_paid'),
                "total_tds_deducted"=>$this->input->post('total_tds_deducted'),
                "total_other_deduction"=>$this->input->post('total_other_deduction'),
                "amount_adjusted"=>$this->input->post('total_adv_adjusted'),
                "amount_paid_by" => $this->input->post('paid_by'),
                "payment_mode" => $this->input->post('payment_mode'),
                "cheque_no" => $this->input->post('chq_no'),
                "bank_detail" => $this->input->post('bank_details'),
                "is_active"=>1,
                "created_by" =>  $this->session->userdata['user_id'],
                "created_date" => date("Y-m-d"));

            $response=$this->Supplier_Payment_model->save_payment_data($data);

            if($response==true){
                
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
                            'charset'   => 'iso-8859-1',
                            'wordWrap' => true
                        );
                        
                        $this->email->initialize($config);
                        $this->email->set_mailtype("html");
                        $this->email->set_newline("\r\n");
                        
                        // Recipient
                        $to = $supplierDetailsValue->email;
                        
                        $url = base_url()."Payment_Paid_Entry_Supplier/generatedPdf?vc=$voucher_no&supplier=$supplier";
                        // Email body content
                        $htmlContent = "<p>Dear ".$supplierDetailsValue->supplier_name.",</p>

                        <p>Voucher Number $voucher_no of Amount ".$this->input->post('total_amount_paid')." has been created .</p> 
                        <p><a href='$url'>Click Here</a> to view payment details.</p>
                        <p>Thanks & Regards<br>
                        ".$this->input->post('company_name').". </p>";
                        
                            $this->email->from("info@supereditors.in", $this->input->post('company_name'));
                            $this->email->to($to);
                            $this->email->cc('info@supereditors.in');
                            $this->email->bcc('iambommanakavya@gmail.com','keshriedutech@gmail.com');
            
                            $this->email->subject("Payment Paid Entry Created");
                            $this->email->message($htmlContent);
                            $this->email->send();
                
                
                   redirect(base_url().'Payment_Paid_Entry_Supplier/generatedPdf?vc='.$voucher_no.'&supplier='.$supplier.'&company='.$this->input->post('companyName'));
            }
            else{
                echo "Insert error !";
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
    
        public function generatedPdf(){
        $this->load->view('SupplierPaymentReportPdf');
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream("SupplierPaymentReportPdf.pdf", array("Attachment"=>0)); // Output the generated PDF (1 = download and 0 = preview)
    }
    
     public function SupplierPaymentReport()
    {
        if ($this->session->userdata['role'] == 1){
            $this->load->view('user/supplier_payment_report');

        }else{
            $this->load->view('basic/login');
        }
    }

}
