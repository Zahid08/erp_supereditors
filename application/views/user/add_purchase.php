<?php
error_reporting(0);
   $transportDetails = $this->db->query("SELECT * FROM transport WHERE is_active = 1")->result();
   $supplierDetailsValue = $this->db->query("SELECT * FROM supplier WHERE is_active = 1")->result();
   $measureDetails = $this->db->query("SELECT * FROM measure WHERE is_active = 1")->result();
   $itemtypeDetails = $this->db->query("SELECT * FROM item_type WHERE is_active = 1")->result();
   if(!empty($purchase_supplier_id)){
      $supplierDetails = $this->db->query("SELECT *,s.supplier_name,s.gst,s.state_id FROM purchase_supplier p INNER JOIN supplier s ON s.supplier_id=p.supplier_id WHERE p.is_active = 1 AND s.is_active = 1 AND purchase_supplier_id = $purchase_supplier_id  ORDER BY purchase_supplier_id DESC")->result(); 
         foreach($supplierDetails as $getsupplierDetails){
               $purchase_supplier_id = $getsupplierDetails->purchase_supplier_id;
               $supplier_name = $getsupplierDetails->supplier_name;
               $showroom_name = $getsupplierDetails->showroom_name;
               $challan_no = $getsupplierDetails->challan_no;
               $inward_date = $getsupplierDetails->inward_date;
               $company_name = $getsupplierDetails->company_name;
               $lr_no = $getsupplierDetails->supplier_id;
               $gst = $getsupplierDetails->gst;
               $state= $getsupplierDetails->state_id;
               $inward_no = $getsupplierDetails->inward_no;     
               $dicount=0;
            }
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
      <style>
        .form-control.custom-height {
            height: 25px;
        }
        select.custom-height {
            height: 30px !important;
        }
        .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
            line-height: 12px;
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
                                        <input class="form-control custom-height" type="text" name="inward_no" id="inward_no"  placeholder="Inward No" readonly required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Tax Type</small>
                                        <select class="form-control custom-height" name="tax_type" id="tax_type" required>
                                            <option value="">Choose Tax Type</option>
                                            <option value="C&SGST" <?php echo ($tax_type == "C&SGST") ? 'selected' : ''; ?>>C&SGST</option>
                                            <option value="IGST" <?php echo ($tax_type == "IGST") ? 'selected' : ''; ?>>IGST</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Company Name</small>
                                        <select class="form-control custom-height" name="company_name"   id="company_name" required>
                                        <option value="">Company Name </option>
                                        <option value="SuperEditors" <?php if($company_name == "SuperEditors"){ ?>selected<?php } ?> >SuperEditors </option>
                                        <option value="MannaMenswear" <?php if($company_name == "MannaMenswear"){ ?>selected<?php } ?> >MannasMensWear </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Suppiler Name</small>
                                        <select class="form-control custom-height" name="supplier_name" id="supplier_name" required>
                                            <option value="">Choose suppiler Name</option>
                                            <?php foreach($supplierDetailsValue as $getsupplierDetails){ ?>
                                            <option value="<?php echo $getsupplierDetails->supplier_id ?>" <?php if($getsupplierDetails->supplier_id == $supplierid){ ?>selected<?php } ?> ><?php echo $getsupplierDetails->supplier_name  ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Supp. Bill/Ch No</small>
                                        <input class="form-control custom-height" type="text" name="challan_number" id="challan_number" placeholder="Challan Number" required>
                                        <span id="challan_numberError" style="color: red;"></span>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Transport Name</small>
                                        <select class="form-control custom-height" name="transport_name" id="transport_name" required>
                                            <option value="">Choose Transport Name</option>
                                            <?php foreach($transportDetails as $val){ ?>
                                            <option value="<?php echo $val->transport_id ?>" <?php if($val->transport_id == $transportid){ ?>selected<?php } ?> ><?php echo $val->transport_name  ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Inward Date</small>
                                        <input class="form-control custom-height" type="date" name="inword_date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date('Y-m-d'); ?>" placeholder="Inward Date" id="inword_date" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>L.R.No.</small>
                                        <input class="form-control custom-height" type="number" name="lr_no" id="lr_no" placeholder="L.R.No" required>
                                        <span id="lr_noError" style="color: red;"></span>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>L.R.Quantity.</small>
                                        <input class="form-control custom-height" type="number" name="lr_qty" id="lr_qty" placeholder="L.R.Qty" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>L.R.Amount.</small>
                                        <input class="form-control custom-height" type="number" name="lr_amt" id="lr_amt" placeholder="L.R.Amount" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>L.R.Date</small>
                                        <input class="form-control custom-height" type="date" name="lr_date" max="<?php echo date("Y-m-t") ?>"  placeholder="L.R.Date" id="lr_date"   required>
                                    </div>
                                    <div class="col-sm-4">
                                    <small>Party Name</small>
                                        <select class="form-control custom-height" name="showroom_name" id="showroom_name" placeholder="Select Party" required>
                                            <option>Select Party</option>
                                            <option value=""<?php if(!empty($showroom_name)){ ?>selected<?php } ?>><?php echo $showroom_name ?></option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Item Type</small>
                                        <select class="form-control custom-height" name="item_type" id="item_type" required>
                                            <option value="">Choose Item Type</option>
                                            <?php foreach($itemtypeDetails as $getitemtypeDetails){ ?>
                                            <option value="<?php echo $getitemtypeDetails->item_type_id ?>"><?php echo $getitemtypeDetails->item_type  ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Item Name</small>
                                        <select class="form-control custom-height" name="item_name" id="item_name" required>
                                            <option value="">Choose Item Name</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Measure</small>
                                        <select class="form-control custom-height" name="size" id="size" required>
                                        <option value="">Choose Measure</option>
                                            <?php foreach($measureDetails as $getmeasureDetails){ ?>
                                            <option value="<?php echo $getmeasureDetails->measure_id ?>"><?php echo $getmeasureDetails->measure_name  ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Size</small>
                                        <input class="form-control custom-height" type="text" name="measurement" id="measurement" placeholder="Size" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Color</small>
                                        <input class="form-control custom-height" type="text" name="color" id="color" placeholder="Color"  required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Stock Quantity</small>
                                        <input class="form-control custom-height" type="text" name="Stock_qty" id="Stock_qty" placeholder="Stock Quantity" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Billling Quantity</small>
                                        <input class="form-control custom-height" type="text" name="billing_qty" id="billing_qty" placeholder="Billing Qty"  required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Number Of Pack</small>
                                        <input class="form-control custom-height" type="number" name="no_packs" id="no_packs"  placeholder="Number of packs" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Quantity Per Pack</small>
                                        <input class="form-control custom-height" type="number" name="Qty_per_pack" id="Qty_per_pack" placeholder="Qty per pack" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Rate</small>
                                        <input class="form-control custom-height" type="text" name="rate" id="rate" placeholder="Rate" step=".01" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>MRP</small>
                                        <input class="form-control custom-height" type="number" name="mrp" id="mrp" placeholder="MRP" step=".01"   required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Tax Per</small>
                                        <input class="form-control custom-height" type="text" name="tax" id="tax" placeholder="Tax Per" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <small>Amount</small>
                                        <input class="form-control custom-height" type="text" name="amount" id="amount" placeholder="Amount" required>
                                    </div>
                                    <div class="col-sm-4">
                                        <br>
                                        <button type="submit" class="btn btn-sm btn-primary text-white" id="add">ADD</button>
                                        <button type="submit" class="btn btn-sm btn-primary text-white" id="remove">Remove</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-7"style="padding-top: 10px;">
                                <div class="table-responsive" style="border-style: double;height:400px;position:relative;" id="barcodeBlock">
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="border: 0.5px solid gray">Sr.No</th>
                                                <th style="border: 0.5px solid gray"><input type="checkbox" style="=" id="checkall"  class=""></th>
                                                <th style="border: 0.5px solid gray">Item Name</th>
                                                <th style="border: 0.5px solid gray">Stk Qty</th>
                                                <th style="border: 0.5px solid gray">Bill Qty</th>
                                                <th style="border: 0.5px solid gray">Measure</th>
                                                <th style="border: 0.5px solid gray">Size</th>
                                                <th style="border: 0.5px solid gray">Shade</th>
                                                <th style="border: 0.5px solid gray">Rate</th>
                                                <th style="border: 0.5px solid gray">Amount</th>
                                                <th Style="border: 0.5px solid gray">Tax type</th>
                                                <th Style="border: 0.5px solid gray">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="getCodeGenerationLeftBlock">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                <div class="col-sm-2">
                                    <small> GST Tpt</small>
                                    <input class="form-control custom-height" type="text" name="gst"  id="gst" placeholder="GST" required>
                                </div>
                                <div class="col-sm-2">
                                    <small>IGST Tpt</small>
                                    <input class="form-control custom-height" type="number" name="igst_tpt" id="igst_tpt" placeholder="IGST Tpt" required>
                                </div>
                                <div class="col-sm-2">
                                    <small> CGST Tpt</small>
                                    <input class="form-control custom-height" type="number" name="cgst_tpt"  id="cgst_tpt" placeholder="CGST Tpt" required>
                                </div>
                                <div class="col-sm-2">
                                    <small> SGST Tpt</small>
                                    <input class="form-control custom-height" type="number" name="sgst_tpt" id="sgst_tpt" placeholder="SGST Tpt" required>
                                </div>
                                <div class="col-sm-2">
                                    <small>Tot Stk Qty</small>
                                    <input class="form-control custom-height" type="text" name="totstkqty" id="totstkqty"   placeholder="Tot Stk Qty">
                                </div>                
                                <div class="col-sm-2">
                                    <small>Tot Bill Qty</small>
                                    <input class="form-control custom-height" type="text" name="totbillqty" id="totbillqty"   placeholder="Tot Bill Qty">
                                </div>
                                <div class="col-sm-2">
                                    <small>Basic Amount</small>
                                    <input class="form-control custom-height" type="text" name="totamount" id="totamount" placeholder="Total Amount">
                                </div>
                                    <input type="hidden" name="basicamount" id="basicamount" placeholder="Basic Amount">
                                <div class="col-sm-2">
                                    <small> Total Tax</small>
                                    <input class="form-control custom-height" type="text" name="tax_per" id="tax_per" placeholder="Total Tax">
                                </div>
                                <div class="col-sm-2">
                                    <small>Total IGST</small>
                                    <input class="form-control custom-height" type="text" name="total_igst" id="total_igst" placeholder="IGST">
                                </div>
                                <div class="col-sm-2">
                                    <small> Total CGST</small>
                                    <input class="form-control custom-height" type="text" name="total_cgst"  id="total_cgst" placeholder="CGST">
                                </div>
                                <div class="col-sm-2">
                                    <small> Total SGST</small>
                                    <input class="form-control custom-height" type="text" name="total_sgst" id="total_sgst" placeholder="SGST">
                                </div>
                                <div class="col-sm-2">
                                    <small>Total Transport</small>
                                    <input class="form-control custom-height" type="number" name="total_transport" id="total_transport" placeholder="Total Transport" required>
                                </div>
                                <input type="hidden" name="transport" id="transport">
                                <div class="col-sm-2">
                                    <small> Any Addition</small>
                                    <input class="form-control custom-height" type="number" name="anyadd" id="anyadd" placeholder="Any Addition" required>
                                </div>
                                <div class="col-sm-2">
                                    <small> Received By</small>
                                    <input class="form-control custom-height" type="text" name="receivedby" id="receivedby" placeholder="Received By" required>
                                </div>
                                <div class="col-sm-2">
                                    <small> Any Discount(in %)</small>
                                    <input class="form-control custom-height" type="number" name="disamt" id="disamt" placeholder="Any Discount">
                                </div>
                                <div class="col-sm-2">
                                    <small> Discount Amount</small>
                                    <input class="form-control custom-height" type="text" name="discountamount" id="discountamount" placeholder="Discount Amount">
                                </div>
                                <div class="col-sm-2">
                                    <small> Net Amt</small>
                                    <input class="form-control custom-height" type="text" name="netamt" id="netamt" placeholder="Net Amt" required>
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

        <!-- Add this modal HTML structure in your HTML file -->
        <div class="modal fade" id="editPurchaseItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Edit Purchase</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closebtn">
                        <span aria-hidden="true" style="font-size:20px;position: absolute;top:5px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="<?= base_url()?>/Purchase/save_pucharse_item" autocomplete="off">
                            <input type="hidden" class="form-control" id="editId">
                            <div class="form-group">
                                <label for="editStockQty">Stock Quantity:</label>
                                <input type="text" class="form-control" id="editStockQty" placeholder="Stock Quantity">
                            </div>
                            <div class="form-group">
                                <label for="editBillingQty">Billing Quantity:</label>
                                <input type="text" class="form-control" id="editBillingQty" placeholder="Billing Quantity">
                            </div>
                            <div class="form-group">
                                <label for="editRate">Rate:</label>
                                <input type="text" class="form-control" id="editRate" placeholder="Rate">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="saveChangesButton">Save changes</button>
                    </div>
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
      <script>
        function checkLRAndSupplier() {
            var supplier = $('#supplier_name').val();
            var lr_no = parseInt($('input#lr_no').val());
            var lr_noError = $('#lr_noError');
            var url = "<?php echo base_url();?>Purchase/checkLrnoAndChallanno";

            $.ajax({
                url: url,
                type: 'POST',
                data: { lr_no: lr_no, supplier_id: supplier },
                success: function (response) {
                    console.log(response);
                    if (response == 1) {
                        lr_noError.text('LR number entry is already present in the database');
                    } else {
                        lr_noError.text('');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Request Failed:', status, error);
                    lr_noError.text('An error occurred during the AJAX request');
                }
            });
        }
        $('#supplier_name, #lr_no').on('change input', function () {
            checkLRAndSupplier();
        });

        function checkChallanAndSupplier() {
            var supplier = $('#supplier_name').val();
            var challan_numberInput = parseInt($('input#challan_number').val());
            var challan_numberError = $('#challan_numberError');
            var url = "<?php echo base_url();?>Purchase/checkLrnoAndChallanno";
            $.ajax({
                url: url,
                type: 'POST',
                data: { challan_number: challan_numberInput, supplier_id: supplier },
                success: function (response) {
                    console.log(response);
                    if (response == 1) {
                        challan_numberError.text('Challan number entry is already present in the database');
                    } else {
                        challan_numberError.text('');
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Request Failed:', status, error);
                    challan_numberError.text('An error occurred during the AJAX request');
                }
            });
        }
        $('#supplier_name, #challan_number').on('change input', function () {
            checkChallanAndSupplier();
        });
            $(document).ready(function () {
                $(document).on('click', '.editButton', function (e) {
                    e.preventDefault();
                    var row = $(this).closest('tr');
                    var purchaseItemId = row.find('input#id').val();
                    var stockQty = row.find('input#stock_quntitiy').val();
                    var billingQty = row.find('input#billing_quntityText').val();
                    var rate = row.find('input#rateText').val();

                    $('#editId').val(purchaseItemId);
                    $('#editStockQty').val(stockQty);
                    $('#editBillingQty').val(billingQty);
                    $('#editRate').val(rate);

                    // Show the edit modal
                    $('#editPurchaseItemModal').modal('show');
                    });

                    $('#closebtn').click(function () {
                        $('#editPurchaseItemModal').modal('hide');
                    });
                });
                $(document).on('change', 'select#supplier_name', function() {
                    var supplierId = $(this).val();
                    var post_data = {
                'supplierId': supplierId,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    }
                    var url = "<?php echo base_url();?>Purchase/getTaxType";
                    $.ajax({
                        url: url, 
                        type: 'POST',
                        data: post_data,
                        success: function (response) {
                            if (response!=0) {
                                $("#tax_type").val(response);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error('Error fetching tax type:', error);
                        }
                    });
                });

                $(document).on('change', 'select#item_type', function() {
                    var item_type_id = $(this).val();
                    var post_data = {
                    'item_type_id': item_type_id,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };

                    var url = "<?php echo base_url();?>Purchase/getItemName";

                    $.ajax({
                    url: url,
                    type: 'POST',
                    data: post_data,
                    success: function(result) {
                        var obj = JSON.parse(result);
                        $('select#item_name').find('option').remove();
                        $('select#item_name').append($('<option/>', {
                            value: '',
                            text: 'Select Item Name',
                        }));

                        for (var i = 0; i < obj.length; i++) {
                            $('select#item_name').append($('<option/>', {
                            value: obj[i]['item_id'],
                            text: obj[i]['item_name']
                            }));
                        }
                    }
                    });
                });

                $(document).on('change', 'select#company_name', function() {
                    var companyname=$(this).val();

                    var post_data = {
                    'companyname': companyname,
                    '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
                    };

                    var url = "<?php echo base_url();?>Purchase/getCompanyWiseCustomer";
                    $.ajax({
                    url : url,
                    type : 'POST',
                    data: post_data,
                    success : function(result)
                    {
                        var obj = JSON.parse(result);
                        $('select#showroom_name').find('option').remove();
                        $('select#showroom_name').append($('<option/>', {
                            value: '',
                            text : 'Select Showroom',
                        }));

                        for(var i=0;i<obj.length;i++)
                        {
                            $('select#showroom_name').append($('<option/>', {
                                value: obj[i]['name'],
                                text : obj[i]['name']
                            }));
                        }
                    }
                    });
                });
                $('#item_type').change(function(){
                    var id = $(this).val();
                    var sup_name = $('#supplier_name').find(":selected").val();
                    var url = "<?php echo base_url('Purchase/get_itemname'); ?>";
                    var post_data = {
                        'id': id,
                        'sup_name': sup_name,
                        '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
                    };
                    $.ajax({
                    url : url,
                    type : 'POST',
                    data: post_data,
                    success : function(result)
                    {  
                        var obj = JSON.parse(result);
                        $('#item_name').find('option').remove();
                        $('#item_name').append($('<option/>', { 
                                value: '0',
                                text : 'Select Item Name'
                            }));
                        for(var i=0;i<obj.length;i++)
                        {
                        $('#item_name').append($('<option/>', { 
                                value: obj[i]['item_id'],
                                text : obj[i]['item_name']
                            }));
                        }
                    }
                    });          
                });

                $(document).on('input', function() {
                var stockValue = parseFloat($('input#Stock_qty').val());
                var rateValue = parseFloat($('input#rate').val());
                var total=stockValue * rateValue;
                var amount = isNaN(total) ? 0 : total;
                $('input#amount').val(amount.toFixed(2));
                });

                $(document).on('input', function() {
                    var itemValue = parseInt($('select#item_name').val());
                    var supplierValue = parseInt($('select#supplier_name').val());
                    var amountValue = parseFloat($('input#amount').val());
                    var post_data = {
                    'itemValue': itemValue,
                    'supplierValue':supplierValue,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };
                    var url = "<?php echo base_url();?>Purchase/getTax";
                    $.ajax({
                    url: url,
                    type: 'POST',
                    data: post_data,
                    success: function(result) {
                            var obj = JSON.parse(result);
                            console.log(result)
                                if(obj.length=='2')
                                {
                                    var array = obj;
                                    var sum = parseFloat(array[0]) + parseFloat(array[1]);
                                    var tax = isNaN(sum) ? 0 : sum;
                                    $('input#tax').val(tax.toFixed(2));
                                    var cg=(parseFloat(array[0])/100)*amountValue;
                                    var sg=(parseFloat(array[1])/100)*amountValue;
                                    var cgst = isNaN(cg) ? 0 : cg;
                                    var sgst = isNaN(sg) ? 0 : sg;
                                    var total_tax=cgst + sgst;
                                    $('input#gst').val(total_tax.toFixed(2));
                                    $('input#cgst_tpt').val(cgst.toFixed(2));
                                    $('input#sgst_tpt').val(sgst.toFixed(2));
                                    
                                }else{
                                    var tax = isNaN(obj)|| obj=='0' ? 0 : obj;
                                    $('input#tax').val(tax);
                                    var ig=(tax/100)*amountValue;
                                    var igst = isNaN(ig) ? 0 : ig;
                                    $('input#igst_tpt').val(igst.toFixed(2));
                                    $('input#gst').val(igst.toFixed(2));
                                }
                            }
                        });
                    });
                    function calculateTotals() {
                        var totalStockQty = 0;
                        var totalBillingQty = 0;
                        var totalTax = 0;
                        var totalAmount = 0;
                        var totalIgst = 0;
                        var totalCgst = 0; 
                        var totalSgst = 0;
                        var ajaxRequests = [];

                        $('tbody#getCodeGenerationLeftBlock tr').each(function () {
                            var id = parseFloat($(this).find('input#id').val()) || 0;
                            console.log("ids", id);

                            var request = $.ajax({
                                type: 'GET',
                                url: '<?php echo base_url('Purchase/total_item_data'); ?>?id=' + id,
                                dataType: 'json'
                            });

                            ajaxRequests.push(request);
                            request.done(function (data) {
                                console.log("datas", data);
                                try {
                                    var stockQty = parseFloat(data.stock_qty) || 0;
                                    var billingQty = parseFloat(data.billing_qty) || 0;
                                    var tax = parseFloat(data.gst_tpt) || 0;
                                    var amount = parseFloat(data.amount) || 0;
                                    var igst = parseFloat(data.igst_tpt) || 0;
                                    var cgst = parseFloat(data.cgst_tpt) || 0;
                                    var sgst = parseFloat(data.sgst_tpt) || 0;

                                    totalStockQty += stockQty;
                                    totalBillingQty += billingQty;
                                    totalTax += tax;
                                    totalAmount += amount;
                                    totalIgst += igst;
                                    totalCgst += cgst;
                                    totalSgst += sgst;
                                } catch (error) {
                                    console.error('Error parsing JSON:', error);
                                }
                            });

                            request.fail(function (jqXHR, textStatus, errorThrown) {
                                console.error('AJAX request failed:', textStatus, errorThrown);
                            });
                        });

                        $.when.apply($, ajaxRequests).done(function () {
                            $('#totstkqty').val(totalStockQty.toFixed(2));
                            $('#totbillqty').val(totalBillingQty.toFixed(2));
                            $('#tax_per').val(totalTax.toFixed(2));
                            $('#totamount').val(totalAmount.toFixed(2));
                            $('#total_igst').val(totalIgst.toFixed(2));
                            $('#total_cgst').val(totalCgst.toFixed(2));
                            $('#total_sgst').val(totalSgst.toFixed(2));

                            var netAmt = totalTax + totalAmount;
                            $('#netamt').val(Math.round(netAmt).toFixed(2));
                        });
                    }

                    function onDataChange() {
                        calculateTotals();
                    }   
            var countCalling = 0;
            $(document).ready(function () {
                var rowIndex; 
                $(document).on('click', 'button#add', function (e) {
                    e.preventDefault();
                    var rowIndex = $('tbody#getCodeGenerationLeftBlock tr').length + 1;
                    var isValid = validateForm($('#billgeneratedForm').serializeArray(), rowIndex);

                    if (!isValid) {
                        alert('Please fill in all required fields.');
                        return;
                    }
                    var data = $('#billgeneratedForm').serializeArray();
                    var url = "<?php echo base_url('Purchase/save_purchase_item_data'); ?>";
                    data.push({
                        name: '<?php echo $this->security->get_csrf_token_name(); ?>',
                        value: '<?php echo $this->security->get_csrf_hash(); ?>'
                    });

                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: data,
                        success: function (response) {
                            if (response) {
                                var obj = JSON.parse(response);
                                $.each(obj, function (index, value) {
                                    var className = 'odd';
                                    if (index % 2 == 0) {
                                        className = 'even';
                                    }
                                    var id = value.purchase_item_entry_id;
                                    var gst_tpt = parseFloat(value.gst_tpt) || 0;
                                    var igst_tpt = parseFloat(value.igst_tpt) || 0;
                                    var cgst_tpt = parseFloat(value.cgst_tpt) || 0;
                                    var sgst_tpt = parseFloat(value.sgst_tpt) || 0;
                                    var transport = parseFloat(value.transport) || 0;

                                    var newRow = `<tr role="row" class="${className}" data-purchaseitemid="${id}">
                                        <input type="hidden" class="form-control" name="PurchaseItem[${rowIndex}][id]" id="id" placeholder="" value="${id}" readonly>
                                        <td style="border: 0.5px solid gray" class="sorting_1">${rowIndex}</td>
                                        <td style="border: 0.5px solid gray">
                                            <input type="checkbox" id="checkbox" name="PurchaseItem[${rowIndex}][Purchaseitem_select]" data-id="${id}" data-index="${rowIndex}" data-item_name="${item_name}" data-size="${value.measure_name}" data-stock_quntitiy="${value.stock_qty}"  data-billing_quntity="${value.billing_qty}" data-rate="${value.rate}"  data-amount="${value.amount}" data-tax_type="${value.tax_type}"  class="cb-element" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray" id="item_name">
                                            <input type="text" class="form-control disabled-options" style="width:auto;" name="PurchaseItem[${rowIndex}][item_name]" id="item_name" placeholder="" value="${value.item_name}" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray" id="stock_quntitiyText">
                                            <input type="text" class="form-control disabled-options stock_quntitiy_${rowIndex}" style="width:100px;" name="PurchaseItem[${rowIndex}][stock_quntitiy]" id="stock_quntitiy" placeholder="" value="${value.stock_qty}" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray" id="billing_quntity">
                                            <input type="text" class="form-control disabled-options billing_quntity_${rowIndex}"style="width:100px;" name="PurchaseItem[${rowIndex}][billing_quntity]" id="billing_quntityText" placeholder="" value="${value.billing_qty}" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray" id="measure">
                                            <input type="text" class="form-control disabled-options size_${rowIndex}" style="width:100px;" name="PurchaseItem[${rowIndex}][measure]" id="measure" placeholder="" value="${value.measure_name}" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray" id="size">
                                            <input type="text" class="form-control disabled-options size_${rowIndex}" style="width:100px;" name="PurchaseItem[${rowIndex}][size]" id="size" placeholder="" value="${value.size}" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray" id="color">
                                            <input type="text" class="form-control disabled-options size_${rowIndex}" style="width:100px;" name="PurchaseItem[${rowIndex}][size]" id="color" placeholder="" value="${value.color}" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray" id="rate">
                                            <input type="text" class="form-control disabled-options rate_${rowIndex}" style="width:100px;" name="PurchaseItem[${rowIndex}][rate]" id="rateText" placeholder="" value="${value.rate}" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray" id="amount">
                                            <input type="text" class="form-control disabled-options amount_${rowIndex}" style="width:100px;" name="PurchaseItem[${rowIndex}][amount]" id="amountText" placeholder="" value="${value.amount}" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray" id="tax_type">
                                            <input type="text" class="form-control disabled-options tax_type_${rowIndex}" style="width:100px;" name="PurchaseItem[${rowIndex}][tax_type]" id="tax_typeText" placeholder="" value="${value.tax_type}" readonly>
                                        </td>
                                        <td style="border: 0.5px solid gray"><button type="button" class="btn btn-primary text-white editButton" data-toggle="modal" data-row-id="${id}">Edit</button>
                                        &nbsp<button type="button" class="btn btn-primary text-white" id="deleteButton">Delete</button>
                                        <input type="hidden" class="form-control" name="PurchaseItem[${rowIndex}][tot_tax]" id="tpttax" placeholder="" value="${gst_tpt}" readonly>
                                        <input type="hidden" class="form-control" name="PurchaseItem[${rowIndex}][tot_igst]" id="tptigst" placeholder="" value="${igst_tpt}" readonly>
                                        <input type="hidden" class="form-control" name="PurchaseItem[${rowIndex}][tot_sgst]" id="tptsgst" placeholder="" value="${cgst_tpt}" readonly>
                                        <input type="hidden" class="form-control" name="PurchaseItem[${rowIndex}][tot_cgst]" id="tptcgst" placeholder="" value="${sgst_tpt}" readonly>
                                        <input type="hidden" class="form-control" name="PurchaseItem[${rowIndex}][transport]" id="transport" placeholder="" value="${transport}" readonly>
                                    </tr>`;

                                    $('tbody#getCodeGenerationLeftBlock').append(newRow);
                                    countCalling++;
                                    onDataChange();
                                    onTransport();
                                });
                            }
                        },
                        error: function (error) {
                            console.error('Ajax request failed:', error);
                        }
                    });

                    function validateForm(data, rowIndex) {
                        for (var i = 0; i < data.length; i++) {
                            var fieldName = data[i].name;
                            var fieldValue = data[i].value;
                            var excludedFields = ['totstkqty', 'totbillqty', 'totamount', 'tax_per', 'total_igst', 'total_cgst', 'total_sgst','total_transport','anyadd','disamt','receivedby','netamt','igst_tpt','cgst_tpt','sgst_tpt','discountamount','inward_no'];
                            if (excludedFields.indexOf(fieldName) !== -1) {
                                continue;
                            }

                            if (!fieldValue.trim()) {
                                console.log('Field is empty:', fieldName);
                                return false;
                            }
                        }
                        return true;
                    }
                }); 
                $('#saveChangesButton').click(function () {
                    var amountValue = parseFloat($('#editStockQty').val()) * parseFloat($('#editRate').val());
                    var formData = {
                        editId: $('#editId').val(),
                        editStockQty: $('#editStockQty').val(),
                        editBillingQty: $('#editBillingQty').val(),
                        editRate: $('#editRate').val(),
                    };
                    var post_data = {
                        'itemValue': parseInt($('select#item_name').val()),
                        'supplierValue': parseInt($('select#supplier_name').val()),
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };

                    var url = "<?php echo base_url();?>Purchase/getTax";

                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: post_data,
                        success: function (result) {
                            try {
                                var obj = JSON.parse(result);
                                if (obj.length == '2') {
                                    var array = obj;
                                    var sum = parseFloat(array[0]) + parseFloat(array[1]);
                                    var tax = isNaN(sum) ? 0 : sum;
                                    $('input#tax').val(tax.toFixed(2));

                                    var cg = (parseFloat(array[0]) / 100) * amountValue;
                                    var sg = (parseFloat(array[1]) / 100) * amountValue;
                                    var cgst = isNaN(cg) ? 0 : cg;
                                    var sgst = isNaN(sg) ? 0 : sg;
                                    var total_tax = cgst + sgst;
                                    $('input#tptcgst').val(cgst.toFixed(2));
                                    $('input#tptsgst').val(sgst.toFixed(2));
                                    $('input#tpttax').val(total_tax.toFixed(2));

                                    formData.editCgst = cgst.toFixed(2);
                                    formData.editSgst = sgst.toFixed(2);
                                    formData.editGst = total_tax.toFixed(2);

                                } else {
                                    var tax = isNaN(obj) || obj == '0' ? 0 : obj;
                                    $('input#tax').val(tax);

                                    var ig = (tax / 100) * amountValue;
                                    var igst = isNaN(ig) ? 0 : ig;

                                    $('input#tptigst').val(igst.toFixed(2));
                                    $('input#tpttax').val(igst.toFixed(2));

                                    formData.editIgst = igst.toFixed(2);
                                    formData.editGst = igst.toFixed(2);
                                }
                            } catch (error) {
                                console.error('Error parsing JSON:', error);
                                alert('Error parsing JSON. Please try again.');
                            }

                            var saveUrl = "<?php echo base_url('Purchase/save_edited_purchase_item_data'); ?>";

                            $.ajax({
                                type: 'POST',
                                url: saveUrl,
                                data: formData,
                                success: function (response) {
                                    try {
                                        if (response && response.length > 0) {
                                            var obj = JSON.parse(response);
                                            var purchaseItemId = obj[0].purchase_item_entry_id;
                                            var existingRow = $(`tr[data-purchaseitemid="${purchaseItemId}"]`);
                                            if (existingRow.length > 0) {
                                                var stockQtyValue = !isNaN(parseFloat(obj[0].stock_qty)) ? parseFloat(obj[0].stock_qty) : '';
                                                var billingQtyValue = !isNaN(parseFloat(obj[0].billing_qty)) ? parseFloat(obj[0].billing_qty) : '';
                                                var rateValue = !isNaN(parseFloat(obj[0].rate)) ? parseFloat(obj[0].rate) : '';
                                                var amountValue = !isNaN(parseFloat(obj[0].amount)) ? parseFloat(obj[0].amount) : '';

                                                existingRow.find('#stock_quntitiy').val(stockQtyValue);
                                                existingRow.find('#billing_quntityText').val(billingQtyValue);
                                                existingRow.find('#rateText').val(rateValue);
                                                existingRow.find('#amountText').val(amountValue);

                                                $('#editPurchaseItemModal').modal('hide');
                                            }
                                        }
                                    } catch (error) {
                                        console.error('Error parsing JSON:', error);
                                        alert('Error parsing JSON. Please try again.');
                                    }  
                                    onDataChange();
                                },
                                error: function (error) {
                                    console.error('Ajax request failed:', error);
                                    alert('Something went wrong. Please try again.');
                                }
                            });
                        },
                        error: function (error) {
                            console.error('Ajax request failed:', error);
                            alert('Something went wrong. Please try again.');
                        }
                    });
                });

                $(document).on('click', 'button#bulkItemLoad', function (e) {
                    e.preventDefault();
                    var tableData = [];
                    $('tbody#getCodeGenerationLeftBlock tr').each(function () {
                        var rowData = {};
                        $(this).find('input, select').each(function () {
                            rowData[$(this).attr('name')] = $(this).val();
                        });
                        tableData.push(rowData);
                    });
                    var formData = {};
                    $('#billgeneratedForm input, #billgeneratedForm select').each(function () {
                        formData[$(this).attr('name')] = $(this).val();
                    });

                    var saveUrl = "<?php echo base_url('Purchase/save_purchase_item_entry_data'); ?>";
                    $.ajax({
                        type: 'POST',
                        url: saveUrl,
                        data: { tableData: tableData, formData: formData },
                        success: function (response) {
                            console.log("final",response)
                            var result = JSON.parse(response);
                           if (result.success) {
                            $('#inward_no').val(result.purchase_inward_no);
                                alert('Purchase Data Inserted Successfully,\npurchase_inward_no: ' + result.purchase_inward_no + ',\ntransport_inward_no: ' + result.transport_inward_no);
                                var url = "<?php echo base_url('Purchase/add_purchase'); ?>";
                                window.location.href = url;
                            } else {
                                alert('Something went wrong! Please try again.');
                            }                       
                        },error: function (error) {
                            console.error('Ajax request failed:', error);
                        }
                    });
                });
               
               $(document).on('click', 'button#closeButton', function (e) {
                  e.preventDefault();
                  var purchaseItemId = $('#id').val();
                  var deleteUrl = "<?php echo base_url('Purchase/delete_purchase_item_data/'); ?>" + purchaseItemId;
                  $.ajax({
                        type: 'POST',
                        url: deleteUrl,
                        success: function (response) {
                           var result = JSON.parse(response);
                           if (result.success) {
                              $("#getCodeGenerationLeftBlock").empty();
                           } else {
                              console.error('Error deleting records:', result.message);
                           }
                        },
                        error: function (error) {
                           console.error('Ajax request failed:', error);
                        }
                  });
               });

                $(document).on('click', 'button#deleteButton', function (e) {
                  e.preventDefault();
                    var row = $(this).closest('tr');
                    var purchaseItemId = row.find('input#id').val();
                    if (purchaseItemId.length > 0) {
                        if (confirm('Are you sure you want to delete the selected items?')) {
                           var deleteUrl = "<?php echo base_url('Purchase/delete_selected_purchase_items'); ?>";
                           var csrfToken = {
                              name: '<?php echo $this->security->get_csrf_token_name(); ?>',
                              value: '<?php echo $this->security->get_csrf_hash(); ?>'
                           };
                           $.ajax({
                              type: 'POST',
                              url: deleteUrl,
                              data: { purchase_item_id: purchaseItemId, csrf_token: csrfToken },
                              success: function (response) {
                                 var result = JSON.parse(response);
                                 if (result.success) {
                                       row.remove();
                                       $('#disamt').val('0');
                                       $('#discountamount').val('0');
                                        updateSerialNumbers();
                                        onDataChange();
                                 } else {
                                       console.error('Error deleting selected records:', result.message);
                                 }
                              },
                              error: function (error) {
                                 console.error('Ajax request failed:', error);
                              }
                           });      
                     }
                  } else {
                     alert('Please select at least one item to delete.');
                  }
               });
            });
            function updateSerialNumbers() {
                $('tbody#getCodeGenerationLeftBlock tr').each(function (index) {
                    $(this).find('.sorting_1').text(index + 1);
                });
            }
            $(document).ready(function() {
                var totalTax = 0; 
                $(document).on('change', 'input#disamt', function(e) {
                var ajaxRequests = [];
                    var discountValue = parseFloat($('input#disamt').val()) || 0;
                    var totalIgst = 0;
                    var totalCgst = 0;
                    var totalSgst = 0;

                    $('tbody#getCodeGenerationLeftBlock tr').each(function() {
                        var id = parseFloat($(this).find('input#id').val()) || 0;
                        console.log("ids", id);

                        var request = $.ajax({
                            type: 'GET',
                            url: '<?php echo base_url('Purchase/total_item_data'); ?>?id=' + id,
                            dataType: 'json'
                        });

                        ajaxRequests.push(request);

                        request.done(function(data) {
                            try {
                                var igst = parseFloat(data.igst_tpt) || 0;
                                var cgst = parseFloat(data.cgst_tpt) || 0;
                                var sgst = parseFloat(data.sgst_tpt) || 0;

                                totalIgst += igst;
                                totalCgst += cgst;
                                totalSgst += sgst;
                            } catch (error) {
                                console.error('Error parsing JSON:', error);
                            }
                        });

                        request.fail(function(jqXHR, textStatus, errorThrown) {
                            console.error('AJAX request failed:', textStatus, errorThrown);
                        });
                    });

                    $.when.apply($, ajaxRequests).done(function() {
                        $('#total_igst').val(totalIgst.toFixed(2));
                        $('#total_cgst').val(totalCgst.toFixed(2));
                        $('#total_sgst').val(totalSgst.toFixed(2));

                        var disamtIgst = (totalIgst * discountValue) / 100;
                        var totalAmountIgst = totalIgst - disamtIgst;
                        $('input#total_igst').val(totalAmountIgst.toFixed(2));

                        var disamtCgst = (totalCgst * discountValue) / 100;
                        var totalAmountCgst = totalCgst - disamtCgst;
                        $('input#total_cgst').val(totalAmountCgst.toFixed(2));

                        var disamtSgst = (totalSgst * discountValue) / 100;
                        var totalAmountSgst = totalSgst - disamtSgst;
                        $('input#total_sgst').val(totalAmountSgst.toFixed(2));

                        if(totalAmountIgst){
                            $('input#tax_per').val(Math.round(totalAmountIgst).toFixed(2));
                        }else{
                            var totalTax = totalAmountCgst + totalAmountSgst;
                            $('input#tax_per').val(Math.round(totalTax).toFixed(2));
                        }
                        var amount = parseFloat($('input#basicamount').val()) || 0;
                        var tax = parseFloat($('input#tax_per').val()) || 0;
                        var originalAmt = amount + tax;
                        console.log("originalAmt",originalAmt)
                        $('input#netamt').val(Math.round(originalAmt).toFixed(2));
                        });
                });
            });
            $(document).on('input', function() {
                var amount = parseFloat($('input#totamount').val());
                var discount = parseFloat($('input#disamt').val());
                var total=(amount * discount)/100;
                var value = isNaN(total) ? 0 : total;
                $('#discountamount').val(value.toFixed(2)); 
                
                var amtvalue = (amount * discount)/100;
                var val = amount - amtvalue;
                var basicamount = isNaN(val) ? 0 : val;
                $('#basicamount').val(basicamount.toFixed(2)); 
                });

            $(document).ready(function() {
                $("#remove").click(function() {
                    $("#billgeneratedForm .col-sm-4 input").val('');
                    $("#billgeneratedForm .col-sm-4 select").val('');
                    $("#billgeneratedForm .col-sm-8 select").val('');
                    $("#billgeneratedForm .col-sm-8 input").val('');
                    $("#billgeneratedForm .col-sm-4 input").not("#inward_no").val('');
                    setInwardNoValue();
                });
            }); 
            $(document).on('input', 'input#lr_amt', function() {
                var lrAmtValue = parseFloat($(this).val()) || 0;
                $('input#transport').val(lrAmtValue.toFixed(2));
            });
            function onTransport() {
                var totalTransport = 0;
                var ajaxRequests = [];

                $('tbody#getCodeGenerationLeftBlock tr').each(function () {
                    var id = parseFloat($(this).find('input#id').val()) || 0;

                    var request = $.ajax({
                        type: 'GET',
                        url: '<?php echo base_url('Purchase/total_item_data'); ?>?id=' + id,
                        dataType: 'json'
                    });

                    ajaxRequests.push(request);
                    request.done(function (data) {
                        console.log("datas", data);
                        try {
                            var transport = parseFloat(data.transport) || 0;

                            totalTransport += transport;
                        } catch (error) {
                            console.error('Error parsing JSON:', error);
                        }
                    });
                    request.fail(function (jqXHR, textStatus, errorThrown) {
                        console.error('AJAX request failed:', textStatus, errorThrown);
                    });
                });

                $.when.apply($, ajaxRequests).done(function () {
                    $('#total_transport').val(totalTransport.toFixed(2));
                });
            }
           
            $(document).on('input', function() {
            var billValue = parseFloat($('input#billing_qty').val());
            var nopackValue = parseFloat($('input#no_packs').val());
            var total=billValue/nopackValue;
            var qty_per_pack = isNaN(total) ? 0 : total;
            $('input#Qty_per_pack').val(qty_per_pack.toFixed(2));
            });
            $(document).ready(function() {
                $("#item_name").click(function() {
                    $("#billgeneratedForm .col-sm-4 input#Stock_qty").val('');
                    $("#billgeneratedForm .col-sm-4 input#billing_qty").val('');
                    $("#billgeneratedForm .col-sm-4 input#no_packs").val('');
                    $("#billgeneratedForm .col-sm-4 input#Qty_per_pack").val('');
                    $("#billgeneratedForm .col-sm-4 input#rate").val('');
                    $("#billgeneratedForm .col-sm-4 input#mrp").val('');
                    $("#billgeneratedForm .col-sm-4 input#tax").val('');
                    $("#billgeneratedForm .col-sm-4 input#amount").val('');
                });
            });

      </script>
   </body>
</html>