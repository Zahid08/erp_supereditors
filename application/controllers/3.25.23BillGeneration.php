<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BillGeneration extends CI_Controller {

	public function index()
	{
        $this->load->model('General_Billing_model');
        $max = $this->General_Billing_model->get_billing_serial_maxid();
        $maxid = $max+1;
        $billing_serial = str_pad($maxid, 5, '0', STR_PAD_LEFT);
        $nextYear=date("Y")+1;
        $billing_number='SE-'.$billing_serial.'/'.date("Y").'-'.$nextYear.'';

	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/bill_generation',array('billing_number'=>$billing_number));
	    }else{
	        $this->load->view('basic/login');
	    }
	}
	public function get_barcodeList(){
	    $itemId     =$_REQUEST['itemId'];
        $barcodeDetails = $this->db->query("SELECT p.igst,b.purchased_amount_per_pack,p.created_date,sup.supplier_name, s.company_name,b.barcode,m.measure_name,b.purchase_item_id,p.quantitiy_per_pack,b.purchase_supplier_id,b.amount_per_pack,b.stock_quantity,b.rate,b.mrp,i.item_name FROM `barcodes` b INNER JOIN purchase_item p ON p.purchase_item_id = b.purchase_item_id
                       INNER JOIN purchase_supplier s ON s.purchase_supplier_id = p.purchase_supplier_id
                       INNER JOIN supplier sup ON sup.supplier_id = s.supplier_id
                       INNER JOIN item_type it ON it.item_type_id = p.item_type_id
                       INNER JOIN items i ON i.item_id = p.item_id 
                       INNER JOIN measure m ON m.measure_id = p.measure_id
                       where b.is_active = 1 AND i.item_id =$itemId ORDER BY 1 DESC")->result();

        print_r(json_encode($barcodeDetails));
        exit();
    }

    public function save_bill_data(){
        $this->load->model('General_Billing_model');
        $max = $this->General_Billing_model->get_billing_serial_maxid();
        $maxid = $max+1;
        $billing_serial = str_pad($maxid, 1, '0', STR_PAD_LEFT);
        $billing_number=$billing_serial;

        $data=array( "billing_serial"=>$billing_serial,
            "billing_number" => $billing_number,
            "company_name"=>$this->input->post('company_name'),
            "chalan_number"=>$this->input->post('ch_no'),
            "billing_date" => $this->input->post('bill_date'),
            "billing_po_number"=>$this->input->post('po_no'),
            "category_name"=>$this->input->post('category'),
            "billing_type" => $this->input->post('bill_type'),
            "billing_customer" => $this->input->post('customer'),
            "credit_limit" => $this->input->post('credit_limit'),
            "delivery_address" => $this->input->post('delivery_address'),
            "order_number" => $this->input->post('order_no'),
            "eway_bill_no" => $this->input->post('eway_bill_no'),
            "sales_person" => $this->input->post('sales_person'),
            "tax_type" => $this->input->post('tax_type'),
            "total_amount" => $this->input->post('total_amount'),
            "total_discount" => $this->input->post('total_disc'),
            "igst_amount" => $this->input->post('igst_amount'),
            "cgst_amount" => $this->input->post('cgst_amount'),
            "sgst_amount" => $this->input->post('sgst_amount'),
            "tpt_amount" => $this->input->post('tpt_amount'),
            "net_bill_amount" => $this->input->post('net_bill_amt'),
            "remark" => $this->input->post('remark'),
            "billing_customer_id" => $this->input->post('billing_customer_id'),
            "selected_item" => $this->input->post('selectedItem'),
            "is_active"=>1,
            "created_by" =>  $this->session->userdata['user_id'],
            "created_date" => date("Y-m-d h:i:s"));

        $response=$this->General_Billing_model->save_billing_data($data);

        if($response==true){
            $lastBillingInsertId = $this->db->insert_id();
            $selectedItemArray =isset($_REQUEST['Billing'])?$_REQUEST['Billing']:'';
            if ($selectedItemArray) {
                $totalAmount=0;
                foreach ($selectedItemArray as $key => $item) {
                    $barcode = $item['barcode'];
                    $itemName = $item['itemName'];
                    $orderNumber = $item['orderNumber'];
                    $quantity = $item['quantity'];
                    $ratePirce = $item['ratePirce'];
                    $subTotalAmount = $item['subTotalAmount'];
                    $discount = $item['discountAmount'];
                    $totalAmount+=$subTotalAmount;
                    $insertedData = array(
                        'billing_id' => $lastBillingInsertId,
                        'order_no' =>$orderNumber,
                        'item_name' => $itemName,
                        'barcode' => $barcode,
                        'discount' => $discount,
                        'qty' => $quantity,
                        'rate' => $ratePirce,
                        'amount' => $subTotalAmount,
                    );
                    $this->db->insert('general_billing_entry_order_item', $insertedData);

                    //Update Barcode
                    $singleBarcode = $this->db->query("SELECT * FROM barcodes WHERE barcode ='$barcode'")->row();
                    $updateStockQty=$singleBarcode->stock_quantity-$quantity;
                    $updateData=array(
                        'stock_quantity'=>$updateStockQty
                    );

                    $this->db->where('barcode_id', $singleBarcode->barcode_id);
                    $this->db->update('barcodes', $updateData);
                }

                //Update Total Data
                $updateBillingData=array(
                    'total_amount'=>$totalAmount
                );

                $this->db->where('billing_id', $lastBillingInsertId);
                $this->db->update('general_billing_entry', $updateBillingData);

            }

            $max = $this->General_Billing_model->get_billing_serial_maxid();
            $maxid = $max+1;
            $billing_serial = str_pad($maxid, 5, '0', STR_PAD_LEFT);
            $nextYear=date("Y")+1;
            $billing_number='SE-'.$billing_serial.'/'.date("Y").'-'.$nextYear.'';
            $nextBilling=array('nextBillingId'=>$billing_number);
            $newData=array_merge($data,$nextBilling);
            print_r(json_encode($newData));
            exit();
        }else{
            echo 2;
            exit();
        }
    }

    public function get_billing_report(){
        $this->load->view('BillingReport');
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream("BillingReport.pdf", array("Attachment"=>0)); // Output the generated PDF (1 = download and 0 = preview)
    }

    public function BillingReport()
    {
        if ($this->session->userdata['role'] == 1){
            $this->load->view('user/bill_generation_report');

        }else{
            $this->load->view('basic/login');
        }
    }
}
