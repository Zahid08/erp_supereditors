<?php

$supplierDetailsValue = $this->db->query("SELECT * FROM supplier WHERE is_active = 1")->result();
$advancePaymentEntry = $this->db->query("SELECT * FROM advance_payment_entry WHERE advance_payment_entry_id = ".$_GET['id']." ")->result();
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
      <title>SuperEditors | Advance Bill Payment Entry  </title>
      <!-- Custom CSS -->
      <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">

   </head>
   <body class="header-fix fix-sidebar">
   <style>
      .col-sm-4 {
         margin-bottom: 10px;
      }
   </style>
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
                  <h3 class="text-primary">Edit Advance Bill Payment Entry</h3>
               </div>
               <div class="col-md-7 align-self-center">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                     <li class="breadcrumb-item active">Edit Advance Bill Payment Entry</li>
                  </ol>
               </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
               <center>
                  <p style="color:green"><?php echo $this->session->flashdata('advance_payment_entry') ?></p>
               </center>
               <!-- Start Page Content -->
               <div class="card">
                  <div class="card-body">
                     <h4 class="card-title">Edit Advance Bill Payment Entry  </h4>
                     <hr>
                        <form method="post" action="<?php echo base_url() ?>Advance_payment_entry/save_advance_payment_update" id="advancePaymentForm">
                            <input type="hidden" name="advance_payment_entry_id" value="<?= $advancePaymentEntry[0]->advance_payment_entry_id?>">
                           <div class="row">
                               <div class="col-sm-4">
                                   <label>Company Name</label>
                                <select class="form-control " name="company_name"   id="company_name" required>
                                    <option value="">Company Name</option>
                                   <option  <?php if($advancePaymentEntry[0]->company_name=='SuperEditors'){ echo 'selected';} ?> value = "SuperEditors">SuperEditors</option>
                                    <option  <?php if($advancePaymentEntry[0]->company_name=='MannaMenswear'){ echo 'selected';} ?> value = "MannaMenswear">MannaMenswear</option>
                                </select>
                            </div>
                             <!--  <div class="col-sm-4">
                                  <label>Receipt Number</label>
                                 <input type = "text" class="form-control" name="voucher_no" id="voucher_no" placeholder="Receipt Number" readonly>
                              </div> -->

                              <div class="col-sm-4">
                                  <label>Party Name</label>
                                 <select class="form-control" name="party_name"   id="party_name" required>
                                    <?php foreach($supplierDetailsValue as $getsupplierDetails){ ?>
                                    <option <?php if($advancePaymentEntry[0]->party_name==$getsupplierDetails->supplier_id){ echo 'selected';} ?> value="<?php echo $getsupplierDetails->supplier_id ?>" dataselectedName="<?php echo $getsupplierDetails->supplier_name ?>"><?php echo $getsupplierDetails->supplier_name  ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                              <div class="col-sm-4">
                                  <label>Amount Recd.</label>
                                 <input type="text" onfocus="this.type='number'" value="<?= $advancePaymentEntry[0]->amount_paid?>" class="form-control" name="amount_paid" id="amount_paid" placeholder="Amount Paid" >
                              </div>
                        <div class="col-sm-4">
                           <label>Amount Recd. By</label>
                           <input type="text" value="<?= $advancePaymentEntry[0]->amount_paid_by?>" class="form-control" name="amount_paid_by" id="amount_paid_by" placeholder="Amount Recd. By" >
                        </div>
                              <div class="col-sm-4">
                                  <label>Mode of Payment</label>
                                 <select type = "text" class="form-control" name="payment_mode" id="payment_mode"  >
                                    <option value="">Mode of Payment</option>
                                    <option <?php if($advancePaymentEntry[0]->payment_mode=='NEFT'){ echo 'selected';} ?> value="NEFT">NEFT</option>
                                    <option <?php if($advancePaymentEntry[0]->payment_mode=='RTGS'){ echo 'selected';} ?> value="RTGS">RTGS</option>
                                    <option <?php if($advancePaymentEntry[0]->payment_mode=='Cheque'){ echo 'selected';} ?> value="Cheque">Cheque</option>
                                    <option <?php if($advancePaymentEntry[0]->payment_mode=='IMPS'){ echo 'selected';} ?> value="IMPS">IMPS</option>
                                    <option <?php if($advancePaymentEntry[0]->payment_mode=='Cash'){ echo 'selected';} ?> value="Cash">Cash</option>
                                    <option <?php if($advancePaymentEntry[0]->payment_mode=='Google'){ echo 'selected';} ?> value="Google Pay">Google Pay</option>
                                    <option <?php if($advancePaymentEntry[0]->payment_mode=='Phone'){ echo 'selected';} ?> value="Phone Pay">Phone Pay</option>
                                 </select>
                              </div>
                              <div class="col-sm-4">
                                  <label>Cheque No/DD No</label>
                                 <input type="text"   class="form-control" value="<?= $advancePaymentEntry[0]->cheque_no?>" name="cheque_no" id="cheque_no" placeholder="Cheque No./Transaction ID" >
                              </div>
                        <div class="col-sm-4">
                           <label>Payment Date</label>
                           <input type="text" onfocus="this.type='date'" value="<?= $advancePaymentEntry[0]->payment_date?>" class="form-control" name="payment_date" id="payment_date"  placeholder="Payment Date" >
                        </div>
                              <div class="col-sm-4">
                                  <label>Bank Details</label>
                                 <input type = "text" class="form-control" value="<?= $advancePaymentEntry[0]->to_bank?>" name="to_bank" id="to_bank" placeholder="To Bank Details" >
                              </div>

                              <div class="col-sm-12" style="margin-top: 10px;">
                                 <button type="submit" name="save" class="btn btn-primary" id="submitbtn">Save Advance Bill Payment</button>
                              </div>
                           </div>
                        </form>
                  </div>

               </div>
               <!-- The Modal -->
            </div>
         </div>
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

   
   </body>
</html>
