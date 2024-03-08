<?php
error_reporting(0);
$createdby = $this->session->userdata['user_id'];

   $enquiry_id = $_GET['enquiry_id'];
   if(!empty($enquiry_id)){
   $enquiryDetails = $this->db->query("SELECT *,c.name as c_name,e.name as e_name FROM enquiry e
                                        LEFT JOIN contact_person c ON c.enquiry_id = e.enquiry_id
                                        WHERE e.isactive = 1  and e.is_customer = 1 and e.enquiry_id = $enquiry_id ORDER BY e.enquiry_id DESC LIMIT 1")->result();
  foreach($enquiryDetails as $getenquiryDetails){
      $pan_no = $getenquiryDetails->pan_no;
      $tan_no = $getenquiryDetails->tan_no;
      $gst = $getenquiryDetails->gst_no;
      $credit_limit = $getenquiryDetails->credit_limit;
      $credit_days = $getenquiryDetails->credit_days;
      $state = $getenquiryDetails->state;
      $billing_address = $getenquiryDetails->billing_address;
      $shipping_address = $getenquiryDetails->shipping_address;
      $party_name = $getenquiryDetails->e_name;
      $contact_name = $getenquiryDetails->c_name;
      $email = $getenquiryDetails->email;
      $mob = $getenquiryDetails->mobile_no;
      $companyName=$getenquiryDetails->company_name;
  }
   }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- Tell the browser to be responsive to screen width -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- Favicon icon -->
      <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/client_asstes/images/favicon.png">
      <title>SuperEditors || Home Page</title>
      <!-- Custom CSS -->
      <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
      <!--============For Editor===========-->
      <link rel="stylesheet" href="<?php echo base_url(); ?>assets/client_asstes/css/lib/html5-editor/bootstrap-wysihtml5.css" />
      <!--============For Editor===========-->
      <!--============For Accordian===========-->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
      <!--============For Accordian===========-->
      <!--============For Dropdown Search and Multi Select===========-->
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.css">
      <script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/choices.min.js"></script>
      <script>
         $(document).ready(function(){
             var multipleCancelButton = new Choices('#choices-multiple-remove-button', {
             removeItemButton: true,
             maxItemCount:10,
             searchResultLimit:10,
             renderChoiceLimit:10
             });
         });
      </script>
      <!--============For Dropdown Search and Multi Select===========-->
   </head>
   <body class="header-fix fix-sidebar">
      <!-- Main wrapper  -->
      <div id="main-wrapper">
      <!-- header header  -->
      <?php include("includes/header.php") ?>
      <!-- End header header -->
      <!-- Left Sidebar  -->
      <?php include("includes/sidenav.php") ?>
      <!-- End Left Sidebar  -->
      <!-- Page wrapper  -->
      <div class="page-wrapper">
         <!-- Bread crumb -->
         <div class="row page-titles">
            <div class="col-md-5 align-self-center">
               <h3 class="text-primary">Customer Details</h3>
            </div>
            <div class="col-md-7 align-self-center">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                  <li class="breadcrumb-item active">Customer Details</li>
               </ol>
            </div>
         </div>
         <!-- End Bread crumb -->
         <!-- Container fluid  -->
         <div class="container-fluid">
             
            
            <!-- Start Page Content -->
            <section id="po_section" name="po_section">
               <button type="button" class="btn btn-primary btn-block text-white" data-toggle="collapse" data-target="#customerform" >Customer Details</button>
               <div id="customerform" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        <center>
                           <p style="color:green"><?php echo $this->session->flashdata('po_message') ?></p>
                        </center>
                        <h5 class="card-title">Customer Details</h5>
                        <form method="post" action = "<?php echo base_url() ?>Customer/save_offline_customer">
                            
                            <div class="row">
                               <input class="form-control" type="hidden" name="enquiry_id" id="enquiry_id" value="<?php echo $_GET['enquiry_id'] ?>" required>
        						<div class="col-sm-4">
        							<label>Company Name</label>
        							<select class="form-control " name="company_name"   id="company_name" required>
        								<option value="">Company Name</option>
        								<option value ="SuperEditors" <?php if ($companyName=='SuperEditors'){echo 'selected';}?>>SuperEditors</option>
        								<option value ="MannaMenswear" <?php if ($companyName=='MannaMenswear'){echo 'selected';}?>>MannaMenswear</option>
        							</select>
        						</div>
							
                              <div class="col-sm-4">
                                  <label>Party Name</label>
                                 <input class="form-control" name="party_name" id="party_name" placeholder="Party Name" value="<?php echo $party_name ?>" required>
                              </div>
                              <div class="col-sm-4">
                                  <label>Contact Person Name</label>
                                 <input class="form-control" name="c_name" id="c_name" placeholder="Contact Person Name" value="<?php echo $contact_name ?>" required>
                              </div>
                              <div class="col-sm-4">
                                  <label>Mobile No.</label>
                                 <input class="form-control" name="mob" id="mob" placeholder="Mobile Number" value="<?php echo $mob ?>" required>
                              </div>
                              <div class="col-sm-4">
                                  <label>Email</label>
                                 <input class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $email ?>" required>
                              </div>
                              <div class="col-sm-4">
                                  <label>Pan No</label>
                                 <input class="form-control" name="pan_no" id="pan_no" placeholder="PAN No." value="<?php echo $pan_no ?>" required>
                              </div>
                             <!-- <div class="col-sm-4">
                                  <label>Tan No</label>
                                 <input class="form-control" name="tan_no" id="tan_no" placeholder="TAN No."  value="<?php echo $tan_no ?>"  required>
                              </div>-->
                              <div class="col-sm-4">
                                  <label>Credit Days</label>
                                 <input class="form-control" type="number" name="credit_days" id="credit_days" value="<?php echo $credit_days ?>"  placeholder="Credit Days" required>
                              </div>
                              <div class="col-sm-4">
                                  <label>Credit Limit</label>
                                 <input class="form-control" type="number" name="credit_limit" id="credit_limit" value="<?php echo $credit_limit ?>"  placeholder="Credit Limit"  required>
                              </div>
                              <div class="col-sm-4">
                                  <label>GST No</label>
                                 <input class="form-control" name="gst_no" id="gst_no" placeholder="GST No." value="<?php echo $gst ?>"   required>
                              </div>
                              <div class="col-sm-4">
                                  <label>State</label>
                                 <input class="form-control" name="state" id="state" placeholder="State" value="<?php echo $state ?>"  required>
                              </div>
                              <div class="col-sm-5">
                                  <label>Shipping Address</label>
                                 <input class="form-control" name="shipping_address" id="shipping_address" placeholder="Shipping Address" value="<?php echo $shipping_address ?>"  required>
                              </div>
                              <div class="col-sm-5">
                                  <label>Billing Address</label>
                                 <input class="form-control" name="billing_address" id="billing_address" placeholder="Billing Address" value="<?php echo $billing_address ?>"  required>
                              </div>
                              <div class="col-sm-2">
                                  <br>
                              <button type="submit" class="btn btn-primary text-white" >Save</button>
                                </dive>
                             

                           </div>
                        </form>
                           
                       
                     </div>
                  </div>
               </div>
            </section>
            
            <!-- End Container fluid  -->
            <!-- footer -->
            <?php include("includes/footer.php") ?>
            <!-- End footer -->
         </div>
         <!-- End Page wrapper  -->
      </div>
      <!-- End Wrapper -->
      <!-- All Jquery -->
      
      
      
    
      
      <!-- Scripts -->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/jquery/jquery.min.js"></script>
      <!-- Bootstrap tether Core JavaScript -->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/popper.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/bootstrap/js/bootstrap.min.js"></script>
      <!-- slimscrollbar scrollbar JavaScript -->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/jquery.slimscroll.js"></script>
      <!--Menu sidebar -->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/sidebarmenu.js"></script>
      <!--stickey kit -->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
      <!--Custom JavaScript -->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/webticker/jquery.webticker.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/peitychart/jquery.peity.min.js"></script>
      <!-- scripit init-->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/custom.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/dashboard-1.js"></script>
      <!-- Data Tables-->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables-init.js"></script>
      <!--text editor kit -->
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/html5-editor/wysihtml5-0.3.0.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/html5-editor/bootstrap-wysihtml5.js"></script>
      <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/html5-editor/wysihtml5-init.js"></script>
      
      
      <!-- Bootstrap Modal -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    
      
   </body>
</html>