<?php defined('BASEPATH') OR exit('No direct script access allowed');

class GeneratePdfController extends CI_Controller {
    
    public function index(){
        $this->load->view('GeneratePdfView');
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $this->dompdf->stream("Quotation.pdf", array("Attachment"=>0)); // Output the generated PDF (1 = download and 0 = preview)
    }

    public function generatedPdf(){
        $this->load->view('GeneratePdfView');
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'potrait');
        $this->dompdf->render();
        $file = $this->dompdf->output();

        $pdf_name='attachements_'.$_REQUEST['heading_id'];
        $file_location =$_SERVER['DOCUMENT_ROOT']."/assets/client_asstes/quotations/".$pdf_name.".pdf";
        file_put_contents($file_location, $file);
    }
    
}