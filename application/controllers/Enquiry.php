<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Enquiry extends CI_Controller
{

	public function index()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$this
				->load
				->view('user/enquiry');
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function enquirylist()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$this
				->load
				->view('user/enquirylist');
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function quotationlist()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$this
				->load
				->view('user/quotationlist');
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function appointmentlist()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$this
				->load
				->view('user/appointment');
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function delete_enquiry_data()
	{
		$enquiryID = $_GET['enquiry_id'];
		$data = array(
			"isactive" => 0 ,
			"updated_datetime" => date('Y-m-d H:i:s') ,
			"updated_by" => $this
				->session
				->userdata['user_id']
		);
		$this
			->load
			->model('Enquiry_model');

		$response = $this
			->Enquiry_model
			->delete_enquiry_data($enquiryID,$data);

		if ($response == true)
		{
			$this->session->set_flashdata('enquiry_message', 'Enquiry Data Deleted Successfully');
			redirect('Enquiry/enquirylist');
		}
		else
		{
			echo "Insert error !";
		}

	}

	public function saveEnquiry()
	{
		$this->load->model('Enquiry_model');
		$this->db->trans_start();
	
		$postData = $this->input->post();
		
		try {
			if (isset($postData['tableData']) && is_array($postData['tableData'])) {
				foreach ($postData['tableData'] as $row) {
					$id = isset($row[23]) ? $row[23] : null;
					$data = array(
						'name' => $row[1] ?? null,
						'type' => $row[2] ?? null,
						'month' => $row[3] ?? null,
						'is_existing_customer' => $row[4] ?? null,
						'is_customer' => $row[5] ?? null,
						'credit_days' => $row[6] ?? null,
						'credit_limit' => $row[7] ?? null,
						'start_date' => $row[21] ?? null,
						'end_date' => $row[22] ?? null,
						'created_datetime'=>date('Y-m-d H:i:s')
					);
	
					$data1 = array(
						'name' => $row[14] ?? null,
						'designation' => $row[15] ?? null,
						'mobile_no' => $row[16] ?? null,
						'landline' => $row[17] ?? null,
						'email' => $row[18] ?? null,
						'dob' => $row[19] ?? null,
						'marriage_anniversary_date' => $row[20] ?? null,
					);
	
					$data2 = array(
						'address_line_1' => $row[8] ?? null,
						'country' => $row[9] ?? null,
						'state' => $row[10] ?? null,
						'city' => $row[11] ?? null,
						'street' => $row[12] ?? null,
						'pincode' => $row[13] ?? null,
					);
					$data3 = array(
						'start_date' => $row[21] ?? null,
						'end_date' => $row[22] ?? null
					);
					$enquiry_id = $this->Enquiry_model->EnquiryData($id, $data);
					if(!empty($enquiry_id))
					{
						$data1['enquiry_id'] = $enquiry_id;
						$this->Enquiry_model->ContactData($enquiry_id, $data1);
						$data2['enquiry_id'] = $enquiry_id;
					    $this->Enquiry_model->AddressData($enquiry_id, $data2);
						$data3['enquiry_id'] = $enquiry_id;
					    $this->Enquiry_model->AgentData($enquiry_id, $data3);
					}
				}
			} else {
				throw new Exception('Invalid or missing "tableData" key in the input data.');
			}
	
			$this->db->trans_complete();
	
			$response = array(
				'status' => 'success',
			);
	
			echo json_encode($response);
		} catch (Exception $e) {
			$this->db->trans_rollback();
	
			$response = array(
				'status' => 'error',
				'message' => 'Error: ' . $e->getMessage()
			);
	
			echo json_encode($response);
		}
	}
		
	public function save_enquiry_data()
	{
		
		if ($this->session->userdata['role'] == (1 || 2))
		{
			$id=$this->input->get('enquiry_id');
			if(empty($id))
			{
				$data = array(
					"name" => $this->input->post('party_name') ,
					"type" => $this->input->post('party_type') ,
					"month" => $this->input->post('enquiry_opening_month') ,
					"is_existing_customer" => $this->input->post('is_existing_customer') ,
					"created_datetime" => date('Y-m-d H:i:s') ,
					"created_by" => $this->session->userdata['user_id']
				);

				$companyname = $this->input->post('party_name');
				$companyCount = $this->db->query("SELECT * FROM enquiry WHERE isactive = 1 AND  name = '$companyname' ORDER BY enquiry_id DESC")->result();
				if(count($companyCount) > 0) {
					$this->session->set_flashdata('enquiry_message', 'Company Already Exists in the System');
					redirect('enquiry?enquiry_id=' . $enquiryid . '&#enquiry_section');
				}

				$this->load->model('Enquiry_model');

				$response = $this->Enquiry_model->save_enquiry_data($data);

				if ($response == true)
				{
					$enquiryid = $this->db->insert_id();

					$data_agentEnquiries = array(
						"user_id" => $this->session->userdata['user_id'] ,
						"enquiry_id" => $enquiryid ,
						"start_date" => date('Y-m-d'),
						"created_datetime" => date('Y-m-d H:i:s') ,
						"created_by" => $this->session->userdata['user_id']
					);

					$this->load->model('Enquiry_model');

					$this->Enquiry_model->save_enquiryagent_data($data_agentEnquiries);

					$this->session->set_flashdata('enquiry_message', 'Enquiry Data Saved Successfully');
					redirect('enquiry?enquiry_id=' . $enquiryid . '&#enquiry_section');
				}
				else
				{
					echo "Insert error !";
				}
			}else{
				$data = array(
					"name" => $this->input->post('party_name') ,
					"type" => $this->input->post('party_type') ,
					"month" => $this->input->post('enquiry_opening_month') ,
					"is_existing_customer" => $this->input->post('is_existing_customer') ,
					"updated_datetime" => date('Y-m-d H:i:s') ,
					"updated_by" => $this->session->userdata['user_id']
				);
				$this->load->model('Enquiry_model');
				$this->Enquiry_model->update_data($data,$id);
				$this->session->set_flashdata('enquiry_message', 'Enquiry Data updated Successfully');
				redirect('enquiry?enquiry_id=' . $id);
			}
		}
		else
		{
			$this->load->view('basic/login');
		}
	}

	public function save_address_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{

			$data = array(
				"enquiry_id" => $this
					->input
					->post('enquiry_id') ,
				"address_type" => $this
					->input
					->post('address_type') ,
				"address_line_1" => $this
					->input
					->post('address_line_1') ,
				"address_line_2" => $this
					->input
					->post('address_line_2') ,
				"country" => $this
					->input
					->post('country') ,
				"state" => $this
					->input
					->post('state') ,
				"city" => $this
					->input
					->post('city') ,
				"street" => $this
					->input
					->post('street') ,
				"pincode" => $this
					->input
					->post('pincode') ,
				"created_datetime" => date('Y-m-d H:i:s') ,
				"created_by" => $this
					->session
					->userdata['user_id']
			);

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->save_address_data($data);

			if ($response == true)
			{
				$enquiryid = $this
					->input
					->post('enquiry_id');

				$this
					->session
					->set_flashdata('address_message', 'Address Data Saved Successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#address_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function save_contact_data()
	{
		$this
			->load
			->model('Enquiry_model');

		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{

			$response=false;
			if (isset($_REQUEST['Contact'])){
				foreach ($_REQUEST['Contact'] as $key=>$requestSingle){

					$data = array(
						"enquiry_id" => $this->input->post('enquiry_id') ,
						"name" => $this->input->post('name') ,
						"designation" =>$this->input->post('designation') ,
						"dob" => $this->input->post('dob'),
						"marriage_anniversary_date" =>$this->input->post('marriage_anniversary_date'),
						"mobile_no" =>$requestSingle['mobile_no'],
						"landline" =>$requestSingle['landline'],
						"email" =>$requestSingle['email'],
						"created_datetime" => date('Y-m-d H:i:s') ,
						"created_by" => $this->session->userdata['user_id']
					);

					$ContactModel = $this->Enquiry_model->save_contact_data($data);
					$response=true;
				}
			}

			if ($response==true)
			{
				$enquiryid = $this
					->input
					->post('enquiry_id');

				$this
					->session
					->set_flashdata('contact_message', 'Contact Data Saved Successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#contact_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function save_owner_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{

			$this->load->model('Enquiry_model');

			$response=false;
			if (isset($_REQUEST['ContactOwner'])){
				foreach ($_REQUEST['ContactOwner'] as $key=>$requestSingle){

					$data = array(
						"enquiry_id" => $this->input->post('enquiry_id') ,
						"name" => $this->input->post('name') ,
						"dob" => $this->input->post('dob'),
						"marriage_anniversary_date" =>$this->input->post('marriage_anniversary_date'),
						"mobile_no" =>$requestSingle['mobile_no'],
						"landline" =>$requestSingle['landline'],
						"email" =>$requestSingle['email'],
						"created_datetime" => date('Y-m-d H:i:s') ,
						"created_by" => $this->session->userdata['user_id']
					);

					$ContactModel = $this->Enquiry_model->save_owner_data($data);
					$response=true;
				}
			}

			if ($response == true)
			{
				$enquiryid = $this
					->input
					->post('enquiry_id');

				$this
					->session
					->set_flashdata('owner_message', 'Owner Data Saved Successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#owner_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function save_item_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"enquiry_id" => $this
					->input
					->post('enquiry_id') ,
				"name" => $this
					->input
					->post('name') ,
				"approximate_value" => $this
					->input
					->post('approximate_value') ,
				"approximate_quantity" => $this
					->input
					->post('approximate_quantity') ,
				"created_datetime" => date('Y-m-d H:i:s') ,
				"created_by" => $this
					->session
					->userdata['user_id']
			);

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->save_item_data($data);

			if ($response == true)
			{
				$enquiryid = $this
					->input
					->post('enquiry_id');

				$this
					->session
					->set_flashdata('item_message', 'Item Data Saved Successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#item_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function save_remark_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"enquiry_id" => $this
					->input
					->post('enquiry_id') ,
				"remark" => $this
					->input
					->post('remark') ,
				"call_back_date" => $this
					->input
					->post('call_back_date') ,
				"call_back_time" => $this
					->input
					->post('call_back_time') ,
				"created_datetime" => date('Y-m-d H:i:s') ,
				"created_by" => $this
					->session
					->userdata['user_id']
			);

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->save_remark_data($data);

			if ($response == true)
			{
				$enquiryid = $this
					->input
					->post('enquiry_id');

				$this
					->session
					->set_flashdata('remark_message', 'Remark Data Saved Successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#remarks_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function save_appointment_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{

			$data = array(
				"enquiry_id" => $this
					->input
					->post('enquiry_id') ,
				"date" => $this
					->input
					->post('date') ,
				"time" => $this
					->input
					->post('time') ,
				"mail_to" => $this
					->input
					->post('mail_to') ,
				"sms_to" => $this
					->input
					->post('sms_to') ,
				"created_datetime" => date('Y-m-d H:i:s') ,
				"created_by" => $this
					->session
					->userdata['user_id']
			);

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->save_appointment_data($data);

			if ($response == true)
			{

				$aptid = $this
					->db
					->insert_id();
				$date = date_format(date_create($this
					->input
					->post('date')) , "d-m-Y");
				$time = date_format(date_create($this
					->input
					->post('time')) , "h:i a");



				//send mail --start
				//Load email library
				$this->load->library('email');

				//SMTP & mail configuration
				$config = array(
					'protocol'  => 'smtp',
					'smtp_host' => 'smtp.mailgun.org',
					'smtp_port' => 587,
					'smtp_user' => 'postmaster@erp.supereditors.in',
					'smtp_pass' => 'fb8383a7f32d11772972da4de9ee96b3-02fa25a3-27f46143',
					'mailtype'  => 'html',
					'charset'   => 'iso-8859-1'
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");


				$this
					->email
					->set_mailtype('html');

				$message = "<html>
                                <p>Your Appointment has been Scheduled on $date $time </p>
                                <p>Please <a href='" . base_url() . "Enquiry/confirm_appointment?aptid=$aptid'>Click Here</a> to Confirm.</p>
                                <br>
                                
                                <p>Thanks and Regards,</p>
                                <p>SUPEREDITORS</p>
                                <p>" . base_url() . "</p>
                            </html>";

				$this
					->email
					->from('admin@supereditors.in', 'SUPEREDITORS');
				$this
					->email
					->to($this
						->input
						->post('mail_to'));
				$this
					->email
					->cc('info@supereditors.in');
				$this
					->email
					->bcc('iambommanakavya@gmail.com',$this->session->userdata['role']);

				$this
					->email
					->subject('Appointment Scheduled');
				$this
					->email
					->message($message);

				//Send email
				if($this->email->send())
					/*echo 'sent';
					else
					echo 'fail';
					echo $this->email->print_debugger();*/
					// exit;

					//send mail --end


					$var = "Client";
				$confirmurl = base_url()."?aptid=".$aptid;
				/*$confirmurl = base_url();*/
				$dateTime = $date.' '.$time;

				//send sms -- start
				$mobile = urlencode($this->input->post('sms_to'));
				$username = urlencode("u6442");
				$msg_token = urlencode("8DnWEI");
				$sender_id = urlencode("SUPEDT");
				$message = urlencode("Dear $var, Greeting from Super Editors ! As discussed with our sales team, your appointment has been scheduled on $dateTime Please click here $confirmurl to confirm. Best Regards Super Editors, www.supereditors.in, info@supereditors.in, 02024430981/9028544114");
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
					exit;
				} /*else {
                      echo $response;
                    }*/
				//exit;
				//send sms --end


				$enquiryid = $this
					->input
					->post('enquiry_id');

				$this
					->session
					->set_flashdata('appointment_message', 'Appointment Data Saved Successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#appointment_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function save_appointment_data_inlist()
	{
		$query = $this->db->query("SELECT DISTINCT email, mobile_no, enquiry_id FROM (SELECT email, mobile_no, enquiry_id FROM owner_details WHERE isactive = 1 
                           UNION ALL
                           SELECT email, mobile_no, enquiry_id FROM contact_person WHERE isactive = 1) T");

        $communication = $query->result();
		if($communication[0]->email==$this
				->input
				->post('mail_to')){
			$enquiry_id = $communication[0]->enquiry_id;
		}
		if ($this->session->userdata['role'] == (1 || 2))
		{
			$data = array(
				"enquiry_id" =>$this
					->input
					->post('enquiry_id'),
				"name" =>$this
					->input
					->post('enquery_name'),
				"remark" =>$this
					->input
					->post('remark'),
				"date" => $this
					->input
					->post('date') ,
				"time" => $this
					->input
					->post('time') ,
				"mail_to" => $this
					->input
					->post('mail_to') ,
				"sms_to" => $this
					->input
					->post('sms_to') ,
				"created_datetime" => date('Y-m-d H:i:s') ,
				"created_by" => $this
					->session
					->userdata['user_id']
			);

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->save_appointment_data($data);

			if ($response == true)
			{

				$aptid = $this
					->db
					->insert_id();
				$date = date_format(date_create($this
					->input
					->post('date')) , "d-m-Y");
				$time = date_format(date_create($this
					->input
					->post('time')) , "h:i a");



				//send mail --start
				//Load email library
				$this->load->library('email');

				//SMTP & mail configuration
				$config = array(
					'protocol'  => 'smtp',
					'smtp_host' => 'smtp.mailgun.org',
					'smtp_port' => 587,
					'smtp_user' => 'postmaster@erp.supereditors.in',
					'smtp_pass' => 'fb8383a7f32d11772972da4de9ee96b3-02fa25a3-27f46143',
					'mailtype'  => 'html',
					'charset'   => 'iso-8859-1'
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");


				$this
					->email
					->set_mailtype('html');

				$message = "<html>
                                <p>Your Appointment has been Scheduled on $date $time </p>
                                <p>Please <a href='" . base_url() . "Enquiry/confirm_appointment?aptid=$aptid'>Click Here</a> to Confirm.</p>
                                <br>
                                
                                <p>Thanks and Regards,</p>
                                <p>SUPEREDITORS</p>
                                <p>" . base_url() . "</p>
                            </html>";

				$this
					->email
					->from('admin@supereditors.in', 'SUPEREDITORS');
				$this
					->email
					->to($this
						->input
						->post('mail_to'));
				$this
					->email
					->cc('info@supereditors.in');
				$this
					->email
					->bcc('iambommanakavya@gmail.com',$this->session->userdata['role']);

				$this
					->email
					->subject('Appointment Scheduled');
				$this
					->email
					->message($message);

				//Send email
				// if($this->email->send())
				//     /*echo 'sent';
				//     else
				//     echo 'fail';
				//     echo $this->email->print_debugger();*/
				//     // exit;

				//     //send mail --end


				//     $var = "Client";
				// $confirmurl = base_url()."?aptid=".$aptid;
				// /*$confirmurl = base_url();*/
				// $dateTime = $date.' '.$time;

				// //send sms -- start
				// $mobile = urlencode($this->input->post('sms_to'));
				// $username = urlencode("u6442");
				// $msg_token = urlencode("8DnWEI");
				// $sender_id = urlencode("SUPEDT");
				// $message = urlencode("Dear $var, Greeting from Super Editors ! As discussed with our sales team, your appointment has been scheduled on $dateTime Please click here $confirmurl to confirm. Best Regards Super Editors, www.supereditors.in, info@supereditors.in, 02024430981/9028544114");
				// $api = "http://mysms.exposys.in/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile."";
				// $Message = htmlspecialchars($message);
				// $curl = curl_init();
				// curl_setopt($curl,CURLOPT_URL,$api);
				// curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
				// //curl_exec($curl);

				// $response = curl_exec($curl);
				// $err = curl_error($curl);

				// curl_close($curl);

				// if ($err) {
				//     echo "cURL Error #:" . $err;
				//     exit;
				// } /*else {
				//       echo $response;
				//     }*/
				// //exit;
				// //send sms --end


				$this
					->session
					->set_flashdata('appointment_message', 'Appointment Data Saved Successfully');
				redirect('Enquiry/appointmentlist');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function confirm_appointment()
	{
		$data = array(
			'isaccepted' => 1
		);
		$appointmentID = $this
			->input
			->get('aptid');

		$this
			->load
			->model('Enquiry_model');

		$response = $this
			->Enquiry_model
			->confirm_appointment($appointmentID, $data);

		if ($response == true)
		{
			$this->session->set_flashdata('message', 'You have Confirmed the Appointment. Our Team will contact you soon.');
			$this
				->load
				->view('user/appointment_confirmed');
		}
		else
		{
			echo "Update error !";
		}
	}

	public function save_quotation_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{

			$enquiryid = $this
				->input
				->post('enquiry_id');

			//upload to a Folder
			$config['upload_path'] = 'assets/client_asstes/quotations';
			$config['allowed_types'] = 'jpg|png|pdf|jpeg';

			$this
				->load
				->library('upload', $config);

			if (!$this
				->upload
				->do_upload('attachment'))
			{
				$error = array(
					'error' => $this
						->upload
						->display_errors()
				);
				print_r($error);
			}
			else
			{
				$data = array(
					'upload_data' => $this
						->upload
						->data()
				);
				$fileName = $data[upload_data][file_name];

			}
			//upload to a Folder
			//send mail --start
			//Load email library
			$this->load->library('email');

			//SMTP & mail configuration
			$config = array(
				'protocol'  => 'smtp',
				'smtp_host' => 'smtp.mailgun.org',
				'smtp_port' => 587,
				'smtp_user' => 'postmaster@erp.supereditors.in',
				'smtp_pass' => 'fb8383a7f32d11772972da4de9ee96b3-02fa25a3-27f46143',
				'mailtype'  => 'html',
				'charset'   => 'iso-8859-1',
				'wordWrap' => true
			);

			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->set_newline("\r\n");
			// Recipient
			$to = $this
					->input
					->post('mail_to') . ',iambommanakavya@gmail.com';





			// Attachment file
			$file = "assets/client_asstes/quotations/" . $fileName;

			// Email body content
			$htmlContent = $this
				->input
				->post('quotation_msg');;
			$htmlContent .= "<p>Please <a href='".base_url().$file."'>Click Here</a> to see Quotaion</p>";

			$this->email->from('admin@supereditors.in', 'SUPEREDITORS');
			$this->email->to($to);
			$this->email->cc('info@supereditors.in');
			$this->email->bcc('iambommanakavya@gmail.com');

			$this->email->subject('Quotation');
			$this->email->message($htmlContent);
			$this->email->attach('https://soft.supereditors.in/assets/client_asstes/quotations/'.$fileName);
			if ($this->email->send())
			{


				$data = array(
					"enquiry_id" => $this
						->input
						->post('enquiry_id') ,
					"quotation_msg" => $this
						->input
						->post('quotation_msg') ,
					"attachment" => $fileName,
					"mail_to" => $this
						->input
						->post('mail_to') ,
					"created_datetime" => date('Y-m-d H:i:s') ,
					"created_by" => $this
						->session
						->userdata['user_id']
				);

				$this
					->load
					->model('Enquiry_model');

				$response = $this
					->Enquiry_model
					->save_quotation_data($data);

				if ($response == true)
				{
					//send mail --end
					$this
						->session
						->set_flashdata('quotation_message', 'Quotation Data Saved Successfully');
					redirect('enquiry?enquiry_id=' . $enquiryid . '&#quotation_section');

				}
				else
				{
					echo "Insert error !";
				}

			}

		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function send_wishes()
	{
		//send mail --start
		/*$wishData = $this
			->db
			->query("SELECT * FROM MDV_Wish_Data WHERE (MONTH(dob) = MONTH(CURRENT_DATE()) AND DAY(dob) = DAY(CURRENT_DATE())) OR (MONTH(marriage_anniversary_date) = MONTH(CURRENT_DATE()) AND DAY(marriage_anniversary_date) = DAY(CURRENT_DATE()))")
			->result();*/
		$wishData = $this
			->db
			->query("SELECT * FROM MDV_Wish_Data")
			->result();
		if (count($wishData) > 0)
		{

			foreach ($wishData as $getwishData)
			{
				if ($getwishData->wish == 'Happy Birthday' || $getwishData->wish == 'Happy Marriage Anniversary' || $getwishData->wish == 'Happy Birthday and Happy Marriage Anniversary'){
					$UserName = $getwishData->NAME;
					//Load email library
					$this->load->library('email');

					//SMTP & mail configuration
					$config = array(
						'protocol'  => 'smtp',
						'smtp_host' => 'smtp.mailgun.org',
						'smtp_port' => 587,
						'smtp_user' => 'postmaster@erp.supereditors.in',
						'smtp_pass' => 'fb8383a7f32d11772972da4de9ee96b3-02fa25a3-27f46143',
						'mailtype'  => 'html',
						'charset'   => 'iso-8859-1'
					);
					$this->email->initialize($config);
					$this->email->set_mailtype("html");
					$this->email->set_newline("\r\n");
					$this
						->email
						->set_mailtype('html');
					if ($getwishData->wish == 'Happy Birthday')
					{
						$message = "<html>
                                <p>Dear $UserName,</p>
                                <p>God is mighty always been connecter of good and beautiful souls! Congratulations to you on your wedding day.</p>
                                <br>
                                
                                <p>Warm Regards ,</p>
                                <p>SUPEREDITORS</p>
                                <p>" . base_url() . "</p>
                            </html>";
					}
					else if ($getwishData->wish == 'Happy Marriage Anniversary')
					{
						$message = "<html>
                                <p>Dear $UserName,</p>
                                <p>Super Editors Wishes you a very Happy B'day!!! 
                                If wisdom and experience were wealth, you were one of the richest people we ever met. People like you inspire us long after they leave. Wish you a very happy birthday.</p>
                                <br>
                                
                                <p>Warm Regards ,</p>
                                <p>SUPEREDITORS</p>
                                <p>" . base_url() . "</p>
                            </html>";
					}
					else if ($getwishData->wish == 'Happy Birthday and Happy Marriage Anniversary')
					{
						$message = "<html>
                                <p>Dear $UserName,</p>
                                <p>Super Editors Wishes you a very Happy B'day and Happy Marriage Anniversary!!! 
                                If wisdom and experience were wealth, you were one of the richest people we ever met. People like you inspire us long after they leave. Wish you a very happy birthday.</p>
                                <br>
                                
                                <p>Warm Regards ,</p>
                                <p>SUPEREDITORS</p>
                                <p>" . base_url() . "</p>
                            </html>";
					}

					$this
						->email
						->from('admin@supereditors.in', 'SUPEREDITORS');
					$this
						->email
						->to($getwishData->email);
					$this
						->email
						->cc('info@supereditors.in');
					$this
						->email
						->bcc('iambommanakavya@gmail.com');

					$this
						->email
						->subject('Wishes from SUPEREDITORS');
					$this
						->email
						->message($message);

					$this
						->email
						->send();

					//echo $this->email->print_debugger();
					//send mail --end


					//send sms -- start

					$var = "Client";


					//send sms -- start
					$mobile = urlencode($getwishData->mobile_no);
					$username = urlencode("u6442");
					$msg_token = urlencode("8DnWEI");
					$sender_id = urlencode("SUPEDT");


					if ($getwishData->wish == 'Happy Birthday')
					{
						$msg = urlencode("Dear $var , A client is need is a client indeed. We wish you will always be in need of our services. Happy Birthday. Warm Regards Super Editors www.supereditors.in info@supereditors.in 02024430981, 9028544114");
					}
					else if ($getwishData->wish == 'Happy Marriage Anniversary')
					{
						$msg = urlencode("Dear $var, Sending our warmest wishes to a wonderful couple on their special day. Hope that you have a sparkling celebration on your Anniversary. Warm Regards Super Editors www.supereditors.in, info@supereditors.in, 02024430981/9028544114");
					}
					else if ($getwishData->wish == 'Happy Birthday and Happy Marriage Anniversary')
					{
						$msg = urlencode("Dear $var , A client is need is a client indeed. We wish you will always be in need of our services. Happy Birthday. Warm Regards Super Editors www.supereditors.in info@supereditors.in 02024430981, 9028544114");
					}


					$api = "http://mysms.exposys.in/api/send_transactional_sms.php?username=".$username."&msg_token=".$msg_token."&sender_id=".$sender_id."&message=".$message."&mobile=".$mobile."";
					$Message = htmlspecialchars($msg);
					$curl = curl_init();
					curl_setopt($curl,CURLOPT_URL,$api);
					curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
					//curl_exec($curl);

					$response = curl_exec($curl);
					$err = curl_error($curl);

					curl_close($curl);

					if ($err) {
						echo "cURL Error #:" . $err;
					} /*else {
                      echo $response;
                    }*/
					//send sms --end
				}

			}
			echo "Wishes Sent";
		}
		else
		{
			echo "No Wishes";
		}

	}

	public function quotation()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$this
				->load
				->view('user/quotation');
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function save_quotation_heading_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{



			$data = array(
				"unique_id" => 'SE'.rand(1000,9999).rand(10,99),
				"to_email" => $this
					->input
					->post('to_email'),
				"company" => $this
					->input
					->post('company'),
				"heading_text" => $this
					->input
					->post('heading'),
				"address_type" => $this
					->input
					->post('address_type'),
				"enquiry_id" => $this->input->post('enquiry_id'),



				"created_datetime" => date('Y-m-d H:i:s') ,
				"created_by" => $this
					->session
					->userdata['user_id']
			);

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->save_quotation_heading_data($data);

			if ($response == true)
			{

				$enquiryid = $this->input->post('enquiry_id');
				$header_id = $this->db->insert_id();
				$this
					->session
					->set_flashdata('quotation_heading_message', 'Heading Data Saved Successfully');
				redirect(base_url().'Enquiry/quotation?enquiry_id=' . $enquiryid.'&header_id='.$header_id.'&#quotationheadingform');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function save_quotation_heading_details_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(

				"enquiry_id" => $this->input->post('enquiry_id'),
				"heading_id" => $this->input->post('heading_id'),

				"moq" => $this->input->post('moq'),
				"gst" => $this->input->post('gst'),
				"delivery_period" => $this->input->post('delivery_period'),
				"delivery_charges" => $this->input->post('delivery_charges'),
				"payment_terms" => $this->input->post('payment_terms'),
				"sampling" => $this->input->post('sampling'),
				"extra_text" => $this->input->post('extra_text'),
				"remark" => $this->input->post('remark'),

				"created_datetime" => date('Y-m-d H:i:s') ,
				"created_by" => $this
					->session
					->userdata['user_id']
			);

			$enquiryid = $this->input->post('enquiry_id');
			$headingid = $this->input->post('heading_id');

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->save_quotation_heading_details_data($data,$enquiryid,$headingid);

			if ($response == true)
			{

				$enquiryid = $this->input->post('enquiry_id');
				$headingid = $this->input->post('heading_id');

				$this
					->session
					->set_flashdata('quotation_heading_details_message', 'Data Saved Successfully');
				redirect(base_url().'Enquiry/quotation?enquiry_id=' . $enquiryid.'&header_id='.$headingid.'&#enquiry_details_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function save_quotation_item_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"item_name" => $this->input->post('name'),
				"quantity" => $this->input->post('quantity'),
				"unit" => $this->input->post('unit'),
				"rate" => $this->input->post('rate'),
				"description" => $this->input->post('description'),
				"enquiry_id" => $this->input->post('enquiry_id'),
				"heading_id" => $this->input->post('heading_id'),
				"created_datetime" => date('Y-m-d H:i:s') ,
				"created_by" => $this
					->session
					->userdata['user_id']
			);

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->save_quotation_item_data($data);

			if ($response == true)
			{
				$heading_id = $this->input->post('heading_id');
				$enquiryid = $this->input->post('enquiry_id');

				$this
					->session
					->set_flashdata('quotation_item_message', 'Item Data Saved Successfully');
				redirect(base_url().'Enquiry/quotation?enquiry_id=' . $enquiryid.'&header_id='.$heading_id.'&#quotation_item_details');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}


	public function delete_quotation_item_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$quotation_item_id = $_GET['quotation_item_id'];
			$enquiryid = $_GET['enquiry_id'];
			$heading_id = $_GET['heading_id'];

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->delete_quotation_item_data($quotation_item_id,$enquiryid);

			if ($response == true)
			{

				$this
					->session
					->set_flashdata('quotation_del_item_message', 'Deleted Successfully');
				redirect(base_url().'Enquiry/quotation?enquiry_id=' . $enquiryid.'&header_id='.$heading_id.'&#quotation_item_details');
			}
			else
			{
				echo "Delete error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}


	public function delete_quotation_address_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$quotation_address_id = $_GET['quotation_address_id'];
			$enquiryid = $_GET['enquiry_id'];

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->delete_quotation_address_data($quotation_address_id,$enquiryid);

			if ($response == true)
			{

				$this
					->session
					->set_flashdata('quotation_del_address_message', 'Deleted Successfully');
				redirect(base_url().'Enquiry/?enquiry_id=' . $enquiryid.'&#address_section');
			}
			else
			{
				echo "Delete error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function delete_quotation_contact_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$quotation_contact_id = $_GET['quotation_contact_id'];
			$enquiryid = $_GET['enquiry_id'];

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->delete_quotation_contact_data($quotation_contact_id,$enquiryid);

			if ($response == true)
			{

				$this
					->session
					->set_flashdata('quotation_del_contact_message', 'Deleted Successfully');
				redirect(base_url().'Enquiry/?enquiry_id=' . $enquiryid.'&#contact_section');
			}
			else
			{
				echo "Delete error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function delete_quotation_owner_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$quotation_owner_id = $_GET['quotation_owner_id'];
			$enquiryid = $_GET['enquiry_id'];

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->delete_quotation_owner_data($quotation_owner_id,$enquiryid);

			if ($response == true)
			{

				$this
					->session
					->set_flashdata('quotation_del_owner_message', 'Deleted Successfully');
				redirect(base_url().'Enquiry/?enquiry_id=' . $enquiryid.'&#owner_section');
			}
			else
			{
				echo "Delete error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function delete_remark_itemdetails_data(){
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$remark_itemdetails_id = $_GET['remark_itemdetails_id'];
			$enquiryid = $_GET['enquiry_id'];
			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->delete_remark_data($remark_itemdetails_id,$enquiryid);

			if ($response == true)
			{
				$this->session->set_flashdata('remark_delete_message', 'Deleted Successfully');
				if(isset($_REQUEST['type']) && $_REQUEST['type']=='List'){
					redirect(base_url() . 'Enquiry/ramarklist');
				}else {
					redirect(base_url() . 'Enquiry/?enquiry_id=' . $enquiryid . '&#remarks_section');
				}
			}
			else
			{
				echo "Delete error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}

	}


	public function ramarklist()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$this
				->load
				->view('user/remark');
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function save_remark_list_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"enquiry_id" => $this
					->input
					->post('enquiry_id') ,
				"remark" => $this
					->input
					->post('remark') ,
				"call_back_date" => $this
					->input
					->post('call_back_date') ,
				"call_back_time" => $this
					->input
					->post('call_back_time') ,
				"contact_name" => $this
					->input
					->post('contact_name') ,
				"contact_email" => $this
					->input
					->post('contact_email') ,
				"contact_phone" => $this
					->input
					->post('contact_phone') ,
				"created_datetime" => date('Y-m-d H:i:s') ,
				"created_by" => $this
					->session
					->userdata['user_id']
			);

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->save_remark_data($data);

			if ($response == true)
			{
				$this
					->session
					->set_flashdata('remark_message', 'Remark Data Saved Successfully');
				redirect('Enquiry/ramarklist');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function delete_quotation_appointment_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$quotation_appointment_id = $_GET['quotation_appointment_id'];
			$enquiryid = $_GET['enquiry_id'];

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->delete_quotation_appointment_data($quotation_appointment_id,$enquiryid);

			if ($response == true)
			{

				$this
					->session
					->set_flashdata('quotation_del_appointment_message', 'Deleted Successfully');
				redirect(base_url().'Enquiry/?enquiry_id=' . $enquiryid.'&#appointment_section');
			}
			else
			{
				echo "Delete error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function delete_quotation_itemdetails_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$quotation_itemdetails_id = $_GET['quotation_itemdetails_id'];
			$enquiryid = $_GET['enquiry_id'];

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->delete_quotation_itemdetails_data($quotation_itemdetails_id,$enquiryid);

			if ($response == true)
			{

				$this
					->session
					->set_flashdata('quotation_del_itemdetails_message', 'Deleted Successfully');
				redirect(base_url().'Enquiry/?enquiry_id=' . $enquiryid.'&#item_section');
			}
			else
			{
				echo "Delete error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function edit_address_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"address_type" => $this->input->post('address_type') ,
				"address_line_1" => $this->input->post('address_line_1') ,
				"address_line_2" => $this->input->post('address_line_2') ,
				"country" => $this->input->post('country') ,
				"state" => $this->input->post('state') ,
				"city" => $this->input->post('city') ,
				"street" => $this->input->post('street') ,
				"pincode" => $this->input->post('pincode') ,
				"updated_datetime" => date('Y-m-d H:i:s') ,
				"updated_by" => $this->session->userdata['user_id']
			);

			$addressid = $this->input->post('address_id');


			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->edit_address_data($data,$addressid);

			if ($response == true)
			{

				$enquiryid = $this->input->post('enquiry_id');

				$this
					->session
					->set_flashdata('address_update_msg', 'Updated successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#address_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function edit_contact_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"enquiry_id" => $this->input->post('enquiry_id') ,
				"name" => $this->input->post('name') ,
				"designation" => $this->input->post('designation') ,
				"mobile_no" =>$_REQUEST['Contact'][0]['mobile_no'] ,
				"landline" =>$_REQUEST['Contact'][0]['landline'],
				"email" =>$_REQUEST['Contact'][0]['email'],
				"dob" => $this->input->post('dob') ,
				"marriage_anniversary_date" => $this->input->post('marriage_anniversary_date') ,
				"updated_datetime" => date('Y-m-d H:i:s') ,
				"updated_by" => $this->session->userdata['user_id']
			);

			$contactid = $this->input->post('contact_id');

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->edit_contact_data($data,$contactid);

			if ($response == true)
			{

				$enquiryid = $this->input->post('enquiry_id');
				if (isset($_REQUEST['Contact']) && count($_REQUEST['Contact'])>1){
					unset($_REQUEST['Contact'][0]);

					foreach ($_REQUEST['Contact'] as $key=>$requestSingle){

						$data = array(
							"enquiry_id" =>$enquiryid,
							"name" => $this->input->post('name') ,
							"designation" =>$this->input->post('designation') ,
							"dob" => $this->input->post('dob'),
							"marriage_anniversary_date" =>$this->input->post('marriage_anniversary_date'),
							"mobile_no" =>$requestSingle['mobile_no'],
							"landline" =>$requestSingle['landline'],
							"email" =>$requestSingle['email'],
							"created_datetime" => date('Y-m-d H:i:s') ,
							"created_by" => $this->session->userdata['user_id']
						);

						$ContactModel = $this->Enquiry_model->save_contact_data($data);
						$response=true;
					}
				}

				$this
					->session
					->set_flashdata('contact_update_msg', 'Updated successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#contact_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

public function edit_owner_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"enquiry_id" => $this->input->post('enquiry_id') ,
				"name" => $this->input->post('name') ,
				"mobile_no" =>$_REQUEST['ContactOwner'][0]['mobile_no'],
				"landline" =>$_REQUEST['ContactOwner'][0]['landline'],
				"email" =>$_REQUEST['ContactOwner'][0]['email'],
				"dob" => $this->input->post('dob') ,
				"marriage_anniversary_date" => $this->input->post('marriage_anniversary_date') ,
				"updated_datetime" => date('Y-m-d H:i:s') ,
				"updated_by" => $this->session->userdata['user_id']
			);

			$ownerid = $this->input->post('owner_id');


			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->edit_owner_data($data,$ownerid);

			if ($response == true)
			{

				if (isset($_REQUEST['ContactOwner']) && count($_REQUEST['ContactOwner'])>1){
					unset($_REQUEST['ContactOwner'][0]);
					foreach ($_REQUEST['ContactOwner'] as $key=>$requestSingle){

						$data = array(
							"enquiry_id" => $this->input->post('enquiry_id') ,
							"name" => $this->input->post('name') ,
							"dob" => $this->input->post('dob'),
							"marriage_anniversary_date" =>$this->input->post('marriage_anniversary_date'),
							"mobile_no" =>$requestSingle['mobile_no'],
							"landline" =>$requestSingle['landline'],
							"email" =>$requestSingle['email'],
							"created_datetime" => date('Y-m-d H:i:s') ,
							"created_by" => $this->session->userdata['user_id']
						);

						$ContactModel = $this->Enquiry_model->save_owner_data($data);

					}
				}

				$enquiryid = $this->input->post('enquiry_id');

				$this
					->session
					->set_flashdata('owner_update_msg', 'Updated successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#owner_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	
	public function edit_item_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"enquiry_id" => $this->input->post('enquiry_id') ,
				"name" => $this->input->post('name') ,
				"approximate_value" => $this->input->post('approximate_value') ,
				"approximate_quantity" => $this->input->post('approximate_quantity') ,
				"updated_datetime" => date('Y-m-d H:i:s') ,
				"updated_by" => $this->session->userdata['user_id']
			);

			$itemid = $this->input->post('item_id');


			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->edit_item_data($data,$itemid);

			if ($response == true)
			{

				$enquiryid = $this->input->post('enquiry_id');

				$this
					->session
					->set_flashdata('item_update_msg', 'Updated successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#item_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function edit_remark_data(){
		//print_r($_POST);

		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{ $data = array(
			"enquiry_id" => $this
				->input
				->post('enquiry_id') ,
			"remark" => $this
				->input
				->post('remark') ,
			"call_back_date" => $this
				->input
				->post('call_back_date') ,
			"call_back_time" => $this
				->input
				->post('call_back_time') ,
			"updated_datetime" => date('Y-m-d H:i:s') ,
			"updated_by" => $this
				->session
				->userdata['user_id']
		);
			$remark_id = $this->input->post('remark_id');

			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->edit_remark_data($data,$remark_id);

			if ($response == true)
			{

				$enquiryid = $this->input->post('enquiry_id');

				$this
					->session
					->set_flashdata('remark_message', 'Updated successfully');
				if(isset($_REQUEST['type']) && $_REQUEST['type']=='list'){
					redirect(base_url() . 'Enquiry/ramarklist');
				}else {
					redirect('enquiry?enquiry_id=' . $enquiryid . '&#remarks_section');
				}
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}

	}
	public function edit_appointment_data_index()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"enquiry_id" => $this->input->post('enquiry_id') ,
				"date" => $this->input->post('date') ,
				"time" => $this->input->post('time') ,
				"mail_to" => $this->input->post('mail_to') ,
				"sms_to" => $this->input->post('sms_to') ,
				"updated_datetime" => date('Y-m-d H:i:s') ,
				"updated_by" => $this->session->userdata['user_id']
			);

			$appointmentid = $this->input->post('appointment_id');


			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->edit_appointment_data($data,$appointmentid);

			if ($response == true)
			{

				$enquiryid = $this->input->post('enquiry_id');

				$this
					->session
					->set_flashdata('appointment_message', 'Appointment Data Update Successfully');
				redirect('Enquiry/appointmentlist');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function edit_appointment_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"enquiry_id" => $this->input->post('enquiry_id') ,
				"date" => $this->input->post('date') ,
				"time" => $this->input->post('time') ,
				"mail_to" => $this->input->post('mail_to') ,
				"sms_to" => $this->input->post('sms_to') ,
				"updated_datetime" => date('Y-m-d H:i:s') ,
				"updated_by" => $this->session->userdata['user_id']
			);

			$appointmentid = $this->input->post('appointment_id');


			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->edit_appointment_data($data,$appointmentid);

			if ($response == true)
			{

				$enquiryid = $this->input->post('enquiry_id');

				$this
					->session
					->set_flashdata('appointment_update_msg', 'Updated successfully');
				redirect('enquiry?enquiry_id=' . $enquiryid . '&#appointment_section');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function edit_item_data_quotation()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			$data = array(
				"item_name" => $this->input->post('name'),
				"quantity" => $this->input->post('quantity'),
				"unit" => $this->input->post('unit'),
				"rate" => $this->input->post('rate'),
				"description" => $this->input->post('description'),
				"enquiry_id" => $this->input->post('enquiry_id'),
				"heading_id" => $this->input->post('heading_id'),
				"updated_datetime" => date('Y-m-d H:i:s') ,
				"updated_by" => $this
					->session
					->userdata['user_id']
			);
			$itemid = $this->input->post('item_id');


			$this
				->load
				->model('Enquiry_model');

			$response = $this
				->Enquiry_model
				->edit_item_data_quotation($data,$itemid);

			if ($response == true)
			{
				$heading_id = $this->input->post('heading_id');
				$enquiryid = $this->input->post('enquiry_id');

				$this
					->session
					->set_flashdata('quotation_item_message', 'Item Data Saved Successfully');
				redirect(base_url().'Enquiry/quotation?enquiry_id=' . $enquiryid.'&header_id='.$heading_id.'&#quotation_item_details');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}
	public function edit_quotation_heading()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{



			$data = array(
				"unique_id" => 'SE'.rand(1000,9999).rand(10,99),
				"to_email" => $this
					->input
					->post('to_email'),
				"company" => $this
					->input
					->post('company'),
				"heading_text" => $this
					->input
					->post('heading'),
				"address_type" => $this
					->input
					->post('address_type'),
				"enquiry_id" => $this->input->post('enquiry_id'),



				"updated_datetime" => date('Y-m-d H:i:s') ,
				"updated_by" => $this
					->session
					->userdata['user_id']
			);

			$this
				->load
				->model('Enquiry_model');
			$headingid = $this->input->post('heading_id');

			$response = $this
				->Enquiry_model
				->edit_quotation_heading($data,$headingid);

			if ($response == true)
			{

				$enquiryid = $this->input->post('enquiry_id');
				$this
					->session
					->set_flashdata('quotation_heading_message', 'Heading Data Saved Successfully');
				redirect(base_url().'Enquiry/quotation?enquiry_id=' . $enquiryid.'&header_id='.$headingid.'&#quotationheadingform');
			}
			else
			{
				echo "Insert error !";
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function sent_global_email(){
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{
			if (!empty($_POST['sent_to_email'])) {

				$this->load->library('email');
				//SMTP & mail configuration
				$config = array(
					'protocol' => 'smtp',
					'smtp_host' => 'smtp.mailgun.org',
					'smtp_port' => 587,
					'smtp_user' => 'postmaster@supereditors.in',
					'smtp_pass' => 'db96c0db1b5d97134e8ef7bf629987ae-156db0f1-549f6847',
					'mailtype' => 'html',
					'charset' => 'iso-8859-1',
					'wordWrap' => true
				);
				$this->email->initialize($config);
				$this->email->set_mailtype("html");
				$this->email->set_newline("\r\n");

				$enqueId    =$_POST['enquiry_id'];
				$headerId   =$_POST['heading_id'];
				$quation_status   =$_POST['quation_status'];

				// Email body content
				$htmlContent = $this
					->input
					->post('quotation_msg');

				$htmlContent .='<br><br><br>'.$this
						->input
						->post('signature_msg');

				$attachmentUrl='';
				if ($quation_status==1){
					$fileName=$_POST['quation_image'];
					$attachmentUrl =$_SERVER['DOCUMENT_ROOT']."/kavya/assets/upload_quations/" . $fileName."";
				}else{
					//File Attachements
					$this->load->view('GeneratePdfView');
					$html = $this->output->get_output();
					$this->load->library('pdf');
					$this->dompdf->loadHtml($html);
					$this->dompdf->setPaper('A4', 'potrait');
					$this->dompdf->render();
					$file = $this->dompdf->output();
					$pdf_name='attachements_'.$headerId;
					$file_location =$_SERVER['DOCUMENT_ROOT']."/kavya/assets/client_asstes/quotations/".$pdf_name.".pdf";
					file_put_contents($file_location, $file);
					$fileName       ='attachements_'.$headerId.'.pdf';
					$attachmentUrl='https://soft.supereditors.in/assets/client_asstes/quotations/'.$fileName;
				}

				foreach ($_POST['sent_to_email'] as $key=>$items) {

					$file = base_url() . "/GeneratePdfController?enquiry_id=40&heading_id=26";

					// Recipient
					$to =!empty($items)?$items:'iambommanakavya@gmail.com';

					$this->email->from('admin@supereditors.in', 'SUPEREDITORS');
					$this->email->to($to);
					$this->email->cc('info@supereditors.in');
					$this->email->bcc('iambommanakavya@gmail.com');
					$this->email->subject('Quotation');
					$this->email->message($htmlContent);
					$this->email->attach($attachmentUrl);

					if ($this->email->send())
					{

						$data = array(
							"enquiry_id" => $this
								->input
								->post('enquiry_id') ,
							"quotation_msg" => $this
								->input
								->post('quotation_msg') ,
							"attachment" => $fileName,
							"mail_to" =>$to,
							"created_datetime" => date('Y-m-d H:i:s') ,
							"created_by" => $this
								->session
								->userdata['user_id']
						);

						$this->load->model('Enquiry_model');

						$response = $this
							->Enquiry_model
							->save_quotation_data($data);
					}

				}

				//Updated Signature
				$updateData=array(
					'mail_sent_status'=>1,
				);
				$this->db->where('heading_id', $headerId);
				$this->db->update('quotation_heading', $updateData);

				$userId=$this->session->userdata['user_id'];

				//Updated Signature
//                $signatures=$this->input->post('signature_msg');
//                $updateSignatureData=array(
//                    'signature'=>$signatures,
//                );
//                $this->db->where('user_id', $userId);
//                $this->db->update('user', $updateSignatureData);


				$this->session->set_flashdata('quotation_email_sent_message', 'Email sent successfully');
				redirect('enquiry/quotation?enquiry_id=' . $enqueId . '&header_id='.$headerId);
			}
		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}


	public function save_uploaded_heading_data()
	{
		if ($this
				->session
				->userdata['role'] == (1 || 2))
		{

			if (isset($_FILES['uploadedAttachment'])) {
				$_FILES['file']['name'] = time() . $_FILES['uploadedAttachment']['name'];
				$_FILES['file']['type'] = $_FILES['uploadedAttachment']['type'];
				$_FILES['file']['tmp_name'] = $_FILES['uploadedAttachment']['tmp_name'];
				$_FILES['file']['error'] = $_FILES['uploadedAttachment']['error'];
				$_FILES['file']['size'] = $_FILES['uploadedAttachment']['size'];


				//upload to a Folder
				$config['upload_path'] = 'assets/upload_quations';
				$config['allowed_types'] = 'jpg|png|pdf|jpeg';

				// Load and initialize upload library
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				$fileName = $_FILES['uploadedAttachment']['name'];

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


				$data = array(
					"unique_id" => 'SE'.rand(1000,9999).rand(10,99),
					"upload_quations_image" => $fileName,
					"quation_status" =>1,
					"to_email" => '',
					"company" => $this->input->post('company'),
					"heading_text" =>'',
					"enquiry_id" => $this->input->post('enquiry_id'),
					"created_datetime" => date('Y-m-d H:i:s') ,
					"created_by" => $this->session->userdata['user_id']
				);

				$this
					->load
					->model('Enquiry_model');

				$response = $this
					->Enquiry_model
					->save_quotation_heading_data($data);

				if ($response == true)
				{

					$enquiryid = $this->input->post('enquiry_id');
					$header_id = $this->db->insert_id();
					$this
						->session
						->set_flashdata('quotation_upload_heading_message', 'Quations Uploaded Successfully');
					redirect(base_url().'Enquiry/quotation?enquiry_id=' . $enquiryid.'&header_id='.$header_id.'&#quotationheadingform');
				}
				else
				{
					echo "Insert error !";
				}

			}

		}
		else
		{
			$this
				->load
				->view('basic/login');
		}
	}

	public function getEnquiryWiseEmail()
	{
		$enquiryEmail = $this->db->query("SELECT * FROM contact_person WHERE enquiry_id='".$this->input->post('enquiryid')."'")->result();
		print_r(json_encode($enquiryEmail));
		exit();
	}
	public function getEnquiryWisePhone()
	{
		$enquiryPhone = $this->db->query("SELECT * FROM contact_person WHERE email='".$this->input->post('mailto')."'")->result();
		print_r(json_encode($enquiryPhone));
		exit();
	}

}

?>
