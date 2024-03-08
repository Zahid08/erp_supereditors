<?php
$customerDetails = $this->db->query("SELECT * FROM enquiry e where isactive = 1")->result();
$salesPersonDetails = $this->db->query("SELECT * FROM user u where isactive = 1 and name IS NOT NULL")->result();
$itemtypeDetails = $this->db->query("SELECT * FROM item_type WHERE is_active = 1")->result();
$itemDetails = $this->db->query("SELECT * FROM items WHERE is_active = 1")->result();
$brandDetails = $this->db->query("SELECT * FROM brand WHERE is_active = 1")->result();
$chalanNumber    = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
$generalBilling = $this->db->query("SELECT * FROM general_billing_entry")->result();
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
</head>
<body class="header-fix fix-sidebar">
<style>
	.form-control {
		height: 30px;
		font-size:11px;
	}
	select.form-control:not([size]):not([multiple]) {
		height: 30px;
		font-size: 11px;
	}
	.disabled-options {
		pointer-events: none;
		background: #ca25736e;
		border: 1px solid #ca25736e;
	}
	#loading-bar-spinner.spinner {
		left: 50%;
		margin-left: -20px;
		top: 50%;
		margin-top: -20px;
		position: absolute;
		z-index: 19 !important;
		animation: loading-bar-spinner 400ms linear infinite;
	}

	#loading-bar-spinner.spinner .spinner-icon {
		width: 40px;
		height: 40px;
		border:  solid 4px transparent;
		border-top-color:  #ca2573 !important;
		border-left-color: #ca2573 !important;
		border-radius: 50%;
	}

	@keyframes loading-bar-spinner {
		0%   { transform: rotate(0deg);   transform: rotate(0deg); }
		100% { transform: rotate(360deg); transform: rotate(360deg); }
	}
	.toast-content {
		margin-top: 55px!important;
		background: #ca2573;
	}
	.table>thead>tr>th,.table>tbody>tr>td {
		font-size: 80%;
		font-weight: 400;
	}
	div.hide-div {
		display: none;
	}
	input.form-control.hide-input-field {
		border: none;
		background: white;
	}
	input#Barcode,input.subTotalAmount,input#OrderNumber,input#itemName,input#discountAmount{
		pointer-events: none;
	}
	.modal-backdrop.in {
		background: #8080804f!important;
	}
	#fullScreenDiv.fullscreen{
		z-index: 9999;
		width: 100%;
		height: 100%;
		position: fixed;
		top: 0;
		left: 0;
		background: #666666;
	}
	span#fullScreenbtn {
		cursor: pointer;
	}
	div.screen-full footer.footer {
		display: none;
	}
	div.screen-full .card{
		height: 95vh;
		overflow: auto;
	}
	.card-body {
		padding: inherit;
	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
		color: black;
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



		<!-- End Bread crumb -->
		<!-- Container fluid  -->
		<div class="container-fluid" id="fullScreenDiv">
			<!-- Start Page Content -->
			<form method="post" action = "<?php echo base_url() ?>BillGeneration/save_bill_data" id="billgeneratedForm">
				<section id="po_section" name="po_section">
					<div id="customerform" class="collapse in">
						<div class="card">
							<div class="card-body">
								<center>
									<p style="color:green"><?php echo $this->session->flashdata('message') ?></p>
								</center>
								<h5 class="card-title">Bill Generation <span id="fullScreenbtn" style="float: right"><img src="https://p.kindpng.com/picc/s/25-253656_transparent-sensor-icon-png-show-full-screen-icon.png" height="20px" width="20px" alt="homepage"></span></h5>
								<div class="row">
									<div class="col-sm-6">
										<div class="row" style="border-style: ridge;margin-left: 1px;">
											<div class="col-sm-4">
												<small>Company Name</small>
												<select class="form-control " name="company_name"   id="company_name" required>
													<option value="">Company Name</option>
													<option value = "SuperEditors">SuperEditors</option>
													<option value = "MannaMenswear">MannaMenswear</option>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Ch No.</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  required value="">
											</div>
											<div class="col-sm-3" style="display: none">
												<small>Date</small>
												<input type="date" class="form-control" name="bill_date" id="bill_date" value="<?php echo date("Y-m-d") ?>"   required>
											</div>
											<div class="col-sm-4">
												<small>Category</small>
												<select class="form-control" name="category" id="category">
													<option value="Bill">Bill</option>
													<option value="Proforma">Proforma</option>
												</select>
											</div>

											<div class="col-sm-12">
												<small>Customer</small>
												<select class="form-control" name="customer" id="customer" required>
													<option value="">Select Customer</option>
													<?php foreach($customerDetails as $getcustomerDetails){ ?>
														<option value="<?php echo $getcustomerDetails->name ?>"
																data-credit-limit="<?=$getcustomerDetails->credit_limit?>"
																data-state="<?=$getcustomerDetails->state?>"
																data-customer-id="<?=$getcustomerDetails->enquiry_id?>"
																data-delivery-address="<?=$getcustomerDetails->shipping_address?>"
														><?php echo $getcustomerDetails->name ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-sm-3">
												<small>Credit Lmt</small>
												<input type="text" class="form-control" name="credit_limit" id="credit_limit" placeholder="Credit Lmt"   required>
											</div>


											<div class="col-sm-6">
												<small>Bill type</small>
												<select class="form-control" name="bill_type" id="bill_type">
													<option value="Against Customer Order">Against Customer Order</option>
													<option value="Against Non Customer Order">Against Non Customer Order</option>
												</select>
											</div>

											<div class="col-sm-12">
												<small>Delivery Address</small>
												<input type="text" class="form-control" name="delivery_address" id="delivery_address" placeholder="Delivery Address"   required>
											</div>

											<div class="col-sm-3">
												<small>PO No</small>
												<input type="text" class="form-control" name="po_no" id="po_no" placeholder="PO No.">
											</div>
											<div class="col-sm-3">
												<small>EWay Bill No.</small>
												<input type="text" class="form-control" name="eway_bill_no" id="eway_bill_no" placeholder="EWay Bill No" >
											</div>
											<div class="col-sm-3" id="orderNumberBlock">
												<small>Order No.</small>
												<input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No">
											</div>

											<div class="col-sm-3">
												<small>Sales Person</small>
												<select class="form-control" name="sales_person" id="sales_person">
													<?php foreach($salesPersonDetails as $getsalesPersonDetails){ ?>
														<option value="<?php echo $getsalesPersonDetails->user_id ?>"><?php echo $getsalesPersonDetails->name ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-sm-4 mt-2">
												<small>Item Type</small>
												<select class="form-control" name="item_type" id="item_type">
													<option value="">Choose Item Type</option>
													<?php foreach($itemtypeDetails as $getitemtypeDetails){ ?>
														<option value="<?php echo $getitemtypeDetails->item_type_id ?>"><?php echo $getitemtypeDetails->item_type  ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-sm-4 mt-2 ">
												<div class="appending_div"></div>
											</div>
											<div class="col-sm-4 mt-2">
												<small>Item Name</small>
												<select class="form-control" name="item_name" id="item_name" required>
													<option value="">Choose Item Name</option>
													<?php foreach($itemDetails as $getitemDetails){ ?>
														<option value="<?php echo $getitemDetails->item_id ?>" dataigst="<?=$getitemDetails->igst?>" dataItemName="<?php echo $getitemDetails->item_name  ?>"><?php echo $getitemDetails->item_name  ?></option>
													<?php } ?>
												</select>
											</div>
											<div class="col-sm-12">
												<br>
												<button type="button" class="btn btn-sm btn-primary text-white disabled-options" id="showBarCodeGenerations">Show Barcodes</button>
												<button type="button" class="btn btn-sm btn-primary text-white " id="bulkItemSelectCodeGenerations">Bulk Item Select</button>
											</div>
											<div class="col-sm-3">
												<small>BarCode</small>
												<input type="text" class="form-control" name="barcode" id="barcode" placeholder="Barcode" >
											</div>
											<div class="col-sm-3">
												<small>Qty</small>
												<input type="number" class="form-control" name="qty" id="qty" placeholder="Quantity">
											    <input type="hidden" class="form-control" name="max_input_qty" id="max_input_qty" placeholder="Quantity" >
											</div>
											<div class="col-sm-3">
												<small>Rate</small>
												<input type="text" class="form-control" name="rate" id="rate" placeholder="Rate" >
											</div>
											<div class="col-sm-3"></div>
											<div class="col-sm-3">
												<small>Disc %</small>
												<input type="text" class="form-control" name="disc" id="disc" placeholder="Disc %" >
											</div>
											<div class="col-sm-3">
												<small>GST %</small>
												<input type="text" class="form-control" name="gst" id="gst" placeholder="GST %">
											</div>

											<div class="col-sm-3">
												<small>Amount</small>
												<input type="text" class="form-control" name="amount" id="amount" placeholder="Amount">
											</div>

											<div class="col-sm-3" style="margin-top: 31px;padding: 0">
												<button type="button" class="btn btn-sm btn-primary text-white"  id="addedCalcualtedAmount">Add</button>
												<button type="button" class="btn btn-sm btn-primary text-white" id="removeCalcualtedAmount" >Remove</button>
											</div>


											<div class="col-sm-3">
												<small>Tax Type</small>
												<input type="text" class="form-control" name="tax_type" id="tax_type" placeholder="Tax Type"   required>
											</div>
											<div class="col-sm-3">
												<small>Total Amount</small>
												<input type="text" class="form-control" name="total_amount" id="total_amount" placeholder="Total Amt"   required value="0.00">
											</div>
											<div class="col-sm-3">
												<small>Total Disc</small>
												<input type="text" class="form-control" name="total_disc" id="total_disc" placeholder="Total Disc"   required value="0.00">
											</div>
											<div class="col-sm-3">
												<small>IGST Amt</small>
												<input type="text" class="form-control" name="igst_amount" id="igst_amount" placeholder="IGST Amt"   required value="0.00">
											</div>
											<div class="col-sm-3">
												<small>CGST Amt</small>
												<input type="text" class="form-control" name="cgst_amount" id="cgst_amount" placeholder="CGST Amt"   required value="0.00">
											</div>
											<div class="col-sm-3">
												<small>SGST Amt</small>
												<input type="text" class="form-control" name="sgst_amount" id="sgst_amount" placeholder="SGST Amt"   required value="0.00">
											</div>
											<div class="col-sm-3">
												<small>TPT Amt</small>
												<input type="text" class="form-control" name="tpt_amount" id="tpt_amount" placeholder="TPT Amt"   required value="0.00">
											</div>
											<div class="col-sm-3">
												<small>GST % on TPT</small>
												<input type="text" class="form-control" name="tpt_gst" id="tpt_gst" placeholder="TPT GST"   required value="0.00">
											</div>
											<div class="col-sm-3">
												<small>Net Bill Amt</small>
												<input type="text" class="form-control" name="net_bill_amt" id="net_bill_amt" placeholder="Net Bill Amt"   required value="0.00">
											</div>
											<div class="col-sm-12">
												<small>Remark</small>
												<input type="text" class="form-control" name="remark" id="remark" placeholder="Remark"   required>
											</div>

											<input type="hidden" class="form-control" name="authorizationsDataStatus" id="authorizationsDataStatus" value="">
											<input type="hidden" class="form-control" name="codeGenerationsId" id="codeGenerationsId" value="">
											<input type="hidden" class="form-control" name="selectedItem" id="selectedItems" value="">
											<input type="hidden" class="form-control" name="selectedItemBarcode" id="selectedItemBarcode" value="">
											<input type="hidden" class="form-control" name="billing_customer_id" id="billingCustomerId" value="">
											<input type="hidden" class="form-control" name="codemensurementId" id="codemensurementId" value="">

											<div class="col-sm-12" style="margin-bottom: 10px">
												<br>
												<button type="submit" class="btn btn-sm btn-primary text-white" >Save</button>
												<button type="button" class="btn btn-sm btn-primary text-white" >Modify Bill</button>
											</div>

										</div>


									</div>
									<div class="col-sm-6">
										<div class="table-responsive hide-div" style="border-style: double;height:697px;position:relative;" id="barcodeBlock">
											<table class="table table-sm">
												<thead>
												<tr>
													<th></th>
													<th>Sr.No</th>
													<th>Supplier Name</th>
													<th>Created Date</th>
													<th>Barcode</th>
													<th>Item Name</th>
													<th>Stock</th>
													<th>Purchase Rate</th>
													<th>MRP</th>
												</tr>
												</thead>
												<tbody id="barCodeContent" >
												</tbody>
											</table>
										</div>
										<div style="margin-top: 15px;text-align: center;" id="barcodeBlock" class="hide-div">
											<button type="button" class="btn btn-sm btn-primary text-white" id="bulkItemLoad">Bulk Item Load</button>
											<button type="button" class="btn btn-sm btn-primary text-white" id="closeButton">Close</button>
										</div>

										<div class="table-responsive" style="border-style: double;height:320px;position:relative;" id="reportBlock">
											<table class="table table-sm">
												<thead>
												<tr>
													<th>Order No</th>
													<th>Item Name</th>
													<th>Barcode</th>
													<th>Qty</th>
													<th>Rate</th>
													<th>Disc%</th>
													<th>Amount</th>
												</tr>
												</thead>
												<tbody id="getOrderList" >
												</tbody>
											</table>
										</div>
										<div class="table-responsive" style="border-style: double;height:379px;" id="reportBlock">
											<table class="table table-sm">
												<thead>
												<tr>
													<th>Category Name</th>
													<th>Bill No.</th>
													<th>Chalan No.</th>
													<th>Date</th>
													<th>Customer Name</th>
													<th>Amount</th>
													<th>Sales Person</th>
													<th>Bill Made By</th>
												</tr>
												</thead>
												<tbody id="billingFormated">
												<?php if ($generalBilling): foreach ($generalBilling as $key=>$items){
													$userId=$items->sales_person;
													$created_by=$items->created_by;

													$salesPersonName = $this->db->query("SELECT name FROM user u where isactive = 1 and name IS NOT NULL and user_id=$userId")->row();
													$nameSalesPerson='';
													if ($salesPersonName){
														$nameSalesPerson=$salesPersonName->name;
													}

													$createdByName = $this->db->query("SELECT name FROM user u where isactive = 1 and name IS NOT NULL and user_id=$created_by")->row();
													$nameCreatedBy='';
													if ($salesPersonName){
														$nameCreatedBy=$createdByName->name;
													}

													?>
													<tr>
														<th ><?=$items->category_name?></th>
														<td>
															<a target="_blank" href="<?php base_url() ?>get_billing_report?billing_serial=<?php echo $items->billing_serial;?>">
																<?php
																if($items->billing_number<10){
																	if($items->company_name=='SuperEditors'){
																		echo 'SE-0'.$items->billing_number.'-'.date("Y");
																	}else{
																		echo 'MM-0'.$items->billing_number.'-'.date("Y");
																	}
																}else{
																	if($items->company_name=='SuperEditors'){
																		echo 'SE-'.$items->billing_number.'-'.date("Y");
																	}else{
																		echo 'MM-'.$items->billing_number.'-'.date("Y");
																	}
																}
																?>
															</a>
														</td>
														<td><?=$items->chalan_number?></td>
														<td><?=$items->billing_date?></td>
														<td><?=$items->billing_customer?></td>
														<td><?=$items->net_bill_amount?></td>
														<td><?=$nameSalesPerson?></td>
														<td><?=$nameCreatedBy?></td>
													</tr>
												<?php }endif; ?>
												</tbody>
											</table>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
			</form>

			<!-- End Container fluid  -->
			<!-- footer -->
			<?php include("includes/footer.php") ?>
			<!-- End footer -->
		</div>
		<!-- End Page wrapper  -->
	</div>
	<!-- End Wrapper -->
	<!-- All Jquery -->

	<div class='modal' id='myModal' tabindex='-1' aria-labelledby='myModallabel' aria-hidden='true'>
		<div class='modal-dialog modal-dialog-centered modal-lg'>
			<div class='modal-content'>
				<div class='modal-header'>
					<h5 class="modal-title" id="exampleModalLongTitle" style="color:black">Bulk Item Selected Options</h5>
					<button type='button' class='close' data-dismiss='modal' aria-label='Close'>
						<span aria-hidden='true'>&times;</span>
					</button>
				</div>
				<div class='modal-body text'>
					<input type="hidden" value="" id="alreadyOpeningBulkItemModalStatus">
					<div class="row">
						<div class="col-sm-4">
							<small>Item Name</small>
							<select class="form-control" name="item_name_modal" id="item_name_modal" required>
								<option value="">Choose Item Name</option>
								<?php foreach($itemDetails as $getitemDetails){ ?>
									<option value="<?php echo $getitemDetails->item_id ?>" dataigst="<?=$getitemDetails->igst?>" dataItemName="<?php echo $getitemDetails->item_name  ?>"><?php echo $getitemDetails->item_name  ?></option>
								<?php } ?>
							</select>
						</div>
						<div class="col-sm-4">
							<small>Rate</small>
							<input type="text" class="form-control" name="rate_modal" id="total_rated_amount" placeholder="Rate" >
						</div>

						<div class="col-sm-4" style="margin-top: 21px;">
							<button type="button" class="btn btn-sm btn-primary text-white"  id="updatedRateAll">Update Rate</button>
							<button type="button" class="btn btn-sm btn-primary text-white" id="addBillingSections" >Added In Bill</button>
							<p id="successMessageModal" style="margin: 0;color: green"></p>
						</div>
					</div>

					<table id="example2555" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
						<tr>
							<th>SR NO</th>
							<th><input type="checkbox" style="=" id="checkall"  class=""></th>
							<th>Code</th>
							<th>Order Number</th>
							<th>Item Name</th>
							<th>Qty</th>
							<th>Rate</th>
							<th>Rate Ind GST</th>
							<th>Amount</th>
							<th>GST %</th>
						</tr>
						</thead>
						<tbody id="getCodeGenerationLeftBlock" >

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>



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
	<script>
		$( document ).ready(function() {

			$(document).on('change', '#checkall', function() {
				$('.cb-element').prop('checked', this.checked);
			});

			$(document).on('change', '.cb-element', function() {
				if ($('.cb-element:checked').length == $('.cb-element').length) {
					$('#checkall').prop('checked', true);
				} else {
					$('#checkall').prop('checked', false);
				}
			});

			$(document).on('change', 'select#company_name', function() {
				var companyname=$(this).val();

				var post_data = {
					'companyname': companyname,
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				};

				var url = "<?php echo base_url();?>CodeGeneration/getCompanyWiseCustomer";

				$.ajax({
					url : url,
					type : 'POST',
					data: post_data,
					success : function(result)
					{
						var obj = JSON.parse(result);
						$('select#customer').find('option').remove();
						$('select#customer').append($('<option/>', {
							value: '',
							text : 'Select Customer',
						}));

						for(var i=0;i<obj.length;i++)
						{
							$('select#customer').append($('<option/>', {
								value: obj[i]['name'],
								text : obj[i]['name']
							}));
						}
					}
				});
			});


			function bulkItemSelections() {
				$(document).on('click', 'button#addBillingSections', function() {

					var totalAmount=0;
					var productIndex=0;
					$(".cb-element:checked").each(function(){

						var itemname			=$(this).data('itemname');
						var orderid			=$(this).data('orderid');
						var itemId			=$(this).data('itemid');
						var amount			=$(this).data('amount');

						var quantity			=$(this).data('quantity');
						var totalamount			=$(this).data('totalamount');
						var codeGenerationsId 	=$('select#item_name').find(':selected').attr('codegenerationsid')||'';

						var barcode='';
						var discountAmount=0;

						totalAmount=Number(totalAmount)+Number(amount);

						var html = `<tr>
                                <th ><input type="hidden" value="`+codeGenerationsId+`" name=Billing[`+productIndex+`][codeGenerationsId]"><input type="hidden" value="`+itemId+`" name=Billing[`+productIndex+`][itemId]"><input type="text" value="`+orderid+`" name="Billing[`+productIndex+`][orderNumber]" class="form-control hide-input-field ordernumber-event OrderNumber-`+productIndex+`" data-key-index="`+productIndex+`" id="OrderNumber"></th>
                                <td><input type="text" value="`+itemname+`" name="Billing[`+productIndex+`][itemName]" class="form-control hide-input-field itemname-event itemName-`+productIndex+`" data-key-index="`+productIndex+`" id="itemName"></td>
                                <td><input type="text" value="`+barcode+`" name="Billing[`+productIndex+`][barcode]" class="form-control hide-input-field barcode-event Barcode-`+productIndex+`" data-key-index="`+productIndex+`" id="Barcode"></td>
                                <td><input type="text" value="`+quantity+`" name="Billing[`+productIndex+`][quantity]" class="form-control hide-input-field stock-event Quantity-`+productIndex+`" data-key-index="`+productIndex+`" id="Quantity"></td>
                                <td><input type="text" value="`+amount+`" name="Billing[`+productIndex+`][ratePirce]" class="form-control hide-input-field rate-price ratePirce-`+productIndex+`" data-key-index="`+productIndex+`" id="ratePirce"></td>
                                <td><input type="text" value="`+discountAmount+`" name="Billing[`+productIndex+`][discountAmount]" class="form-control hide-input-field discount-event discountAmount-`+productIndex+`" data-key-index="`+productIndex+`" id="discountAmount"></td>
                                <td><input type="text" value="`+totalamount+`" name="Billing[`+productIndex+`][subTotalAmount]" class="form-control hide-input-field amount-event subTotalAmount" data-key-index="`+productIndex+`" id="subTotalAmount-`+productIndex+`"></td>
                            </tr>`;

						$('tbody#getOrderList').append(html);

						productIndex++;

					});

					$('input#total_amount').val(parseFloat(totalAmount).toFixed(2));
					$('input#net_bill_amt').val(parseFloat(totalAmount).toFixed(2));

					$('#myModal').modal('hide');
				});
			}

			$(document).on('click', 'button#bulkItemSelectCodeGenerations', function() {

				var customerName   =$('select#customer').val()||'';
				var prefixData		=$('select#order_no').val()||'';
				var url 				="<?php echo base_url('BillGeneration/getBulkAuthorizationItem'); ?>";

				if (prefixData) {
					var post_data = {
						'customerName': customerName,
						'prefixData': prefixData,
						'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
					};

					$.ajax({
						url: url,
						type: 'POST',
						data: post_data,
						success: function (result) {
							if (result){
								var obj = JSON.parse(result);
								$('tbody#getCodeGenerationLeftBlock').html('');

								$.each(obj, function (index,value) {
									var className='odd';
									if (index%2==0){
										className='even';
									}
									++index;

									var totalAmount=parseFloat(value.gens_rate).toFixed(2)*value.gens_qty;

									var html =`<tr role="row" class="`+className+`">
												<td>`+index+`</td>
												<td><input type="checkbox"  name="billing_actions" data-index="`+index+`" data-orderid="`+value.order_no+`" data-itemID="`+value.itemId+`" data-itemname="`+value.item_name+`" data-quantity="`+value.gens_qty+`" data-totalamount="`+totalAmount+`" data-amount="`+value.gens_rate+`"  class="cb-element" id="authorizations-`+index+`"></td>
												<td>`+value.unique_code+`</td>
												<td>`+value.order_no+`</td>
												<td>`+value.item_name+`</td>
												<td>`+value.gens_qty+`</td>
												<td>`+value.gens_rate+`</td>
												<td>`+value.gens_rate+`</td>
												<td>`+totalAmount+`</td>
												<td>`+value.cgst+`</td>
												</tr>
												`;

									$('tbody#getCodeGenerationLeftBlock').append(html);
								});


								var openStatus=$('input#alreadyOpeningBulkItemModalStatus').val()||'';

								if (openStatus==='') {
									$('#example2555').DataTable({
										dom: 'Bfrtip',
										buttons: [
											'copy', 'csv', 'excel', 'pdf', 'print'
										]
									});
									$('input#alreadyOpeningBulkItemModalStatus').val(1);

								}

								bulkItemSelections();

							}

						}
					});

					$('#myModal').modal('show');
				}
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
							text : 'Select Item Name',
							dataigst : ''
						}));

						$('input#authorizationsDataStatus').val('');
						var html=`  <small>Order No.</small>
                                                <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No">`
						$('#orderNumberBlock').html(html);
						$('button#bulkItemSelectCodeGenerations').addClass('disabled-options');


						for(var i=0;i<obj.length;i++)
						{
							$('#item_name').append($('<option/>', {
								value: obj[i]['item_id'],
								text : obj[i]['item_name'],
								dataigst : obj[i]['igst'],
								dataItemName : obj[i]['item_name'],
							}));
						}
						if(id == '3')
						{
							var field ='<small>Brand Name</small><select  class="form-control" name="brand_name" id="brand_name" onchange="function1(this)" placeholder="Brand Name" ><option value="">Choose Brand Name</option><?php foreach($brandDetails as $getbrandDetails){ ?><option value="<?php echo $getbrandDetails->brand_id ?>"><?php echo $getbrandDetails->brand_name  ?></option><?php } ?></select>';
							$(".appending_div").html(field);



						}
						else{
							var field ='<small>Brand Name</small><select class="form-control" name="brand_name" id="brand_name" onchange="myFunction() placeholder="Brand Name" ><?php foreach($brandDetails as $getbrandDetails){ ?><option value="<?php echo $getbrandDetails->brand_id ?>"><?php echo $getbrandDetails->brand_name  ?></option><?php } ?></select>';
							$(".appending_div").html('');

						}
					}

				});

			});

			function function1(obj){

				//$('#brand_name').change(function(){
				//alert("ok");
				var id1 = $(obj).val();

				var sup_name = $('#supplier_name').find(":selected").val();
				var url = "<?php echo base_url('Purchase/get_brandname'); ?>";
				var post_data = {
					'id1': id1,
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
								value: obj[i]['fabric_id'],
								text : obj[i]['fabric_name']
							}));
						}


					}

				});

				// });
			}


			/*----------------------Billing Generations Scripts------------------------*/
			var errorImage      ='<?php echo base_url(); ?>assets/alert_image/error.svg';
			var successImage    ='<?php echo base_url(); ?>assets/alert_image/success.svg';

			$(document).on('change', 'select#customer', function() {
				var customerName         =$(this).val();
                getCustomerInfoByID(customerName);
				getAuthorizationsCode($(this).val(),$('select#company_name').val());
			});

            
            //Reload Customer Informations    
        	function getCustomerInfoByID(customerName){
        	    
				var url = "<?php echo base_url('BillGeneration/get_single_customer'); ?>";
				var post_data = {
					'customerName': customerName,
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				};
				
				$.ajax({
					url : url,
					type : 'POST',
					data: post_data,
					success : function(result)
					{
					    var obj = JSON.parse(result);
					    if(obj){
            				$('input#credit_limit').val(obj.credit_limit);
            				$('input#delivery_address').val(obj.shipping_address);
            				$('input#billingCustomerId').val(obj.enquiry_id);
            
            				if (obj.state==='Maharashtra' || obj.state==='maharashtra'){
            					$('input#tax_type').val('GST');
            				}else {
            					$('input#tax_type').val('IGST');
            				}
					    }
					}

				});
			}
			
			 //Reload Authorizations Data
			function getAuthorizationsCode(customerName,companyName) {

				if (customerName && companyName){
					var url = "<?php echo base_url('BillGeneration/getAuthorizationBillingCode'); ?>";

					var post_data = {
						'customerName': customerName,
						'companyName': companyName,
						'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
					};

					$.ajax({
						url : url,
						type : 'POST',
						data: post_data,
						success : function(result)
						{

							var obj = JSON.parse(result);
							if (obj.length>0) {
								var html=`<small>Order No.</small><select name="order_no" id="order_no" class="form-control"></select>`
								$('#orderNumberBlock').html(html);
								$('select#order_no').find('option').remove();
								$('select#order_no').append($('<option/>', {
									value: '0',
									text: 'Select Code Number'
								}));

								for (var i = 0; i < obj.length; i++) {
									$('select#order_no').append($('<option/>', {
										value: obj[i]['unique_code'],
										text: obj[i]['unique_code']
									}));
								}

								$('input#authorizationsDataStatus').val(1);
								$('button#bulkItemSelectCodeGenerations').removeClass('disabled-options');
								loadedItemAccordingToOrder();
							}else {
								var html=`  <small>Order No.</small>
                                                <input type="text" class="form-control" name="order_no" id="order_no" placeholder="Order No">`
								$('#orderNumberBlock').html(html);
								$('button#bulkItemSelectCodeGenerations').addClass('disabled-options');
							}
						}
					});
				}
			}

			function loadedItemAccordingToOrder(){
				$(document).on('change', 'select#order_no', function() {
					var prefix =$(this).val();

					var url = "<?php echo base_url('BillGeneration/getItemName'); ?>";

					var post_data = {
						'prefix': prefix,
						'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
					};

					$.ajax({
						url : url,
						type : 'POST',
						data: post_data,
						success : function(result)
						{
							var obj = JSON.parse(result);


							$('select#item_name').find('option').remove();
							$('select#item_name').addClass('add-authorizations-item');
							$('select#item_name').append($('<option/>', {
								value: '0',
								text : 'Select Item Name'
							}));

							$('select#item_name_modal').find('option').remove();
							$('select#item_name_modal').append($('<option/>', {
								value: '0',
								text : 'Select Item Name'
							}));

							for(var i=0;i<obj.length;i++)
							{
								$('select#item_name').append($('<option/>', {
									value: obj[i]['item_id'],
									text :obj[i]['item_name'],
									dataigst :0,
									dataItemName : obj[i]['item_name'],
									codegenerationsid: obj[i]['code_generations_id'],
								}));

								$('select#item_name_modal').append($('<option/>', {
									value: obj[i]['item_id'],
									text :obj[i]['item_name'],
									dataigst :0,
									dataItemName : obj[i]['item_name'],
									codegenerationsid: obj[i]['code_generations_id'],
									codeGenerationItemId: obj[i]['id'],
								}));

							}
						}
					});
				});


				$(document).on('click', 'button#updatedRateAll', function() {
					var codeGenerationItemid 	=$('select#item_name_modal').find(':selected').attr('codeGenerationItemId');
					var rate=$('input#total_rated_amount').val();

					if (codeGenerationItemid && rate){

						var url = "<?php echo base_url('BillGeneration/updateGlobalRate'); ?>";

						var post_data = {
							'rate': rate,
							'codeGenerationItemid': codeGenerationItemid,
							'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
						};

						$.ajax({
							type: "POST",
							url: url,
							data: post_data,
							success: function(response)
							{
							if (response==1){
								reloadModalCOntent();
								$('p#successMessageModal').html("Successfully update rate");
								$('button#updatedRateAll').html("Update Rate");
								setTimeout(function() {
									$('p#successMessageModal').html("");
								}, 5000);
							}
							},error: function (){
								alert("Something went wrong");
								$('button#updatedRateAll').html("Update Rate");
							},
							beforeSend: function (xhr){
								$('button#updatedRateAll').html("<span class='fa fa-spin fa-spinner'></span> Processing...");
							}
						});
					}
				});

			}

			function reloadModalCOntent() {
				var customerName   =$('select#customer').val()||'';
				var prefixData		=$('select#order_no').val()||'';
				var url 				="<?php echo base_url('BillGeneration/getBulkAuthorizationItem'); ?>";

				if (prefixData) {
					var post_data = {
						'customerName': customerName,
						'prefixData': prefixData,
						'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
					};

					$.ajax({
						url: url,
						type: 'POST',
						data: post_data,
						success: function (result) {
							if (result){
								var obj = JSON.parse(result);
								$('tbody#getCodeGenerationLeftBlock').html('');

								$.each(obj, function (index,value) {
									var className='odd';
									if (index%2==0){
										className='even';
									}
									++index;

									var totalAmount=parseFloat(value.gens_rate).toFixed(2)*value.gens_qty;

									var html =`<tr role="row" class="`+className+`">
												<td>`+index+`</td>
												<td><input type="checkbox"  name="billing_actions" data-index="`+index+`" data-orderid="`+value.order_no+`" data-itemID="`+value.itemId+`" data-itemname="`+value.item_name+`" data-quantity="`+value.gens_qty+`" data-totalamount="`+totalAmount+`" data-amount="`+value.gens_rate+`"  class="cb-element" id="authorizations-`+index+`"></td>
												<td>`+value.order_no+`</td>
												<td>`+value.item_name+`</td>
												<td>`+value.gens_qty+`</td>
												<td>`+value.gens_rate+`</td>
												<td>`+value.gens_rate+`</td>
												<td>`+totalAmount+`</td>
												<td>`+value.cgst+`</td>
												</tr>
												`;

									$('tbody#getCodeGenerationLeftBlock').append(html);
								});


								var openStatus=$('input#alreadyOpeningBulkItemModalStatus').val()||'';

								if (openStatus==='') {
									$('#example2555').DataTable({
										dom: 'Bfrtip',
										buttons: [
											'copy', 'csv', 'excel', 'pdf', 'print'
										]
									});
									$('input#alreadyOpeningBulkItemModalStatus').val(1);

								}

							}

						}
					});
				}
			}


			$(document).on('change', 'select.add-authorizations-item', function() {

				var codeGenerationsId 	=$('select#item_name').find(':selected').attr('codegenerationsid');
				$('input#codeGenerationsId').val(codeGenerationsId);

				var itemId 				=$(this).val();
				var url 				="<?php echo base_url('BillGeneration/getAuthorizationsItemData'); ?>";

				var post_data = {
					'itemId': itemId,
					'unique_code': $('select#order_no').val(),
					'codeGenerationsId': codeGenerationsId,
					'<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
				};

				$.ajax({
					url : url,
					type : 'POST',
					data: post_data,
					success : function(result)
					{
						var obj = JSON.parse(result);
						$('input#qty').val(obj.gens_qty);
						$('input#qty').attr("max",obj.gens_qty);
						$('#max_input_qty').val(obj.gens_qty);
						$('input#rate').val(obj.gens_rate);
						var calcualtedAmount=obj.gens_qty*obj.gens_rate;
						$('input#amount').val(parseFloat(calcualtedAmount).toFixed(2));
						$('input#codemensurementId').val(obj.code_mesurement_id);

					}
				});
			});


            $(document).on('blur', 'input#qty', function() {
			    if(	$('input#codeGenerationsId').val()){
			        if(Number($('input#qty').val())>Number($('input#max_input_qty').val())){
			            alert("Quantity can not greater than "+$('input#max_input_qty').val());
			            $('input#qty').val($('input#max_input_qty').val());
			            var calcualtedAmount=$('input#rate').val()*$('input#max_input_qty').val();
						$('input#amount').val(parseFloat(calcualtedAmount).toFixed(2));
			        }
			    }
			});
			
			$(document).on('click', 'button#closeButton', function() {
				$('div#barcodeBlock').addClass('hide-div');
				$('div#reportBlock').show();
			});


			var productIndex = $('tbody#getOrderList tbody tr').length;
			var reloadBarcodeList=[];

			$('button#bulkItemLoad').click(function(){
				var Datalist=[];
				var OrderItemList=[];
				$("input:checkbox[type=checkbox]:checked").each(function(){
					var index                   =$(this).data('key-index');
					var barcodeValue            =$(this).val();
					var ratePirce               =$('tr.unique-'+barcodeValue+'').data('rate');
					var stock                   =$('tr.unique-'+barcodeValue+'').data('stock');
					var igst                    =$('tr.unique-'+barcodeValue+'').data('igst')||0;
					var itemId                  = $('select#item_name').val();
					var ItemName                =$('select#item_name').find(':selected').attr('dataItemName')

					var stringData=itemId+'-'+barcodeValue+'-'+stock;

					var data={
						'ItemName':ItemName,
						'barcode':barcodeValue,
						'qty':stock,
						'rate':ratePirce,
						'amount':stock*ratePirce,
					};

					Datalist.push(stringData);
					OrderItemList.push(data);
				});

				if(OrderItemList.length>0) {
					var html='';
					var totalAmount=0;
					OrderItemList.forEach(function (item, index) {
						totalAmount=Number(totalAmount)+Number(item.amount);
						var orderNumber=$('input#order_no').val()||'----';
						reloadBarcodeList.push(item.barcode);
						html += `<tr>
                                <th ><input type="text" value="`+orderNumber+`" name="Billing[`+productIndex+`][orderNumber]" class="form-control hide-input-field ordernumber-event OrderNumber-`+productIndex+`" data-key-index="`+productIndex+`" id="OrderNumber"></th>
                                <td><input type="text" value="`+item.ItemName+`" name="Billing[`+productIndex+`][itemName]" class="form-control hide-input-field itemname-event itemName-`+productIndex+`" data-key-index="`+productIndex+`" id="itemName"></td>
                                <td><input type="text" value="`+item.barcode+`" name="Billing[`+productIndex+`][barcode]" class="form-control hide-input-field barcode-event Barcode-`+productIndex+`" data-key-index="`+productIndex+`" id="Barcode"></td>
                                <td><input type="text" value="`+item.qty+`" name="Billing[`+productIndex+`][quantity]" class="form-control hide-input-field stock-event Quantity-`+productIndex+`" data-key-index="`+productIndex+`" id="Quantity"></td>
                                <td><input type="text" value="`+item.rate+`" name="Billing[`+productIndex+`][ratePirce]" class="form-control hide-input-field rate-price ratePirce-`+productIndex+`" data-key-index="`+productIndex+`" id="ratePirce"></td>
                                <td><input type="text" value="0" name="Billing[`+productIndex+`][discountAmount]" class="form-control hide-input-field discount-event discountAmount-`+productIndex+`" data-key-index="`+productIndex+`" id="discountAmount"></td>
                                <td><input type="text" value="`+item.amount+`" name="Billing[`+productIndex+`][subTotalAmount]" class="form-control hide-input-field amount-event subTotalAmount" data-key-index="`+productIndex+`" id="subTotalAmount-`+productIndex+`"></td>
                            </tr>`;
						productIndex++;
					});

					$('tbody#getOrderList').append(html);

					var totalAmountInfield = Number($('input#total_amount').val() || 0) + Number(totalAmount);
					$('input#total_amount').val(parseFloat(totalAmountInfield).toFixed(2));
				}

				//Loaded In Input Field
				if (Datalist.length>0){

					$('div#reportBlock').show();
					$('div#barcodeBlock').addClass('hide-div');

					$('input#bulk_barcode').prop('checked',false);

					var previousItem = $('input#selectedItems').val();
					var selectedItem = Datalist;
					if (previousItem) {
						selectedItem = previousItem + ',' + Datalist;
					}
					$('input#selectedItems').val(selectedItem);
				}else {
					alert("Please select item first");
				}

			});

			$("input#barcode").blur(function(){
				var getCurrentValue    =$(this).val();
				var ratePirce          =$('tr.unique-'+getCurrentValue+'').data('rate');
				var stock              =$('tr.unique-'+getCurrentValue+'').data('stock');
				var igst              =$('tr.unique-'+getCurrentValue+'').data('igst')||0;

				$('input#rate').val(ratePirce);
				$('input#qty').val(stock);
				// $('input#gst').val(igst);

				var calcualtedAmount=stock*ratePirce;
				$('input#amount').val(parseFloat(calcualtedAmount).toFixed(2));
			});


			function loadedOrder(barcode,stock,ratePirce,authorizationsDataStatus=''){

				var orderNumber         =$('input#order_no').val()||'';
				if(orderNumber==""){
				    orderNumber     =$('select#order_no').val()||'';
				}
				var quantity            =$('input#qty').val();
				var codeGenerationsId   =$('input#codeGenerationsId').val()||'';
				var ItemName            =$('select#item_name').find(':selected').attr('dataItemName');
				var ItemId            	=$('select#item_name').val()||'';
				var discountAmount      =Number($('input#disc').val());
				var gstValue            =Number($('input#gst').val());
				var subamount           =Number($('input#amount').val());
				var ratePrice           =Number($('input#rate').val());
				var codeMesuremetnId    =$('input#codemensurementId').val()||'';

				reloadBarcodeList.push(barcode);
				var html = `<tr>
                                <th ><input type="hidden" value="`+authorizationsDataStatus+`" name=Billing[`+productIndex+`][authorizationsDataStatus]">
								<input type="hidden" value="`+codeGenerationsId+`" name=Billing[`+productIndex+`][codeGenerationsId]">
								<input type="hidden" value="`+codeMesuremetnId+`" name=Billing[`+productIndex+`][codeMesuremetnId]">
								<input type="hidden" value="`+ItemId+`" name=Billing[`+productIndex+`][itemId]">
								<input type="text" value="`+orderNumber+`" name="Billing[`+productIndex+`][orderNumber]" class="form-control hide-input-field ordernumber-event OrderNumber-`+productIndex+`" data-key-index="`+productIndex+`" id="OrderNumber"></th>
                                <td><input type="text" value="`+ItemName+`" name="Billing[`+productIndex+`][itemName]" class="form-control hide-input-field itemname-event itemName-`+productIndex+`" data-key-index="`+productIndex+`" id="itemName"></td>
                                <td><input type="text" value="`+barcode+`" name="Billing[`+productIndex+`][barcode]" class="form-control hide-input-field barcode-event Barcode-`+productIndex+`" data-key-index="`+productIndex+`" id="Barcode"></td>
                                <td><input type="text" value="`+quantity+`" name="Billing[`+productIndex+`][quantity]" class="form-control hide-input-field stock-event Quantity-`+productIndex+`" data-key-index="`+productIndex+`" id="Quantity"></td>
                                <td><input type="text" value="`+ratePrice+`" name="Billing[`+productIndex+`][ratePirce]" class="form-control hide-input-field rate-price ratePirce-`+productIndex+`" data-key-index="`+productIndex+`" id="ratePirce"></td>
                                <td><input type="text" value="`+discountAmount+`" name="Billing[`+productIndex+`][discountAmount]" class="form-control hide-input-field discount-event discountAmount-`+productIndex+`" data-key-index="`+productIndex+`" id="discountAmount"></td>
                                <td><input type="text" value="`+subamount+`" name="Billing[`+productIndex+`][subTotalAmount]" class="form-control hide-input-field amount-event subTotalAmount" data-key-index="`+productIndex+`" id="subTotalAmount-`+productIndex+`"></td>
                            </tr>`;

				$('tbody#getOrderList').append(html);

				productIndex++;
				$('input#codemensurementId').val('');
			}

			$(document).on('click', 'button#showBarCodeGenerations', function() {

				$('div#reportBlock').hide();
				$('div#barcodeBlock').removeClass('hide-div');

				var loaderHtml='<div id="loading-bar-spinner" class="spinner"><div class="spinner-icon"></div></div>';
				$('tbody#barCodeContent').html(loaderHtml);

				var itemId   = $('select#item_name').val();
				if (itemId) {
					var url = "<?php echo base_url('BillGeneration/get_barcodeList'); ?>";
					var post_data = {
						'itemId': itemId,
						'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
					};
					$.ajax({
						url: url,
						type: "POST",
						data: post_data,
						success: function (result) {
							var obj = JSON.parse(result);
							var htmlTbody = '';

							if (obj.length>0) {
								obj.forEach(function (item, index) {
									index=index+1;
									if(jQuery.inArray(item.barcode, reloadBarcodeList)=== -1 && item.stock_quantity>0) {
										htmlTbody += ` <tr class="unique-` + item.barcode + `" data-rate="` + item.amount_per_pack + `" data-stock="` + item.stock_quantity + `" data-gst="` + item.igst + `" >
                                            <th ><input type="checkbox" id="bulk_barcode" data-key-index="` + index + `" value="` + item.barcode + `" name="GetBarcodeList[` + index + `][barcode]" /></th>
                                            <th >` + index + `</th>
                                            <td>` + item.supplier_name + `</td>
                                            <td>` + item.created_date + `</td>
                                            <td>` + item.barcode + `</td>
                                            <td>` + item.item_name + `</td>
                                            <td>` + item.stock_quantity + `</td>
                                            <td>` + item.purchased_amount_per_pack + `</td>
                                            <td>` + item.amount_per_pack + `</td>
                                        </tr>
                                    `;
									}
								});
							}else{
								htmlTbody+=`<tr>
                                        <th >---</th>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>Not Found Barcode</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                        <td>---</td>
                                    </tr>`;
							}
							$('tbody#barCodeContent').html(htmlTbody);
						}
					});
				}else {
					alert("Please select item first");
				}

			});

			$(document).on('click', 'input#Quantity', function() {
				$(this).removeClass('hide-input-field');
			});

			$(document).on('blur', 'input#Quantity', function() {
				$(this).addClass('hide-input-field');
				CalcuatedRowData($(this).val(),$(this).data('key-index'));
			});

			$(document).on('blur', 'input#ratePirce', function() {
				$(this).addClass('hide-input-field');
				var quantity=Number($('input.Quantity-'+$(this).data('key-index')+'').val());
				var totalAmount=Number($(this).val()*quantity);
				$('input#subTotalAmount-'+$(this).data('key-index')+'').val(totalAmount);
			});


			$(document).on('click', 'input#ratePirce', function() {
				$(this).removeClass('hide-input-field');
			});


			function CalcuatedRowData(quantity,currentIndex){
				var reatedAmount=Number($('input.ratePirce-'+currentIndex+'').val());
				var totalAmount=Number(reatedAmount*quantity);
				$('input#subTotalAmount-'+currentIndex+'').val(totalAmount);
			}

			$(document).on('change', 'select#item_name', function() {
			    var checkAuthorizationsStatus=$('input#codeGenerationsId').val()||'';
			    
				if ($(this).val() && checkAuthorizationsStatus=="") {
					var igstValue          =$('select#item_name').find(':selected').attr('dataigst');
					$('input#gst').val(igstValue);
                
					$('button#showBarCodeGenerations').removeClass('disabled-options');
				}else {
					$('button#showBarCodeGenerations').addClass('disabled-options');
				}
			});

			$("input#qty").keyup(function(){
				if($(this).val()<=0){
					$(this).val('');
				}else {
					var rateAmount=$('input#rate').val()||0;
					var calcualtedAmount=rateAmount*$(this).val();
					$('input#amount').val(parseFloat(calcualtedAmount).toFixed(2));
				}
			});

			$("input#rate").keyup(function(){
				if($(this).val()<=0){
					$(this).val('');
				}else {
					var quantity=$('input#qty').val()||0;
					var calcualtedAmount=quantity*$(this).val();
					$('input#amount').val(parseFloat(calcualtedAmount).toFixed(2));
				}
			});

			$(document).on('click', 'button#removeCalcualtedAmount', function() {
				var previousItem = $('input#selectedItems').val();
				if (previousItem) {
					if (confirm("Are you sure?")) {

						resetAllfield();
						$('tbody#getOrderList').html('');
					}
				}
				return false;
			});

			/*-------Add Calcualtions functionality---------------*/
			$(document).on('click', 'button#addedCalcualtedAmount', function() {
			    
				var barcodeId   = $('input#barcode').val() || '';
				var ratedAmount =$('input#rate').val();
				
				var authorizationsDataStatus=$('input#authorizationsDataStatus').val();
				if (authorizationsDataStatus){
					loadedOrder($('input#barcode').val(), $('input#qty').val(), $('input#rate').val(),authorizationsDataStatus);
					calucaltedAmount();
				}else {
					if (ratedAmount > 0 && barcodeId != '') {
						loadedOrder($('input#barcode').val(), $('input#qty').val(), $('input#rate').val());
						calucaltedAmount();
					} else {
						alert("Please add rate price and barcode")
					}
				}
			});

			function calucaltedAmount() {
			    
				var ratedAmount =$('input#rate').val();
				var barcodeId = $('input#barcode').val() || '';
				var itemId   = $('select#item_name').val();
				var quantity   = $('input#qty').val()||1;
				var authorizationsDataStatus=$('input#authorizationsDataStatus').val();

				var newItemLoad=itemId+'-'+barcodeId+'-'+quantity;

				if ((ratedAmount>0 && barcodeId!='')||Number(authorizationsDataStatus)==1) {
					//Load Selected item
					var previousItem = $('input#selectedItems').val();
					var selectedItem = newItemLoad;
					if (previousItem) {
						selectedItem = previousItem + ',' + newItemLoad;
					}
					$('input#selectedItems').val(selectedItem);


					//CalcualtedAMount
					var discountAmount = Number($('input#amount').val()) * Number($('input#disc').val()) / 100;
					var gstDiscount = Number($('input#amount').val()) * Number($('input#gst').val()) / 100;

					var totalAmount = Number($('input#total_amount').val() || 0) + Number($('input#amount').val() || 0);
					var totalDiscountAmount = Number($('input#total_disc').val() || 0) + Number(discountAmount);
					var totalIgstAmount = Number($('input#igst_amount').val() || 0) + Number(gstDiscount);

					var totalCgstAmount = $('input#cgst_amount').val() || 0;
					var totalSgstAmount = $('input#sgst_amount').val() || 0;
					var totalTptAmount = $('input#tpt_amount').val() || 0;
					var gstTptAmount = $('input#tpt_gst').val() || 0;

					$('input#total_amount').val(parseFloat(totalAmount).toFixed(2));
					$('input#total_disc').val(parseFloat(totalDiscountAmount).toFixed(2));
					$('input#igst_amount').val(parseFloat(totalIgstAmount).toFixed(2));


					emptyCalculatedField();
					totalNetAmount();
				}else {
					alert("Please add rate price and barcode")
				}
			}

			/*-------Calcualted empty field---------------*/
			function emptyCalculatedField(){
				$('input#qty').val('');
				$('input#barcode').val('');
				$('input#rate').val('');
				$('input#gst').val('');
				$('input#disc').val('');
				$('input#amount').val('');
			}


			/*-------Calcualted total amount---------------*/
			$("input#total_disc,input#igst_amount,input#cgst_amount,input#sgst_amount,input#tpt_amount,input#tpt_gst").blur(function(){
				totalNetAmount();
			});
			function totalNetAmount(){
				var totalAMount           =$('input#total_amount').val()||0;
				var totalDiscount         =$('input#total_disc').val()||0;
				var totalIgstAmount       =$('input#igst_amount').val()||0;
				var totalCgstAmount      =$('input#cgst_amount').val()||0;
				var totalSgstAmount      =$('input#sgst_amount').val()||0;
				var totalTptAmount       =$('input#tpt_amount').val()||0;
				var gstTptAmount         =$('input#tpt_gst').val()||0;

				var netAmount=Number(totalAMount)+(Number(totalDiscount)+Number(totalIgstAmount)+Number(totalCgstAmount)+Number(totalSgstAmount)+Number(totalTptAmount));
				$('input#net_bill_amt').val(netAmount);
			}

			// this is the id of the form
			$("form#billgeneratedForm").submit(function(e) {
				e.preventDefault();

				var form = $(this);
				var actionUrl = form.attr('action');

				$.ajax({
					type: "POST",
					url: actionUrl,
					data: form.serialize(), // serializes the form's elements.
					success: function(result)
					{
						var responseData = JSON.parse(result);
						if (responseData) {
							var html = `<tr>
                                    <th >` + responseData.billing_type + `</th>
                                    <td>` + responseData.billing_number + `</td>
                                    <td>` + responseData.chalan_number + `</td>
                                    <td>` + responseData.billing_date + `</td>
                                    <td>` + responseData.billing_customer + `</td>
                                    <td>` + responseData.net_bill_amount + `</td>
                                     <td>` + responseData.net_bill_amount + `</td>
                                      <td>` + responseData.net_bill_amount + `</td>
                                </tr>`;

							var chalanNumber = '<?php echo $chalanNumber;?>';
							$('input#ch_no').val(chalanNumber);
							$('input#bill_no').val(responseData.nextBillingId);
							$('tbody#billingFormated').append(html);
							$('tbody#getOrderList').html('');

							resetAllfield();

							cuteAlert({
								type: "success", // or 'info', 'error', 'warning'
								title: 'Billing',
								message: "Successfully generated bill",
								buttonText: "Okay",
								img: successImage,
							}).then((e)=>{
								if ( e === ("ok")){
									var url = "<?php echo base_url('BillGeneration/get_billing_report?billing_serial='); ?>"+responseData.billing_id;
									window.location.href =url;
								}
							});

						}else {
							alert("Somethings wrong");
						}
					}
				});

			});


			function resetAllfield(){
				$('input#po_no').val('');
				$('input#credit_limit').val('');
				$('input#delivery_address').val('');
				$('input#order_no').val('');
				$('input#eway_bill_no').val('');
				$('input#tax_type').val('');
				$('input#total_amount').val('');
				$('input#total_disc').val('');
				$('input#igst_amount').val('');
				$('input#cgst_amount').val('');
				$('input#sgst_amount').val('');
				$('input#tpt_amount').val('');
				$('input#tpt_gst').val('');
				$('input#selectedItems').val('');
				$('input#remark').val('');
				$('input#net_bill_amt').val('');
				$('select#customer').val('').trigger('change');
				$('select#item_name').val('').trigger('change');
				$('select#item_type').val('').trigger('change');

				var htmlTbody=`<tr>
                                <th >---</th>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td>Not Found Barcode</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                                <td>---</td>
                     </tr>`;
				$('tbody#barCodeContent').html(htmlTbody);
			}
		});

		$('span#fullScreenbtn').click(function(e){
			$('#fullScreenDiv').toggleClass('fullscreen');
			$('div#main-wrapper').toggleClass('screen-full');
		});

	</script>

</body>
</html>
