<?php
error_reporting(0);
$itemtypeDetails = $this->db->query("SELECT * FROM item_type WHERE is_active = 1")->result();
   $purchase_item_id = $_GET['purchase_item_id'];
   if($purchase_item_id == 0){
       $where = "WHERE 1 = 1 AND ";
   }else{
       $where = "WHERE b.purchase_item_id= $purchase_item_id AND 1 = 1 AND ";
   }
    $company_name=$_POST['company_name'];
    if(!empty($company_name)){
       $where .= "company_name='$company_name' AND ";
   }
   $itemTypeName=$_POST['item_type'];
    if(!empty($itemTypeName)){
       $where .= "it.item_type_id ='$itemTypeName' AND ";
   }
   $fromDate=$_POST['from_date'];
   $toDate=$_POST['to_date'];
    if(!empty($fromDate) && !empty($toDate)){
       $where .= "(p.created_date >='$fromDate' AND p.created_date <='$toDate') AND";
   }else if(!empty($fromDate) && empty($toDate)){
       $where .= "(p.created_date >='$fromDate') AND";
   }else if(empty($fromDate) && !empty($toDate)){
       $where .= "(p.created_date >='$toDate') AND";
   }
   
   $barcodeDetails = $this->db->query("SELECT 
   b.purchased_amount_per_pack,
   p.created_date,
   sup.supplier_name,
   b.barcode,
   m.measure_name,
   b.purchase_item_id,
   s.qty_per_pack,
   b.purchase_supplier_id,
   b.amount_per_pack,
   b.stock_quantity,
   b.rate,
   b.mrp,
   i.item_name 
FROM 
   `barcodes` b 
   INNER JOIN purchase_item p ON p.purchase_item_id = b.purchase_item_id
   INNER JOIN (
       SELECT 
           purchase_item_entry_id,
           supplier_id,
           item_type_id,
           item_id,
           measure_id,
           qty_per_pack,
           company_name AS entry_company_name
       FROM 
           purchase_item_entry
   ) s ON s.purchase_item_entry_id = p.purchase_item_entry_id
   INNER JOIN supplier sup ON sup.supplier_id = s.supplier_id
   INNER JOIN item_type it ON it.item_type_id = s.item_type_id
   INNER JOIN items i ON i.item_id = s.item_id 
   INNER JOIN measure m ON m.measure_id = s.measure_id
   $where b.is_active = 1 ORDER BY 1 DESC")->result();
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
      <title><?php echo ucwords($company_name); ?> | Barcodes  </title>
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
                  <h3 class="text-primary">Barcodes</h3>
               </div>
               <div class="col-md-7 align-self-center">
                  <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                     <li class="breadcrumb-item active">Barcodes</li>
                  </ol>
               </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
               <center>
                  <p style="color:green"><?php echo $this->session->flashdata('purchase_message') ?></p>
               </center>
               <!-- Start Page Content -->
               <div class="card">
                  <div class="card-body">
                     <h4 class="card-title">Barcodes </h4>
                     <div class=" card-title">
                        <form method="post" action="">
                            <div class="row">
                           <div class="col-sm-3">
                              
                              <select class="form-control" name="company_name"   id="company_name" >
                                 <option value="">Choose Company/Firm Name </option>
                                 <option value="supereditors" <?php if($company_name == 'supereditors'){ ?> selected <?php } ?> >SuperEditors </option>
                                 <option value="mannasmenswear" <?php if($company_name == 'mannasmenswear'){ ?> selected <?php } ?>>MannasMensWear </option>
                              </select>
                              
                           </div>
                           <div class="col-sm-3">
                               
                               <select class="form-control" name="item_type"   id="item_type" >
                                 <option value="">Select Item Type </option>
                                 <?php foreach($itemtypeDetails as $getitemtypeDetails){ ?>
                                       <option value="<?php echo $getitemtypeDetails->item_type_id ?>" <?php if($itemTypeName == $getitemtypeDetails->item_type_id){ ?> selected<?php } ?>><?php echo $getitemtypeDetails->item_type  ?></option>
                                 <?php } ?>
                                 
                              </select>
                           </div>
                           <div class="col-sm-2">
                              
                               <input type = "text" class="form-control" name="from_date" id="from_date" placeholder="From Date" value="<?php echo $fromDate ?>" onfocus="this.type='date'">
                           </div>
                           <div class="col-sm-2">
                              
                               <input type = "text" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?php echo $toDate ?>" onfocus="this.type='date'">
                           </div>
                           
                           <div class="col-sm-2">
                               <button type="submit" name="save" class="btn btn-primary">Search</button>
                           </div>
                           </div>
                        </form>
                     </div>
                     <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>
                     <div class="table-responsive m-t-40">
                        <table id="example23" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                           <thead>
                              <tr>
                                 <th>Sr.No</th>
                                 
                                 <th>Supplier Name</th>
                                 <th>Created Date</th>
                                 <th>Barcode</th>
                                 <th>Item Name</th>
                                 <th>Size</th>
                                 <th>Qty Per Pack</th>
                                 <th>Stock</th>
                                 <th>Purchase Rate</th>
                                 <th>MRP</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php
                                 $i=1;
                                 $totalStock = 0;
                                 $totalAmount = 0;
                                 $totalPurchasedAmount = 0;
                                     foreach($barcodeDetails as $getbarcodeDetails){
                                     $totalStock = $totalStock + $getbarcodeDetails->stock_quantity;
                                     $totalAmount = $totalAmount + $getbarcodeDetails->amount_per_pack;
                                     $totalPurchasedAmount = $totalPurchasedAmount + $getbarcodeDetails->purchased_amount_per_pack;
                                     ?>
                              <tr>
                                 <td><?php echo $i++ ?></td>
                                 
                                 <td><?php echo $getbarcodeDetails->supplier_name ?></td>
                                 <td><?php echo date("d-m-Y", strtotime($getbarcodeDetails->created_date)); ?></td>
                                 <td><?php echo $getbarcodeDetails->barcode ?></td>
                                 <td><?php echo $getbarcodeDetails->item_name ?></td>
                                 <td><?php echo $getbarcodeDetails->measure_name ?></td>
                                 <td><?php echo $getbarcodeDetails->quantitiy_per_pack ?></td>
                                 <td><?php echo $getbarcodeDetails->stock_quantity ?></td>
                                 <td><?php echo $getbarcodeDetails->purchased_amount_per_pack ?></td>
                                 <td><?php echo $getbarcodeDetails->amount_per_pack ?></td>
                              </tr>
                              <?php
                                 }
                                 ?>
                               <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><b>Total</b></td>
                              <td><b><?php echo  $totalStock ?></b></td>
                              <td></td>
                              <td><?php echo  "Rs. ".$totalPurchasedAmount ?></td>
                              <td><?php echo  "Rs. ".$totalAmount ?></td>
                           </tr>
                                 
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