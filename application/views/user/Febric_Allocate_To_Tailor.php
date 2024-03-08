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
								<h5 class="card-title">Febric Allocate To Tailor<span id="fullScreenbtn" style="float: right"><img src="https://p.kindpng.com/picc/s/25-253656_transparent-sensor-icon-png-show-full-screen-icon.png" height="20px" width="20px" alt="homepage"></span></h5>
								<div class="row">
									<div class="col-sm-6">
										<div class="row" style="border-style: ridge;margin-left: 1px;">
											
											<div class="col-sm-4">
												<small>Challan No.</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="">
											</div>
											<div class="col-sm-4">
												<small>Challan Date</small>
												<input type="date" class="form-control" name="bill_date" id="bill_date" value="<?php echo date("Y-m-d") ?>"   required>
											</div>

											<div class="col-sm-4">
												<small>Party Name</small>
												<select class="form-control" name="category" id="category">
													<option value="Bill">Bill</option>
													<option value="Proforma">Proforma</option>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Karigar Name</small>
												<select class="form-control" name="customer" id="customer" required>
													<option value="">Select Karigar Type</option>
												</select>
											</div>

											<div class="col-sm-4">
												<small>Allocate Order No.</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="">
											</div>

											<div class="col-sm-6">
												<small>Total Gents MTS</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="">
											</div>

											<div class="col-sm-6">
												<small>Ladeis MTS</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="">
											</div>

											<div class="col-sm-6">
												<small>Total Order MTS</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="">
											</div>

											<div class="col-sm-6">
											</div>

											<div class="col-sm-6">
												<small>Already allocated</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="">
											</div>

											<div class="col-sm-6">
												<small>Bal to allocated</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="">
											</div>

											<div class="col-sm-6">
												<small>Brand Name</small>
												<select class="form-control" name="customer" id="customer" required>
													<option value="">Select Brand Name</option>
												</select>
											</div>
                                            <div class="col-sm-6">
											</div>
											<div class="col-sm-6">
												<small>Febric Name</small>
												<select class="form-control" name="customer" id="customer" required>
													<option value="">Select Febric Name</option>
												</select>
											</div>
                                            <div class="col-sm-6">
											</div>
                                            <br><br><br>
                                            <div class="col-sm-6">
                                            <center><button class="btn btn-sm btn-primary text-white" name="febric" id="febric" required>Show Febric Stock</button></center>
											</div>

                                            <div class="col-sm-6">
											</div>
											<div class="col-sm-6">
												<small>Total Tagas</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="">
											</div>
											<div class="col-sm-6"></div>

											<div class="col-sm-6">
												<small>Total MTS</small>
												<input type="text" class="form-control" name="ch_no" id="ch_no" placeholder="Ch No."  value="">
											</div>

											<div class="col-sm-12" style="margin-bottom: 10px">
												<br>
												<button type="submit" class="btn btn-sm btn-primary text-white" >Save</button>
												<button type="button" class="btn btn-sm btn-primary text-white" >Modify</button>
                                                <button type="button" class="btn btn-sm btn-primary text-white" >Delete</button>
												<button type="button" class="btn btn-sm btn-primary text-white" >Add New</button>
                                                <button type="button" class="btn btn-sm btn-primary text-white" >Cancel</button>
											</div>

										</div>

									</div>
                                        <div class="col-sm-6">
                                            <h4>Select The Febric Taga To Allocate.</h4>
                                            <div class="table-responsive" style="border-style: double;height:520px;position:relative;" id="barcodeBlock">
                                                <table class="table table-sm">
                                                    <thead>
                                                    <tr>
                                                        <th>Sr.No</th>
                                                        <th>Select</th>
                                                        <th>Barcode</th>
                                                        <th>Febric Name</th>
                                                        <th>Shade</th>
                                                        <th>MTS</th>
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

</body>
</html>
