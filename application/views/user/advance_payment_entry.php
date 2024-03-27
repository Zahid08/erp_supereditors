<?php
   $supplierDetailsValue = $this->db->query("SELECT * FROM supplier WHERE is_active = 1")->result();

$where = " WHERE s.is_active = 1 ";
if (isset($_POST['from_date'])){
    $fromDate   =$_POST['from_date'];
    $toDate     =$_POST['to_date'];
}

if(!empty($_POST['c_name']) ){
    $c_name = $_POST['c_name'];
    $where .= " AND a.company_name='$c_name'  ";
}else{
    $where .= " ";
}


if (isset($_POST['supplier_name'])){
    $supplierId=$_POST['supplier_name'];
}
if(!empty($supplierId) && !empty($fromDate) AND !empty($toDate) ){
    $where .= "AND a.supplier_id='$supplierId' AND ";
}elseif (!empty($fromDate) AND !empty($toDate)){
    $where .= " AND";
}else{
    $where .= " ";
}





if(!empty($fromDate) && !empty($toDate)){
    $where .= "(a.created_date >='$fromDate' AND a.created_date <='$toDate')";
}else if(!empty($fromDate) && empty($toDate)){
    $where .= "(a.created_date >='$fromDate')";
}else if(empty($fromDate) && !empty($toDate)){
    $where .= "(a.created_date >='$toDate')";
}

    $supplierAdvance = $this->db->query("SELECT * FROM  supplier s
                                             INNER JOIN advance_payment_entry a ON s.supplier_id = a.supplier_id
                                             $where  ORDER BY 1 DESC")->result();
   ?>

<style>
    .form-control {
        height: 34px!important;
    }
    .dataTables_wrapper {
        padding-top: 0!important;
    }
</style>
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
      <title>SuperEditors | Supplier Advance Payment Entry  </title>
      <!-- Custom CSS -->
      <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">

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
                  <h3 class="text-primary">Supplier Advance Payment Entry</h3>
               </div>
               <div class="col-md-7 align-self-center">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                     <li class="breadcrumb-item active">Supplier Advance Payment Entry</li>
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
                        <form method="post" action="<?php echo base_url() ?>Advance_payment_entry/save_advance_payment" id="advancePaymentForm">
                           <div class="row">
                               <div class="col-sm-3">
                                   <label>Company Name</label>
                                <select class="form-control " name="company_name"   id="company_name" required>
                                    <option value="">Company Name</option>
                                   <option value = "SuperEditors">SuperEditors</option>
                                    <option value = "MannaMenswear">MannaMenswear</option>
                                </select>
                            </div>
                              <div class="col-sm-3">
                                  <label>Payment Date</label>
                                 <input type="text" onfocus="this.type='date'" class="form-control" name="payment_date" id="payment_date"  placeholder="Payment Date"  value="<?=date ('m/d/Y')?>" style="pointer-events: none">
                              </div>
                              <div class="col-sm-3">
                                  <label>Supplier Name</label>
                                 <select class="form-control" name="party_name"   id="party_name" required>
                                     <option value="">Select Supplier Name</option>
                                    <?php foreach($supplierDetailsValue as $getsupplierDetails){ ?>
                                    <option value="<?php echo $getsupplierDetails->supplier_id ?>" dataselectedName="<?php echo $getsupplierDetails->supplier_name ?>"><?php echo $getsupplierDetails->supplier_name  ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                              <div class="col-sm-3">
                                  <label>Advance Amount Paid</label>
                                 <input type="text" onfocus="this.type='number'" class="form-control" name="amount_paid" id="amount_paid" placeholder="Amount Paid" required>
                              </div>

                              <div class="col-sm-3">
                                  <label>Mode of Payment</label>
                                 <select type = "text" class="form-control" name="payment_mode" id="payment_mode"  required>
                                    <option value="">Mode of Payment</option>
                                    <option value="NEFT">NEFT</option>
                                    <option value="RTGS">RTGS</option>
                                    <option value="Cheque">Cheque</option>
                                    <option value="IMPS">IMPS</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Google Pay">Google Pay</option>
                                    <option value="Phone Pay">Phone Pay</option>
                                 </select>
                              </div>
                              <div class="col-sm-3">
                                  <label>Cheque No/DD No</label>
                                 <input type="text"   class="form-control" name="cheque_no" id="cheque_no" placeholder="Cheque No./Transaction ID" >
                              </div>
                              <div class="col-sm-3">
                                  <label>Bank Details </label>
                                 <input type = "text" class="form-control" name="bank_details" id="bank_details" placeholder="From Bank Details" required>
                              </div>

                              <div class="col-sm-3">
                                  <label>Amount Paid By</label>
                                 <input type="text" class="form-control" name="amount_paid_by" id="amount_paid_by" placeholder="Amount Paid By" >
                              </div>
                              <div class="col-sm-12" style="margin-top: 10px;">
                                 <button type="submit" name="save" class="btn btn-primary" id="submitbtn">Save</button>
                              </div>
                           </div>
                        </form>
                  </div>

                   <hr/>

                <div class=" card-title">
                    <form  method="post" action="">
                        <div class="row">
                            <div class="col-sm-3">
                                <select class="form-control " name="c_name"   id="c_name" required>
                                    <option value="">Company Name</option>
                                   <option value = "SuperEditors">SuperEditors</option>
                                    <option value = "MannaMenswear">MannaMenswear</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <input type = "text" class="form-control" name="from_date" id="from_date" placeholder="From Date" value="<?php echo $fromDate ?>" onfocus="this.type='date'" required>
                            </div>
                            <div class="col-sm-2">
                                <input type = "text" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?php echo $toDate ?>" onfocus="this.type='date'" required>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control " name="supplier_name"   id="company_name">
                                    <option value="">Supplier Name </option>
                                    <?php foreach($supplierDetailsValue as $getsupplierDetails){  echo "<pre>";
                                        ?>
                                        <option value="<?php echo $getsupplierDetails->supplier_id  ?>"><?php echo $getsupplierDetails->supplier_name  ?></option>
                                        <?php } ?>
                                </select>
                            </div>

                            <div class="col-sm-2 " >
                                <button type="submit" name="save" class="btn btn-primary">Search</button>
                                <a href="<?php echo base_url() ?>Advance_payment_entry"><button type="button" name="save" class="btn btn-danger">Reset</button></a>
                            </div>
                        </div>
                    </form>
                </div>
                <br>

                  <div class="table-responsive">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                           <thead>
                              <tr>
                                 <th>Sr.No</th>
                                 <th>Voucher #</th>
                                  <th>Company Name</th>
                                 <th>Payment Date</th>
                                 <th>Supplier Name</th>
                                 <th>Amount Paid</th>
                                 <th>Amount Paid By</th>
                                 <th>Mode of Payment</th>
                                 <th>Cheque No/DD No</th>
                                 <th>Bank Details</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 $i=1;
                                     foreach($supplierAdvance as $supplierAdvanceDetails){ ?>
                              <tr>
                                 <td><?php echo $i++ ?></td>
                                 <td><a target="_blank" href="<?php echo base_url() ?>Advance_payment_entry/generatedAdvancePdf?vc=<?php echo $supplierAdvanceDetails->voucher_no ?>"><?php echo $supplierAdvanceDetails->voucher_no ?></a></td>
                                 <td><?php echo $supplierAdvanceDetails->company_name ?></td>
                                 <td><?php echo date('d-m-Y', strtotime($supplierAdvanceDetails->payment_date)) ?></td>
                                 <td><?php echo $supplierAdvanceDetails->supplier_name ?></td>
                                 <td><?php echo $supplierAdvanceDetails->amount_paid ?></td>
                                 <td><?php echo $supplierAdvanceDetails->amount_paid_by ?></td>
                                 <td><?php echo $supplierAdvanceDetails->payment_mode ?></td>
                                 <td><?php echo $supplierAdvanceDetails->cheque_no	?></td>
                                 <td><?php echo $supplierAdvanceDetails->bank_details ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                            </table>
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

      <script>
          var redirectURL='<?php echo base_url() ?>Advance_payment_entry/generatedAdvancePdf?vc=';
          var warning    ='<?php echo base_url(); ?>assets/alert_image/warning.svg';
          var successImage    ='<?php echo base_url(); ?>assets/alert_image/success.svg';

          // this is the id of the form
          $("form#advancePaymentForm").submit(function(e) {
              e.preventDefault();

              $('button#submitbtn').html('Saving...');
              $('button#submitbtn').addClass('not-clickable');

              var form = $(this);
              var actionUrl = form.attr('action');

              $.ajax({
                  type: "POST",
                  url: actionUrl,
                  data: form.serialize(), // serializes the form's elements.
                  success: function(response)
                  {
                      var obj                      = JSON.parse(response);
                      var partyName                =$('select#party_name').find(':selected').attr('dataselectedName');
                      var partyId                  =$('select#party_name').find(':selected').val();

                      cuteToast({
                          type: "success", // or 'info', 'error', 'warning'
                          message: "Successfully Save Advance Payment",
                          timer: 5000,
                          img:successImage,
                      })

                      cuteAlert({
                          type: "question",
                          title: "PDF OPENING ALERT",
                          message: "Do you want to Open PDF ?",
                          confirmText: "Okay",
                          cancelText: "Cancel",
                          img:warning,
                      }).then((e)=>{
                          if ( e ==='confirm'){
                              window.location.href=redirectURL+obj.voucher_no;
                              //sendSms(obj.voucher_no,partyName,obj.amount_paid,obj.company_name,partyId);
                          }
                      });

                      $('button#submitbtn').html('Save');
                      $('button#submitbtn').removeClass('not-clickable');
                  }
              });

          });

          function sendSms(voucher_no,partyName,amount_paid,company_name,partyId) {

              var url = "<?php echo base_url('Advance_payment_entry/sendsms'); ?>";
              var post_data = {
                  'voucher_no': voucher_no,
                  'partyName': partyName,
                  'amount_paid': amount_paid,
                  'company_name': company_name,
                  'partyId': partyId,
                  '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
              };
              $.ajax({
                  url : url,
                  type : 'POST',
                  data: post_data,
                  success : function(result)
                  {
                      if (result){
                          cuteToast({
                              type: "success", // or 'info', 'error', 'warning'
                              message: "Successfully Send Sms and Email",
                              timer: 5000,
                              img:successImage,
                          })
                      }
                  }

              });
          }

      </script>
   </body>
</html>
