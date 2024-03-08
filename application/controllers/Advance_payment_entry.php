<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Advance_payment_entry extends CI_Controller {

    public function advanceBillPay()
    {
        if($this->session->userdata['role'] == (1 || 2) ){
            $this->load->view('user/advance_bill_payment_entry');
        }else{
            $this->load->view('basic/login');
        }
    }

    public function index()
    {
        if($this->session->userdata['role'] == (1 || 2) ){
            $this->load->view('user/advance_payment_entry');
        }else{
            $this->load->view('basic/login');
        }
    }

    function advance_payment_entry_edit(){
        $this->load->view('user/advance_payment_entry_edit');
    }

    public function generatedAdvancePdf(){
        $this->load->view('AdvancePaymentReportPdf');
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream("AdvancePaymentReportPdf.pdf", array("Attachment"=>0)); // Output the generated PDF (1 = download and 0 = preview)
    }
    public function generatedAdvanceBillPdf(){
        $this->load->view('AdvancePaymentReportPdfBill');
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream("AdvancePaymentReportPdf.pdf", array("Attachment"=>0)); // Output the generated PDF (1 = download and 0 = preview)
    }
    public function save_advance_payment(){
        $this->load->model('Advance_Payment_model');
            $max = $this->Advance_Payment_model->get_voucher_maxid();
            $maxid = $max+1;
            $voucher_no = str_pad($maxid, 5, '0', STR_PAD_LEFT);

            $supID =  $this->input->post('party_name');
               $supplierDetailsValue = $this->db->query("SELECT * FROM supplier s INNER JOIN 
               supplier_contact_details sd ON sd.supplier_id = s.supplier_id
               WHERE s.is_active = 1 and s.supplier_id = $supID")->row();



      $data=array( "voucher_no"=>$voucher_no,
                    "company_name" => $this->input->post('company_name'),
                       "payment_date"=>$this->input->post('payment_date'),
                       "supplier_id" => $this->input->post('party_name'),
                     "amount_paid"=>$this->input->post('amount_paid'),
                     "amount_adjusted"=>$this->input->post('amount_adjusted'),
                       "amount_paid_by" => $this->input->post('amount_paid_by'),
                       "payment_mode" => $this->input->post('payment_mode'),
                       "cheque_no" => $this->input->post('cheque_no'),
                       "from_bank" => $this->input->post('from_bank'),
                       "to_bank" => $this->input->post('to_bank'),
                       "is_active"=>1,
                       "created_by" =>  $this->session->userdata['user_id'],
                 "created_date" => date("Y-m-d"));


            $response=$this->Advance_Payment_model->save_payment_data($data);
            $this->session->set_flashdata('advance_payment_entry', 'Data Saved Successfully');
 
            if($response==true){
                print_r(json_encode($data));
                exit();
//              //Load email library
//                        $this->load->library('email');
//
//                //SMTP & mail configuration
//                        $config = array(
//                            'protocol'  => 'smtp',
//                            'smtp_host' => 'smtp.mailgun.org',
//                            'smtp_port' => 587,
//                            'smtp_user' => 'postmaster@supereditors.in',
//                            'smtp_pass' => 'db96c0db1b5d97134e8ef7bf629987ae-156db0f1-549f6847',
//                            'mailtype'  => 'html',
//                            'charset'   => 'iso-8859-1',
//                            'wordWrap' => true
//                        );
//
//                        $this->email->initialize($config);
//                        $this->email->set_mailtype("html");
//                        $this->email->set_newline("\r\n");
//
//                        // Recipient
//                        $to = $supplierDetailsValue->email;
//
//
//                        $url = base_url()."Advance_payment_entry/generatedAdvancePdf?vc=$voucher_no";
//                        // Email body content
//                        $htmlContent = "<p>Dear ".$supplierDetailsValue->supplier_name.",</p>
//                        <p>Voucher Number $voucher_no has been created against Advance payment of ".$this->input->post('amount_paid')." Amount.</p>
//                        <p><a href='$url'>Click Here</a> to view payment details.</p>
//                        <p>Thanks & Regards<br>
//                        ".$this->input->post('company_name').". </p>";
//
//                            $this->email->from("info@supereditors.in", $this->input->post('company_name'));
//                            $this->email->to($to);
//                            $this->email->cc('info@supereditors.in');
//                            $this->email->bcc('iambommanakavya@gmail.com','keshriedutech@gmail.com');
//
//                            $this->email->subject("Advance Payment Created");
//                            $this->email->message($htmlContent);
//                            $this->email->send();
//                  $this->session->set_flashdata('advance_payment_entry', 'Data Saved Successfully');
//                  redirect('Advance_payment_entry');
            }
            else{
                    echo "Insert error !";
            }

    }

    public function save_advance_payment_update(){
        $this->load->model('Advance_Payment_model');
        $data=array( 
        "company_name" => $this->input->post('company_name'),
        "payment_date"=>$this->input->post('payment_date'),
        "supplier_id" => $this->input->post('party_name'),
        "amount_paid"=>$this->input->post('amount_paid'),
        "amount_adjusted"=>$this->input->post('amount_adjusted'),
        "amount_paid_by" => $this->input->post('amount_paid_by'),
        "payment_mode" => $this->input->post('payment_mode'),
        "cheque_no" => $this->input->post('cheque_no'),
        "from_bank" => $this->input->post('from_bank'),
        "to_bank" => $this->input->post('to_bank'),
        "is_active"=>1,
        "created_by" =>  $this->session->userdata['user_id'],
        "created_date" => date("Y-m-d"));

        $response=$this->Advance_Payment_model->save_payment_data_update($data,$this->input->post('advance_payment_entry_id'));
        $this->session->set_flashdata('advance_payment_entry', 'Data Updated Successfully');
        redirect('Advance_payment_entry/advanceBillPay');

    }

    function sendsms(){

        $voucher_no         =$_REQUEST['voucher_no'];
        $partyName          =$_REQUEST['partyName'];
        $amount_paid        =$_REQUEST['amount_paid'];
        $company_name       =$_REQUEST['company_name'];
        $partyId            =$_REQUEST['partyId'];

        $supplierDetailsValue = $this->db->query("SELECT * FROM supplier s INNER JOIN 
               supplier_contact_details sd ON sd.supplier_id = s.supplier_id
               WHERE s.is_active = 1 and s.supplier_id = $partyId")->row();

        $mobile = $supplierDetailsValue->phone;
        $phone=preg_replace('/[^\dxX]/', '', $mobile);
        if(strlen($phone)==10 || strlen($phone)==12){
            $mobile = urlencode('+919028403587');
            $username = urlencode("u6442");
            $msg_token = urlencode("8DnWEI");
            $sender_id = urlencode("SUPEDT");
            $message = urlencode('Dear '.$partyName.', Voucher Number '.$voucher_no.' of Amount '.$amount_paid.' has been created against Bill Number XXXX. Thanks & Regards Super Editors www.supereditors.in 02024430981/9028544114');
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


            $url = base_url()."Advance_payment_entry/generatedAdvancePdf?vc=$voucher_no";
            // Email body content
            $htmlContent = "<p>Dear ".$supplierDetailsValue->supplier_name.",</p>
            <p>Voucher Number $voucher_no has been created against Advance payment of ".$amount_paid." Amount.</p>
            <p><a href='$url'>Click Here</a> to view payment details.</p>
            <p>Thanks & Regards<br>
            ".$this->input->post('company_name').". </p>";

                $this->email->from("info@supereditors.in", $company_name);
                $this->email->to($to);
                $this->email->cc('info@supereditors.in');
                $this->email->bcc('iambommanakavya@gmail.com','keshriedutech@gmail.com');

                $this->email->subject("Advance Payment Created");
                $this->email->message($htmlContent);
                $this->email->send();


                echo 1;
                exit();

    }

    public function advance_payment_entry_delete(){
     $advance_payment_entry_id=$_GET['id'];   
    //print_r($perchaseid);
     
          $data = [
            'is_active' => '0'
        ];
     $this->load->model('Advance_Payment_model');
     
     $response = $this->Advance_Payment_model->delete_advance_payment_data($data,$advance_payment_entry_id);
     
          
       if($response == true){
          
        $this->session->set_flashdata('advance_payment_entry', 'Advance Payment Data Deleted Successfully');
         redirect('Advance_payment_entry/advanceBillPay');
               
       }
    }

}
