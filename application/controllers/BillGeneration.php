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
		$max = $this->General_Billing_model->get_billing_serial_maxid($this->input->post('company_name'));
		$maxid = $max+1;
		$billing_serial = str_pad($maxid, 1, '0', STR_PAD_LEFT);
		$billing_number=$billing_serial;

		$customerName=$this->input->post('customer');
		$customerEmail='';
		$customerEmail = $this->db->query("SELECT * FROM enquiry where isactive = 1 and name LIKE '%$customerName%'")->row();
		if ($customerEmail) {
			$enquiry_id = $customerEmail->enquiry_id;
			$enquiryDetails = $this->db->query("SELECT *,c.name as c_name,e.name as e_name FROM enquiry e
                                        LEFT JOIN contact_person c ON c.enquiry_id = e.enquiry_id
                                        WHERE e.isactive = 1  and e.is_customer = 1 and e.enquiry_id = $enquiry_id ORDER BY e.enquiry_id DESC LIMIT 1")->row();
			if ($enquiryDetails){
				$customerEmail=$enquiryDetails->email;
			}
		}

        $companyName=$this->input->post('company_name');
        $billNumber="";
        if($companyName=='SuperEditors'){
			$billNumber= 'SE-0'.$billing_number;
		}else{
			$billNumber= 'MM-0'.$billing_number;
		}
										
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
					if ($barcode) {
						$singleBarcode = $this->db->query("SELECT * FROM barcodes WHERE barcode ='$barcode'")->row();
						$updateStockQty = $singleBarcode->stock_quantity - $quantity;
						$updateData = array(
							'stock_quantity' => $updateStockQty
						);

						$this->db->where('barcode_id', $singleBarcode->barcode_id);
						$this->db->update('barcodes', $updateData);
					}else{
				
						$codeMesurementID	=$item['codeMesuremetnId'];

						$singleGenerationsItem 	=$this->db->query("SELECT * FROM code_measurement WHERE id=$codeMesurementID")->row();
						
						$updateStockQty 		=$singleGenerationsItem->gens_qty - $quantity;

						$updateData = array(
							'gens_qty' => $updateStockQty
						);

						$this->db->where('id', $singleGenerationsItem->id);
						$this->db->update('code_measurement', $updateData);
					}
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
			$nextBilling=array('nextBillingId'=>$billing_number,'billing_id'=>$lastBillingInsertId);
			$newData=array_merge($data,$nextBilling);

			$this->load->view('BillingReport',array('billId'=>$lastBillingInsertId));
			$html = $this->output->get_output();
			$this->load->library('pdf');
			$this->dompdf->loadHtml($html);
			$this->dompdf->setPaper('A4', 'potrait');
			$this->dompdf->render();
			$file = $this->dompdf->output();

			$pdf_name='generatedBil_'.$lastBillingInsertId;
			$file_location =$_SERVER['DOCUMENT_ROOT']."/assets/bill_report/".$pdf_name.".pdf";
			file_put_contents($file_location, $file);

			if ($customerEmail){
				self::sendEmail($pdf_name,$customerEmail,'Billing invoice');
				self::sendSms($totalAmount,$billNumber);
			}

			print_r(json_encode($newData));
			exit();
		}else{
			echo 2;
			exit();
		}
	}

	public function updateGlobalRate(){
		$codeGenerationItemid 	= $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('codeGenerationItemid'))));
		$rate 				   = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('rate'))));

		$updateData = array(
			'gens_rate' => $rate
		);
		$this->db->where('code_generations_item_id', $codeGenerationItemid);
		$this->db->update('code_measurement', $updateData);

		echo 1;
		exit();
	}

	public function sendSms($totalAmount,$billNumber){
	       $billGenerationsDate     = date("d-m-Y");
	       
	        $mobile = urlencode('+919028403587');
            $username = urlencode("u6442");
            $msg_token = urlencode("8DnWEI");
            $sender_id = urlencode("SUPEDT");
            $message = urlencode('Greeting from Super Editors! Your Bill No. '.$billNumber.' Dated: '.$billGenerationsDate.' and Net Amount: '.$totalAmount.' has generated. Pay Online: https://easebuzz.in/pay/SUPEREDITORS Thanks & Regards - Super Editors info@supereditiors.in www.supereditors.in 020 - 24430981, 9028544116');
            $api = "http://mysms.exposys.in/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile."";
            $Message = htmlspecialchars($message);
            $curl = curl_init();
            curl_setopt($curl,CURLOPT_URL,$api);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            //curl_exec($curl);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
                //exit;
            }
	}
	
	public function sendEmail($fileName,$toEmail,$subject)
	{

		$htmlContentNew='<h1>Your Billing Report</h1>';
		$this->load->model('Email_Config_model');

		// Email body content
		$htmlContent = $htmlContentNew;

		//Load email library
		$this->load->library('email');


		//SMTP & mail configuration
		$config = $this
			->Email_Config_model
			->getConfig('info');


		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");

		$attachemnt=base_url()."/assets/bill_report/".$fileName.".pdf";


		$this->email->attach($attachemnt);


		// Recipient
		//$to ='aiubzahid@gmail.com';
		$to =$toEmail;
		$mailFrom='info@supereditors.in';

		$this->email->from($mailFrom);
		$this->email->to($to);
		$this->email->cc('info@supereditors.in');
		$this->email->bcc('iambommanakavya@gmail.com');
		$this->email->subject($subject);
		$this->email->message($htmlContent);

		$this->email->send();
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

	public function getBulkAuthorizationItem(){

		$customerName 	= $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('customerName'))));
		$prefixData 	= $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('prefixData'))));
		$prefixArray = explode('-', $prefixData);
		$prefix=$prefixArray[0];

		$billingStatus=1;

		$getDataSql="SELECT code_authorizations_details.unique_code as unique_code,code_generations_items.id as itemId, code_generations.order_no,code_generations_items.item_name,code_measurement.gens_qty,code_measurement.gens_rate,items.cgst
					FROM `code_authorizations_details`
					RIGHT JOIN code_measurement
					ON code_authorizations_details.unique_code=code_measurement.unique_code
					LEFT JOIN code_generations_items
					ON code_generations_items.id=code_measurement.code_generations_item_id
					LEFT JOIN code_generations
					ON code_generations_items.code_generations_id=code_generations.code_generations_id
					LEFT JOIN items
					ON code_generations_items.item_id=items.item_id
					WHERE code_authorizations_details.billing_status=1 AND code_measurement.gens_qty>0 and code_measurement.prefix='".$prefix."'";

		$getCodeMesurementData = $this->db->query($getDataSql)->result();

		if ($getCodeMesurementData){
			print_r(json_encode($getCodeMesurementData));
			exit();
		}
	}

	public function getAuthorizationBillingCode(){

		$customerName = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('customerName'))));
		$companyName = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('companyName'))));

		$getAuthorizations = $this->db->query("SELECT * FROM code_authorizations WHERE customer_name='".$customerName."'")->result();

		if ($getAuthorizations){
			$dataList=array();
			foreach ($getAuthorizations as $key=>$item){
				$dataList[]=$item->id;
			}

			$listedDataId=implode(",", $dataList);
			
        	$dataItemList = $this->db->query("SELECT * FROM code_authorizations_details 
INNER JOIN code_measurement
ON code_measurement.unique_code=code_authorizations_details.unique_code
WHERE code_authorizations_details.code_authorization_id IN ($listedDataId) and code_authorizations_details.billing_status=1 AND code_measurement.gens_qty>0 and code_measurement.mesurement IS NOT NULL")->result();
        	
			print_r(json_encode($dataItemList));
			exit();
				
		}else{
			echo 2;
			exit();
		}
	}

	public function getItemName(){

		$prefix = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('prefix'))));
		$prefixArray = explode('-', $prefix);
		$prefix=$prefixArray[0];
		$getAuthorizations = $this->db->query("SELECT * FROM code_generations WHERE prefix LIKE '%$prefix%'")->row();
		if ($getAuthorizations){

			$codeGenerationsId=$getAuthorizations->code_generations_id;

			$this->db->select();
			$this->db->from('code_generations_items');
			$this->db->where('code_generations_id',$codeGenerationsId);
			$this->db->where('is_active','1');
			$query = $this->db->get();

			if( $query->num_rows() > 0 )
			{
				print_r(json_encode($query->result_array()));
				exit();
			}
			else
			{
				return false;
			}
		}
	}

	public function getAuthorizationsItemData(){

		$itemId 	= $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('itemId'))));
		$codeGenerationsId = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('codeGenerationsId'))));

		$getItemType = $this->db->query("SELECT * FROM items WHERE item_id=$itemId")->row();
		
		$uniqueCode 	= $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('unique_code'))));

		$dataArray=array();
		$typeId='';
		if ($getItemType){
			$typeId=$getItemType->item_type_id;
		}

		//$getSingleItem = $this->db->query("SELECT * FROM code_generations_items WHERE code_generations_id=$codeGenerationsId and item_id=$itemId")->row();
		
		$getSingleItem = $this->db->query("SELECT CM.id as code_mesurement_id,CM.gens_qty,CGI.gens_rate,CGI.ladies_qty,CGI.ladies_rate,CGI.brand_id FROM code_generations_items as CGI INNER JOIN code_measurement as CM ON CM.code_generations_item_id=CGI.id WHERE CGI.code_generations_id=$codeGenerationsId and CGI.item_id=$itemId AND CM.gens_qty>0 and CM.unique_code='$uniqueCode'")->row();
		
		if ($getSingleItem){
			$dataArray=array(
				'type_id'		=>$typeId,
				'code_mesurement_id'=>$getSingleItem->code_mesurement_id,
				'gens_qty'		=>$getSingleItem->gens_qty,
				'gens_rate'		=>$getSingleItem->gens_rate,
				'ladies_qty'    =>$getSingleItem->ladies_qty,
				'ladies_rate'	=>$getSingleItem->ladies_rate,
				'brand_id'		=>$getSingleItem->brand_id,
			);

		     print_r(json_encode($dataArray));
		     exit();
		}

	}
	
	public function get_single_customer(){
	    $customerName 	= $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('customerName'))));
	    $customerDetails = $this->db->query("SELECT * FROM enquiry e where isactive = 1 and name='$customerName'")->row();
	    if($customerDetails){
	        print_r(json_encode($customerDetails));
		    exit();
	    }
	}
}
