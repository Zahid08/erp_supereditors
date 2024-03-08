<?php
error_reporting(0);
$inward_no = $_GET['inward_no'];
$itemValue = $this->db->query("SELECT * FROM purchase_item_entry p WHERE inward_no = '$inward_no' ")->result();

if(!empty($inward_no)){
 $purchaseDetails = $this->db->query("SELECT * FROM purchase_item_entry p LEFT JOIN purchase_item s ON s.purchase_item_entry_id = p.purchase_item_entry_id WHERE inward_no = '$inward_no' order by p.purchase_item_entry_id desc")->result();
 foreach($purchaseDetails as $getpurchase){
     $inward_no = $getpurchase->inward_no;
     $inward_date = $getpurchase->inward_date;
     $tax_type = $getpurchase->tax_type;
     $supplier_id = $getpurchase->supplier_id;
     $challan_no = $getpurchase->challan_no;
     $transport_id = $getpurchase->transport_name;
     $lr_no = $getpurchase->supplier_id;
     $lr_amount = $getpurchase->lr_amount;
     $lr_quantity= $getpurchase->lr_quantity;
     $lr_date = $getpurchase->lr_date;
     $shaowroom_name = $getpurchase->shaowroom_name;
     $item_type_id = $getpurchase->item_type_id;
     $item_id = $getpurchase->item_id;
     $measure_id = $getpurchase->measure_id;
     $stock_qty = $getpurchase->stock_qty;
     $billing_qty = $getpurchase->billing_qty;
     $no_of_packs = $getpurchase->no_of_packs;
     $qty_per_pack = $getpurchase->qty_per_pack;
     $rate = $getpurchase->rate;
     $mrp = $getpurchase->mrp;
     $tax_per = $getpurchase->tax_per;
     $amount = $getpurchase->amount;
     $addition_amount = $getpurchase->addition_amount;
     $totstkqty = $getpurchase->totstkqty;
     $totbillqty = $getpurchase->totbillqty;
     $totamount = $getpurchase->totamount;
     $total_igst = $getpurchase->total_igst;
     $total_cgst = $getpurchase->total_cgst;
     $total_sgst = $getpurchase->total_sgst;
     $total_transport = $getpurchase->total_transport;
     $anyadd = $getpurchase->anyadd;
     $discount = $getpurchase->discount;
     $company_name = $getpurchase->company_name;
     $gst_tpt = $getpurchase->gst_tpt;
     $any_deduction = $getpurchase->any_deduction;
     $igst_tpt = $getpurchase->igst_tpt;
     $cgst_tpt = $getpurchase->cgst_tpt;
     $sgst_tpt = $getpurchase->sgst_tpt;
     $receivedby = $getpurchase->receivedby;
     $total_tax = $getpurchase->total_tax;
     $netamt = $getpurchase->netamt;
     $discountamount = $getpurchase->discountamount;
  }
  $supplierDetailsValue = $this->db->query("SELECT supplier_name FROM supplier WHERE supplier_id = $supplier_id")->row();
  $supplierName = $supplierDetailsValue->supplier_name;
  $transportDetails = $this->db->query("SELECT transport_name FROM transport WHERE transport_id = $transport_id")->row();
  $transport_name = $transportDetails->transport_name;
  $itemtypeDetails = $this->db->query("SELECT item_type FROM item_type WHERE item_type_id = $item_type_id")->row();
  $item_type = $itemtypeDetails->item_type;
  $itemDetails = $this->db->query("SELECT item_name FROM items WHERE item_id = $item_id")->row();
  $item_name = $itemDetails->item_name;
  $measureDetails = $this->db->query("SELECT measure_name FROM measure WHERE measure_id = $measure_id")->row();
  $measure_name = $measureDetails->measure_name;
 }
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url(); ?>assets/client_asstes/images/favicon.png">
      <title>SuperEditors || Purchase Page</title>
      <link href="<?php echo base_url(); ?>assets/client_asstes/css/style.css" rel="stylesheet">
      <!--for bootstrap Model-->
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
      <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
      <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/dataTables.bootstrap5.min.css">
      <style>
        .form-control.custom-height {
            height: 25px;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
            line-height: 30px;
        }
        .table td, .table th {
            padding: 0.2em;
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
                <!-- Bread crumb -->
                <div class="container-fluid" id="fullScreenDiv">
                <center>
                    <p style="color:green"><?php echo $this->session->flashdata('purchase_item_messege') ?>
                    </p>
                </center>
                <form method="post" action = "" id="billgeneratedForm">
                    <div class="col-sm-12">
                        <div class="row" style="border-style: ridge;">
                            <div class="col-sm-5">
                               <div class="row">
                                    <div class="col-sm-4">
                                        <small>Inward No</small>
                                        <input class="form-control custom-height" type="text" name="inward_no" id="inward_no"  placeholder="Inward No" value="<?php echo $inward_no; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Tax Type</small>
                                        <input class="form-control custom-height" name="tax_type" id="tax_type" value="<?php echo $tax_type; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Company Name</small>
                                        <input class="form-control custom-height" name="company_name"   id="company_name" value="<?php echo $company_name; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Suppiler Name</small>
                                        <input class="form-control custom-height" name="supplier_name" id="supplier_name" value="<?php echo $supplierName; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Supp. Bill/Ch No</small>
                                        <input class="form-control custom-height" type="text" name="challan_number" id="challan_number" placeholder="Challan Number" value="<?php echo $challan_no; ?>"readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Transport Name</small>
                                        <input class="form-control custom-height" name="transport_name" id="transport_name" value="<?php echo $transport_name; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Inward Date</small>
                                        <input class="form-control custom-height" type="date" name="inword_date" max="<?php echo date("Y-m-t") ?>"  placeholder="Inward Date" id="inword_date"  value="<?php echo $inward_date; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>L.R.No.</small>
                                        <input class="form-control custom-height" type="number" name="lr_no" id="lr_no" placeholder="L.R.No" value="<?php echo $lr_no; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>L.R.Quantity.</small>
                                        <input class="form-control custom-height" type="number" name="lr_qty" id="lr_qty" placeholder="L.R.Qty" value="<?php echo $lr_quantity; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>L.R.Amount.</small>
                                        <input class="form-control custom-height" type="number" name="lr_amt" id="lr_amt" placeholder="L.R.Amount"value="<?php echo $lr_amount; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>L.R.Date</small>
                                        <input class="form-control custom-height" type="date" name="lr_date" max="<?php echo date("Y-m-t") ?>"  placeholder="L.R.Date" id="lr_date" value="<?php echo $lr_date; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                    <small>Showroom Name</small>
                                        <input class="form-control custom-height" name="showroom_name" id="showroom_name" placeholder="Showroom" value="<?php echo $shaowroom_name; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Item Type</small>
                                        <input class="form-control custom-height" name="item_type" id="item_type" value="<?php echo $item_type; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Item Name</small>
                                        <input class="form-control custom-height" name="item_name" id="item_name" value="<?php echo $item_name; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Size</small>
                                        <input class="form-control custom-height" name="size" id="size" value="<?php echo $measure_name; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Stock Quantity</small>
                                        <input class="form-control custom-height" type="text" name="Stock_qty" id="Stock_qty" placeholder="Stock Quantity" value="<?php echo $stock_qty; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Billling Quantity</small>
                                        <input class="form-control custom-height" type="text" name="billing_qty" id="billing_qty" placeholder="Billing Qty" value="<?php echo $billing_qty; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Number Of Pack</small>
                                        <input class="form-control custom-height" type="number" name="no_packs" id="no_packs"  placeholder="Number of packs" value="<?php echo $no_of_packs; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Quantity Per Pack</small>
                                        <input class="form-control custom-height" type="number" name="Qty_per_pack" id="Qty_per_pack" placeholder="Qty per pack" value="<?php echo $qty_per_pack; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Rate</small>
                                        <input class="form-control custom-height" type="text" name="rate" id="rate" placeholder="Rate" step=".01" value="<?php echo $rate; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>MRP</small>
                                        <input class="form-control custom-height" type="number" name="mrp" id="mrp" placeholder="MRP" step=".01" value="<?php echo $mrp; ?>"  readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Tax Per</small>
                                        <input class="form-control custom-height" type="text" name="tax" id="tax" placeholder="Tax Per" value="<?php echo $tax_per; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Amount</small>
                                        <input class="form-control custom-height" type="text" name="amount" id="amount" placeholder="Amount" value="<?php echo $amount; ?>" readonly>
                                    </div>
                                    <div class="col-sm-4">
                                        <br>
                                        <button type="submit" class="btn btn-sm btn-primary text-white" id="add">ADD</button>
                                        <button type="submit" class="btn btn-sm btn-primary text-white" id="remove">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7"style="padding-top: 10px;">
                                <div class="table-responsive" style="border-style: double;height:300px;position:relative;" id="barcodeBlock">
                                <table class="table table-striped table-bordered table-hover" id="purchaseTable">
                                 <thead>
                                    <tr>
                                       <th style="border: 0.5px solid gray">Sr.No</th>
                                       <th style="border: 0.5px solid gray">Item Name</th>
                                       <th style="border: 0.5px solid gray">Measure</th>
                                        <th style="border: 0.5px solid gray">Size</th>
                                        <th style="border: 0.5px solid gray">Shade</th>
                                       <th style="border: 0.5px solid gray">Stk Qty</th>
                                       <th style="border: 0.5px solid gray">Bill Qty</th>
                                       <th style="border: 0.5px solid gray">Rate</th>
                                       <th style="border: 0.5px solid gray">Amount</th>
                                       <th style="border: 0.5px solid gray">Tax type</th>
                                    </tr>
                                 </thead>
                                    <tbody>
                                       <?php
                                       $i = 1;

                                       foreach ($itemValue as $val) {
                                          $itemDetails = $this->db->query("SELECT item_name FROM items WHERE item_id = $val->item_id")->row();
                                          $item_name = $itemDetails->item_name;
                                          $measureDetails = $this->db->query("SELECT measure_name FROM measure WHERE measure_id = $val->measure_id")->row();
                                          $measure_name = $measureDetails->measure_name;
                                          ?>
                                          <tr>
                                                <td><?php echo $i++; ?></td>
                                                <td><?php echo $item_name; ?></td>
                                                <td><?php echo $measure_name; ?></td>
                                                <td><?php echo $val->size; ?></td>
                                                <td><?php echo $val->color; ?></td>
                                                <td><?php echo $val->stock_qty; ?></td>
                                                <td><?php echo $val->billing_qty; ?></td>
                                                <td><?php echo $val->rate; ?></td>
                                                <td><?php echo $val->amount; ?></td>
                                                <td><?php echo $val->tax_type; ?></td>
                                          </tr>
                                       <?php
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                                </div>
                            </div>
                                <div class="col-sm-2">
                                    <small> GST Tpt</small>
                                    <input class="form-control custom-height" type="text" name="gst"  id="gst" placeholder="GST" value="<?php echo $gst_tpt; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small>IGST Tpt</small>
                                    <input class="form-control custom-height" type="number" name="igst_tpt" id="igst_tpt" placeholder="IGST Tpt" value="<?php echo $igst_tpt; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> CGST Tpt</small>
                                    <input class="form-control custom-height" type="number" name="cgst_tpt"  id="cgst_tpt" placeholder="CGST Tpt" value="<?php echo $cgst_tpt; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> SGST Tpt</small>
                                    <input class="form-control custom-height" type="number" name="sgst_tpt" id="sgst_tpt" placeholder="SGST Tpt" value="<?php echo $sgst_tpt; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small>Tot Stk Qty</small>
                                    <input class="form-control custom-height" type="text" name="totstkqty" id="totstkqty"   placeholder="Tot Stk Qty" value="<?php echo $totstkqty; ?>" readonly>
                                </div>                
                                <div class="col-sm-2">
                                    <small>Tot Bill Qty</small>
                                    <input class="form-control custom-height" type="text" name="totbillqty" id="totbillqty"   placeholder="Tot Bill Qty" value="<?php echo $totbillqty; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small>Basic Amount</small>
                                    <input class="form-control custom-height" type="text" name="totamount" id="totamount" placeholder="Total Amount" value="<?php echo $totamount; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> Total Tax</small>
                                    <input class="form-control custom-height" type="text" name="tax_per" id="tax_per" placeholder="Total Tax"value="<?php echo $total_tax; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small>Total IGST</small>
                                    <input class="form-control custom-height" type="text" name="total_igst" id="total_igst" placeholder="IGST" value="<?php echo $total_igst; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> Total CGST</small>
                                    <input class="form-control custom-height" type="text" name="total_cgst"  id="total_cgst" placeholder="CGST"value="<?php echo $total_cgst; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> Total SGST</small>
                                    <input class="form-control custom-height" type="text" name="total_sgst" id="total_sgst" placeholder="SGST" value="<?php echo $total_sgst; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small>Total Transport</small>
                                    <input class="form-control custom-height" type="number" name="total_transport" id="total_transport" placeholder="Total Transport" value="<?php echo $total_transport; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> Any Addition</small>
                                    <input class="form-control custom-height" type="number" name="anyadd" id="anyadd" placeholder="Any Addition" value="<?php echo $anyadd; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> Received By</small>
                                    <input class="form-control custom-height" type="text" name="receivedby" id="receivedby" placeholder="Received By" value="<?php echo $receivedby; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> Any Discount(in %)</small>
                                    <input class="form-control custom-height" type="number" name="disamt" id="disamt" placeholder="Any Discount"value="<?php echo $discount; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> Discount Amount</small>
                                    <input class="form-control custom-height" type="text" name="discountamount" id="discountamount" placeholder="Discount Amount" value="<?php echo $discountamount; ?>" readonly>
                                </div>
                                <div class="col-sm-2">
                                    <small> Net Amt</small>
                                    <input class="form-control custom-height" type="text" name="netamt" id="netamt" placeholder="Net Amt" value="<?php echo $netamt; ?>" readonly>
                                </div>
                            </div>
                        <div class="col-sm-12">
                            <div style="margin-top: 15px;text-align: center;" id="barcodeBlock" class="hide-div">
                                <button type="button" class="btn btn-sm btn-primary text-white" id="bulkItemLoad">Save</button>
                                <button type="button" class="btn btn-sm btn-primary text-white" id="closeButton">Cancel</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
      <!-- Start Page Content -->   
      <!-- End Container fluid  -->
      <!-- footer -->
      <?php include("includes/footer.php") ?>
      <!-- End footer -->
      </div>
      <!-- End Page wrapper  -->
      </div>
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
        <!-- Include DataTables script -->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/datatables/datatables.min.js"></script>

        <!-- Your custom scripts -->
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/webticker/jquery.webticker.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/lib/peitychart/jquery.peity.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/custom.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/client_asstes/js/dashboard-1.js"></script>
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
      <script src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.min.js"></script>
      <script src="https://cdn.datatables.net/1.11.6/js/dataTables.bootstrap5.min.js"></script>
      <script>
         $(document).ready(function () {
            $('#purchaseTable').DataTable({
                  "paging": false,
                  "ordering": false,
                  "info": false,
                  "responsive": true,
                  "searching": false,
            });
         });
      </script>
   </body>
</html>