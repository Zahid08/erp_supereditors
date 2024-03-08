<?php
//error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Communication extends CI_Controller {



	public function index()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/choosecommunication');
	    }else{
	        $this->load->view('basic/login');
	    }
	}

	public function bulk_mail_report()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/bulk_mail_report');
	    }else{
	        $this->load->view('basic/login');
	    }
	}
		public function bulk_sms_report()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/bulk_sms_report');
	    }else{
	        $this->load->view('basic/login');
	    }
	}

	public function comm()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/communication');
	    }else{
	        $this->load->view('basic/login');
	    }
	}

	public function comm_sms()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/sms');
	    }else{
	        $this->load->view('basic/login');
	    }
	}


		 public function choose_communication_data()
    {
        if ($this
            ->session
            ->userdata['role'] == (1 || 2))
        {


            $all_agents = $this->input->post('all_agents');
            $all_enquiry = $this->input->post('all_enquiry');
            $all_customers = $this->input->post('all_customers');

          redirect(base_url().'Communication/comm?allagents='.$all_agents.'&allenquiry='.$all_enquiry.'&allcus'.$all_customers);


        }
        else
        {
            $this
                ->load
                ->view('basic/login');
        }
    }

     public function choose_sms_data()
    {
        if ($this
            ->session
            ->userdata['role'] == (1 || 2))
        {


            $all_agents = $this->input->post('all_agents');
            $all_enquiry = $this->input->post('all_enquiry');
            $all_customers = $this->input->post('all_customers');
            
         
            if(!empty($_REQUEST['all_agents']) || !empty($_REQUEST['all_enquiry']) || !empty($_REQUEST['all_customers'])){
            redirect(base_url().'Communication/comm_sms?allagents='.$all_agents.'&allenquiry='.$all_enquiry.'&allcus'.$all_customers);
            }else{
              $_SESSION['communication_message'] ='Please check at least one';
              redirect(base_url().'Communication/sms');
            }


        }
        else
        {
            $this
                ->load
                ->view('basic/login');
        }
    }

// 	 public function save_communication_data()
//     {
//         if ($this
//             ->session
//             ->userdata['role'] == (1 || 2))
//         {


//             $all_agents = $this->input->post('all_agents');
//             $all_enquiry = $this->input->post('all_enquiry');
//             $all_customers = $this->input->post('all_customers');
//             $addon_emails = $this->input->post('addon_emails');
//             $subject = $this->input->post('subject');
//             $mail_content = $this->input->post('mail_content');
//             $fromemail = $this->input->post('from_email');
//             $user_id = $_SESSION['user_id'];
//             $created_datetime = date("Y-m-d H:i:s");

//             //upload to a Folder
//             $config['upload_path'] = 'assets/client_asstes/communications';
//             $config['allowed_types'] = 'jpg|png|pdf|jpeg';

//             $this->load->library('upload', $config);
            
            
//             if (!$this->upload->do_upload('attachment'))
//             {
//                 $error = array(
//                     'error' => $this->upload->display_errors()
//                 );
//                 print_r($error);
//             }
//             else
//             {
//                 $data = array(
//                     'upload_data' => $this->upload->data()
//                 );
//                 $fileName = $data['upload_data']['file_name'];
//             }
//             //end of upload to a Folder


//             if($_POST['select_all'] == 'All'){

//             if(!empty($all_agents)){
//                 $AllAgents = $this->db->query("SELECT email FROM user WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL ORDER BY user_id ASC")->result();

//                 foreach($AllAgents as $getAllAgents){
//                     $emailID = $getAllAgents->email;

//                     $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$emailID','$created_datetime','$user_id')");
//                     $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$emailID')");
//                 }
//             }

//             if(!empty($all_enquiry)){
//                 $AllEnquiry = $this->db->query("SELECT email FROM contact_person WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL 
//                                               UNION ALL
//                                               SELECT email FROM owner_details WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL 
//                                                 ")->result();

//                 foreach($AllEnquiry as $getAllEnquiry){
//                     $emailID = $getAllEnquiry->email;
//                     $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$emailID','$created_datetime','$user_id')");
//                     $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$emailID')");
//                 }
//             }

//             }else{

//                 if(!empty($all_agents)){
//                 $AllAgents = $this->db->query("SELECT email FROM user WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL ORDER BY user_id ASC")->result();
//                 $totalAgentCount = count($AllAgents);
//                 for($i = 0;$i <= $totalAgentCount;$i++){
//                     if($_POST['email_select_'.$i]){
//                     $emailID = $_POST['email_select_'.$i];
//                     $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$emailID','$created_datetime','$user_id')");
//                     $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$emailID')");
//                     }
//                 }
//             }



//                 if(!empty($all_enquiry)){
//                 $AllEnquiry = $this->db->query("SELECT email FROM contact_person WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL 
//                                               UNION ALL
//                                               SELECT email FROM owner_details WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL 
//                                                 ")->result();

//                 $totalEnquiryCount = count($AllEnquiry);
//                 for($i = 0;$i <= $totalEnquiryCount;$i++){
//                     if($_POST['email_select_'.$i]){
//                     $emailID = $_POST['email_select_'.$i];
//                     $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$emailID','$created_datetime','$user_id')");
//                     $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$emailID')");
//                     }
//                 }
//             }
//             }

//             $otherEmails = explode (",", $addon_emails);
//             $n = sizeof($otherEmails);
//             for($i=0;$i<=$n;$i++){
//                 $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$otherEmails[$i]','$created_datetime','$user_id')");
//                 $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$otherEmails[$i]')");
//             }



//             $mail_to_query = "SELECT DISTINCT email FROM temp_emails";

//             $data = array(
//                 "mail_to_query" => $mail_to_query,
//                 "addon_mails" => $addon_emails,
//                 "from_email" => $fromemail,
//                 "mail_subject" => $subject,
//                 "mail_content" => $mail_content,
//                 "attachment" => $fileName,
//                 "status" => 'Pending',
//                 "offset" => 0,
//                 "created_datetime" => date('Y-m-d H:i:s') ,
//                 "created_by" => $this->session->userdata['user_id']
//                 );



//             $this
//                 ->load
//                 ->model('Communication_model');

//             $response = $this
//                 ->Communication_model
//                 ->save_communication_data($data);

//             if ($response == true)
//             {


//                 $this
//                     ->session
//                     ->set_flashdata('communication_message', 'Mails are Added to Queue');
//                 redirect(base_url().'Communication');
//             }
//             else
//             {
//                 echo "Insert error !";
//             }
//         }
//         else
//         {
//             $this
//                 ->load
//                 ->view('basic/login');
//         }
//     }


 public function save_communication_data()
    {
        if ($this
                ->session
                ->userdata['role'] == (1 || 2))
        {


            $all_agents = $this->input->post('all_agents');
            $all_enquiry = $this->input->post('all_enquiry');
            $all_customers = $this->input->post('all_customers');
            $addon_emails = $this->input->post('addon_emails');
            $subject = $this->input->post('subject');
            $mail_content = $this->input->post('mail_content');
            $fromemail = $this->input->post('from_email');
            $user_id = $_SESSION['user_id'];
            $created_datetime = date("Y-m-d H:i:s");

            //upload to a Folder
            
             $config['upload_path'] = 'assets/client_asstes/communications';
            $config['allowed_types'] = 'jpg|png|pdf|jpeg|gif|docx|doc';
            $this->load->library('upload', $config);
               

            $files=isset($_FILES['Images'])?$_FILES['Images']:'';
             $images = array();
             if($files){
            foreach ($files['name'] as $key => $image) {
            
                $_FILES['images[]']['name']= $files['name'][$key]['attachment'];
                $_FILES['images[]']['type']= $files['type'][$key]['attachment'];
                $_FILES['images[]']['tmp_name']= $files['tmp_name'][$key]['attachment'];
                $_FILES['images[]']['error']= $files['error'][$key]['attachment'];
                $_FILES['images[]']['size']= $files['size'][$key]['attachment'];
        
               
                  $fileName =$files['name'][$key]['attachment'];
        
              
        
                $config['file_name'] = $fileName;
        
                $this->upload->initialize($config);
        
      
                if ($this->upload->do_upload('images[]')) {
                     $images[] =$this->upload->data()['file_name'];
                } else {
                    echo "Not upload";
                }
            }
             }
             
            // print_r($images);exit();
            
        //   $fileName='';
        //   if(isset($_FILES['attachment']['name']) && $_FILES['attachment']['name']){

        //         if (!$this->upload->do_upload('attachment'))
        //         {
        //             $error = array(
        //                 'error' => $this->upload->display_errors()
        //             );
        //             print_r($error['error']);
        //             exit();
        //         }
        //         else
        //         {
        //             $data = array(
        //                 'upload_data' => $this->upload->data()
        //             );
        //             $fileName = $data['upload_data']['file_name'];
        //         }
        //   }
          
          
            if(isset($_POST['select_all']) && $_POST['select_all'] == 'All'){

                if(!empty($all_agents)){
                    $AllAgents = $this->db->query("SELECT email FROM user WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL ORDER BY user_id ASC")->result();

                    foreach($AllAgents as $getAllAgents){
                        $emailID = $getAllAgents->email;

                        $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$emailID','$created_datetime','$user_id')");
                        $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$emailID')");
                        self::sendEmail($mail_content,$images,$emailID,'supereditors',$fromemail,$subject);
                    }
                }

                if(!empty($all_enquiry)){
                    $AllEnquiry = $this->db->query("SELECT email FROM contact_person WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL 
                                               UNION ALL
                                               SELECT email FROM owner_details WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL 
                                                ")->result();

                    foreach($AllEnquiry as $getAllEnquiry){
                        $emailID = $getAllEnquiry->email;
                        $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$emailID','$created_datetime','$user_id')");
                        $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$emailID')");
                        self::sendEmail($mail_content,$images,$emailID,'supereditors',$fromemail,$subject);
                    }
                }

            }else{

                if(!empty($all_agents)){
                    $AllAgents = $this->db->query("SELECT email FROM user WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL ORDER BY user_id ASC")->result();
                    $totalAgentCount = count($AllAgents);
                    for($i = 0;$i <= $totalAgentCount;$i++){
                         if(isset($_POST['email_select_'.$i]) && !empty($_POST['email_select_'.$i])){
                            $emailID = $_POST['email_select_'.$i];
                            $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$emailID','$created_datetime','$user_id')");
                            $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$emailID')");
                            self::sendEmail($mail_content,$images,$emailID,'supereditors',$fromemail,$subject);
                        }
                    }
                }



                if(!empty($all_enquiry)){
                    $AllEnquiry = $this->db->query("SELECT email FROM contact_person WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL 
                                               UNION ALL
                                               SELECT email FROM owner_details WHERE isactive = 1 AND unsubscribed = 0 AND email IS NOT NULL 
                                                ")->result();

                    $totalEnquiryCount = count($AllEnquiry);
                    for($i = 0;$i <= $totalEnquiryCount;$i++){
                      
                        if(isset($_POST['email_select_'.$i]) && !empty($_POST['email_select_'.$i])){
                            $emailID = $_POST['email_select_'.$i];
                            $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$emailID','$created_datetime','$user_id')");
                            $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$emailID')");
                            self::sendEmail($mail_content,$images,$emailID,'supereditors',$fromemail,$subject);
                        }
                    }
                }
            }

            $otherEmails = explode (",", $addon_emails);
            $n = sizeof($otherEmails);
            for($i=0;$i<=$n;$i++){
           	 if(isset($otherEmails[$i]) && !empty($otherEmails[$i])){
	                $this->db->query("INSERT INTO `bulk_mail_report` (`subject`,`from_email`,`email`,`created_datetime`,`created_by`) VALUES ('$subject','$fromemail','$otherEmails[$i]','$created_datetime','$user_id')");
	                $this->db->query("INSERT INTO `temp_emails` (`email`) VALUES ('$otherEmails[$i]')");
	                self::sendEmail($mail_content,$images,$otherEmails[$i],'supereditors',$fromemail,$subject);
                }
            }



            $mail_to_query = "SELECT DISTINCT email FROM temp_emails";

            $data = array(
                "mail_to_query" => $mail_to_query,
                "addon_mails" => $addon_emails,
                "from_email" => $fromemail,
                "mail_subject" => $subject,
                "mail_content" => $mail_content,
                "attachment" =>($images)?$images[0]:'',
                "status" => 'Pending',
                "offset" =>2,
                "created_datetime" => date('Y-m-d H:i:s') ,
                "created_by" => $this->session->userdata['user_id']
            );



            $this
                ->load
                ->model('Communication_model');

            $response = $this
                ->Communication_model
                ->save_communication_data($data);

            if ($response == true)
            {
               
                exit();
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
    
    
    public function sendEmail($htmlContentNew,$fileName,$toEmail,$from_email_name,$from_email,$subject)
    {
        $this->load->model('Email_Config_model');

        // Email body content
        $htmlContent = $htmlContentNew;
        
        //Load email library
        $this->load->library('email');


        //SMTP & mail configuration
       $config = $this
			->Email_Config_model
			->getConfig($_POST['from_email']);
			
		
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");

        if($fileName){
            foreach($fileName as $key=>$item){     
                $attachemnt=base_url()."assets/client_asstes/communications/".$item;
                $this->email->attach($attachemnt);
            }
        }
  
        // Recipient
        //$to ='aiubzahid@gmail.com';
        $to =$toEmail;
        
         $mailFrom='admin@supereditors.in';
        if($_POST['from_email']=='marketing'){
          $mailFrom='marketing@supereditors.in';
        }elseif($_POST['from_email']=='info'){
            $mailFrom='info@supereditors.in';
        }
    
       // $this->email->from($from_email, $from_email_name);
        $this->email->from($mailFrom);
        $this->email->to($to);
        $this->email->cc('info@supereditors.in');
        $this->email->bcc('iambommanakavya@gmail.com');
        $this->email->subject($subject);
        $this->email->message($htmlContent);
     
    //   print_r($this->email->print_debugger());
    //   exit();
      
        if ($this->email->send())
        {
         echo "Email Sent to ".$toEmail.' | ';
        }else{
           echo "Email Not Sent to".$toEmail;

        }
    }


    public function save_sms_data()
    {
        if ($this
            ->session
            ->userdata['role'] == (1 || 2))
        {


            $all_agents = $this->input->post('all_agents');
            $all_enquiry = $this->input->post('all_enquiry');
            $all_customers = $this->input->post('all_customers');
            $addon_mobile = $this->input->post('addon_mob');
            $template_code = $this->input->post('sms_template');
            $template_string = $this->input->post('template_string');
            $user_id = $_SESSION['user_id'];
            $created_datetime = date("Y-m-d H:i:s");


            if(isset($_POST['select_all']) && ($_POST['select_all'] == 'All')){

            if(!empty($all_agents)){
                $AllAgents = $this->db->query("SELECT mobile  FROM user WHERE isactive = 1  ORDER BY user_id ASC")->result();

                foreach($AllAgents as $getAllAgents){
                    $mobile = $getAllAgents->mobile;
                    $phone=preg_replace('/[^\dxX]/', '', $mobile);
                    if(strlen($phone)==10 || strlen($phone)==12){
                        self::sendSms($phone,$template_string);
                    }
                    $this->db->query("INSERT INTO `bulk_sms_report` (`template_code`,`template_string`,`mobile`,`created_datetime`,`created_by`) VALUES ('$template_code','$template_string','$mobile','$created_datetime','$user_id')");
                    $this->db->query("INSERT INTO `temp_mobile` (`mobile`) VALUES ('$mobile')");
                }
            }

            if(!empty($all_enquiry)){
                $AllEnquiry = $this->db->query("SELECT mobile_no as mobile FROM contact_person WHERE isactive = 1 
                                               UNION ALL
                                               SELECT mobile_no as mobile FROM owner_details WHERE isactive = 1
                                                ")->result();

                foreach($AllEnquiry as $getAllEnquiry){
                    $mobile = $getAllEnquiry->mobile;
                    $phone=preg_replace('/[^\dxX]/', '', $mobile);
                    if(strlen($phone)==10 || strlen($phone)==12){
                        self::sendSms($phone,$template_string);
                    }
                    $this->db->query("INSERT INTO `bulk_sms_report` (`template_code`,`template_string`,`mobile`,`created_datetime`,`created_by`) VALUES ('$template_code','$template_string','$mobile','$created_datetime','$user_id')");
                    $this->db->query("INSERT INTO `temp_mobile` (`mobile`) VALUES ('$mobile')");
                }
            }

            }else{
                
                    if(!empty($all_agents)){
                    $AllAgents = $this->db->query("SELECT mobile FROM user WHERE isactive = 1 ORDER BY user_id ASC")->result();
                    $totalAgentCount = count($AllAgents);
                    for($i = 0;$i <= $totalAgentCount;$i++){
                        if(isset($_POST['mobile_select_'.$i])){
                                if($_POST['mobile_select_'.$i]){
                                $mobile = $_POST['mobile_select_'.$i];
                                $phone=preg_replace('/[^\dxX]/', '', $mobile);
                                if(strlen($phone)==10 || strlen($phone)==12){
                                    self::sendSms($phone,$template_string);
                                }
                                $this->db->query("INSERT INTO `bulk_sms_report` (`template_code`,`template_string`,`mobile`,`created_datetime`,`created_by`) VALUES ('$template_code','$template_string','$mobile','$created_datetime','$user_id')");
                                $this->db->query("INSERT INTO `temp_mobile` (`mobile`) VALUES ('$mobile')");
                                }
                        }
                    }
                }



                if(!empty($all_enquiry)){
                     $AllEnquiry = $this->db->query("SELECT mobile_no as mobile FROM contact_person WHERE isactive = 1 
                                               UNION ALL
                                               SELECT mobile_no as mobile FROM owner_details WHERE isactive = 1 
                                                ")->result();

                    $totalEnquiryCount = count($AllEnquiry);
                    for($i = 0;$i <= $totalEnquiryCount;$i++){
                           if(isset($_POST['mobile_select_'.$i])){
                        if($_POST['mobile_select_'.$i]){
                                $mobile = $_POST['mobile_select_'.$i];
                                $phone=preg_replace('/[^\dxX]/', '', $mobile);
                                if(strlen($phone)==10 || strlen($phone)==12){
                                    self::sendSms($phone,$template_string);
                                }
                                $this->db->query("INSERT INTO `bulk_sms_report` (`template_code`,`template_string`,`mobile`,`created_datetime`,`created_by`) VALUES ('$template_code','$template_string','$mobile','$created_datetime','$user_id')");
                                $this->db->query("INSERT INTO `temp_mobile` (`mobile`) VALUES ('$mobile')");
                                }
                           }
                    }
               }
            }

            $otherMobile = explode (",", $addon_mobile);
            $n = sizeof($otherMobile);
            for($i=0;$i<=$n;$i++){
                $phone=preg_replace('/[^\dxX]/', '', $otherMobile[$i]);
                if(strlen($phone)==10 || strlen($phone)==12){
                    self::sendSms($phone,$template_string);
                }
                $this->db->query("INSERT INTO `bulk_sms_report` (`template_code`,`template_string`,`mobile`,`created_datetime`,`created_by`) VALUES ('$template_code','$template_string','$otherMobile[$i]','$created_datetime','$user_id')");
                $this->db->query("INSERT INTO `temp_mobile` (`mobile`) VALUES ('$otherMobile[$i]')");
            }



            $mail_to_query = "SELECT DISTINCT mobile FROM temp_mobile";

            $data = array(
                "sms_to_query" => $mail_to_query,
                "addon_sms" => $addon_mobile,
                "sms_template" => $template_code,
                "template_string" => $template_string,
                "status" => 'Pending',
                "offset" => 0,
                "created_datetime" => date('Y-m-d H:i:s') ,
                "created_by" => $this->session->userdata['user_id']
                );



            $this
                ->load
                ->model('Communication_model');

            $response = $this
                ->Communication_model
                ->save_sms_communication_data($data);

            if ($response == true)
            {

            $_SESSION['communication_message'] ='SMS Sent Successfully';

                redirect(base_url().'Communication/sms');
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

    public function sendSms($phone,$template_string){
        //send sms -- start
        $mobile = urlencode($phone);
        $username = urlencode("u6442");
        $msg_token = urlencode("8DnWEI");
        $sender_id = urlencode("SUPEDT");
        $message = urlencode($template_string);
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
        }
    }

    public function mail_trigger()
    {
        if (1 == 1)
        {
            $mailRecord = $this->db->query("SELECT * FROM `communication` c INNER JOIN client_emails ce ON ce.client_email_id = c.from_email where track = 0 ORDER BY communication_id ASC LIMIT 1")->result();



            if(count($mailRecord) >= 1 ){
                foreach($mailRecord as $getmailRecord){
                $offset = $getmailRecord->offset;
                $subject = $getmailRecord->mail_subject;
                $fileName = $getmailRecord->attachment;
                $htmlContent = $getmailRecord->mail_content;
                $from_email = $getmailRecord->email;
                $from_email_name = $getmailRecord->email_name;
            }
            }else{
                echo "No active mails";
                exit;
            }
            
                 // Attachment file
                        $file = base_url()."assets/client_asstes/communications/" . $fileName;

                        
                // Email body content
                        $htmlContent = $htmlContent;
                        $htmlContent .= "<br><p>Please <a href='".$file."'>Click Here</a><p>";





            $allEmails = $this->db->query("SELECT * FROM `temp_emails` WHERE email <> '' ORDER BY id ASC LIMIT $offset,100")->result();
                if(count($allEmails) >= 1){
                    foreach($allEmails as $getAllEmails){
                    $emailID = $getAllEmails->email;


                    //send mail --start
                    //Load email library
                        $this->load->library('email');
 
                       //SMTP & mail configuration
                        $this->load->model('Email_Config_model');
                        $config = $this->Email_Config_model->getConfig('info');
                        

                        $this->email->initialize($config);
                        $this->email->set_mailtype("html");
                        $this->email->set_newline("\r\n");

                        // Recipient
                        $to = $emailID;





                   
                            $this->email->from($from_email, $from_email_name);
                            $this->email->to($to);
                            $this->email->cc('info@supereditors.in');
                            $this->email->bcc('iambommanakavya@gmail.com');

                            $this->email->subject($subject);
                            $this->email->message($htmlContent);
                            /* $this->email->attach('https://soft.supereditors.in/assets/client_asstes/communications/'.$fileName);*/



                        }
                        

             if ($this->email->send())
            {
                $communicationID = $getmailRecord->communication_id;
                $data = array(
                    "offset" => $offset + 100 ,
                    "status" => 1,
                    "updated_datetime" => date('Y-m-d H:i:s') ,
                    "updated_by" => $this->session->userdata['user_id']
                );

                $this->load->model('Communication_model');

                $response = $this
                    ->Communication_model
                    ->update_communication_data($data,$communicationID);

                if ($response == true)
                {
                    //send mail --end
                    echo "Mails sent and offset:$offset";
                    exit;

                }
                else
                {
                    echo "Insert error !";
                    exit;
                }

            }
                }else{

                    $communicationID = $getmailRecord->communication_id;
                    $data = array(
                    "track" => 1 ,
                    "status" => 2,
                    "updated_datetime" => date('Y-m-d H:i:s') ,
                    "updated_by" => $this->session->userdata['user_id']
                );
                   $this->db->set($data);
                    $this->db->where('communication_id',$communicationID);
                    $UpdateCommunication = $this->db->update('communication');

                    $this->db->query("TRUNCATE TABLE `temp_emails`");

                    echo "No mail IDs to send mails";
                }



        }
        else
        {
            $this
                ->load
                ->view('basic/login');
        }
    }


     public function sms_trigger()
    {
        if (1 == 1)
        {
            $smsRecord = $this->db->query("SELECT * FROM `sms_communication` where track = 0 ORDER BY sms_communication_id ASC LIMIT 1")->result();

            if(count($smsRecord) >= 1 ){
                foreach($smsRecord as $getsmsRecord){
                $offset = $getsmsRecord->offset;
                $sms_template = $getsmsRecord->sms_template;
                $template_string = $getsmsRecord->template_string;
            }
            }else{
                echo "No active Mobile #";
                exit;
            }



            $allSms = $this->db->query("SELECT * FROM `temp_mobile` WHERE mobile <> '' ORDER BY id ASC LIMIT $offset,2000")->result();
                if(count($allSms) >= 1){
                    foreach($allSms as $allgetSms){
                    $mobile = $allgetSms->mobile;


                    //send sms -- start
        	        $username = urlencode("u6442");
                    $msg_token = urlencode("8DnWEI");
                    $sender_id = urlencode("SUPEDT");
                    $message = urlencode(trim($template_string));
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
                    }
                    exit;*/
                    //send sms --end
                    }
                $smscommunicationID = $getsmsRecord->sms_communication_id;
                $data = array(
                    "offset" => $offset + 2000 ,
                    "status" => 1,
                    "updated_datetime" => date('Y-m-d H:i:s') ,
                    "updated_by" => $this->session->userdata['user_id']
                );

                $this->load->model('Communication_model');

                $response = $this
                    ->Communication_model
                    ->update_sms_communication_data($data,$smscommunicationID);

                if ($response == true)
                {
                    //send mail --end
                    echo "SMS sent and offset:$offset";
                    exit;

                }
                else
                {
                    echo "Insert error !";
                    exit;
                }



                }else{

                    $smscommunicationID = $getsmsRecord->sms_communication_id;
                    $data = array(
                    "track" => 1 ,
                    "status" => 2,
                    "updated_datetime" => date('Y-m-d H:i:s') ,
                    "updated_by" => $this->session->userdata['user_id']
                );
                   $this->db->set($data);
                    $this->db->where('sms_communication_id',$smscommunicationID);
                    $UpdateCommunication = $this->db->update('sms_communication');

                    $this->db->query("TRUNCATE TABLE `temp_mobile`");

                    echo "No mobile #  to send sms";
                }



        }
        else
        {
            $this
                ->load
                ->view('basic/login');
        }
    }

    public function sms()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/choose_sms');
	    }else{
	        $this->load->view('basic/login');
	    }
	}

	public function sms_status(){
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/sms_status');
	    }else{
	        $this->load->view('basic/login');
	    }
	}



    public function mail_status()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/mail_status');
	    }else{
	        $this->load->view('basic/login');
	    }
	}
	public function whatsapp()
	{
	    if($this->session->userdata['role'] == (1 || 2) ){
	        $this->load->view('user/whatsapp');
	    }else{
	        $this->load->view('basic/login');
	    }
	}

	public function ajaxCall_getTemplateString()
	{
	    $templateCode  = $this->input->post('sms_template');
	    $getTemplateString = $this->db->query("SELECT * FROM sms_templates WHERE template_code = '$templateCode' ")->result();
	    foreach($getTemplateString as $getTemplateStringValue){
	        $templateString = $getTemplateStringValue->template_string;
	    }

	    echo $templateString;
	}

}

?>
