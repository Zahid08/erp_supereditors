<?php
error_reporting(0);
 $supplierDetailsValue = $this->db->query("SELECT * FROM supplier WHERE is_active = 1")->result();
   $getinward_no=$_POST['inward_no'];
   $where = "WHERE 1=1";
   if(isset($getinward_no) ){
       $where = "WHERE 1=1 AND s.inward_no='$getinward_no'  AND ";
   }else{
       $where = "WHERE 1=1 AND ";
   } 
   
   $perchaseDetails =  $this->db->query("SELECT 
   s.purchase_item_id,
    s.inward_no,
    p.company_name,
    ss.supplier_name,
    s.transport_date,
    t.transport_name,
    s.lr_no,
    s.lr_qty,
    s.pick_up_location,
    s.lr_amount,
    s.Received_by,
    s.purchase_transport_id
   FROM `purchase_transport` s
   LEFT JOIN supplier ss ON ss.supplier_id = s.supplier_id
   LEFT JOIN purchase_item p ON p.purchase_item_id = s.purchase_item_id
   LEFT JOIN transport t ON t.transport_id = s.transport_id
  $where   s.is_active = 1 ")->result();   
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
      <title>SuperEditors || Transport </title>
      <!-- Custom CSS -->
      <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
      <style>
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
            line-height: 14px;
        }
    </style>
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
            <!-- Container fluid  -->
            <div class="container-fluid">
              <center>
                  <p style="color:green"><?php echo $this->session->flashdata('purchase_message') ?></p>
               </center>
               <!-- Start Page Content -->
               <div class="card">
                  <div class="card-body">
                     <h4 class="text-primary">Transport Entry </h4>
                     <div class=" card-title">
                         <a href="<?php base_url() ?>add_transport?purchase_item_id=0&purchase_transport_id=0">
                            <button type="button" class="btn btn-primary " >
                                Add New Transport
                            </button>
                        </a>
                        <form  method="post" action="">
                           <br>
                            <div class="row">
                           <div class="col-sm-3">
                               <input type = "text" class="form-control" name="inward_no" id="inward_no" placeholder="Inward_no" value="<?php echo $_POST['inward_no'] ?>" >
                           </div>
                            <div class="col-sm-3 ">
                               <button type="submit" name="save" class="btn btn-primary">Search</button>
                           </div>
                           </div>
                        </form>
                     </div>
                     <div class="table-responsive">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                           <thead>
                              <tr>
                                 <th>Sr.No</th>
                                 <th>Company Name</th>
                                 <th>Inward No</th>
                                 <th>Transport Name</th>
                                 <th>Bill Number</th>
                                 <th>Quantity</th>
                                 <th>Pickup Location</th>
                                 <th>Party Name</th>
                                 <th>Transport Date</th>
                                 <th>Net Amount</th>
                                 <th>Created By</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 $i=1;
                                     foreach($perchaseDetails as $getperchaseDetails){ ?>
                              <tr>
                                 <td><?php echo $i++ ?></td>
                                 <td><?php echo $getperchaseDetails->company_name ?></td>
                                 <td><?php echo $getperchaseDetails->inward_no ?></td>
                                 <td><?php echo $getperchaseDetails->transport_name ?></td>
                                 <td><?php echo $getperchaseDetails->lr_no ?></td>
                                 <td><?php echo $getperchaseDetails->lr_qty ?></td>
                                 <td><?php echo $getperchaseDetails->pick_up_location ?></td>
                                 <td><?php echo $getperchaseDetails->supplier_name ?></td>
                                 <td><?php echo $getperchaseDetails->transport_date ?></td>
                                 <td><?php echo $getperchaseDetails->lr_amount ?></td>
                                 <td><?php echo $getperchaseDetails->Received_by ?></td>
                                 <td>                                    
                                    <a href="<?php base_url() ?>edit_transport?purchase_item_id=<?php echo $getperchaseDetails->purchase_item_id ?>&purchase_transport_id=<?php echo  $getperchaseDetails->purchase_transport_id ?>">
                                    <button type="button" class="btn btn-primary btn-sm" >
                                    Edit
                                    </button></a>
                                    <a href="<?php base_url() ?>add_transport?purchase_item_id=<?php echo $getperchaseDetails->purchase_item_id ?>&purchase_transport_id=<?php echo  $getperchaseDetails->purchase_transport_id ?>">
                                    <button type="button" class="btn btn-primary btn-sm" >
                                    Transport
                                    </button></a>
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
   </body>
</html>