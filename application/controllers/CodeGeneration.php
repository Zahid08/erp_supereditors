<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CodeGeneration extends CI_Controller {

	public function index()
	{
		$this->load->model('GenerateCode_model');
		$getPreviousGeneratedCodeList = $this->db->query("SELECT * FROM code_generations WHERE is_active = 1")->result();

		if($this->session->userdata['role'] == (1 || 2) ){
			$this->load->view('user/code_generation',array('generatedCode'=>$getPreviousGeneratedCodeList));
		}else{
			$this->load->view('basic/login');
		}
	}

	public function Measurements()
	{

		$this->load->model('GenerateCode_model');
		$getPreviousGeneratedCodeList = $this->db->query("SELECT * FROM code_generations WHERE is_active = 1")->result();

		if($this->session->userdata['role'] == (1 || 2) ){
			$this->load->view('user/code_mesurement',array('generatedCode'=>$getPreviousGeneratedCodeList));
		}else{
			$this->load->view('basic/login');
		}
	}

	public function Codeauthorize()
	{

		$this->load->model('GenerateCode_model');
		$getPreviousGeneratedCodeList = $this->db->query("SELECT * FROM code_generations WHERE is_active = 1")->result();

		if($this->session->userdata['role'] == (1 || 2) ){
			$this->load->view('user/code_authorize',array('generatedCode'=>$getPreviousGeneratedCodeList));
		}else{
			$this->load->view('basic/login');
		}
	}

	public function save_code_data(){
		if ($this->input->post('codeGenerationsId')==''){
			$prefix=$_REQUEST['prefix'];
			$getCodeGenerationsData = $this->db->query("SELECT * FROM code_generations WHERE prefix='".$prefix."'")->row();
			if($getCodeGenerationsData){
				if ($_REQUEST['number_starts_form']<$getCodeGenerationsData->number_of_code_generations){
					$data=array(
						'support'=>$getCodeGenerationsData->number_of_code_generations+$getCodeGenerationsData->number_starts_form,
						'status'=>'error',
					);
					print_r(json_encode($data));
					exit();
				}
			}
		}

		$this->load->model('GenerateCode_model');

		$data=array(
			"company_name" => $this->input->post('company_name'),
			"customer_name"=>$this->input->post('customer'),
			"order_date"=>$this->input->post('order_date'),
			"delivery_date" =>$this->input->post('delivery_date'),
			"order_no"=>$this->input->post('order_no'),
			"remark"=>$this->input->post('remark'),
			"prefix" => $this->input->post('prefix'),
			"number_of_code_generations" => $this->input->post('number_of_code_generations'),
			"number_starts_form" => $this->input->post('number_starts_form'),
			"is_active"=>1,
			"created_by" =>  $this->session->userdata['user_id'],
			"created_date" => date("Y-m-d h:i:s"));

		if ($this->input->post('codeGenerationsId')) {
			$this->db->where('code_generations_id', $this->input->post('codeGenerationsId'));
			$response=$this->db->update('code_generations', $data);
		}else{
			$response=$this->GenerateCode_model->save_generated_code_data($data);
		}

		$selectedItemArray =isset($_REQUEST['CodeGenerationsItems'])?$_REQUEST['CodeGenerationsItems']:'';
		$codeAuthorizationsId= '';

		if ($response){
			if ($this->input->post('codeGenerationsId')){
				$lastGenrationsId = $this->input->post('codeGenerationsId');
			}else {
				$lastGenrationsId = $this->db->insert_id();
				$codeAuthorizationsId = self::generateCode($lastGenrationsId);
			}

			if ($selectedItemArray && $this->input->post('codeGenerationsId')=="") {
				foreach ($selectedItemArray as $key => $item) {
					if ($item['codeGenerationsItemId']){
						$updateData = array(
							'color_code' 		=> $item['colorCode'],
							'brand_id' 			=> $item['brandName'],
							'item_name' 		=> $item['itemName'],
							'item_id' 			=>$item['itemId'],
							'gens_qty' 			=> $item['gensQty'],
							'gens_rate' 		=> $item['gensRate'],
							'ladies_qty' 		=> $item['ladiesQty'],
							'ladies_rate' 		=> $item['ladiesRate'],
							'item_febrics' 		=> $item['febricsItem'],
							"logo_and_printing" => $item['logo_and_printing'],
							"printing_status" => $item['printing_status'],
							'generated_status' => $item['generatedStatus'],
							'is_active' => 1
						);
						$this->db->where('id', $item['codeGenerationsItemId']);
						$this->db->update('code_generations_items', $updateData);
					}else {

						$insertedData = array(
							'code_generations_id' => $lastGenrationsId,
							'color_code' => $item['colorCode'],
							'brand_id' => $item['brandName'],
							'item_name' => $item['itemName'],
							'item_id' 			=>$item['itemId'],
							'gens_qty' => $item['gensQty'],
							'gens_rate' => $item['gensRate'],
							'ladies_qty' => $item['ladiesQty'],
							'ladies_rate' => $item['ladiesRate'],
							'item_febrics' => $item['febricsItem'],
							"printing_status" => $item['printing_status'],
							'patterns_type' => $item['patternType'],
							'generated_status' => $item['generatedStatus'],
							'is_active' => 1
						);
						$this->db->insert('code_generations_items', $insertedData);
						$lastInsertCodeGenerationsItemid = $this->db->insert_id();
						$this->generateMesurementDetails($lastInsertCodeGenerationsItemid,$codeAuthorizationsId,$insertedData);
					}
				}
			}

			$generatesCodeid=array('genratesCodeId'=>$lastGenrationsId);
			$newData=array_merge($data,$generatesCodeid);
			print_r(json_encode($newData));
			exit();
		}
	}

	public function generateMesurementDetails($codeGenerationItemId,$codeAuthorizeId,$itemData){

		$startForm = $this->input->post('number_starts_form');
		$dataEndOFCode =$this->input->post('number_of_code_generations');

		$start_from =$startForm;
		$start_end =$dataEndOFCode;

		$endedItem = $start_from + $start_end;

		//Save Code Authorizations
		for ($index = $start_from; $index <= $endedItem; $index++) {
			$insertedData = array(
				'code_authorization_id'		 => $codeAuthorizeId,
				'code_generations_item_id' 	=> $codeGenerationItemId,
				'gens_qty' 					=>$itemData['gens_qty'],
				'gens_rate' 				=>$itemData['gens_rate'],
				'ladies_qty' 				=>$itemData['ladies_qty'],
				'ladies_rate' 				=>$itemData['ladies_rate'],
				'patterns_type' 			=>$itemData['patterns_type'],
				'prefix' 					=> $this->input->post('prefix'),
				'unique_code' 				=> $this->input->post('prefix') . '-' . $index,
			);

			$this->GenerateCode_model->save_code_mesurement($insertedData);
		}
	}

	/*---Generated Authorizations Code------------*/
	public function generateCode($lastGenrationsId){

		$this->load->model('GenerateCode_model');

		$startForm = $this->input->post('number_starts_form');
		$dataEndOFCode =$this->input->post('number_of_code_generations');
		$delivery_date =$this->input->post('delivery_date');

		$getAuthorizations = $this->db->query("SELECT * FROM code_authorizations WHERE start_from=$startForm and start_end=$dataEndOFCode and prefix='" . $this->input->post('prefix') . "'")->row();
		if ($getAuthorizations) {
			$lastInsertedId = $getAuthorizations->id;
			$start_from = $getAuthorizations->start_from;
			$start_end = $getAuthorizations->start_end;
		} else {
			$data = array(
				"company_name" => $this->input->post('company_name'),
				"code_generations_id" =>$lastGenrationsId,
				"customer_name" => $this->input->post('customer'),
				"prefix" => $this->input->post('prefix'),
				"delivery_date" => date("Y-m-d h:i:s",strtotime($delivery_date)),
				"start_from" => $startForm,
				"start_end" =>$dataEndOFCode);

			$response = $this->GenerateCode_model->save_authorization_data($data);

			if ($response) {
				$lastInsertedId = $this->db->insert_id();
				$start_from =$startForm;
				$start_end =$dataEndOFCode;

				$endedItem = $start_from + $start_end;

				//Save Code Authorizations
				for ($index = $start_from; $index <= $endedItem; $index++) {
					$insertedData = array(
						'code_authorization_id' => $lastInsertedId,
						'unique_code' => $this->input->post('prefix') . '-' . $index,
						'billing_status' => 0
					);

					$this->GenerateCode_model->save_authorization_details_data($insertedData);
				}

			}
		}
		return $lastInsertedId;
	}


	public function update_authorizations(){

		$updateData = array(
			'billing_status' =>$this->input->post('status')
		);

		$this->db->where('id', $this->input->post('authorizationsId'));
		$response = $this->db->update('code_authorizations_details', $updateData);
		if ($response){
			echo 1;
			exit();
		}
	}

	public function getCodeGenerationsData(){

		$echoCodeGenerationsId=$_REQUEST['id'];
		if ($echoCodeGenerationsId) {
			$getCodeGenerationsData = $this->db->query("SELECT * FROM code_generations WHERE code_generations_id =$echoCodeGenerationsId")->row();
			$codeGenerationsItem = $this->db->query("SELECT * FROM code_generations_items WHERE code_generations_id =$echoCodeGenerationsId")->result();

			$dataList = array(
				'CodeGenerationsData' => json_encode($getCodeGenerationsData),
				'codeGenerationsItem' => json_encode($codeGenerationsItem),
			);

			print_r(json_encode($dataList));
			exit();
		}
	}

	public function get_code_number(){
		$customerName = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('customerName'))));

		$this->db->select();
		$this->db->from('code_generations');
		$this->db->where('customer_name',$customerName);
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

	public function saveOrImportCode(){
		if($_FILES['import_file']['name']) {
			$this->load->model('GenerateCode_model');

			$startForm = $this->input->post('startUp');
			$dataEndOFCode = $this->input->post('dataEndOFCode');
			$getAuthorizations = $this->db->query("SELECT * FROM code_authorizations WHERE start_from=$startForm and start_end=$dataEndOFCode and prefix='" . $this->input->post('prefix') . "'")->row();
			if ($getAuthorizations) {
				$lastInsertedId = $getAuthorizations->id;
				$start_from = $getAuthorizations->start_from;
				$start_end = $getAuthorizations->start_end;
			} else {
				$data = array(
					"company_name" => $this->input->post('companyName'),
					"customer_name" => $this->input->post('customerName'),
					"prefix" => $this->input->post('prefix'),
					"start_from" => $this->input->post('startUp'),
					"start_end" => $this->input->post('dataEndOFCode'));

				$response = $this->GenerateCode_model->save_authorization_data($data);

				if ($response) {
					$lastInsertedId = $this->db->insert_id();
					$start_from = $this->input->post('startUp');
					$start_end = $this->input->post('dataEndOFCode');

					$endedItem = $start_from + $start_end;
					for ($index = $start_from; $index <= $endedItem; $index++) {
						$insertedData = array(
							'code_authorization_id' => $lastInsertedId,
							'unique_code' => $this->input->post('prefix') . '-' . $index,
							'billing_status' => 0
						);

						$this->GenerateCode_model->save_authorization_details_data($insertedData);
					}

				}
			}

			$FinalResponse=[];
			if ($start_end && $start_from) {

				if ($_FILES['import_file']['name']) {
					$filename = explode(".", $_FILES['import_file']['name']);
					if ($filename[1] == 'csv') {
						$final_array = array();
						$handle = fopen($_FILES['import_file']['tmp_name'], "r");
						$count = 0;
						while ($data = fgetcsv($handle)) {
							if ($count >= 1) {
								$getAuthorizationsDetails = $this->db->query("SELECT * FROM code_authorizations_details WHERE unique_code='" . $data[1] . "'")->row();

								if (!empty($getAuthorizationsDetails)) {
									$updateData = array(
										'unique_name' => $data[2],
										'gender' => $data[3],
										'authorization' => $data[4],
										'roll_no' => $data[5],
										'cell_no' => $data[6],
										'mens_tak' => $data[7],
										'mens_taken' => $data[8],
										'stud_name' => $data[9]
									);

									$this->db->where('id', $getAuthorizationsDetails->id);
									$response = $this->db->update('code_authorizations_details', $updateData);

									$FinalResponse[]=$updateData;
								}
							}
							$count++;
						}
						fclose($handle);
					}
				}
			}
			print_r(json_encode($FinalResponse));
			exit();
		}else{

			$userId=$this->session->userdata['user_id'];
			$getUser = $this->db->query("SELECT * FROM user WHERE user_id =$userId")->row();

			$authorizationsData=$this->input->post('AuthorizationsItem');
			if ($authorizationsData){
				foreach ($authorizationsData as $key=>$itemData){
					$billingStatus=0;
					if (isset($itemData['authorization_status'])){
						if ($itemData['authorization_status']=='on'){
							$billingStatus=1;
						}
					}

					$updateData = array(
						'billing_status' =>$billingStatus,
						'unique_name' =>$itemData['unique_name'],
						'gender' =>$itemData['gender'],
						'authorization' =>$itemData['authorization'],
						'roll_no' =>$itemData['roll_no'],
						'cell_no' =>$itemData['cell_no'],
						'mens_tak' =>$itemData['mens_tak'],
						'stud_name' =>$itemData['stud_name'],
						'modifications_user' =>json_encode($getUser),
					);

					$this->db->where('id', $itemData['id']);
					$response = $this->db->update('code_authorizations_details', $updateData);
				}
			}

			echo 1;
			exit();
		}
	}

	public function getCodeMesurementInfo(){
		$prefix					=$this->input->post('prefix');
		$codeGenerationItemId	=$this->input->post('codeGenerationItemId');

		$getDataSql="SELECT code_measurement.*,code_authorizations_details.gender,code_authorizations_details.unique_name,code_authorizations_details.billing_status,code_authorizations_details.id as authorizationId FROM `code_measurement` 
					INNER JOIN code_authorizations_details
					ON code_measurement.unique_code=code_authorizations_details.unique_code
					WHERE code_measurement.code_generations_item_id='$codeGenerationItemId'  and code_measurement.prefix='".$prefix."'";

		$getCodeMesurementData = $this->db->query($getDataSql)->result();

		if ($getCodeMesurementData){
			print_r(json_encode($getCodeMesurementData));
			exit();
		}
	}

	public function getGenerationsInfo(){
		$dataGenerationsItem[] = array(
			'gens_qty' =>'',
			'ladies_qty' =>'',
			'patterns_type' =>'',
			'delivery_date' =>''
		);

		if ($this->input->post('codeGenerationsId')) {
			$codeGenerationsId = $this->input->post('codeGenerationsId');
			$itemName = $this->input->post('itemName');
			$getCodeGeneationsItem = $this->db->query("SELECT * FROM code_generations_items WHERE code_generations_id=$codeGenerationsId and item_name='" . $itemName . "'")->row();
			if ($getCodeGeneationsItem) {
				$dataGenerationsItem= array(
					'gens_qty' => $getCodeGeneationsItem->gens_qty,
					'ladies_qty' => $getCodeGeneationsItem->ladies_qty,
					'patterns_type' => $getCodeGeneationsItem->patterns_type
				);
			}
		}

		$startForm=$this->input->post('startUp');
		$dataEndOFCode=$this->input->post('dataEndOFCode');
		$deleteStatus=0;

		$getAuthorizations = $this->db->query("SELECT * FROM code_authorizations WHERE start_from=$startForm and start_end=$dataEndOFCode and prefix='".$this->input->post('prefix')."'")->row();
		if ($getAuthorizations) {

			$codeGenerationsId = $getAuthorizations->code_generations_id;
			$code_generations = $this->db->query("SELECT * FROM code_generations WHERE code_generations_id =$codeGenerationsId")->row();
			$deliveryDate='';
			if ($code_generations){
				$deliveryDate=$code_generations->delivery_date;
			}

			$getAllAuthorizationData = $this->db->query("SELECT * FROM code_authorizations_details WHERE code_authorization_id=$getAuthorizations->id and delete_status=$deleteStatus")->result();
			$finalresponseArray=array(
				'codeAuthorizationsDetails'=>$getAllAuthorizationData,
				'codeGenerations'=>$dataGenerationsItem,
				'delivery_date'=>$deliveryDate
			);
			print_r(json_encode($finalresponseArray));
			exit();
		}
	}


	public function get_code_genrated_item_name(){

		$codeGenerationsId = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('codeGenerationsId'))));
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


	public function importCodeMesurement(){

		if($_FILES['import_file']['name']) {
			$this->load->model('GenerateCode_model');

			$prefix = $this->input->post('prefix');
			$startForm = $this->input->post('startUp');
			$dataEndOFCode = $this->input->post('dataEndOFCode');
			$itemid = $this->input->post('itemid');

			if (!empty($startForm) && !empty($dataEndOFCode) && !empty($prefix)) {

				$getAuthorizations = $this->db->query("SELECT * FROM code_authorizations WHERE start_from=$startForm and start_end=$dataEndOFCode and prefix='" . $this->input->post('prefix') . "'")->row();
				if ($getAuthorizations) {
					$lastInsertedId = $getAuthorizations->id;
					$start_from = $getAuthorizations->start_from;
					$start_end = $getAuthorizations->start_end;

	                    $FinalResponse=[];
	
					if ($_FILES['import_file']['name']) {
						$filename = explode(".", $_FILES['import_file']['name']);
						if ($filename[1] == 'csv') {
							$final_array = array();
							$handle = fopen($_FILES['import_file']['tmp_name'], "r");
							$count = 0;
							while ($data = fgetcsv($handle)) {
								if ($count >= 1) {
								
									$getAuthorizationsDetails = $this->db->query("SELECT * FROM code_authorizations_details WHERE unique_code='" . $data[1] . "'")->row();
									if (!empty($getAuthorizationsDetails) && !empty($data[2])) {
										$updateData = array(
											'unique_name' => $data[2],
											'gender' => $data[3],
										);
										
										$this->db->where('id', $getAuthorizationsDetails->id);
										$response = $this->db->update('code_authorizations_details', $updateData);
									}

									$code_measurement = $this->db->query("SELECT * FROM code_measurement WHERE unique_code='" . $data[1] . "' and code_generations_item_id='$itemid'")->row();

									if (!empty($code_measurement)) {
										$updateData = array(
											'gender' => $data[3],
											'gens_qty' => $data[4],
											'mesurement' => $data[5],
										);

										$this->db->where('id', $code_measurement->id);
										$response = $this->db->update('code_measurement', $updateData);
									}
								
								    $updateData=array(
											'unique_name' => $data[2],
											'gender' => $data[3],
											'gens_qty' => $data[4],
											'mesurement' => $data[5],
											'pattern' => $data[6],
											'remark' => $data[7],
										);
										
								    $FinalResponse[]=$updateData;
								}
								
							   
								    
								$count++;
							}
							fclose($handle);
						}
						
						print_r(json_encode($FinalResponse));
		            	exit();
					}

				}else{
					echo 2;
					exit();
				}
			}else{
				echo 2;
				exit();
			}
		}else{

			$userId=$this->session->userdata['user_id'];
			$getUser = $this->db->query("SELECT * FROM user WHERE user_id =$userId")->row();

			$authorizationsData=$this->input->post('AuthorizationsItem');
			if ($authorizationsData){
				foreach ($authorizationsData as $key=>$itemData){

					$attrobutesName='ladies_qty';
					if ($itemData['gender']=='Male'){
						$attrobutesName='gens_qty';
					}

					//update mesurements
					$updateData = array(
						$attrobutesName	=>$itemData['mesurement_qty'],
						'mesurement' 		=>$itemData['mesurement'],
						'remark' =>$itemData['mesurement_remark'],
						'gender' =>$itemData['gender'],
					);

					$this->db->where('id', $itemData['id']);
					$response = $this->db->update('code_measurement', $updateData);

					//Update authorization details
					$updateData = array(
						"unique_name"	=>$itemData['unique_name'],
					);

					$this->db->where('id', $itemData['authorizationId']);
					$response = $this->db->update('code_authorizations_details', $updateData);

				}
			}

			echo 1;
			exit();
		}
	}

	public function sendOtpCode(){
		$userId=$this->session->userdata['user_id'];
		$getUser =$this->db->query("SELECT * FROM user WHERE user_id =$userId")->row();
		if (empty($getUser->otp_code)){
			$digits =5;
			$otpCode=rand(pow(10, $digits-1), pow(10, $digits)-1);
			$updateData = array(
				'otp_code' =>$otpCode
			);
			$this->db->where('user_id', $userId);
			$this->db->update('user', $updateData);

			//Send SMS
			$mobile = urlencode('+919028403587');
			$username = urlencode("u6442");
			$msg_token = urlencode("8DnWEI");
			$sender_id = urlencode("SUPEDT");
			$messageBox="Dear Uttam, User Zahid wants to modify data on your system and the OTP is ".$otpCode.". Don't share if you not authorized the user. Regards Super Editors";
			$message = urlencode($messageBox);
			$api = "http://mysms.exposys.in/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile."";
			$Message = htmlspecialchars($message);
			$curl = curl_init();
			curl_setopt($curl,CURLOPT_URL,$api);
			curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
			//curl_exec($curl);

			$response = curl_exec($curl);

			echo "<pre>";
			print_r($response);
			exit();

			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
				echo "cURL Error #:" . $err;
				exit;
			}

			echo 1;
			exit();
		}else{
			echo 2;
			exit();
		}
	}

	public function authorizations(){
		if (isset($_REQUEST['otp_code'])) {
			$userId=$this->session->userdata['user_id'];
			$getUser = $this->db->query("SELECT * FROM user WHERE user_id =$userId")->row();
			if ($getUser->otp_code==$_REQUEST['otp_code']){
				$updateData = array(
					'authorize_edit_code_status' =>1
				);
				$this->db->where('user_id', $userId);
				$this->db->update('user', $updateData);

				$this->session->set_flashdata('pattern_message', 'You can edit informations now. please check ');
				if (isset($_REQUEST['page']) && $_REQUEST['page']=='Measurements'){
					redirect('CodeGeneration/Measurements');
				}else {
					redirect('CodeGeneration/Codeauthorize');
				}
			}else{
				$this->session->set_flashdata('pattern_message', 'Your OTP Code Invalid.');
				if (isset($_REQUEST['page']) && $_REQUEST['page']=='Measurements'){
					redirect('CodeGeneration/Measurements');
				}else {
					redirect('CodeGeneration/Codeauthorize');
				}
			}
		}
	}

	public function deleteAuthorizationsItem(){

		$updateData = array(
			'delete_status'=>1
		);

		$this->db->where('id', $this->input->post('authorizationsId'));
		$response = $this->db->update('code_authorizations_details', $updateData);
		if ($response){
			echo 1;
			exit();
		}
	}

	function exportCSV(){

	if (isset($_REQUEST['startForm']) && isset($_REQUEST['dataEndOFCode']) && isset($_REQUEST['prefix'])){

			$startForm=$_REQUEST['startForm'];
			$dataEndOFCode=$_REQUEST['dataEndOFCode'];
			$deleteStatus=0;
			$prefix=$_REQUEST['prefix'];
			$customer=$_REQUEST['customer'];

			$getAuthorizations = $this->db->query("SELECT * FROM code_authorizations WHERE start_from=$startForm and start_end=$dataEndOFCode and prefix='".$prefix."'")->row();
			if ($getAuthorizations) {
				$getAllAuthorizationData = $this->db->query("SELECT * FROM code_authorizations_details WHERE code_authorization_id=$getAuthorizations->id and delete_status=$deleteStatus")->result();
				if ($getAllAuthorizationData) {

					$fileName =strtolower($customer)."-". date("d-m-y") . ".csv";
					header("Content-type: text/csv");
					header("Content-Disposition: attachment; filename=$fileName");
					header("Pragma: no-cache");
					header("Expires: 0");

					$output = fopen("php://output", "w");

					$header_row = array(
						0 => 'SR NO',
						1 => 'Unique Code',
						2 => 'Unique name',
						3 => 'Gender(Gens/Ladies)',
						4 => 'Authorizations',
						5 => 'ID/Roll No',
						6 => 'Cell No',
						7 => 'Mens Tak',
						8 => 'Mens Taken',
						9 => 'Delivery By',
					);

					//write the header
					fputcsv($output, $header_row);

					// loop for insert data into CSV file
					$index = 1;
					foreach ($getAllAuthorizationData as $statementFet) {
						$wp_array = array(
							"index" => $index,
							"unique_code" => $statementFet->unique_code,
							"unique_name" => $statementFet->unique_name,
							"gender" => $statementFet->gender,
							"authorization" => $statementFet->authorization,
							"roll_no" => $statementFet->roll_no,
							"cell_no" => $statementFet->cell_no,
							"mens_tak" => $statementFet->mens_tak,
							"mens_taken" => $statementFet->mens_taken,
							"stud_name" => $statementFet->stud_name
						);
						fputcsv($output, $wp_array);
						$index++;
					}

					fclose($output);
					exit;
				}
			}
		}
	}


	function exportCsvMesurement(){

		if (isset($_REQUEST['startForm']) && isset($_REQUEST['dataEndOFCode']) && isset($_REQUEST['prefix'])){

			$startForm=$_REQUEST['startForm'];
			$dataEndOFCode=$_REQUEST['dataEndOFCode'];
			$deleteStatus=0;
			$prefix=$_REQUEST['prefix'];
			$codeGenerationItemId=$_REQUEST['itemId'];
			$customer=$_REQUEST['customer'];

			$getDataSql="SELECT code_measurement.*,code_authorizations_details.gender,code_authorizations_details.unique_name,code_authorizations_details.billing_status,code_authorizations_details.id as authorizationId FROM `code_measurement` 
					INNER JOIN code_authorizations_details
					ON code_measurement.unique_code=code_authorizations_details.unique_code
					WHERE code_measurement.code_generations_item_id='$codeGenerationItemId' and code_measurement.prefix='".$prefix."'";

			$getCodeMesurementData = $this->db->query($getDataSql)->result();

			if ($getCodeMesurementData) {

				$fileName =strtolower($customer)."-". date("d-m-y") . ".csv";
				header("Content-type: text/csv");
				header("Content-Disposition: attachment; filename=$fileName");
				header("Pragma: no-cache");
				header("Expires: 0");

				$output = fopen("php://output", "w");

				$header_row = array(
					0 => 'SR NO',
					1 => 'Unique Code',
					2 => 'Name',
					3 => 'Gender(Gens/Ladies)',
					4 => 'New Quantity',
					5 => 'Mesurement',
					6 => 'Pattern',
					7 => 'Remark'
				);

				//write the header
				fputcsv($output, $header_row);

				// loop for insert data into CSV file
				$index = 0;
				foreach ($getCodeMesurementData as $statementFet) {
					$qty=$statementFet->gens_qty;
					if ($statementFet->gender=='Male'){
						$qty=$statementFet->ladies_qty;
					}
					$wp_array = array(
						"index" => $index,
						"unique_code" => $statementFet->unique_code,
						"unique_name" => $statementFet->unique_name,
						"gender" => $statementFet->gender,
						"mesurement_qty" => $qty,
						"mesurement" => $statementFet->mesurement,
						"mesurement_pattern" => $statementFet->patterns_type,
						"mesurement_remark" => $statementFet->remark,
					);
					fputcsv($output, $wp_array);
					$index++;
				}

				// Close file
				fclose($output);
				exit;
			}
		}
	}

	function markAllQuantityUpdate(){
		$itemid = $this->security->xss_clean(htmlspecialchars(strip_tags($this->input->post('itemid'))));

		$updateData = array(
			'gens_qty' =>0
		);
		$this->db->where('mesurement','');
		$this->db->where('code_generations_item_id',$itemid);
		$updateQuantity=$this->db->update('code_measurement', $updateData);
		if ($updateQuantity){
			echo 1;
			exit();
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
