<?php
error_reporting(1);
$patternList    = $this->db->query("SELECT * from payment_terms order by id DESC")->result();
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
    <title>SuperEditors || Payment Terms Page</title>
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
                    <h3 class="text-primary">Payment Terms</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Payment Terms</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <!-- Start Page Content -->
                    <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Payment Terms</h4>
                                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                                
                                <center>
                                    <p style="color:green"><?php echo $this->session->flashdata('pattern_message') ?></p>
                                </center>
                                
                               <form method="post" action="<?php echo base_url() ?>PaymentTerms/save_or_update" autocomplete="off">
                                   
                                    <input class="form-control" type="hidden" name="payment_term_id" id="payment_term_id" value="">

                                   <div class="row">

									   <div class="col-sm-4">
										   <input class="form-control" name="name" id="name"  placeholder="Payment Terms" required>
									   </div>

									   <div class="col-sm-4">
										   <select class="form-control" name="status" id="status">
											   <option value="">Select Status</option>
											   <option value="1">Active</option>
											   <option value="2">Inactive</option>
										   </select>
									   </div>
                                      
                                      <div class="col-sm-4">
                                           <button type="submit" class="btn btn-primary  text-white" id="createPaymentTerms">Create Payment Terms</button>
                                      </div>
                                   </div>
                                </form>
                                
                                <div class="table-responsive m-t-40">
                                    <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr.No</th>
                                                <th>Payment Terms</th>
                                                <th>Status</th>
                                                <th>Created By</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <?php
                                            $i=1;
                                            foreach($patternList as $key=>$getPatterns){ ?>
                                                   <td>
                                                       <input type="hidden" value="<?php echo $getPatterns->id ?>" id="itemId-<?=$key?>">.
													   <input type="hidden" value="<?=$getPatterns->payment_terms?>" id="paymentTermsName-<?=$key?>">
                                                       <?php echo $i++ ?>
                                                    </td>
                                                    <td><?php echo $getPatterns->payment_terms ?></td>
                                                    <td><?php if ($getPatterns->status==1){echo "Active";}else{echo "Inactive";}  ?></td>
                                                   <td><?php if($getPatterns->created_by == NULL){ echo 'Self'; }else{ echo 'Admin'; } ?></td>
                                                    <td><?php echo $getPatterns->created_date ?></td>
                                                  
                                                    <td>
                                                        <a href="javascript:void(0);" data-status="<?=$getPatterns->status?>" data-id="<?=$getPatterns->id?>" id="editPaymentTerms" data-index="<?=$key?>">
                                                        <button type="button" class="btn btn-primary btn-sm" >
                                                          Edit
                                                        </button>
                                                        </a>
                                                         <a href="<?php base_url() ?>PaymentTerms/delete_pattern?term_id=<?php echo $getPatterns->id  ?>">
                                                        <button type="button" onclick="return confirm('Are you sure you want to delete this records?');"  class="btn btn-primary btn-sm " >
                                                          Delete
                                                        </button>
                                                        </a>
                                                    </td>
                                                </tr>
                                                <?php } 
                                                ?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>    
            <!-- End Container fluid  -->
            <!-- footer -->
            <?php include("includes/footer.php") ?>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
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
       $(document).on('click', 'a#editPaymentTerms', function() {
		   var currentIndex    =$(this).data('index');
            var patternId       	=$(this).data('id');
            var status       		=$(this).data('status');
            var paymentTermsName      =$("#paymentTermsName-"+currentIndex+"").val();

            $("input#payment_term_id").val(patternId);
            $("select#status").val(status).trigger("change");
            $("input#name").val(paymentTermsName);
            $("#createPaymentTerms").html("Update Payment Terms");
            
       });
 </script>
   
</body>

</html>
