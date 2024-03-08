<?php

 
$purchasedataDetails = $this->db->query("SELECT *,t.transport_name,t.credit_day,w.inward_no FROM purchase_transport p
                                         INNER JOIN transport t ON t.transport_id = p.transport_id
                                         INNER JOIN purchase_supplier w ON w.purchase_supplier_id = p.purchase_supplier_id
                                         
                                      WHERE  t.is_active = 1 AND p.is_active = 1  ")->result();
            
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
    <title>SuperEditors || Purchase Paid </title>
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
                    <h3 class="text-primary">Purchase Paid Entry</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Purchase Paid Entry</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <!--    <a href="<?php echo base_url()?>Purchase/add_purchase" target="_blank"><button type="button" class="btn btn-primary  text-white" >Add Purchase</button></a>
                -->
                <center>
                    <p style="color:green"><?php echo $this->session->flashdata('purchase_message') ?></p>
                </center>
            <!-- Start Page Content -->
                <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Purchase Paid Entry</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                

                                                <th>Sr.No</th>
                                                
                                                <th>Inword No</th> 
                                                <th>Bill No</th>
                                               <th>Party Name</th>
                                                 <th>Amount</th>
                                                
                                                 
                                                <th>Amt Paid</th>
                                                 <th>TDS Ded</th>
                                                 
                                                <th>Other Ded</th>
                                                 <th>Adv Adjust</th>
                                                  <th>Payment Mode</th>
                                                   <th>Cheq Number</th>
                                                 <th>Dated</th>
                                                  <th>Pay Paid By</th>
                                                <th>Balace</th> 
                                                <th>Due Date</th>
                                                
                                               
                                               
                                                
                                              
                                               
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody><?php
                                        $i=1;
                                            foreach($purchasedataDetails as $gettransportDetails){ ?>
                                                <tr>
                                                    <td><?php echo $i++ ?></td>
                                                    
                                                    
                                                    <td><?php echo $gettransportDetails->inward_no ?></td>
                                                    <td><?php echo $gettransportDetails->lr_no ?></td>
                                                      <td><?php echo $gettransportDetails->transport_name ?></td>
                                                            
                                                             <td><?php echo $gettransportDetails->lr_amount	 ?></td>
                                                             <td><?php echo $gettransportDetails->total_amt_paid	 ?></td>
                                                               <td><?php echo $gettransportDetails->total_tds_ded	 ?></td>
                                                               <td><?php echo $gettransportDetails->total_other_ded	 ?></td>
                                                             <td><?php echo $gettransportDetails->total_adv_adj	 ?></td>
                                                               <td><?php echo $gettransportDetails->payment_mode	 ?></td>
                                                                  <td><?php echo $gettransportDetails->cheq_no	 ?></td>
                                                                  <td><?php echo $gettransportDetails->dated	 ?></td>
                                                                     <td><?php echo $gettransportDetails->pay_paid_by	 ?></td>
                                                                        <td><?php echo $gettransportDetails->balace	 ?></td>
                                                    <td><?php echo date('Y-m-d', strtotime($gettransportDetails->created_date. ' + '.$gettransportDetails->credit_day. day)); ?>
                                                    </td>
                                                    
                                                    
                                                    <td>
                                                       <button type="button" class="btn btn-primary text-white" data-toggle="modal" data-target="#editContact<?php echo $gettransportDetails->purchase_transport_id ?>"><i class="fa fa-edit"></i> Edit</button>
                                         <!--Contact Modal--->
       <div class="modal" id="editContact<?php echo $gettransportDetails->purchase_transport_id  ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
                                                  <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                      <!-- Modal Header -->
                                                        <div class="modal-header">
                                                          <h4 class="modal-title">EDIT</h4>
                                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        </div>
                                                      <div class="modal-body">
                                                            <form method="post" action="<?php echo base_url() ?>Payment_Paid_Entry/edit_transport_purchase">
                                                    <div class="row">
                                                <div class="col-sm-6">
                                                  <label>Total Amount Paid</label>
                                               <input type="text" name="total_amt_paid" id="total_amt_paid" value="<?php echo $gettransportDetails->total_amt_paid ?>"  class="form-control" required>
                                                <input type="hidden" name="purchase_transport_id" id="purchase_transport_id" value="<?php echo $gettransportDetails->purchase_transport_id ?>" required>
                                                </div>
                                                 <div class="col-sm-6">
                                                <label>Total TDS Deduction</label>
                                               <input type="text" name="total_tds_ded" id="total_tds_ded" value="<?php echo $gettransportDetails->total_tds_ded ?>" class="form-control" required>
                                               </div>
                                                 <div class="col-sm-6">
                                                 <label>Total Other Deduction</label>
                                               <input type="text" name="total_other_ded" id="total_other_ded" value="<?php echo $gettransportDetails->total_other_ded ?>" class="form-control" required>
                                                </div>
                                                 <div class="col-sm-6">
                                                 <label>Total Adv Adjust </label>
                                               <input type="text" name="total_adv_adj" id="total_adv_adj" value="<?php echo $gettransportDetails->total_adv_adj ?>" class="form-control" required>
                                                </div>
                                                 <div class="col-sm-6">
                                                
                                                 <label>Payment Mode </label>
                                               <input type="text" name="payment_mode" id="payment_mode" value="<?php echo $gettransportDetails->payment_mode ?>" class="form-control" required>
                                                
                                                </div>
                                                 <div class="col-sm-6">
                                                 <label>Cheq No </label>
                                               <input type="text" name="cheq_no" id="cheq_no" value="<?php echo $gettransportDetails->cheq_no ?>" class="form-control" required>
                                                </div>
                                                 <div class="col-sm-6">
                                                
                                                 <label>Bank Details </label>
                                               <input type="text" name="bank_details" id="bank_details" value="<?php echo $gettransportDetails->bank_details ?>" class="form-control" required>
                                                </div>
                                                 <div class="col-sm-6">
                                                 <label>Dated </label>
                                               <input type="text" name="dated" id="dated" value="<?php echo $gettransportDetails->dated ?>" class="form-control" required>
                                                </div>
                                                 <div class="col-sm-6">
                                                 <label>Pay Paid </label>
                                               <input type="text" name="pay_paid_by" id="pay_paid_by" value="<?php echo $gettransportDetails->pay_paid_by ?>" class="form-control" required>
                                                
                                                </div>
                                                 <div class="col-sm-6">
                                                 <label>Balance </label>
                                               <input type="text" name="balace" id="balace" value="<?php echo $gettransportDetails->balace ?>" class="form-control" required>
                                                </div>
                                                </div>
                                                </div>
                                                
                                                <!-- Modal footer -->
                                                <div class="modal-footer">
                                                  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                     <button type="submit" class="btn btn-primary edit_item_save">Save changes</button>
                                                </div>
                                                </form>
                                              </div>
                                            </div>
                                                    </div>
                                                  </div>
                                                </div>

                                                        
                                                      
                                                        </td>
                                                        </tr>
                                             <?php
                                            }
                                            ?>
                                                     
                                            
                                        </tbody>
                                    </table>
                                </div>
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
            
      $(document).ready(function() {
          
  $('.editname').click(function() {

     var id = $(this).attr('id'); 
     $('#edit_id').val(id);
     
     var total_amt_paid = $(this).attr('data-id'); 
     $('#amount_edit_name').val(total_amt_paid);
     
      var total_tds_ded = $(this).attr('data-id2'); 
     $('#total_tds_ded').val(total_tds_ded);
      
       var total_other_ded = $(this).attr('data-id3'); 
     $('#total_other_ded').val(total_other_ded);
      
       var total_adv_adj = $(this).attr('data-id4'); 
     $('#adv_adj_edit').val(total_adv_adj);
      
       var payment_mode = $(this).attr('data-id5'); 
     $('#payment_mode_edit').val(payment_mode);
      
         var cheq_no = $(this).attr('data-id6'); 
     $('#cheq_no_edit').val(cheq_no);
      
        var bank_details = $(this).attr('data-id7'); 
     $('#bank_details_edit').val(bank_details);

var dated = $(this).attr('data-id8'); 
     $('#Dated_edit').val(dated);

var pay_paid_by = $(this).attr('data-id9'); 
     $('#pay_paid_edit').val(pay_paid_by);

var balace = $(this).attr('data-id10'); 
     $('#balance_edit').val(balace);

  });
  
   
  
  
      });
        </script>

   
</body>

</html>