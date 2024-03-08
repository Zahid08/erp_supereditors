<?php
$purchaseid = $_GET["purchase_item_entry_id"];

$perchasedataDetails = $this->db->query("SELECT * FROM purchase_item_entry WHERE is_active = 1 ")->result();
$perchaseDetails = $this->db->query("SELECT * FROM purchase_item_entry WHERE is_active = 1 AND purchase_item_entry_id=$purchaseid")->result();
$transportDetails = $this->db->query("SELECT * FROM transport WHERE is_active = 1")->result();
$itemDetails = $this->db->query("SELECT * FROM items WHERE is_active = 1")->result();
$supplierDetails = $this->db->query("SELECT * FROM supplier WHERE is_active = 1")->result();
$measureDetails = $this->db->query("SELECT * FROM measure WHERE is_active = 1")->result();
$itemtypeDetails = $this->db->query("SELECT * FROM item_type WHERE is_active = 1")->result();
$itemtypeDetails = $this->db->query("SELECT * FROM item_type WHERE is_active = 1")->result();
$brandDetails = $this->db->query("SELECT * FROM brand WHERE is_active = 1")->result();
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
    <title>SuperEditors || Roles Page</title>
    <!-- Custom CSS -->
    
    <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">a
    
    
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
                    <h3 class="text-primary">Measue</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Measure</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
            <section id="enquiry_section" name="enquiry_section">
               <center>
                    <p style="color:green"><?php echo $this->session->flashdata('purchase_message') ?></p>
                </center>
               <div id="addRole" class="collapse in">
                  <div class="card">
                     <div class="card-body">
                        
                        <h5 class="card-title">Purchase</h5>
                        <?php foreach($perchaseDetails as $getperchaseDetails){ ?>
                    <form method="post" action="<?php echo base_url() ?>Purchase/save_edit_purchase_data" onsubmit="return confirm('Purchase Data Sucessfully Updated ?');" autocomplete="off">
                               <input class="form-control" type="hidden" name="purchase_item_entry_id" id="purchase_item_entry_id" value="<?php echo $purchaseid ?>" required>
                              <div class="row">
                            <div class="col-sm-4">
                                <label>Inward Number</label>
                                 <input class="form-control" name="inword_number" value="<?php echo $getperchaseDetails->inward_no ?>" id="inword_number"   required>
                              </div>
                              <!--   <div class="col-sm-4">
                                   <label>Tax Type</label>
                                  <select class="form-control" name="tax_type" id="tax_type"  required>
                                           <?php foreach($perchasedataDetails as $getperchasedataDetails){ ?>
                                      <option value="<?php echo $getperchasedataDetails->purchase_item_entry_id ?>" <?php if($getperchaseDetails->tax_type == $getperchasedataDetails->purchase_item_entry_id)
                                      { ?> selected <?php } ?>><?php echo $getperchasedataDetails->tax_type  ?></option>
                                      <?php } ?>
                                  </select>
                              </div>-->
                              <div class="col-sm-4">
                                  <label>Supplier Name</label>
                                 <select class="form-control" name="supplier_name" placeholder="supplier Name" id="role" required>
                                    
                                        <?php foreach($supplierDetails as $getsupplierDetails){ ?>
                                      <option value="<?php echo $getsupplierDetails->supplier_id ?>" <?php if($getperchaseDetails->supplier_name == $getsupplierDetails->supplier_id)
                                      { ?> selected <?php } ?>><?php echo $getsupplierDetails->supplier_name  ?></option>
                                      <?php } ?>
                                      
                                      
                                 </select>
                              </div>
                              <div class="col-sm-4">
                                  <label>Challan/Bill number</label></label>
                                 <input class="form-control" name="challan_number" id="challan_number" value="<?php echo $getperchaseDetails->challan_no ?>" required>
                              </div>
                              <div class="col-sm-4">
                                   <label>Inward Date</label>
                                 <input class="form-control" type="date" name="inword_date" value="<?php echo $getperchaseDetails->inward_date ?>" id="inword_date"   required>
                              </div>
                              <div class="col-sm-4">
                                   </div>
                              <div class="col-sm-4">
                                 </div>
                              
                              
                              <div class="col-sm-4">
                                  <label>Transport Name</label>
                                 <select class="form-control" name="transport_Name" id="role" required>
                                     
                                     <?php foreach($transportDetails as $gettransportDetails){ ?>
                                      <option value="<?php echo $gettransportDetails->transport_id ?>" <?php if($getperchaseDetails->transport_name == $gettransportDetails->transport_id)
                                      { ?> selected <?php } ?>><?php echo $gettransportDetails->transport_name  ?></option>
                                      <?php } ?>
                                     
                                 </select>
                              </div>
                               
                               <div class="col-sm-4">
                                   <label>L.R.Number</label>
                                 <input class="form-control"  name="lr_no" id="lr_no" value="<?php echo $getperchaseDetails->lr_no ?>"  required>
                              </div>
            <div class="col-sm-4 mt-2">
                     <label>L.R.Amount (Per Parcel)</label>
            <input class="form-control" type="number"  name="lrper_amout" id="lrper_amout" value="<?php echo $getperchaseDetails->lrper_amout ?>"  required>  
          </div>
          <div class="col-sm-4 mt-2">
            <label>L.R. Qty</label>
            <input class="form-control" type="number"  name="lrqty_amout" id="lrqty_amout" value="<?php echo $getperchaseDetails->lrqty_amout ?>"  required>  
          </div>
                               <div class="col-sm-4">
                                   <label>L.R.Amount</label>
                                 <input class="form-control"  name="lr_amout" id="lr_amout"  value="<?php echo $getperchaseDetails->lr_amount ?>"  required>
                              </div>
                              <div class="col-sm-4">
                                  <label>L.R.Date</label>
                                 <input class="form-control" type="date" name="lr_date" id="lr_date" value="<?php echo $getperchaseDetails->lr_date ?>"   required>
                              </div>
                              <div class="col-sm-4">
                                  <label>Shawroom Name</label>
                                 <input class="form-control" name="showroom_name" id="showroom_name" value="<?php echo $getperchaseDetails->shaowroom_name ?>"  required>
                              </div>
                               <div class="col-sm-4">
                                   <label>Item Type</label>
                                <select class="form-control" name="item_type" id="role" required>
                                       
                                         <?php foreach($itemtypeDetails as $getitemtypeDetails){ ?>
                                      <option value="<?php echo $getitemtypeDetails->item_type_id ?>" <?php if($getperchaseDetails->item_type == $getitemtypeDetails->item_type_id)
                                      { ?> selected <?php } ?>><?php echo $getitemtypeDetails->item_type  ?></option>
                                      <?php } ?>
                                     
                                 </select>
                               </div>
                               <div class="col-sm-4">
                                   <label>Brand Name</label>
                                <select class="form-control" name="brand_name" id="role" required>
                                       
                                         <?php foreach($brandDetails as $getbrandDetails){ ?>
                                      <option value="<?php echo $getbrandDetails->brand_id ?>" <?php if($getperchaseDetails->brand_name == $getbrandDetails->brand_id)
                                      { ?> selected <?php } ?>><?php echo $getbrandDetails->brand_name  ?></option>
                                      <?php } ?>
                                     
                                 </select>
                               </div>
                              
                              
                              <div class="col-sm-4">
                                  <label>Item Name</label>
                                <select class="form-control" name="item_name" id="role" required>
                                        
                                          <?php foreach($itemDetails as $getitemDetails){ ?>
                                      <option value="<?php echo $getitemDetails->item_id ?>" <?php if($getperchaseDetails->item_name == $getitemDetails->item_id)
                                      { ?> selected <?php } ?>><?php echo $getitemDetails->item_name  ?></option>
                                      <?php } ?>
                                        
                                      
                                 </select>
                               </div>
                               <div class="col-sm-4">
                                   <label>Measure Name</label>
                               <select class="form-control" name="size" id="role" required>
                                   
                                     
                                          <?php foreach($measureDetails as $getmeasureDetails){ ?>
                                      <option value="<?php echo $getmeasureDetails->measure_id ?>" <?php if($getperchaseDetails->measure_name == $getmeasureDetails->measure_id)
                                      { ?> selected <?php } ?>><?php echo $getmeasureDetails->measure_name  ?></option>
                                      <?php } ?>
                                     
                                 </select>
                              </div>
                               <div class="col-sm-4">
                                   <label>Stock Qty</label>
                                 <input class="form-control" name="Stock_qty" id="Stock_qty"  value="<?php echo $getperchaseDetails->stock_qty ?>"  required>
                              </div>
                              <div class="col-sm-4">
                                  <label>Billing Qty</label>
                                 <input class="form-control" name="billing_qty" id="billling_qty" value="<?php echo $getperchaseDetails->billing_qty ?>"   required>
                              </div>
                               <div class="col-sm-4">
                                   <label>No Of Packs</label>
                                 <input class="form-control" name="no_packs" id="no_packs" value="<?php echo $getperchaseDetails->no_of_packs ?>"  required>
                              </div>
                               <div class="col-sm-4">
                                   <label>Qty Per Pack</label>
                                 <input class="form-control" name="Qty_per_pack" id="Qty_per_pack" value="<?php echo $getperchaseDetails->qty_per_pack ?>"  required>
                              </div>
                             
                               <div class="col-sm-4">
                                   <label>Rate</label>
                                 <input class="form-control" name="rate" id="rate" value="<?php echo $getperchaseDetails->rate ?>"   required>
                              </div>
                               <div class="col-sm-4">
                                   <label>MRP</label>
                                 <input class="form-control" name="mrp" id="mrp"  value="<?php echo $getperchaseDetails->mrp ?>" required>
                              </div>
                                <div class="col-sm-4">
                                    <label>Tax Per</label>
                                 <input class="form-control" name="tax_per" id="tax_per" value="<?php echo $getperchaseDetails->tax_per ?>"  required>
                              </div> 
                              <div class="col-sm-4">
                                   <label>Amount</label>
                                 <input class="form-control" name="amount" id="amount" value="<?php echo $getperchaseDetails->amount ?>"   required>
                              </div>
                              
                             
                                <div class="col-sm-4">
                                     <label>Total Tax</label>
                                 <input class="form-control" name="total_tax" id="addition_amount" value="<?php echo $getperchaseDetails->total_tax ?>"  required>
                              </div>
                                <div class="col-sm-4">
                                     <label>GST % Tpt</label>
                                 <input class="form-control" name="gst_tpt" id="addition_amount" value="<?php echo $getperchaseDetails->gst_tpt ?>" required>
                              </div>
                               
                               <div class="col-sm-4">
                                    <label>Total IGST</label>
                                 <input class="form-control" name="total_igst" id="total_igst"  value="<?php echo $getperchaseDetails->total_igst ?>"  required>
                              </div>
                                <div class="col-sm-4">
                                     <label>Total CGST</label>
                                 <input class="form-control" name="total_cgst" id="total_cgst" value="<?php echo $getperchaseDetails->total_cgst ?>"  required>
                              </div>  
                              <div class="col-sm-4">
                                   <label>Total SGST</label>
                                 <input class="form-control" name="total_sgst" id="total_sgst" value="<?php echo $getperchaseDetails->total_sgst ?>" required>
                              </div>
                               <div class="col-sm-4">
                                    <label>IGST Tpt</label>
                                 <input class="form-control" name="igst_tpt" id="total_cgst"  value="<?php echo $getperchaseDetails->igst_tpt ?>" required>
                              </div> 
                               <div class="col-sm-4">
                                    <label>CGST Tpt</label>
                                 <input class="form-control" name="cgst_tpt" id="total_cgst"  value="<?php echo $getperchaseDetails->cgst_tpt ?>" required>
                              </div>  
                              <div class="col-sm-4">
                                   <label>sGST tp</label>
                                 <input class="form-control" name="sgst_tpt" id="total_cgst"  value="<?php echo $getperchaseDetails->sgst_tpt ?>" required>
                              </div> 
                              
                              <div class="col-sm-4">
                                   <label>Received By</label>
                                 <input class="form-control" name="Received_by" id="Received_by" value="<?php echo $getperchaseDetails->recieved_by ?>"  required>
                              </div>  
                              <div class="col-sm-4"> 
                              <label>net Amount</label>
                                 <input class="form-control" name="net_amount" id="net_amount"  value="<?php echo $getperchaseDetails->net_amount ?>" required>
                              </div> 
                              		
                             
                              <div class="col-sm-12">
                                <p>&nbsp;</p>  
                              </div>
                              <div class="col-sm-12">
                                 <br>
                                 <button type="submit" class="btn btn-primary  text-white" >Save</button>
                              </div>
                           </div>
                        </form>
                        <?php } ?>
                     </div>
                  </div>
               </div>
            </section>
               
            
            <!-- Start Page Content -->   
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